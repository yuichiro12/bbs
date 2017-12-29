$(function() {
    var socket = null;
	var notification = $(".header-icon-notification");
	var box = $(".notification-box");
	var host = window.location.host;
	var badge = $("#badge");
	var n = parseInt(badge[0].dataset.notification);

	if (n > 0) addBadge();

    notification.on("click", e => {
		var url = notification.data("url");
		$.ajax({
			url: url,
			type: "get",
			timeout:10000,
		}).done((data) => {
			box.empty().append(data);
			removeBadge();
		});
	});

	if (!window["WebSocket"]) {
		alert("error: Your Browser doesn't support WebSocket.")
	} else {
		socket = new WebSocket("wss://" + host + "/ws");
		socket.onopen = function() {
			socket.send($("#uid").text())
			console.log("WebSocket connection has opened.")
		}
		socket.onclose = function() {
			console.log("WebSocket connection has closed.");
		}
		socket.onmessage = function(e) {
			addBadge();
			countUpBadge();
			var json = JSON.parse(e.data)
			Push.create("のらねこBBS", {
				body: json.message,
				icon: json.icon,
			});
		}
	}

	function addBadge() {
		if (!badge.hasClass("notification-badge")) {
			badge.addClass("notification-badge");
		}
	}

	function removeBadge() {
		badge.removeClass("notification-badge");
	}

	function countUpBadge() {
		badge[0].dataset.notification = n + 1;
	}

});
