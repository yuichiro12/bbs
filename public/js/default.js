window.onload = function() {
	var logoutLink = document.getElementById("logoutLink");
	var logoutForm = Document.getElementById("logoutForm");
	logoutLink.addEventListener("click", function() {
		logoutForm.submit();
	});
}
