$(function() {
	$("input[type=file]").change(function () {

		let fieldVal = $(this).val();

		fieldVal = fieldVal.replace("C:\\fakepath\\", "");
		if (fieldVal != undefined || fieldVal != "") {
			$(this).next(".custom-file-label").attr('data-content', fieldVal);
			$(this).next(".custom-file-label").text(fieldVal);
		}
	});
});