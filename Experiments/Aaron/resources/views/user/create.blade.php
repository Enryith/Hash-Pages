@php /** @var $form Collective\Html\FormBuilder */ @endphp
@php /** @var $user App\Entities\User */ @endphp
@extends('theme.base')
@section('title', 'Created')
@section('content')
    Hello, {{ $user->getName() }}
@endsection
