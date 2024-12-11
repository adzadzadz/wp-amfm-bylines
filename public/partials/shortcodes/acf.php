<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://adzjo.online/adz
 * @since      1.0.9
 *
 * @package    Amfm_Bylines
 * @subpackage Amfm_Bylines/public/partials
 */


//  create a shortcode to display an acf field
add_shortcode('amfm_acf', function ($atts) {
    // get the field name
    $field = $atts['field'];

    // get the before text
    $before = $atts['before'];

    // get the post id
    $post_id = get_the_ID();

    // get the field value
    $value = get_field($field, $post_id);

    // if there is no value, return nothing if has value return with before text
    if (!$value) {
        return '';
    }

    // if there is a before text, add it to the value
    if ($before) {
        $value = $before . " " . $value;
    }

    // return the value
    return $value;
});

