jQuery(document).ready(function ($) {

    console.log("AMFM Elementor Widgets Running")

    $(document).on('click', '.amfm-pagination a', function (e) {
        e.preventDefault();

        let page = $(this).attr('href').split('paged=')[1];
        let filter = $('.amfm-related-posts-widget').data('filter');
        let postsPerPage = $('.amfm-related-posts-widget').data('posts-count');
        
        $.ajax({
            url: amfm_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'amfm_fetch_posts',
                security: amfm_ajax_object.nonce,
                paged: page,
                filter: filter,
                posts_per_page: postsPerPage,
                post_id: amfm_ajax_object.post_id
            },
            beforeSend: function () {
                $('.amfm-related-posts').html('<p>Loading...</p>');
            },
            success: function (response) {
                console.log(response);
                if (response.content) {
                    $('.amfm-related-posts').html(response.content);
                    $('.amfm-pagination').html(response.pagination);
                }
            },
            error: function () {
                $('.amfm-related-posts').html('<p>Error loading posts.</p>');
            },
        });
    });
});