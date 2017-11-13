$(() => {
	var uploader = $("form#uploader");
	var imageField = uploader.children("input[name=image]");

	$(".icon-upload").on("click", function() {
		imageField.click();
	});

	imageField.on("change", e => {
		var upload_url = uploader.prop("action");
		var fd = new FormData(uploader.get(0));
		$.ajax({
			url: upload_url,
			type: "post",
			dataType: "text",
			data: fd,
			processData: false,
			contentType: false,
			timeout:10000,
		}).done((data) => {
			var icon = $("#icon");
			icon.html('<img src="' + data + '">');
		}).fail((XMLHttpRequest, textStatus, errorThrown) => {
			alert(textStatus);
		});
	});
});
