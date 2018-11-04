@php /** @var $form Collective\Html\FormBuilder */ @endphp
@php /** @var $errors \Illuminate\Support\ViewErrorBag */ @endphp
@php($has = $errors->has($id))
@php($invalid = $has ? "is-invalid" : "")
@php($danger = $has ? "has-danger" : "")
<div class="form-group {{$danger}}">
	{{ $form->label($id, $label, ["class" => "form-control-label"]) }}
	{{ $form->text($id, null, ["class" => "form-control $invalid"]) }}
	@if(isset($help))
		<small class="form-text text-muted">{{ $help }}</small>
	@endif
	@if($has)
		<div class="invalid-feedback">{{ $errors->first($id) }}</div>
	@endif
</div>