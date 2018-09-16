@php /** @var $form Collective\Html\FormBuilder */ @endphp
@php /** @var $errors \Illuminate\Support\ViewErrorBag */ @endphp
@php($check = old($id) !== null ? "active" : "")
<div class="form-group">
	<div class="btn-group btn-group-toggle" data-toggle="buttons">
		<label class="btn btn-primary {{ $check }}">
			{{ $form->checkbox($id, 1, null, ["autocomplete" => "off"]) }} {{$label}}
		</label>
	</div>
</div>