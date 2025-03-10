<?php

add_action('acf/init', function () {
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_6785868418204',
        'title' => 'Page Data',
        'fields' => array(
            array(
                'key' => 'field_6785868526a3c',
                'label' => 'Location',
                'name' => 'location',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_675375a800734',
        'title' => 'Staff',
        'fields' => array(
            array(
                'key' => 'field_675375a8a3896',
                'label' => 'Title',
                'name' => 'title',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_6758b20d63b1b',
                'label' => 'Region',
                'name' => 'region',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_6753837a88ef5',
                'label' => 'Description',
                'name' => 'description',
                'aria-label' => '',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'rows' => '',
                'placeholder' => '',
                'new_lines' => '',
            ),
            array(
                'key' => 'field_675a1f9562651',
                'label' => 'Honorific Suffix',
                'name' => 'honorific_suffix',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_675a1fb162652',
                'label' => 'Credential Type',
                'name' => 'credential_type',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'EducationalOccupationalCredential',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_675a1fba62653',
                'label' => 'Credential Name',
                'name' => 'credential_name',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_675a1fc162654',
                'label' => 'Works For',
                'name' => 'works_for',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'AMFM Mental Health Treatment',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_675a2056d26a0',
                'label' => 'Linkedin Url',
                'name' => 'linkedin_url',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_675375e180573',
                'label' => 'Email',
                'name' => 'email',
                'aria-label' => '',
                'type' => 'email',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'staff',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Staff Data',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_679a6d91170e7',
        'title' => 'In The Press',
        'fields' => array(
            array(
                'key' => 'field_679a6d9119785',
                'label' => 'External URL',
                'name' => 'external_url',
                'aria-label' => '',
                'type' => 'url',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_taxonomy',
                    'operator' => '==',
                    'value' => 'post_tag:in-the-press',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
});

add_action('init', function () {
    register_taxonomy('page_type', array(
        0 => '',
    ), array(
        'labels' => array(
            'name' => 'Types',
            'singular_name' => 'Type',
            'menu_name' => 'Types',
            'all_items' => 'All Types',
            'edit_item' => 'Edit Type',
            'view_item' => 'View Type',
            'update_item' => 'Update Type',
            'add_new_item' => 'Add New Type',
            'new_item_name' => 'New Type Name',
            'search_items' => 'Search Types',
            'not_found' => 'No types found',
            'no_terms' => 'No types',
            'items_list_navigation' => 'Types list navigation',
            'items_list' => 'Types list',
            'back_to_items' => '← Go to types',
            'item_link' => 'Type Link',
            'item_link_description' => 'A link to a type',
        ),
        'public' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ));
});

add_action('init', function () {
    register_post_type('staff', array(
        'labels' => array(
            'name' => 'Staff',
            'singular_name' => 'Staff',
            'menu_name' => 'Staff',
            'all_items' => 'All Staffs',
            'edit_item' => 'Edit Staff',
            'view_item' => 'View Staff',
            'view_items' => 'View Staff',
            'add_new_item' => 'Add New Staff',
            'add_new' => 'Add New Staff',
            'new_item' => 'New Staff',
            'parent_item_colon' => 'Parent Staff:',
            'search_items' => 'Search Staff',
            'not_found' => 'No staff found',
            'not_found_in_trash' => 'No staffs found in Trash',
            'archives' => 'Staff',
            'attributes' => 'Staff Attributes',
            'featured_image' => 'Profile Image',
            'set_featured_image' => 'Set Profile Image',
            'remove_featured_image' => 'Remove Profile Image',
            'use_featured_image' => 'Use as Profile Image',
            'insert_into_item' => 'Insert into staff',
            'uploaded_to_this_item' => 'Uploaded to this staff',
            'filter_items_list' => 'Filter staff list',
            'filter_by_date' => 'Filter staff by date',
            'items_list_navigation' => 'Staff list navigation',
            'items_list' => 'Staff list',
            'item_published' => 'Staff published.',
            'item_published_privately' => 'Staff published privately.',
            'item_reverted_to_draft' => 'Staff reverted to draft.',
            'item_scheduled' => 'Staff scheduled.',
            'item_updated' => 'Staff updated.',
            'item_link' => 'Staff Link',
            'item_link_description' => 'A link to a staff.',
        ),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'menu_position' => 3,
        'menu_icon' => 'dashicons-groups',
        'supports' => array(
            0 => 'title',
            1 => 'thumbnail',
        ),
        'taxonomies' => array(
            0 => 'category',
            1 => 'post_tag',
        ),
        'has_archive' => 'staff',
        'rewrite' => array(
            'with_front' => false,
            'feeds' => false,
        ),
        'delete_with_user' => false,
    ));
});


add_filter('enter_title_here', function ($default, $post) {
    switch ($post->post_type) {
        case 'staff':
            return 'Staff Name';
    }

    return $default;
}, 10, 2);
