(function ($) {
	'use strict';

	$(document).ready(function () {
		console.log(amfmLocalize);

		// Hide columns if no data
		if (amfmLocalize.author === '') {
			$('#amfm-byline-col-author').hide();
		}
		if (amfmLocalize.editor === '') {
			$('#amfm-byline-col-editor').hide();
		}
		if (amfmLocalize.reviewedBy === '') {
			$('#amfm-byline-col-reviewer').hide();
			$('#amfm-byline-col-editor').css('border-bottom', 'none !important');
		}

		// Adjust widths to fit 100% total
		if ($(window).width() > 768) {
			var visibleCols = $('.amfm-byline-col:visible').length;
			if (visibleCols > 0) {
				var newWidth = 100 / visibleCols + '%';
				$('.amfm-byline-col').css('width', newWidth);
			}
		} else {
			$('.amfm-byline-col').css('width', '100%');
		}

		// // Set width to 100% on mobile width
		// if ($(window).width() <= 768) {
		// 	$('.amfm-byline-col').css('width', '100%');
		// }
	});

})(jQuery);
