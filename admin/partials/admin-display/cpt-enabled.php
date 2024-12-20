<?php 

// get all data from the Staff CPT
$bylines = get_posts(array(
    'post_type' => 'staff',
    'numberposts' => -1
));

?>



<div class="wrap">
    <div class="row">
        <div class="col-12 mt-4">
            <div class="row">
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="card amfm-card" id="amfm-create-staff">
                        <img src="<?= $placeholder ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Add a Person</h5>
                        </div>
                    </div>
                </div>

                <?php foreach ($bylines as $byline) : ?>
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <div class="card amfm-card amfm-card-item amfm-card-staff-item" data-url="<?php echo get_edit_post_link($byline->ID); ?>">
                            <?php if (has_post_thumbnail($byline->ID)) : ?>
                            <div class="card-img-top" style="background-image: url('<?php echo get_the_post_thumbnail_url($byline->ID); ?>'); background-size: cover; background-position: center; width: 100%; padding-top: 100%;"></div>
                            <?php else : ?>
                            <img src="<?= $placeholder ?>" class="card-img-top" alt="...">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo esc_html(stripslashes($byline->post_title)); ?></h5>
                                <p class="card-text"><?php echo esc_html(stripslashes(wp_trim_words($byline->description, 10, '...'))); ?></p>
                                <!-- Remove delete button -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>