@php /** @var $post App\Entities\Post */ @endphp
@php /** @var $form Collective\Html\FormBuilder */ @endphp
@php /** @var $errors \Illuminate\Support\ViewErrorBag */ @endphp
@php($collapse = $errors->count() > 0 ? "" : "collapse")
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', e($post->getTitle()))
@section('content')

<div class="card mt-3 mb-3">
	<h1 class="card-header">
		{{ $post->getTitle() }}
		<small class="text-muted">{{"@" . $post->getAuthor()->getUsername() }}</small>
	</h1>
	@if($post->getLink())
		<ul class="list-group list-group-flush">
			<li class="list-group-item">
				<h3 class="mb-0"><a href="{{ $post->getLink() }}">{{ $post->getLink() }}</a></h3>
			</li>
		</ul>
	@endif
	<div class="card-body">
		<div class="card-text">
			{{$post->getBody()}}
		</div>
	</div>
</div>

@foreach($post->getDiscussions() as $d)
	<div class="card mt-3 mb-3">
		<div class="card-header pl-3">
			<div class="float-left">
				@component("ajax.tag")
					@slot("discussion", $d)
				@endcomponent
			</div>
			<h4 class="mt-1 mb-1 float-left">
				{{ $d->getTitle() }}
				<small class="text-muted">{{"@" . $post->getAuthor()->getUsername() }}</small>
			</h4>
		</div>
		<div class="card-body">
			<div class="card-text">
				{{ $d->getComments()[0] ? $d->getComments()[0]->getComment() : "?" }}
			</div>
		</div>
	</div>
@endforeach

@auth
	<button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#join">
		Add a Tag
	</button>

	<div class="{{ $collapse }}" id="join">
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
@endsection