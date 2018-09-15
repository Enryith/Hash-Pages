@php /** @var $form Collective\Html\FormBuilder */ @endphp
@php /** @var $errors \Illuminate\Support\ViewErrorBag */ @endphp
<div class="form-group">
	<div class="btn-group btn-group-toggle" data-toggle="buttons">
		<label class="btn btn-primary">
			{{ $form->checkbox($id, 'true', ["autocomplete" => "off"]) }} {{$label}}
		</label>
	</div>
</div>