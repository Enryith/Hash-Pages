@extends('theme.base')
@section('title', 'Login')
@section('content')

	<img style= "object-fit: cover;border-radius:50%" width = "200" height = "200" src="{{ url('/storage/profile_pictures/' . $user->getPicture()) }}" alt="Profile Picture" title="{{ $user->getName() }}" >

	<div style= "font-size: 55px"> {{$user->getUsername()}} </div>

@endsection
