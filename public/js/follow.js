$(() => {
	var button = $(".user-follow-button");
	var form = $(".user-follow-form");
	button.on("click", e => {
		form.prop("disabled", true);
		var url = form.prop("action");
		$.ajax({
			url: url,
			type: "post",
			dataType: "text",
			data: form.serialize(),
			timeout:10000,
		}).done((data) => {
			if ($(".user-follow-status").text() === "観察する") {
				$('.user-follow-status').text("観察中");
				form.prop("action", "/followers/delete");
				button.removeClass("btn-outline-info").addClass("btn-info");
			} else {
				$('.user-follow-status').text("観察する");
				form.prop("action", "/followers/store");
				button.removeClass("btn-info").addClass("btn-outline-info");
			}
		}).fail((XMLHttpRequest, textStatus, errorThrown) => {
			alert("error");
		});
		form.prop("disabled", false);
	});
});
