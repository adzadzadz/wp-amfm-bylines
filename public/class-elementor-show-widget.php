<?php

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class Elementor_Show_Widget_Widget extends \Elementor\Widget_Base
{

    // Widget Name
    public function get_name()
    {
        return 'amfm_show_widget';
    }

    // Widget Title
    public function get_title()
    {
        return __('AMFM Show', 'amfm-bylines');
    }

    // Widget Icon
    public function get_icon()
    {
        return 'eicon-eye';
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
            'section_classnames',
            [
                'label' => __('Class Names', 'amfm-bylines'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'classnames',
            [
                'label' => __('Class Names', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Enter class names separated by commas.', 'amfm-bylines'),
            ]
        );

        $this->add_control(
            'start_date',
            [
                'label' => __('Start Date', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => date('Y-m-d H:i:s'),
                'description' => __('Set the start date.', 'amfm-bylines'),
            ]
        );

        $this->add_control(
            'end_date',
            [
                'label' => __('End Date', 'amfm-bylines'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'description' => __('Set the end date.', 'amfm-bylines'),
            ]
        );

        $this->end_controls_section();
    }

    // Render Output
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $classnames = isset($settings['classnames']) ? esc_attr($settings['classnames']) : '';
        $classnames_array = array_map('trim', explode(',', $classnames));

        $start_date = isset($settings['start_date']) ? strtotime($settings['start_date']) : null;
        $end_date = isset($settings['end_date']) ? strtotime($settings['end_date']) : null;
        $current_date = time();

        $style = 'display: none;';
        if ($start_date && $end_date && $current_date >= $start_date && $current_date <= $end_date) {
            $style = false;
        }

        $classnames_string = false;
        if ($style) {
            // echo all the classnames listed in this format .{classname}, .{classname}, .{classname}
            $classnames_string = implode(', ', array_map(function ($classname) {
                return '.' . trim($classname);
            }, $classnames_array));

            if ($classnames_string) {
                echo '<style>';
                echo $classnames_string . ' { display: none; }';
                echo '</style>';
            }
        }

    }
}

// Register Widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_Show_Widget_Widget());
