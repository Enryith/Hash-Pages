//Makes the file picker dialogue work correctly.
$("input[type=file]").change(function () {
	console.log("hello?");
	let fieldVal = $(this).val().replace("C:\\fakepath\\", "");
	if (fieldVal !== undefined || fieldVal !== "") {
		$(this).next(".custom-file-label").attr('data-content', fieldVal);
		$(this).next(".custom-file-label").text(fieldVal);
	}
});