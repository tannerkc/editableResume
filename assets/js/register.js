$(document).ready(function() {
	$("#hideLogin").click(function() {
		$("#loginForm").hide();
		$("#signupForm").show();
	});
	$("#hideRegister").click(function() {
		$("#loginForm").show();
		$("#signupForm").hide();
	});
});