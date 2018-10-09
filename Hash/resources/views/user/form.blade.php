@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Update Settings')
@section('content')

	{{ $form->open(['files'=>true])}}

	@component("form.file")
		@slot('form', $form)
		@slot('id', 'avatar')
		@slot('label', 'Upload Avatar:')
		@slot('hint', 'Choose a Picture')
		@slot('accept', "image/*")
	@endcomponent

	@component("form.submit")
		@slot('form', $form)
		@slot('label', "Save")
	@endcomponent

	{{ $form->close() }}

@endsection