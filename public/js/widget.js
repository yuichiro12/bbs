$(() => {
	// link
	$(".link-insert").on("click", function() {
		var textarea = $(this).closest("form").find("textarea");
		var body = textarea.val();
		var pos = textarea.get(0).selectionStart;
		var before = body.slice(0, pos);
		var after = body.slice(pos);
		textarea.val(before + '[](url)'+ after);		
	});

	// upload image
	var uploader = $("form#uploader");
	var imageField = uploader.children("input[name=image]");
	var currentForm = null;

	$(".image").on("click", function() {
		currentForm = $(this).closest("form");
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
			insert_imgurl(currentForm.find("textarea"), data);
        }).fail((XMLHttpRequest, textStatus, errorThrown) => {
			alert(textStatus);
        });
	});

	insert_imgurl = (jqobj, str) => {
		var body = jqobj.val();
		var pos = jqobj.get(0).selectionStart;
		var before = body.slice(0, pos);
		var after = body.slice(pos);
		jqobj.val(before + '![' + str + '](' + str + ')'+ after);		
	}


	// preview
	$(".preview").on("click", function() {
		var previewUrl = $(".modal").data("url");
		var currentForm = $(this).closest("form");
		$.ajax({
			url: previewUrl,
			type: "post",
			dataType: "html",
			data: currentForm.serialize(),
		}).done((data) => {
			$(".box_inner").html(data);
			$('.modal').modal('show');
        }).fail((XMLHttpRequest, textStatus, errorThrown) => {
			alert(textStatus);
        });
	})
});
