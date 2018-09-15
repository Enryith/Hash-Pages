@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Login')
@section('content')

{{ $form->open()}}

@component("form.text")
	@slot('form', $form)
	@slot('id', 'login')
	@slot('label', 'Username or Email:')
@endcomponent

@component("form.password")
	@slot('form', $form)
	@slot('id', 'password')
	@slot('label', 'Password:')
@endcomponent

@component("form.checkbox")
	@slot('form', $form)
	@slot('id', 'remember')
	@slot('label', 'Remember me')
@endcomponent

@component("form.submit")
	@slot('form', $form)
	@slot('label', "Let's go!")
@endcomponent

{{ $form->close() }}

@endsection
