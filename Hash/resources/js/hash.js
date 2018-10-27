//Makes the file picker dialogue work correctly.
$("input[type=file]").change(function () {
	console.log("hello?");
	let fieldVal = $(this).val().replace("C:\\fakepath\\", "");
	if (fieldVal !== undefined || fieldVal !== "") {
		$(this).next(".custom-file-label").attr('data-content', fieldVal);
		$(this).next(".custom-file-label").text(fieldVal);
	}
});

//Makes the suggestion boxes work
$(".complete").each(function(e) {
	let $this = $(this);
	let uri = $this.data("uri");
	let $target = $($this.data("target"));
	$this.typeahead({
		minLength: 1,
		maxItem: 0, //The server limits results
		emptyTemplate: "No result for {{query}}",
		dynamic: true,
		delay: 500,
		hint: true,
		accent: true,
		highlight :true,
		multiselect: {
			limit: 5,
			limitTemplate: "Maximum selected.",
			cancelOnBackspace: true,
			matchOn: ["id"],
		},
		source: {
			ajax: {
				type: "POST",
				url: uri,
				data: {
					q: "{{query}}",
				}
			}
		},
		callback: {
			onSubmit: function (node, form, items) {
				$target.val(items.map(e => e.id).join(","));
				return true;
			}
		},
	});
});
