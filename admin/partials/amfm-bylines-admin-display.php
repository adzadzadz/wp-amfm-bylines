<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://adzjo.online/adz
 * @since      1.0.0
 *
 * @package    Amfm_Bylines
 * @subpackage Amfm_Bylines/admin/partials
 */

// get all data stored in the amfm_bylines table in the database
global $wpdb;
$bylines = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}amfm_bylines");

// return plugin url
$placeholder = plugin_dir_url(__FILE__) . "placeholder.jpeg";


?>

<div class="wrap">
    <h2><strong><?php _e('Amfm Bylines', 'amfm-bylines'); ?></strong></h2>
    <p><?php _e('This plugin allows you to manage bylines.', 'amfm-bylines'); ?></p>
</div>

<div id="flash-message-container"></div>

<div class="wrap">
    <h5>Shortcode</h5>

    <div><strong>Usage:</strong> [amfm_info type="author" data="job_title"]</div>
    <div><strong>type:</strong> author, editor, reviewedBy</div>
    <div><strong>data:</strong> name, suffix, job_title, page_link</div>
</div>

<div class="wrap">
    <div class="row">
        <div class="col-12 mt-4">
            <h5><?php _e('People', 'amfm-list'); ?></h5>
            <div class="row">
                <div class="col-3 mb-4">
                    <div class="card amfm-card" id="amfm-create-card">
                        <img src="<?= $placeholder ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Add a Person</h5>
                        </div>
                    </div>
                </div>

                <?php foreach ($bylines as $byline) : ?>
                    <div class="col-3 mb-4">
                        <div class="card amfm-card" data-id="<?php echo esc_attr($byline->id); ?>" data-name="<?php echo esc_attr($byline->byline_name); ?>" data-image="<?php echo esc_url($byline->profile_image); ?>" data-description="<?php echo esc_attr($byline->description); ?>" data-data="<?php echo esc_attr($byline->data); ?>" data-author-tag="<?php echo esc_attr($byline->authorTag); ?>" data-editor-tag="<?php echo esc_attr($byline->editorTag); ?>" data-reviewed-by-tag="<?php echo esc_attr($byline->reviewedByTag); ?>">
                            <div class="card-img-top" style="background-image: url('<?php echo esc_url($byline->profile_image); ?>'); background-size: cover; background-position: center; width: 100%; padding-top: 100%;"></div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo esc_html($byline->byline_name); ?></h5>
                                <p class="card-text"><?php echo esc_html(wp_trim_words($byline->description, 10, '...')); ?></p>
                                <button type="button" class="close delete-byline" data-id="<?php echo esc_attr($byline->id); ?>" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <style>
                .amfm-card {
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                }
                .amfm-card .card-body {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                }
            </style>
        </div>
    </div>
</div>


<!-- Drawer -->
<div id="amfmDrawer" class="drawer">
    <div class="drawer-content">
        <div class="drawer-header">
            <h5 class="drawer-title" id="amfmDrawerLabel">Card Details</h5>
            <button type="button" class="close" id="closeDrawer" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="drawer-body">
            <!-- Drawer content will be dynamically inserted here -->
            <form method="post" action="" id="amfm-bylines-form">
                <input type="hidden" id="byline_id" name="byline_id" value="">
                <div class="form-group">
                    <label for="image"><?php _e('Image URL', 'amfm_bylines'); ?></label>
                    <div class="input-group" style="width: 100%;">
                        <div class="input-group-prepend">
                            <button type="button" class="btn btn-secondary" id="upload_image_button"><?php _e('Upload Image', 'amfm-bylines'); ?></button>
                        </div>
                        <input type="text" id="image_url" name="image_url" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="page_url"><?php _e('Select Page', 'amfm-bylines'); ?></label>
                    <select id="page_selector" class="form-control">
                        <option value=""><?php _e('Select a page', 'amfm-bylines'); ?></option>
                    </select>
                    <input type="text" id="page_url" name="page_url" class="form-control">
                </div>

                <div class="form-group">
                    <label for="name"><?php _e('Name', 'amfm-bylines'); ?></label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="honorificSuffix"><?php _e('Honorific Suffix', 'amfm-bylines'); ?></label>
                    <input type="text" class="form-control" id="honorificSuffix" name="honorificSuffix">
                </div>
                <div class="form-group">
                    <label for="description"><?php _e('Description', 'amfm-bylines'); ?></label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="jobTitle"><?php _e('Job Title', 'amfm-bylines'); ?></label>
                    <input type="text" class="form-control" id="jobTitle" name="jobTitle">
                </div>
                <div class="form-group mt-3 mb-3">
                    <label><strong><?php _e('Has Credentials', 'amfm-bylines'); ?></strong></label>
                    <div class="form-group">
                        <label for="credentialType"><?php _e('Credential Type', 'amfm-bylines'); ?></label>
                        <input type="text" class="form-control" id="credentialType" name="credentialType">
                    </div>
                    <div class="form-group">
                        <label for="credentialName"><?php _e('Credential Name', 'amfm-bylines'); ?></label>
                        <input type="text" class="form-control" id="credentialName" name="credentialName">
                    </div>
                </div>
                <div class="form-group mt-3 mb-3">
                    <label><strong><?php _e('Works For', 'amfm-bylines'); ?></strong></label>
                    <div class="form-group">
                        <label for="worksForType"><?php _e('Type', 'amfm-bylines'); ?></label>
                        <input type="text" class="form-control" id="worksForType" name="worksForType">
                    </div>
                    <div class="form-group">
                        <label for="worksForName"><?php _e('Name', 'amfm-bylines'); ?></label>
                        <input type="text" class="form-control" id="worksForName" name="worksForName">
                    </div>
                </div>
                <div class="form-group">
                    <label for="authorTag"><?php _e('Author Tag', 'amfm-bylines'); ?></label>
                    <input type="text" class="form-control" id="authorTag" name="authorTag">
                </div>
                <div class="form-group">
                    <label for="editorTag"><?php _e('Editor Tag', 'amfm-bylines'); ?></label>
                    <input type="text" class="form-control" id="editorTag" name="editorTag">
                </div>
                <div class="form-group">
                    <label for="reviewedByTag"><?php _e('Reviewed By Tag', 'amfm-bylines'); ?></label>
                    <input type="text" class="form-control" id="reviewedByTag" name="reviewedByTag">
                </div>
                <div class="form-group">
                    <button type="reset" class="btn btn-secondary mt-3"><?php _e('Reset', 'amfm-bylines'); ?></button>
                    <button type="submit" class="btn btn-primary mt-3"><?php _e('Submit', 'amfm-bylines'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>