<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://adzjo.online/adz
 * @since      1.0.0
 *
 * @package    Amfm_Bylines
 * @subpackage Amfm_Bylines/public/partials
 */



/**
 * Usage: [amfm_info type="editor" data="job_title"]
 * type: author, editor, reviewedBy
 * data: name, credentials, job_title, page_url, img
 * 
 * returns raw text
 */
add_shortcode('amfm_info', function ($atts) {
    $type = $atts['type']; # author, editor, reviewedBy
    $data = $atts['data']; # name, credentials, job_title, page_url

    if (!in_array($type, ['author', 'editor', 'reviewedBy'])) {
        return "Type must be either 'author', 'editor', 'reviewedBy'";
    }

    if (!in_array($data, ['name', 'credentials', 'job_title', 'page_url', 'img'])) {
        return "Data must be either 'name', 'credentials', 'job_title', or 'page_url', 'img'";
    }

    $output = '';

    $use_staff_cpt = get_option('amfm_use_staff_cpt');

    $byline = $this->get_byline($type, $use_staff_cpt);

    if (!$byline)
        return "No byline found";

    if (!$use_staff_cpt) {
        $byline_data = json_decode($byline->data, true);

        switch ($data) {
            case 'name':
                $output = $byline->byline_name;
                break;
            case 'credentials':
                $output = $byline_data['honorificSuffix'];
                break;
            case 'job_title':
                $output = $byline_data['jobTitle'];
                break;
            case 'page_url':
                $output = preg_replace('/^https?:\/\//', '', $byline_data['page_url']);
                break;
            case 'img':
                $profile_url = $byline->profile_image ? $byline->profile_image : plugin_dir_url(__FILE__) . 'placeholder.jpeg';
                $name = $byline->byline_name;
                $output = <<<HTML
						<div style="text-align: center; display: inline-block;">
							<img 
								style="width: 40px; border-radius: 50%; border: 2px #00245d solid;" 
								src="$profile_url" 
								alt="$name" />
						</div>
					HTML;
                break;
        }
    } else {
        $byline_data = get_fields($byline->ID);

        $staff_profile_image = get_the_post_thumbnail_url($byline->ID);

        switch ($data) {
            case 'name':
                $output = $byline->post_title;
                break;
            case 'credentials':
                $output = $byline_data['honorific_suffix'];
                break;
            case 'job_title':
                $output = $byline_data['job_title'];
                break;
            case 'page_url':
                $output = preg_replace('/^https?:\/\//', '', get_permalink($byline->ID));
                break;
            case 'img':
                $profile_url = $staff_profile_image ? $staff_profile_image : plugin_dir_url(__FILE__) . 'placeholder.jpeg';
                $name = $byline->post_title;
                $output = <<<HTML
						<div style="text-align: center; display: inline-block;">
							<img 
								style="width: 40px; border-radius: 50%; border: 2px #00245d solid;" 
								src="$profile_url" 
								alt="$name" />
						</div>
					HTML;
                break;
        }
    }

    return "$output";
});

/**
 * Usage: [amfm_author_url]
 * 
 * returns the author's page url
 */
add_shortcode('amfm_author_url', function ($atts) {
    return (string) $this->get_byline_url('author');
});

/**
 * Usage: [amfm_editor_url]
 * 
 * returns the editor's page url
 */
add_shortcode('amfm_editor_url', function ($atts) {
    return (string) $this->get_byline_url('editor');
});

/**
 * Usage: [amfm_reviewer_url]
 * 
 * returns the reviewer's page url
 */
add_shortcode('amfm_reviewer_url', function ($atts) {
    return (string) $this->get_byline_url('reviewedBy');
});
