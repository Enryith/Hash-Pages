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
			</div>
		</div>
	</div>
	@if(isset($help))
		<small class="form-text text-muted">{{ $help }}</small>
	@endif
	<div id="{{"$id-warn"}}" class="invalid-feedback" style="display: none;">@lang("validation.select")</div>
	@if($has)
		<!-- Apparently Bootstrap hides invalid feedback unless it's right after an input? -->
		<div class="invalid-feedback d-block">{{ $errors->first($id) }}</div>
	@endif
	{{ $form->hidden($id) }}
</div>
