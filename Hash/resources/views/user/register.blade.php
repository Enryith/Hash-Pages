@php /** @var $form Collective\Html\FormBuilder */ @endphp
@php /** @var $errors \Illuminate\Support\ViewErrorBag */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Register')
@section('content')
{{ $form->open()}}
	<div>
		{{ $form->label("username", "Username:") }}
		{{ $form->text('username') }}
	</div>
	<div>
		{{ $form->label("email", "Email Address:") }}
		{{ $form->text('email') }}
	</div>
	<div>
		{{ $form->label("name", "Full Name:") }}
		{{ $form->text('name') }}
	</div>
	<div>
		{{ $form->label("password", "Password:") }}
		{{ $form->password('password') }}
	</div>
	<div>
		{{ $form->label("password_confirmation", "Password, Again:") }}
		{{ $form->password('password_confirmation') }}
	</div>
	<div>
		{{ $form->submit('Register') }}
	</div>
{{ $form->close() }}
@endsection
