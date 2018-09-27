@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Register')
@section('content')

{{ $form->open()}}

@component("form.text")
	@slot('form', $form)
	@slot('id', 'title')
	@slot('label', 'Title:')
@endcomponent

@component("form.text")
	@slot('form', $form)
	@slot('id', 'link')
	@slot('label', 'Link:')
@endcomponent

@component("form.textarea")
	@slot('form', $form)
	@slot('id', 'body')
	@slot('label', 'Body:')
@endcomponent

@component("form.submit")
	@slot('form', $form)
	@slot('label', "Share")
@endcomponent

{{ $form->close() }}

@endsection
