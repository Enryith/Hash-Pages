@php /** @var $form Collective\Html\FormBuilder */ @endphp
@php /** @var $errors \Illuminate\Support\ViewErrorBag */ @endphp
@php($check = old($id) !== null ? "active" : "")
<div class="form-group">
	<label class="m-0">
		{{ $form->checkbox($id, 1, null, ["autocomplete" => "off"]) }} {{$label}}
	</label>
</div>