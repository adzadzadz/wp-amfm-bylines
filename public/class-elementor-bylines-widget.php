<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Elementor_AMFM_Bylines_Widget extends \Elementor\Widget_Base
{
    // Widget name
    public function get_name()
    {
        return 'amfm_bylines';
    }

    // Widget title
    public function get_title()
    {
        return __('AMFM Bylines', 'amfm-bylines');
    }

    // Widget icon
    public function get_icon()
    {
        return 'eicon-person';
    }

    // Widget categories
    public function get_categories()
    {
        return ['general'];
    }

    // Widget controls
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'amfm-bylines'),
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label' => __('Show Author', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'amfm-bylines'),
                'label_off' => __('No', 'amfm-bylines'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_editor',
            [
                'label' => __('Show Editor', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'amfm-bylines'),
                'label_off' => __('No', 'amfm-bylines'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_reviewer',
            [
                'label' => __('Show Reviewer', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'amfm-bylines'),
                'label_off' => __('No', 'amfm-bylines'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Start Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Styling', 'amfm-bylines'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'justify_content',
            [
                'label' => __('Justify Content', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'flex-start' => __('Flex Start', 'amfm-bylines'),
                    'center' => __('Center', 'amfm-bylines'),
                    'flex-end' => __('Flex End', 'amfm-bylines'),
                    'space-between' => __('Space Between', 'amfm-bylines'),
                    'space-around' => __('Space Around', 'amfm-bylines'),
                    'space-evenly' => __('Space Evenly', 'amfm-bylines'),
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .amfm-column' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align_items',
            [
                'label' => __('Align Items', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'flex-start' => __('Flex Start', 'amfm-bylines'),
                    'center' => __('Center', 'amfm-bylines'),
                    'flex-end' => __('Flex End', 'amfm-bylines'),
                    'stretch' => __('Stretch', 'amfm-bylines'),
                    'baseline' => __('Baseline', 'amfm-bylines'),
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .amfm-column' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label' => __('Image Size', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .amfm-image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => __('Image Border Radius', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .amfm-image img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // add image border radius color control
        $this->add_control(
            'image_border_color',
            [
                'label' => __('Image Border Color', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .amfm-image img' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Start Style Section
        $this->start_controls_section(
            'spacing_section',
            [
                'label' => __('Spacing', 'amfm-bylines'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'col_padding',
            [
                'label' => __('Column Padding', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-column' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'col_margin',
            [
                'label' => __('Column Margin', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-column' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // end style section
        $this->end_controls_section();


        // responsive border control for author column
        $this->start_controls_section(
            'column_control',
            [
                'label' => __('Columns', 'amfm-bylines'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Start tabs
        $this->start_controls_tabs('columns_tabs');

        // Author tab
        $this->start_controls_tab(
            'author_tab',
            [
                'label' => __('Author', 'amfm-bylines'),
            ]
        );

        $this->add_responsive_control(
            'author_border_width',
            [
                'label' => __('Author Border Width', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-byline-col-author' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'author_border_style',
            [
                'label' => __('Author Border Style', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'none' => __('None', 'amfm-bylines'),
                    'solid' => __('Solid', 'amfm-bylines'),
                    'dotted' => __('Dotted', 'amfm-bylines'),
                    'dashed' => __('Dashed', 'amfm-bylines'),
                    'double' => __('Double', 'amfm-bylines'),
                ],
                'default' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .amfm-byline-col-author' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'author_border_color',
            [
                'label' => __('Author Border Color', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .amfm-byline-col-author' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'author_border_radius',
            [
                'label' => __('Author Border Radius', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-byline-col-author' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Editor tab
        $this->start_controls_tab(
            'editor_tab',
            [
                'label' => __('Editor', 'amfm-bylines'),
            ]
        );

        $this->add_responsive_control(
            'editor_border_width',
            [
                'label' => __('Editor Border Width', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-byline-col-editor' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'editor_border_style',
            [
                'label' => __('Editor Border Style', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'none' => __('None', 'amfm-bylines'),
                    'solid' => __('Solid', 'amfm-bylines'),
                    'dotted' => __('Dotted', 'amfm-bylines'),
                    'dashed' => __('Dashed', 'amfm-bylines'),
                    'double' => __('Double', 'amfm-bylines'),
                ],
                'default' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .amfm-byline-col-editor' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'editor_border_color',
            [
                'label' => __('Editor Border Color', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .amfm-byline-col-editor' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'editor_border_radius',
            [
                'label' => __('Editor Border Radius', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-byline-col-editor' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Reviewer tab
        $this->start_controls_tab(
            'reviewer_tab',
            [
                'label' => __('Reviewer', 'amfm-bylines'),
            ]
        );

        $this->add_responsive_control(
            'reviewer_border_width',
            [
                'label' => __('Reviewer Border Width', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-byline-col-reviewer' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'reviewer_border_style',
            [
                'label' => __('Reviewer Border Style', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'none' => __('None', 'amfm-bylines'),
                    'solid' => __('Solid', 'amfm-bylines'),
                    'dotted' => __('Dotted', 'amfm-bylines'),
                    'dashed' => __('Dashed', 'amfm-bylines'),
                    'double' => __('Double', 'amfm-bylines'),
                ],
                'default' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .amfm-byline-col-reviewer' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'reviewer_border_color',
            [
                'label' => __('Reviewer Border Color', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .amfm-byline-col-reviewer' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'reviewer_border_radius',
            [
                'label' => __('Reviewer Border Radius', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-byline-col-reviewer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // End tabs
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    // Fetch user info
    private function fetch_user_info($type)
    {
        $bylines = new Amfm_Bylines_Public(null, null);
        $use_staff_cpt = get_option('amfm_use_staff_cpt');
        $byline = $bylines->get_byline($type, $use_staff_cpt);

        if (!$byline) {
            return false;
        }

        if (!$use_staff_cpt) {
            $byline_data = json_decode($byline->data, true);
            $data = [
                'name' => '',
                'credentials' => '',
                'title' => '',
                'img' => '',
            ];
        } else {
            $byline_data = get_fields($byline->ID);
            $name = $byline->post_title;
            $staff_profile_image = get_the_post_thumbnail_url($byline->ID);
            $profile_url = $staff_profile_image ? $staff_profile_image : plugin_dir_url(__FILE__) . 'placeholder.jpeg';
            $img_output = <<<HTML
                <img src="$profile_url" alt="$name" />
            HTML;
            $data = [
                'name' => $name,
                'credentials' => $byline_data['honorific_suffix'] ?? '', // Ensure this field is defined
                'title' => $byline_data['job_title'] ?? '', // Ensure this field is defined
                'img' => $img_output,
            ];
        }

        return $data;
    }

    // Render widget output
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $bylines = [
            'author' => $this->fetch_user_info('author'),
            'editor' => $this->fetch_user_info('editor'),
            'reviewer' => $this->fetch_user_info('reviewedBy')
        ];

        echo <<<HTML
            <style>
                .amfm-byline-col-author,
                .amfm-byline-col-editor,
                .amfm-byline-col-reviewer {
                    /* display: none; */
                    cursor: pointer;
                    border: none;
                }

                /* .amfm-byline-col-editor {
                    border-left: solid 1px  #ccc;
                } */

                .amfm-bylines-container {
                    display: flex;
                    flex-wrap: wrap;
                    /* Allow columns to wrap when space is limited */
                    width: 100%;
                    /* border: 1px solid #ccc; */
                    background: #fff;
                    justify-content: space-between;
                }

                .amfm-bylines-container .amfm-column {
                    position: relative;
                    flex: 1 1 200px;
                    /* Allow columns to shrink, grow, and set a minimum width */
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    gap: 20px;
                    /* Adds spacing between elements */
                    /* border-right: 1px solid #ccc; */
                    padding: 20px;
                    box-sizing: border-box;
                    /* Ensures padding doesn't affect width calculation */
                }

                .amfm-column:last-child {
                    border-right: none;
                }

                .amfm-image {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .amfm-image img {
                    width: 40px;
                    max-height: 40px !important;
                    border-radius: 50%;
                    border: 2px #02303C solid;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    overflow: hidden;
                }

                .amfm-row-text-container {
                    display: flex;
                    flex-direction: column;
                    gap: 0px;
                    /* Adds spacing between rows of text */
                }

                .amfm-text {
                    font-size: 12px;
                    font-weight: bold;
                    line-height: 1.1em;
                    max-width: 80px;
                }
                .amfm-row-text-name {
                    font-size: 15px;
                    line-height: 1em;
                    font-weight: bold;
                }
                .amfm-row-text-credentials {
                    font-size: 12px;
                    line-height: 1em;
                }
                .amfm-row-text-title {
                    color:#00997A; 
                    font-weight:bold;
                }

                .amfm-border-left {
                    position: absolute;
                    width: 1px;
                    height: 75%;
                    background-color: #ccc;
                    left: 0;
                    top: 14%;
                }
            </style>
        HTML;

        echo '<div class="amfm-bylines-container">';

        foreach ($bylines as $type => $byline) {
            if ($type === 'author' && $settings['show_author'] !== 'yes') {
                break;
            }
            if ($type === 'editor' && ($settings['show_author'] !== 'yes' || $settings['show_editor'] !== 'yes')) {
                break;
            }
            if ($type === 'reviewer' && ($settings['show_author'] !== 'yes' || $settings['show_editor'] !== 'yes' || $settings['show_reviewer'] !== 'yes')) {
                break;
            }

            if (!$byline) {
                continue;
            }

            $type_title = ucfirst($type);

            echo <<<HTML
            <div class="amfm-column amfm-byline-col-{$type}">
                <div class="amfm-text">{$type_title}:</div>
                <div class="amfm-image">{$byline['img']}</div>
                <div class="amfm-row-text-container">
                    <div class="amfm-row-text-name">{$byline['name']}</div>
                    <div class="amfm-row-text-credentials">{$byline['credentials']}</div>
                    <div class="amfm-row-text-title">{$byline['title']}</div>
                </div>
            </div>
            HTML;
        }

        echo '</div>';
    }
}

// Register Widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_AMFM_Bylines_Widget());
