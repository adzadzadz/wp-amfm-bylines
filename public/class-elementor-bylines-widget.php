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
                'label' => __('Content', 'plugin-name'),
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label' => __('Show Author', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'plugin-name'),
                'label_off' => __('No', 'plugin-name'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_editor',
            [
                'label' => __('Show Editor', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'plugin-name'),
                'label_off' => __('No', 'plugin-name'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_reviewer',
            [
                'label' => __('Show Reviewer', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'plugin-name'),
                'label_off' => __('No', 'plugin-name'),
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

        $this->add_control(
            'justify_content',
            [
                'label' => __('Justify Content', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'flex-start' => __('Flex Start', 'plugin-name'),
                    'center' => __('Center', 'plugin-name'),
                    'flex-end' => __('Flex End', 'plugin-name'),
                    'space-between' => __('Space Between', 'plugin-name'),
                    'space-around' => __('Space Around', 'plugin-name'),
                    'space-evenly' => __('Space Evenly', 'plugin-name'),
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .amfm-column' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'align_items',
            [
                'label' => __('Align Items', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'flex-start' => __('Flex Start', 'plugin-name'),
                    'center' => __('Center', 'plugin-name'),
                    'flex-end' => __('Flex End', 'plugin-name'),
                    'stretch' => __('Stretch', 'plugin-name'),
                    'baseline' => __('Baseline', 'plugin-name'),
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .amfm-column' => 'align-items: {{VALUE}};',
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

        $this->add_control(
            'col_padding',
            [
                'label' => __('Column Padding', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-column' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'col_margin',
            [
                'label' => __('Column Margin', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .amfm-column' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // end style section
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

        $author = $this->fetch_user_info('author');
        $editor = $this->fetch_user_info('editor');
        $reviewer = $this->fetch_user_info('reviewedBy');

        $bylines = [
            'author' => $this->fetch_user_info('author'),
            'editor' => $this->fetch_user_info('editor'),
            'reviewer' => $this->fetch_user_info('reviewedBy')
        ];

        echo <<<HTML
            <style>
                #amfm-byline-col-author,
                #amfm-byline-col-editor,
                #amfm-byline-col-reviewer {
                    /* display: none; */
                    cursor: pointer;
                }

                #amfm-byline-col-editor {
                    border-left: solid 1px  #ccc;
                }

                .amfm-bylines-container {
                    display: flex;
                    flex-wrap: wrap;
                    /* Allow columns to wrap when space is limited */
                    width: 100%;
                    /* border: 1px solid #ccc; */
                    background: #fff;
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

                @media (max-width: 1024px) {
                    .amfm-border-left {
                        left: -3% !important;
                    }
                }
                @media (max-width: 768px) {
                    .amfm-border-left {
                        display: none;
                    }
                    .amfm-byline-column, #amfm-byline-col-editor {
                        border-left: none !important;
                        border-right: none !important;
                    }
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
            <div class="amfm-column" id="amfm-byline-col-{$type}">
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
