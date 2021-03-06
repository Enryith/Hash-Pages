@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Update Settings')
@section('content')

	{{ $form->model($user,['files'=>true])}}

	@component("form.text")
		@slot('form', $form)
		@slot('id', 'username')
		@slot('label', 'Username:')
	@endcomponent

	@component("form.file")
		@slot('form', $form)
		@slot('id', 'avatar')
		@slot('label', 'Upload Avatar:')
		@slot('hint', 'Choose a Picture')
		@slot('accept', "image/*")
	@endcomponent

	@component("form.textarea")
		@slot('form', $form)
		@slot('id', 'bio')
		@slot('label', 'Bio:')
	@endcomponent

	@component("form.select")
		@slot('form', $form)
		@slot('options', App\Entities\User::themeOptions())
		@slot('id', 'theme')
		@slot('label', "Theme:")
	@endcomponent

	@component("form.submit")
		@slot('form', $form)
		@slot('label', "Save")
	@endcomponent

	{{ $form->close() }}

@endsection