@php /** @var $form Collective\Html\FormBuilder */ @endphp
@php /** @var $errors \Illuminate\Support\ViewErrorBag */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Login')
@section('content')
{{ $form->open()}}

	@php($name = "login")
	@php($err = $errors->has($name))
	<div class="form-group @if($err) has-error @endif">
		{{ $form->label($name, "Username or Email:", ["class" => "control-label"]) }}
		{{ $form->text($name, null, ["class" => "form-control"]) }}
		@if($err) <div class="help-block">{{ $errors->first($name) }}</div> @endif
	</div>

	@php($name = "password")
	@php($err = $errors->has($name))
	<div class="form-group @if($err) has-error @endif">
		{{ $form->label($name, "Username or Email:", ["class" => "control-label"]) }}
		{{ $form->password($name, ["class" => "form-control"]) }}
		@if($err) <div class="help-block">{{ $errors->first($name) }}</div> @endif
	</div>

	<div class="checkbox">
		<label>
			{{ $form->checkbox('remember', 'true') }} Remember Me
		</label>
	</div>

	<div class="form-group">
		{{ $form->submit("Let's Go", ["class" => "btn btn-primary"]) }}
	</div>
{{ $form->close() }}
@endsection
