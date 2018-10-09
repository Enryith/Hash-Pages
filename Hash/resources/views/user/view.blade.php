@extends('theme.base')
@section('title', 'Login')
@section('content')

	<img src="{{ url('/storage/' . $user->getPicturePublic()) }}" alt="Profile Picture" title="{{ $user->getName() }}">

@endsection
