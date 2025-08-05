$(document).ready(function () {
	$("#clockin").hide();
	$("#userAccountTypeRadio2").click(function () {
		$("#clockin").show();
	});
	$("#userAccountTypeRadio3").click(function () {
		$("#clockin").hide();
	});

	if ($("input[name='clockin']:checked").val() === "enabled") {
		$("#clockin").show();
	}
});