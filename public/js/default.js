window.onload = function() {
	var logoutLink = document.getElementById("logoutLink");
	var logoutForm = document.getElementById("logoutForm");
	if (logoutLink != null) {
		logoutLink.addEventListener("click", function() {
			logoutForm.submit();
		});
	}

	var deletePost = document.getElementsByClassName('deletePost');
	for (var i in Object.keys(deletePost)) {
		deletePost[i].addEventListener("click", function() {
			if (confirm('本当に削除しますか？')) {
				this.parentNode.submit();
			}
		});
	}
}
