@extends('theme.base')
@section('title', 'Login')
@section('content')

	<img src="{{ url('/storage/profile_pictures/' . $user->getPicture()) }}" alt="Profile Picture" title="{{ $user->getName() }}">

@endsection
