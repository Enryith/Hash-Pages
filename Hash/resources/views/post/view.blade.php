@php
/** @var $post App\Entities\Post */
/** @var $form Collective\Html\FormBuilder */
/** @var $errors \Illuminate\Support\ViewErrorBag */
$show = $errors->has('title') || $errors->has('tag') || $errors->has('comment') ? "show" : "";
@endphp

@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', e($post->getTitle()))
@section('content')

<div class="card mt-3 mb-3">
	<h1 class="card-header">
		{{ $post->getTitle() }}
		<small class="text-muted">
			<a href="{{ action('User@view', ['username' => $post->getAuthor()->getUsername()]) }}">{{"@" . $post->getAuthor()->getUsername() }}</a>
			@can('modify-post', $post)
				<a href="{{ action('Post@deleteForm', ['post' => $post->getId()]) }}">Delete</a>
				<a href="#collapse-post-edit-{{$post->getId()}}" data-toggle="collapse" >Edit</a>
			@endcan
		</small>
	</h1>
	<div class="card-body pb-0">
		@if($post->getLink())
			<h3><a href="{{ $post->getLink() }}">{{ $post->getLink() }}</a></h3>
		@endif

		<div class="card-text">
			@can('modify-post', $post)

				<div class="collapse {{ $show }}" id="collapse-post-edit-{{ $post->getId() }}">
					{{ $form->model($post, ['action' => ['Post@edit', $post->getId()]]) }}

					@component("form.textarea")
						@slot('form', $form)
						@slot('id', 'body')
						@slot('label', 'Body:')
					@endcomponent

					@component("form.submit")
						@slot('form', $form)
						@slot('label', "Edit")
					@endcomponent

					{{ $form->close() }}
				</div>

			@endcan
			@markdown($post->getBody())
		</div>
	</div>
</div>

@foreach($post->getDiscussions() as $d)
	<div class="card mt-3 mb-3">
		<div class="card-header pl-3">
			<div class="float-left">
				<div class="btn btn-dark" data-toggle="collapse" data-target="#top-reply-{{$d->getId()}}">
					Reply
				</div>
			</div>
			<div class="float-left ml-3">
				@component("ajax.tag")
					@slot("discussion", $d)
				@endcomponent
			</div>
			<h4 class="mt-1 mb-1 float-left inline-title">
				{{ $d->getTitle() }}
				<small class="text-muted">
					@can("admin")
						<a href="{{ action('Discussion@form', ['discussion' => $d->getId()]) }}">Delete</a>
					@endif
				</small>
			</h4>
		</div>
		<div class="card-body">
			<div class="collapse" id="top-reply-{{$d->getId()}}">

				{{ $form->open(['action' => ['Comment@root', $d->getId()]])}}

				@component("form.textarea")
					@slot('form', $form)
					@slot('id', 'reply')
					@slot('label', "Reply to {$d->getTitle()}")
					@slot('rows', 3)
				@endcomponent

				<!--For performance reasons, render manually-->
				<div class="form-group"><input class="btn btn-primary" type="submit" value="Reply"></div>

				{{ $form->close() }}
			</div>
			<div class="card-text">

				@component("main.comments")
					@slot("comments", $d->getRootComments())
					@slot("depth", 0)
				@endcomponent

				@if($d->getRootComments()->count() == 0)
					<span class="text-muted">There's nothing here. Add to the discussion with the "Reply" button</span>
				@endif
			</div>
		</div>
	</div>
@endforeach

@auth
	<button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#join">
		Add a Tag
	</button>

	<div class="collapse {{ $show }}" id="join">
		<div class="card mt-3">
			<div class="card-header">Add a tag by starting a new discussion!</div>
			<div class="card-body border-secondary pb-0">

				{{ $form->open(["autocomplete" => 'off'])}}

				@component("form.text")
					@slot('form', $form)
					@slot('id', 'title')
					@slot('label', 'Title:')
					@slot('help', 'Start a new discussion of this post with a title.')
				@endcomponent

				@component("form.complete")
					@slot('form', $form)
					@slot('id', 'tag')
					@slot('uri', '/ajax/tags')
					@slot('label', "Tag:")
					@slot('help', "Give this post and your discussion a new tag.")
				@endcomponent

				@component("form.textarea")
					@slot('form', $form)
					@slot('id', 'comment')
					@slot('label', 'Comment:')
					@slot('help', 'Give an initial comment why you think this tag should be included.')
				@endcomponent

				@component("form.submit")
					@slot('form', $form)
					@slot('label', "Launch Discussion")
				@endcomponent

				{{ $form->close() }}
			</div>
		</div>
	</div>
@endauth
<div class="mb-5"></div>
@endsection