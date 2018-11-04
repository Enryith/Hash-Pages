@php /** @var $comments \App\Entities\Comment[] **/ @endphp
@php /** @var $form Collective\Html\FormBuilder */ @endphp
@php $indentation = isset($indentation) ? $indentation : 0 @endphp
@php $maxDepth = 5 @endphp

@foreach($comments as $comment)
	<div style="margin-left: {{$indentation * 30}}px">
		<strong>{{ "@" . $comment->getAuthor()->getUsername() }}</strong>

		@if($indentation < $maxDepth -1)
			<a href="#collapse-{{$comment->getId()}}" data-toggle="collapse" >reply</a>
		@endif
		<br>
		<span>{{ $comment->getComment() }}</span>
		@if($indentation < $maxDepth -1)
		<div class="collapse" id="collapse-{{$comment->getId()}}">
			<div class="mt-2">
				{{ $form->open(['action' => ['Post@comment', $comment->getId()]])}}

				@component("form.textarea")
					@slot('form', $form)
					@slot('id', 'reply')
				@endcomponent

				@component("form.submit")
					@slot('form', $form)
					@slot('label', "Reply")
				@endcomponent

				{{ $form->close() }}
			</div>
		</div>
		@endif
	</div>

	@if($indentation < $maxDepth - 1 && $comment->getChildren()->count() > 0)
		@php /** RECURSION????????? **/ @endphp
		@component("main.comments")
			@slot("form", $form)
			@slot("comments", $comment->getChildren())
			@slot("indentation", $indentation + 1)
		@endcomponent
	@endif
@endforeach
