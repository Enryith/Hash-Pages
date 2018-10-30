@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Create Tag')
@section('content')

{{ $form->open()}}

@component("form.text")
	@slot('form', $form)
	@slot('id', 'tag')
	@slot('label', 'Tag Name:')
@endcomponent

@component("form.submit")
	@slot('form', $form)
	@slot('label', "Create Tag")
@endcomponent

{{ $form->close() }}

@endsection
