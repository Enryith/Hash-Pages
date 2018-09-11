@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'test')
@section('content')
    {{ $form->open()}}
    <div>
        {{ $form->label("name", "Name ") }}
        {{ $form->text('name', "") }}
    </div>
    <div>
        {{ $form->label("age", "Age ") }}
        {{ $form->text('age', "") }}
    </div>
    <div>
        {{ $form->submit('Submit') }}
    </div>
    {{ $form->close() }}

@endsection
