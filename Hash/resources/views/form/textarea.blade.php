@php /** @var $form Collective\Html\FormBuilder */ @endphp
@php /** @var $errors \Illuminate\Support\ViewErrorBag */ @endphp
@php($has = $errors->has($id))
@php($invalid = $has ? "is-invalid" : "")
@php($danger = $has ? "has-danger" : "")
@php($rows = isset($rows) ? $rows : 6)
<div class="form-group {{$danger}}">
	@isset($label)
		{{ $form->label($id, $label, ["class" => "form-control-label"]) }}
	@endisset
	{{ $form->textarea($id, null, ["class" => "form-control $invalid", "rows" => $rows])}}
	@isset($help)
		<small class="form-text text-muted">{{ $help }}</small>
	@endisset
	@if($has)
		<div class="invalid-feedback">{{ $errors->first($id) }}</div>
	@endif
</div>