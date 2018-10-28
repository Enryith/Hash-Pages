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
	let $warning = $($this.data("warn"));
	$this.typeahead({
		minLength: 1,
		maxItem: 0, //The server limits results
		emptyTemplate: "No result for {{query}}",
		dynamic: true,
		delay: 300,
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
			onResult: function () {
				$this.data("asked", false);
				$warning.hide();
			},
			onSubmit: function (node, form, items) {
				$target.val(items.map(e => e.id).join(","));
				if ($this.val() === "" || $this.data("asked") === true) {
					return true;
				} else {
					$warning.show();
					$this.data("asked", true);
					return false;
				}
			}
		},
	});
});
