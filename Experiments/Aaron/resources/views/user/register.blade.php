@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Test')
@section('content')
    {{ $form->open()}}
        <div>
            {{ $form->label("username", "Username:") }}
            {{ $form->text('username', "") }}
        </div>
        <div>
            {{ $form->label("password", "Password:") }}
            {{ $form->password('password') }}
        </div>
        <div>
            {{ $form->label("password_again", "Password, Again:") }}
            {{ $form->password('password_again') }}
        </div>
        <div>
            {{ $form->submit('Register') }}
        </div>
    {{ $form->close() }}
@endsection
