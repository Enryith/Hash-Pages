//Makes the file picker dialogue work correctly.
$("input[type=file]").change(function () {
	let fieldVal = $(this).val().replace("C:\\fakepath\\", "");
	if (fieldVal !== undefined || fieldVal !== "") {
		$(this).next(".custom-file-label").attr('data-content', fieldVal);
		$(this).next(".custom-file-label").text(fieldVal);
	}
});

//Makes the suggestion boxes work for multi selects
$(".multi").each(function(e) {
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

//Makes the suggestion boxes work
$(".complete").each(function(e) {
	let $this = $(this);
	let uri = $this.data("uri");
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
			onSubmit: function (node, form, item) {
				if ((item !== null && item.display === $this.val()) || $this.data("asked") === true) {
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

//Voting handling
$(".js-vote").click(function () {
	let type = "";
	let $this = $(this);
	if ($this.hasClass("js-agree")) type = "agree";
	if ($this.hasClass("js-disagree")) type = "disagree";
	$this.parent().find(".js-vote").removeClass("active");

	$.ajax({
		type:'POST',
		url:'/ajax/vote',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {
			discussion: $this.data("discussion"),
			type: type,
		},
		success: function(data){
			console.log(data);
			if (data["success"] === "changed" || data["success"] === "created") $this.addClass("active");
			$this.parent().find(".js-agree-text").text(data["votes"]["agree"]);
			$this.parent().find(".js-disagree-text").text(data["votes"]["disagree"]);
		},
		error: function() {
			$this.tooltip({
				title: "Error",
				trigger: "manual"
			}).tooltip("show");

			setTimeout(function() {
				$this.tooltip("hide");
			}, 2000);
		}
	})
});

