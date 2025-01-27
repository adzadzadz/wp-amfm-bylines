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
            'content_section',
            [
                'label' => __('Settings', 'amfm-bylines'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
    }

    // Fetch user info
    private function fetch_user_info($type)
    {
        return [
            'name' => do_shortcode('[amfm_info type="' . $type . '" data="name"]'),
            'title' => do_shortcode('[amfm_info type="' . $type . '" data="job_title"]'),
            'credentials' => do_shortcode('[amfm_info type="' . $type . '" data="credentials"]'),
            'img' => do_shortcode('[amfm_info type="' . $type . '" data="img"]'),
        ];
    }

    // Render widget output
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $author = $this->fetch_user_info('author');
        $editor = $this->fetch_user_info('editor');
        $reviewer = $this->fetch_user_info('reviewedBy');

        $output = '<div class="amfm-bylines-container">';

        if ($settings['show_author'] === 'yes') {
            $output .= <<<HTML
            <div class="amfm-column" id="amfm-byline-col-author">
                <div class="amfm-text">Author:</div>
                <div class="amfm-image">{$author['img']}</div>
                <div class="amfm-row-text-container">
                    <div class="amfm-row-text-name">{$author['name']}</div>
                    <div class="amfm-row-text-credentials">{$author['credentials']}</div>
                    <div class="amfm-row-text-title">{$author['title']}</div>
                </div>
            </div>
            HTML;
        }

        if ($settings['show_editor'] === 'yes') {
            $output .= <<<HTML
            <div class="amfm-column" id="amfm-byline-col-editor">
                <div class="amfm-text">Editor:</div>
                <div class="amfm-image">{$editor['img']}</div>
                <div class="amfm-row-text-container">
                    <div class="amfm-row-text-name">{$editor['name']}</div>
                    <div class="amfm-row-text-credentials">{$editor['credentials']}</div>
                    <div class="amfm-row-text-title">{$editor['title']}</div>
                </div>
            </div>
            HTML;
        }

        if ($settings['show_reviewer'] === 'yes') {
            $output .= <<<HTML
            <div class="amfm-column" id="amfm-byline-col-reviewer">
                <div class="amfm-text">Reviewer:</div>
                <div class="amfm-image">{$reviewer['img']}</div>
                <div class="amfm-row-text-container">
                    <div class="amfm-row-text-name">{$reviewer['name']}</div>
                    <div class="amfm-row-text-credentials">{$reviewer['credentials']}</div>
                    <div class="amfm-row-text-title">{$reviewer['title']}</div>
                </div>
            </div>
            HTML;
        }

        $output .= '</div>';

        echo $output;
    }
}

// Register Widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_AMFM_Bylines_Widget());