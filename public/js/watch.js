$(() => {
	var button = $(".thread-watch-button");
	button.on("click", function(e) {
		var form = $(this).closest("form");
		form.prop("disabled", true);
		var url = form.prop("action");
		$.ajax({
			url: url,
			type: "post",
			dataType: "text",
			data: form.serialize(),
			timeout:10000,
		}).done((data) => {
			var status = form.find(".thread-watch-status");
			if (status.text() === "観察する") {
				status.text("観察中");
				form.prop("action", "/watch/delete");
				$(this).removeClass("btn-outline-info").addClass("btn-info");
			} else {
				status.text("観察する");
				form.prop("action", "/watch/store");
				$(this).removeClass("btn-info").addClass("btn-outline-info");
			}
		}).fail((XMLHttpRequest, textStatus, errorThrown) => {
			alert("error");
		});
		form.prop("disabled", false);
		return false;
	});
});
