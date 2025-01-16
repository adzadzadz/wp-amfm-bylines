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
                    <img src="$profile_url" alt="$name" />
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

add_shortcode('amfm_bylines_grid', function ($atts) {
    
    $output = '';

    $author = [
        "name" => do_shortcode('[amfm_info type="author" data="name"]'),
        "title" => do_shortcode('[amfm_info type="author" data="job_title"]'),
        "credentials" => do_shortcode('[amfm_info type="author" data="credentials"]'),
        "img" => do_shortcode('[amfm_info type="author" data="img"]')
    ];

    $editor = [
        "name" => do_shortcode('[amfm_info type="editor" data="name"]'),
        "title" => do_shortcode('[amfm_info type="editor" data="job_title"]'),
        "credentials" => do_shortcode('[amfm_info type="editor" data="credentials"]'),
        "img" => do_shortcode('[amfm_info type="editor" data="img"]')
    ];

    $reviewer = [
        "name" => do_shortcode('[amfm_info type="reviewedBy" data="name"]'),
        "title" => do_shortcode('[amfm_info type="reviewedBy" data="job_title"]'),
        "credentials" => do_shortcode('[amfm_info type="reviewedBy" data="credentials"]'),
        "img" => do_shortcode('[amfm_info type="reviewedBy" data="img"]')
    ];

    $output .= <<<HTML
    <div class="amfm-bylines-container">
        <!-- Column 1 -->
        <div class="amfm-column" id="amfm-byline-col-author">
            <div class="amfm-text">Author:</div>
            <div class="amfm-image">{$author['img']}</div>
            <div class="amfm-row-text-container">
                <div class="amfm-row-text-name">{$author['name']}</div>
                <div class="amfm-row-text-credentials">{$author['credentials']}</div>
                <div class="amfm-row-text-title">{$author['title']}</div>
            </div>
        </div>

        <!-- Column 2 -->
        <div class="amfm-column" id="amfm-byline-col-editor">
            <div class="amfm-text">Editor:</div>
            <div class="amfm-image">{$editor['img']}</div>
            <div class="amfm-row-text-container">
                <div class="amfm-row-text-name">{$editor['name']}</div>
                <div class="amfm-row-text-credentials">{$editor['credentials']}</div>
                <div class="amfm-row-text-title">{$editor['title']}</div>
            </div>
        </div>

        <!-- Column 3 -->
        <div class="amfm-column" id="amfm-byline-col-reviewer">
            <div class="amfm-text">Reviewer:</div>
            <div class="amfm-image">{$reviewer['img']}</div>
            <div class="amfm-row-text-container">
                <div class="amfm-row-text-name">{$reviewer['name']}</div>
                <div class="amfm-row-text-credentials">{$reviewer['credentials']}</div>
                <div class="amfm-row-text-title">{$reviewer['title']}</div>
            </div>
        </div>
    </div>
    HTML;

    return (string) $output;
});

add_shortcode('related_posts_by_tags', function ($atts) {
    global $post;

    // Get the current page
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    // Get the tags of the current post (CPT)
    $tags = wp_get_post_tags($post->ID);

    if (!$tags) {
        return ''; // No tags, return empty if there are no tags
    }

    // Get the tag IDs
    $tag_ids = array();
    foreach ($tags as $tag) {
        $tag_ids[] = $tag->term_id;
    }

    // Set the number of posts per page based on shortcode attribute or default to 5
    $posts_per_page = isset($atts['count']) ? intval($atts['count']) : 5;

    // Create the custom query to fetch posts with the same tags
    $args = array(
        'post_type' => 'post', // Native post type
        'posts_per_page' => $posts_per_page,
        'post__not_in' => array($post->ID), // Exclude the current post
        'tag__in' => $tag_ids, // Filter by tags
        'orderby' => 'date', // Sort by date
        'order' => 'DESC',
        'paged' => $paged, // Handle pagination
    );

    // Execute the query
    $query = new WP_Query($args);

    // Check if we have posts and output them
    if ($query->have_posts()) {
        $output = '<div class="amfm-related-posts">';
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<div class="amfm-related-post-item" style="margin-bottom: 10px;">';
            $output .= '<div style="font-size: 18px; font-weight: bold;">' . get_the_title() . '</div>';
            $output .= '<a class="amfm-read-more" style="font-size: 14px; font-weight: bold;" href="' . get_permalink() . '">Read More</a>';
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
});