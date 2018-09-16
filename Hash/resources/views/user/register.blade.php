@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Register')
@section('content')

{{ $form->open()}}

@component("form.text")
	@slot('form', $form)
	@slot('id', 'username')
	@slot('label', 'Username:')
@endcomponent

@component("form.text")
	@slot('form', $form)
	@slot('id', 'email')
	@slot('label', 'Email Address:')
@endcomponent

@component("form.text")
	@slot('form', $form)
	@slot('id', 'name')
	@slot('label', 'Full Name:')
@endcomponent

@component("form.password")
	@slot('form', $form)
	@slot('id', 'password')
	@slot('label', 'Password:')
@endcomponent

@component("form.password")
	@slot('form', $form)
	@slot('id', 'password_confirmation')
	@slot('label', 'Password, Again:')
@endcomponent

@component("form.submit")
	@slot('form', $form)
	@slot('label', "Register")
@endcomponent

{{ $form->close() }}

@endsection
