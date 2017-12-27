$(function() {
    var socket = null;
	var host = window.location.host;
    $(".nav-header").click(function() {
        if (!socket) {
            alert("error: WebSocket connection has not opened.");
            return false;
        }
		var msg = JSON.stringify({
			"url": "https://bbs-localhost/image/users/5a253d71b6b7c858171528.png",
			"message": "movさんが重症です。"
		})
        socket.send(msg);
        return false;
    });
    if (!window["WebSocket"]) {
        alert("error: Your Browser doesn't support WebSocket.")
    } else {
        socket = new WebSocket("wss://" + host + "/ws");
		socket.onopen = function() {
			console.log("WebSocket connection starts.")
		}
        socket.onclose = function() {
            console.log("WebSocket connection has closed.");
        }
        socket.onmessage = function(e) {
			var n = $("#badge")[0].dataset.notification;
			$("#badge")[0].dataset.notification = parseInt(n) + 1
            console.log(JSON.parse(e.data));
			var json = JSON.parse(e.data)
			Push.create("のらねこBBS", {
				body: json.message,
				icon: json.url,
			});
        }
    }
});
