@php
	/** @var Illuminate\Pagination\LengthAwarePaginator|App\Entities\Post[] $table */
@endphp

@extends('theme.base')
@section('title', $user->getUsername())
@section('content')



	<div class="row mb-3">
		<div class="col-md-auto">
			<img class="img-thumbnail img-fluid profile" src="{{ url($user->getPicture() ? $user->getPicturePublic() : "/img/default.jpg") }}" alt="Profile Picture" title="{{ $user->getName() }}">
		</div>
		<div class="col">
			<h1>
				{{$user->getUsername()}}
				<small class="text-muted">{{$user->getName()}}</small>
			</h1>
			@markdown($user->getBio())
		</div>
	</div>

	@php($hasPosts=false)

	@foreach($table as $post)
		@php($hasPosts=true)
		<h2>
			<a href="/post/{{$post->getId()}}">{{ $post->getTitle() }}</a>
		</h2>

		@if($post->getLink())
			<h4><a href="{{ $post->getLink() }}">{{ $post->getLink() }}</a></h4>
		@else
			<em>Text Post</em>
		@endif

		@markdown($post->getBody())

		<hr>
	@endforeach

	@if(!$hasPosts)
		<p class="js-init text-muted text-center">USER HAS NO POSTS!!! </p>
	@endif

@endsection
