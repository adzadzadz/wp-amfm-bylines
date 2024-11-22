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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><strong><?php _e('Amfm Bylines', 'amfm-bylines'); ?></strong></h2>
    <p><?php _e('This plugin allows you to manage bylines.', 'amfm-bylines'); ?></p>
</div>

<!-- Create 2 columns sizes 3/4 & 1/4 width. Col 1 contains a repeater list while col 2 contains a form with name and data fields -->
<div class="wrap">
    <div class="row">
        <div class="col-12">
            <h4><?php _e('List', 'amfm-list'); ?></h4>
            <div class="row">
                <div class="col-3">
                    <div class="card amfm-card">
                        <img src="http://test.local/wp-content/uploads/2024/11/placeholder.jpeg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Add a Person</h5>
                        </div>
                    </div>
                </div>

                <?php for ($i = 0; $i < 5; $i++) : ?>
                    <div class="col-3">
                        <div class="card amfm-card">
                            <img src="http://test.local/wp-content/uploads/2024/11/placeholder.jpeg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Jane R. Doe</h5>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
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
            <form method="post" action="">
                <div class="form-group">
                    <label for="image"><?php _e('Image URL', 'amfm-bylines'); ?></label>
                    <div class="input-group" style="width: 100%;">
                        <div class="input-group-prepend">
                            <button type="button" class="btn btn-secondary" id="upload_image_button"><?php _e('Upload Image', 'amfm-bylines'); ?></button>
                        </div>
                        <input type="text" id="image_url" name="image_url" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name"><?php _e('Name', 'amfm-bylines'); ?></label>
                    <input type="text" class="form-control" id="name" name="name" required>
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
                <div class="form-group">
                    <label for="hasCredential"><?php _e('Credential', 'amfm-bylines'); ?></label>
                    <input type="text" class="form-control" id="hasCredential" name="hasCredential">
                </div>
                <div class="form-group">
                    <label for="worksFor"><?php _e('Works For', 'amfm-bylines'); ?></label>
                    <input type="text" class="form-control" id="worksFor" name="worksFor">
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
                <button type="submit" class="btn btn-primary"><?php _e('Submit', 'amfm-bylines'); ?></button>
            </form>
        </div>
    </div>
</div>