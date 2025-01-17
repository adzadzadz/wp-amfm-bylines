<?php

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class Elementor_Staff_Grid_Widget extends \Elementor\Widget_Base
{

    // Widget Name
    public function get_name()
    {
        return 'amfm_staff_grid';
    }

    // Widget Title
    public function get_title()
    {
        return __('AMFM Staff Grid', 'amfm-bylines');
    }

    // Widget Icon
    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    // Widget Categories
    public function get_categories()
    {
        return ['general'];
    }

    // Register Controls
    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'amfm-bylines'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'   => __('Posts Per Page', 'amfm-bylines'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_control(
            'columns',
            [
                'label'   => __('Columns (Desktop)', 'amfm-bylines'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => __('1 Column', 'amfm-bylines'),
                    '2' => __('2 Columns', 'amfm-bylines'),
                    '3' => __('3 Columns', 'amfm-bylines'),
                    '4' => __('4 Columns', 'amfm-bylines'),
                    '5' => __('5 Columns', 'amfm-bylines'),
                    '6' => __('6 Columns', 'amfm-bylines'),
                ],
            ]
        );

        $this->add_control(
            'columns_tablet',
            [
                'label'   => __('Columns (Tablet)', 'amfm-bylines'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '2',
                'options' => [
                    '1' => __('1 Column', 'amfm-bylines'),
                    '2' => __('2 Columns', 'amfm-bylines'),
                    '3' => __('3 Columns', 'amfm-bylines'),
                    '4' => __('4 Columns', 'amfm-bylines'),
                    '5' => __('5 Columns', 'amfm-bylines'),
                    '6' => __('6 Columns', 'amfm-bylines'),
                ],
            ]
        );

        $this->add_control(
            'columns_mobile',
            [
                'label'   => __('Columns (Mobile)', 'amfm-bylines'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => __('1 Column', 'amfm-bylines'),
                    '2' => __('2 Columns', 'amfm-bylines'),
                    '3' => __('3 Columns', 'amfm-bylines'),
                    '4' => __('4 Columns', 'amfm-bylines'),
                    '5' => __('5 Columns', 'amfm-bylines'),
                    '6' => __('6 Columns', 'amfm-bylines'),
                ],
            ]
        );

        $this->add_control(
            'grid_gap',
            [
                'label'   => __('Grid Gap (px)', 'amfm-bylines'),
                'type'    => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'   => [
                    'px' => ['min' => 0, 'max' => 50],
                ],
                'default' => ['size' => 20],
            ]
        );

        $this->add_control(
            'item_max_width',
            [
                'label' => __('Item Max Width', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1500,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors' => [
                    '{{WRAPPER}} .amfm-staff-item' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => __('Image Size', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => $this->get_image_sizes(),
            ]
        );

        $this->add_control(
            'fallback_image',
            [
                'label'   => __('Fallback Image', 'amfm-bylines'),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'image_width',
            [
                'label' => __('Image Width', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .amfm-staff-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_max_width',
            [
                'label' => __('Image Max Width', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1500,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors' => [
                    '{{WRAPPER}} .amfm-staff-image img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Start Text Section
        $this->start_controls_section(
            'text_section',
            [
                'label' => __('Text', 'amfm-bylines'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Start Tabs
        $this->start_controls_tabs('text_tabs');

        // Title Tab
        $this->start_controls_tab(
            'title_tab',
            [
                'label' => __('Title', 'amfm-bylines'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .amfm-staff-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'amfm-bylines'),
                'selector' => '{{WRAPPER}} .amfm-staff-name',
            ]
        );

        $this->add_control(
            'title_alignment',
            [
                'label' => __('Title Alignment', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'amfm-bylines'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'amfm-bylines'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'amfm-bylines'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .amfm-staff-name' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Meta Tab
        $this->start_controls_tab(
            'meta_tab',
            [
                'label' => __('Meta', 'amfm-bylines'),
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => __('Meta Color', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .amfm-staff-meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'label' => __('Meta Typography', 'amfm-bylines'),
                'selector' => '{{WRAPPER}} .amfm-staff-meta',
            ]
        );

        $this->add_control(
            'meta_alignment',
            [
                'label' => __('Meta Alignment', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'amfm-bylines'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'amfm-bylines'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'amfm-bylines'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .amfm-staff-meta' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // End Tabs
        $this->end_controls_tabs();

        // End Text Section
        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'amfm-bylines'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Image Styles
        $this->add_control(
            'image_border_radius',
            [
                'label' => __('Image Border Radius', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-staff-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'label' => __('Image Border', 'amfm-bylines'),
                'selector' => '{{WRAPPER}} .amfm-staff-image img',
            ]
        );

        // Staff Item Styles
        $this->add_control(
            'item_padding',
            [
                'label' => __('Item Padding', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-staff-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
            ]
        );

        $this->add_control(
            'item_margin',
            [
                'label' => __('Item Margin', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-staff-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function get_image_sizes()
    {
        global $_wp_additional_image_sizes;

        $sizes = [];
        foreach (get_intermediate_image_sizes() as $_size) {
            if (in_array($_size, ['thumbnail', 'medium', 'medium_large', 'large'])) {
                $sizes[$_size] = ucwords($_size);
            } elseif (isset($_wp_additional_image_sizes[$_size])) {
                $sizes[$_size] = ucwords(str_replace('_', ' ', $_size)) . ' (' . $_wp_additional_image_sizes[$_size]['width'] . 'x' . $_wp_additional_image_sizes[$_size]['height'] . ')';
            }
        }

        return $sizes;
    }

    // Render Output
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $posts_per_page = $settings['posts_per_page'];
        $columns = $settings['columns'];
        $columns_tablet = $settings['columns_tablet'];
        $columns_mobile = $settings['columns_mobile'];
        $grid_gap = isset($settings['grid_gap']['size']) ? $settings['grid_gap']['size'] : 20;
        $image_size = $settings['image_size'];
        $fallback_image = isset($settings['fallback_image']['url']) ? $settings['fallback_image']['url'] : '';

        // First query: Fetch staff posts with amfm_sort > 0
        $query1 = new WP_Query([
            'post_type'      => 'staff',
            'posts_per_page' => $posts_per_page,
            'orderby'        => 'meta_value_num',
            'meta_key'       => 'amfm_sort', // The ACF field to sort by
            'order'          => 'ASC', // Descending order to get higher amfm_sort values first
            'meta_query'     => [
                [
                    'key'     => 'amfm_sort',
                    'value'   => '0',
                    'compare' => '>',
                ]
            ],
        ]);

        // Second query: Fetch staff posts where amfm_sort is 0 or null
        $query2 = new WP_Query([
            'post_type'      => 'staff',
            'posts_per_page' => $posts_per_page,
            'orderby'        => 'ID',
            'order'          => 'ASC', // Ascending order so these appear last
            'meta_query'     => [
                'relation' => 'OR',
                [
                    'key'     => 'amfm_sort',
                    'value'   => '0',
                    'compare' => '=',
                ],
                [
                    'key'     => 'amfm_sort',
                    'compare' => 'NOT EXISTS', // To get posts where amfm_sort is null
                ],
                [
                    'key'     => 'amfm_hide',
                    'compare' => 'NOT EXISTS',
                ]
            ],
        ]);

        // Merge the results from both queries
        $merged_posts = array_merge($query1->posts, $query2->posts);

        // Generate CSS for responsive breakpoints
        $custom_css = "
            <style>
                .amfm-staff-grid {
                    display: grid;
                    grid-template-columns: repeat(" . esc_attr($columns) . ", 1fr);
                    gap: " . esc_attr($grid_gap) . "px;
                }
                @media (max-width: 1024px) {
                    .amfm-staff-grid {
                        grid-template-columns: repeat(" . esc_attr($columns_tablet) . ", 1fr);
                    }
                    .amfm-staff-item {
                        padding: 10px;
                    }
                }
                @media (max-width: 768px) {
                    .amfm-staff-grid {
                        grid-template-columns: repeat(" . esc_attr($columns_mobile) . ", 1fr);
                    }
                    .amfm-staff-item {
                        padding: 5px;
                    }
                }
            </style>
        ";

        echo $custom_css;

        // Start rendering the grid
        echo '<div class="amfm-staff-grid">';

        if (!empty($merged_posts)) {
            foreach ($merged_posts as $post_id) {
                $post = get_post($post_id);
                $link = get_permalink($post); // Correct the permalink

                $amfm_hide = get_field('amfm_hide', $post_id);
                
                if ($amfm_hide && $amfm_hide === true) {
                    continue; // Skip if amfm_hide is true
                }
                

                echo '<div class="amfm-staff-item">';
                echo '<a href="' . esc_url($link) . '">';

                // Display the staff's thumbnail or fallback image
                if (has_post_thumbnail($post_id)) {
                    echo '<div class="amfm-staff-image">' . get_the_post_thumbnail($post_id, $image_size) . '</div>';
                } elseif ($fallback_image) {
                    echo '<div class="amfm-staff-image"><img src="' . esc_url($fallback_image) . '" alt="' . esc_attr(get_the_title($post_id)) . '"></div>';
                }

                // Display the staff's name
                echo '<h3 class="amfm-staff-name">' . get_the_title($post_id) . '</h3>';

                // Get custom fields: title and region
                $title = get_field('title', $post_id);
                $region = get_field('region', $post_id);

                // Display custom fields if they exist
                if ($title || $region) {
                    echo '<div class="amfm-staff-meta">' . esc_html($title) . ', ' . esc_html($region) . '</div>';
                }

                echo '</a>';
                echo '</div>';
            }
        } else {
            echo '<p>' . __('No staff members found.', 'amfm-bylines') . '</p>';
        }

        echo '</div>';
        wp_reset_postdata();
    }
}

// Register Widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_Staff_Grid_Widget());
