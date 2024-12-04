(function ($) {
	'use strict';

	$(document).ready(function () {

		// Hide columns if no data
		// if (amfmLocalize.author === '') {
		// 	$('#amfm-byline-col-author').hide();
		// }
		// if (amfmLocalize.editor === '') {
		// 	$('#amfm-byline-col-editor').hide();
		// }
		// if (amfmLocalize.reviewedBy === '') {
		// 	$('#amfm-byline-col-reviewer').hide();
		// 	$('#amfm-byline-col-editor').css('border-bottom', 'none !important');
		// }

		let border_left = $('<div>', {
			class: 'amfm-border-left'
		});

		if (amfmLocalize.author == '1') {
			$('#amfm-byline-col-author').css('display', 'flex');
		}
		if (amfmLocalize.editor == '1') {
			$('#amfm-byline-col-editor').css('display', 'flex');

			let editor_border = border_left.clone();
			$('#amfm-byline-col-editor').append(editor_border);
		}
		if (amfmLocalize.reviewedBy == '1' && amfmLocalize.editor == '1') {
			$('#amfm-byline-col-reviewer').css('display', 'flex');
			$('#amfm-byline-col-editor').css('border-bottom', 'none !important');

			let reviewer_border = border_left.clone();
			$('#amfm-byline-col-reviewer').append(reviewer_border);
		}

		// Adjust widths to fit 100% total
		// if ($(window).width() > 768) {
		// 	var visibleCols = $('.amfm-byline-col:visible').length;
		// 	if (visibleCols > 0) {
		// 		var newWidth = 100 / visibleCols + '%';
		// 		$('.amfm-byline-col').css('width', newWidth);
		// 	}
		// } else {
		// 	$('.amfm-byline-col').css('width', '100%');
		// }

		// Set width to 100% on mobile width
		if ($(window).width() <= 768) {
			$('.amfm-byline-col').css('width', '100%');
		}
	});

})(jQuery);