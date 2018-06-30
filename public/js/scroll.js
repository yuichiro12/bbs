$(() => {
	var hash = location.hash;
	if (hash.match(/#[0-9]./) && ($(hash).length > 0)) {
		$("html,body").animate({scrollTop:$(hash).offset().top - 62});
	}
	$(document).on("click", ".notification-item", function() {
		var url = $(this).attr('href');
		if (url.indexOf(location.pathname) === 0) {
			hash = url.replace(location.pathname, "");
			if ($(hash).length === 0) {
				location = url;
				location.reload();
			} else {
				$("html,body").animate({scrollTop:$(hash).offset().top - 62});
			}
		} else {
			location = url;
		}

		return false;
	});
});
