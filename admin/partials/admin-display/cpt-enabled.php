<?php

// Ensure WordPress environment is loaded
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// get all data from the Staff CPT
$bylines = get_posts(array(
    'post_type' => 'staff',
    'numberposts' => -1,
    'order' => 'ASC',
    'meta_key' => 'amfm_sort', // Order by the sort field
    'orderby' => 'meta_value_num', // Important for numerical sorting
));

?>

<div class="wrap">
    <div class="row">
        <div class="col-12 mt-4">
            <div class="row staff-grid sortable"> 
                <div class="col-6 col-md-4 col-lg-2 mb-4 add-staff-item">
                    <div class="card amfm-card" id="amfm-create-staff">
                        <img src="<?= $placeholder ?>" class="card-img-top" alt="Add Staff">
                        <div class="card-body">
                            <h5 class="card-title">Add a Person</h5>
                        </div>
                    </div>
                </div>

                <?php foreach ($bylines as $byline) : ?>
                    <div class="col-6 col-md-4 col-lg-2 mb-4 staff-item" data-id="<?php echo $byline->ID; ?>">
                        <div class="card amfm-card amfm-card-item amfm-card-staff-item" data-url="<?php echo get_edit_post_link($byline->ID); ?>">
                            <?php if (has_post_thumbnail($byline->ID)) : ?>
                                <div class="card-img-top" style="background-image: url('<?php echo get_the_post_thumbnail_url($byline->ID); ?>'); background-size: cover; background-position: center; width: 100%; padding-top: 100%;"></div>
                            <?php else : ?>
                                <img src="<?= $placeholder ?>" class="card-img-top" alt="<?php echo esc_attr(stripslashes($byline->post_title)); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo esc_html(stripslashes($byline->post_title)); ?></h5>
                                <p class="card-text"><?php echo esc_html(stripslashes(wp_trim_words(get_the_excerpt($byline), 10, '...'))); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        $(".sortable").sortable({
            items: ".staff-item", // Only make staff items sortable
            update: function(event, ui) {
                var sortedIDs = $(this).sortable("toArray", { attribute: 'data-id' });
                console.log(sortedIDs);
                $.ajax({
                    url: ajaxurl, // WordPress AJAX URL
                    type: 'POST',
                    data: {
                        action: 'update_staff_order', // Your AJAX action
                        ids: sortedIDs,
                        nonce: '<?php echo wp_create_nonce("update_staff_order_nonce"); ?>' // Nonce for security
                    },
                    success: function(response) {
                        if (response === 'success') {
                            console.log('Order updated successfully');
                        } else {
                            console.error('Error updating order:', response);
                        }
                    },
                    error: function(error) {
                         console.error('AJAX error:', error);
                    }
                });
            }
        });
    });
</script>