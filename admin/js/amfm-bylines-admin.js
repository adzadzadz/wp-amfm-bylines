(function ($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	// Open and close drawer
	$(document).ready(function () {
		$('.amfm-card').on('click', function () {
			var cardTitle = $(this).find('.card-title').text();
			// var cardImage = $(this).find('.card-img-top').attr('src');
			// var cardBody = $(this).find('.card-body').html();

			$('#amfmDrawer .drawer-title').text(cardTitle);
			// $('#amfmDrawer .drawer-body').html('<img src="' + cardImage + '" class="img-fluid mb-3">' + cardBody);
			$('#amfmDrawer').addClass('open');
		});

		$('#closeDrawer').on('click', function () {
			$('#amfmDrawer').removeClass('open');
		});

		// Close drawer when clicking outside of it
		$(document).on('click', function (event) {
			if (!$(event.target).closest('#amfmDrawer, .amfm-card, .media-modal').length) {
				$('#amfmDrawer').removeClass('open');
			}
		});
	});

	// Adjust drawer height to account for admin bar
	$(document).ready(function () {
		var adminBar = $('#wpadminbar');
		var drawer = $('#amfmDrawer');

		if (adminBar.length) {
			var adminBarHeight = adminBar.outerHeight();
			drawer.css({
				'top': adminBarHeight + 'px',
				'height': 'calc(100% - ' + adminBarHeight + 'px)'
			});
		}
	});

})(jQuery);

// Media handler
jQuery(document).ready(function ($) {
	$('#upload_image_button').on('click', function (e) {
		e.preventDefault();
		var mediaFrame;

		// If the media frame already exists, reopen it.
		if (mediaFrame) {
			mediaFrame.open();
			return;
		}

		// Create a new media frame
		mediaFrame = wp.media({
			title: 'Select or Upload Media',
			button: {
				text: 'Use this media'
			},
			multiple: false
		});

		// When an image is selected, run a callback.
		mediaFrame.on('select', function () {
			var attachment = mediaFrame.state().get('selection').first().toJSON();
			$('#image_url').val(attachment.url); // Set the image URL to the input field
		});

		// Finally, open the modal
		mediaFrame.open();
	});
});