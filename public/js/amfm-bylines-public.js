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
		}

		// Adjust widths to fit 100% total
		var visibleCols = $('.amfm-byline-col:visible').length;
		if (visibleCols > 0) {
			var newWidth = 100 / visibleCols + '%';
			$('.amfm-byline-col').css('width', newWidth);
		}
	});

})(jQuery);
