@php /** @var $form Collective\Html\FormBuilder */ @endphp
@php /** @var $errors \Illuminate\Support\ViewErrorBag */ @endphp
@php($has = $errors->has($id))
@php($invalid = $has ? "is-invalid" : "")
@php($danger = $has ? "has-danger" : "")
<div class="form-group {{$danger}}">
	{{ $form->label("$id-text", $label, ["class" => "form-control-label"]) }}
	<div class="typeahead__container">
		<div class="typeahead__field">
			<div class="typeahead__query">
				{{ $form->text("$id-text", null, [
					"class" => "form-control multi $invalid",
					"data-uri" => $uri,
					"data-target" => "input[name='$id']",
					"data-warn" => "#$id-warn"
				]) }}
				<div id="{{"$id-warn"}}" class="invalid-feedback" style="display: none;">@lang("validation.select")</div>
				@if($has)
					<div class="invalid-feedback">{{ $errors->first($id) }}</div>
				@endif
			</div>
		</div>
	</div>
	{{ $form->hidden($id) }}
</div>
