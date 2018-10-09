@php /** @var $form Collective\Html\FormBuilder */ @endphp
@php /** @var $errors \Illuminate\Support\ViewErrorBag */ @endphp
@php($has = $errors->has($id))
@php($invalid = $has ? "is-invalid" : "")
@php($danger = $has ? "has-danger" : "")
@php($hint = $hint ?? $label)
<div class="form-group {{$danger}}">
	{{ $form->label($id, $label, ["class" => "form-control-label"]) }}
	<div class="custom-file">
		{{ $form->file($id, ["class" => "custom-file-input $invalid", "accept" => $accept]) }}
		{{ $form->label($id, $hint, ["class" => "custom-file-label"]) }}
		@if($has)
			<div class="invalid-feedback">{{ $errors->first($id) }}</div>
		@endif
	</div>
</div>

