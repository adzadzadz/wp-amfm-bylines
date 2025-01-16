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
        return __('AMFM Posts', 'text-domain');
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
                'label' => __('Settings', 'text-domain'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_count',
            [
                'label' => __('Number of Posts', 'text-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
            ]
        );

        $this->end_controls_section();
    }

    // Fetch related posts logic
    private function fetch_related_posts($count)
    {
        global $post;

        // Get the tags of the current post (CPT)
        $tags = wp_get_post_tags($post->ID);

        if (! $tags) {
            return '<p>No related posts found.</p>'; // No tags, return empty if there are no tags
        }

        // Get the tag IDs
        $tag_ids = array_map(function ($tag) {
            return $tag->term_id;
        }, $tags);

        // Create the custom query to fetch posts with the same tags
        $args = [
            'post_type'      => 'post', // Native "post" type
            'posts_per_page' => $count,
            'post__not_in'   => [$post->ID], // Exclude the current post
            'tag__in'        => $tag_ids, // Filter by tags
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];

        // Execute the query
        $query = new WP_Query($args);

        // Generate HTML output
        if ($query->have_posts()) {
            $output = '<div class="amfm-related-posts">';
            while ($query->have_posts()) {
                $query->the_post();
                $output .= '<div class="amfm-related-post-item" style="margin-bottom: 10px;">';
                $output .= '<div class="amfm-related-post-title" style="font-size: 18px; font-weight: bold;">' . get_the_title() . '</div>';
                $output .= '<a class="amfm-related-post-link amfm-read-more" style="font-size: 14px; font-weight: bold;" href="' . get_permalink() . '">Read More</a>';
                $output .= '</div>';
            }
            $output .= '</div>';
            
            // Pagination links
            $output .= '<div class="amfm-pagination">';
            $big = 999999999; // A large number for replacing the pagination
            $output .= paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, $paged),
                'total' => $query->max_num_pages,
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
        $count    = $settings['posts_count'];

        // Call the fetch-related-posts function and output the result
        echo $this->fetch_related_posts($count);
    }
}

// Register the widget
function register_elementor_amfm_posts_widget($widgets_manager)
{
    $widgets_manager->register(new \Elementor_AMFM_Posts_Widget());
}
add_action('elementor/widgets/register', 'register_elementor_amfm_posts_widget');
