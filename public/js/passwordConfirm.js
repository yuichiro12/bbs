$(() => {
	var password = $("#password");
	var passwordConfirm = $("#password-confirm");
	var alert = $('#confirm-alert');
	var submit = $("input[type='submit']");

	passwordConfirm.on('keyup', function () {
		if (password.val() !== passwordConfirm.val()) {
			alert.html('<p style="color:#ff5f75">パスワードと一致しません。</p>');
			submit.prop("disabled", true);
		} else {
			alert.html('');
			submit.prop("disabled", false);
		}
	});
});
