@php
	/** @var $tag App\Entities\Tag */
	/** @var $form Collective\Html\FormBuilder */
@endphp

@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', $tag->getTag())
@section('content')

@endsection