window.onload = function() {
	var logoutLink = document.getElementById("logoutLink");
	var logoutForm = document.getElementById("logoutForm");
	if (logoutLink != null) {
		logoutLink.addEventListener("click", function() {
			logoutForm.submit();
		});
	}
}
