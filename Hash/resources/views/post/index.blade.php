@extends('theme.base')
@section('title', 'Landing')
@section('content')

	<div class="container">
		@foreach ($users as $user)
			<?php var_dump($user->); ?>
		@endforeach
	</div>

	{{ $users->links() }}

@endsection