<?php

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class Elementor_AMFM_Posts_Widget extends \Elementor\Widget_Base
{

    // Define widget name
    public function get_name()
    {
        return 'amfm_posts';
    }

    // Define widget title
    public function get_title()
    {
        return __('AMFM Posts', 'amfm-bylines');
    }

    // Define widget icon
    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    // Define widget categories
    public function get_categories()
    {
        return ['general'];
    }

    // Define widget controls
    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Settings', 'amfm-bylines'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'related_posts_filter',
            [
                'label' => __('Related Posts Filter', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'all', // Default value
                'options' => [
                    'all' => __('All', 'amfm-bylines'),
                    'author' => __('Author', 'amfm-bylines'),
                    'editor' => __('Editor', 'amfm-bylines'),
                    'reviewer' => __('Reviewer', 'amfm-bylines'),
                ],
            ]
        );

        $this->add_control(
            'posts_count',
            [
                'label' => __('Number of Posts', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
            ]
        );

        $this->end_controls_section();
    }

    // Fetch related posts logic
    private function fetch_related_posts($posts_per_page = 5, $filter = 'all')
    {
        global $post;

        $paged = get_query_var('paged') ? get_query_var('paged') : 1;

        // Get all tags of the current post
        $tags = wp_get_post_tags($post->ID);

        if (!$tags) {
            return '<p>No related posts found.</p>'; // No tags, return empty if there are no tags
        }

        // Filter tags based on the selected filter
        $tag_prefix = '';
        switch ($filter) {
            case 'author':
                $tag_prefix = 'authored-by-';
                break;
            case 'editor':
                $tag_prefix = 'edited-by-';
                break;
            case 'reviewer':
                $tag_prefix = 'reviewed-by-';
                break;
        }

        // Filter tags by prefix if a specific filter is selected
        if ($tag_prefix) {
            $tags = array_filter($tags, function ($tag) use ($tag_prefix) {
                return strpos($tag->slug, $tag_prefix) === 0;
            });
        }

        if (empty($tags)) {
            return '<p>No related posts found.</p>'; // No matching tags
        }

        // Get the tag IDs
        $tag_ids = array_map(function ($tag) {
            return $tag->term_id;
        }, $tags);

        // Create the custom query to fetch posts with the same tags
        $args = [
            'post_type'      => 'post', // Native "post" type
            'posts_per_page' => $posts_per_page,
            'post__not_in'   => [$post->ID], // Exclude the current post
            'tag__in'        => $tag_ids, // Filter by tags
            'orderby'        => 'date',
            'order'          => 'DESC',
            'paged'          => $paged, // Handle pagination
        ];

        // Execute the query
        $query = new WP_Query($args);

        // Generate HTML output
        if ($query->have_posts()) {
            $output = '<div class="amfm-related-posts">';
            while ($query->have_posts()) {
                $query->the_post();
                $output .= '<div class="amfm-related-post-item">';
                $output .= '<div class="amfm-related-post-title">' . get_the_title() . '</div>';
                $output .= '<a class="amfm-related-post-link amfm-read-more" href="' . get_permalink() . '">Read More</a>';
                $output .= '</div>';
            }
            $output .= '</div>';

            // Pagination links
            $output .= '<div class="amfm-pagination">';
            // $big = 999999999; // A large number for replacing the pagination
            $output .= paginate_links(array(
                'base'      => esc_url(add_query_arg('paged', '%#%')),
                'format'    => '?paged=%#%',
                'current'   => max(1, $paged),
                'total'     => $query->max_num_pages,
                'prev_text' => '&laquo; Previous',
                'next_text' => 'Next &raquo;',
            ));
            $output .= '</div>';
        } else {
            $output = '<p class="amfm-no-related-posts">No related posts found.</p>';
        }

        // Reset post data
        wp_reset_postdata();

        return $output;
    }

    // Render widget output
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $posts_per_page    = $settings['posts_count'];
        $related_posts_filter = $settings['related_posts_filter'];

        echo '<div class="amfm-related-posts-widget" data-filter="' . esc_attr($related_posts_filter) . '" data-posts-count="' . intval($posts_per_page) . '">';
        echo $this->fetch_related_posts($posts_per_page, $related_posts_filter);
        echo '</div>';
    }
}

// Register the widget
function register_elementor_amfm_posts_widget($widgets_manager)
{
    $widgets_manager->register(new \Elementor_AMFM_Posts_Widget());
}
add_action('elementor/widgets/register', 'register_elementor_amfm_posts_widget');
