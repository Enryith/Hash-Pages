@php
/** @var $comments \App\Entities\Comment[] **/
/** @var $form Collective\Html\FormBuilder */
$maxDepth = 10;
$indent = 6;
$css = [
	"border-left: ${indent}px solid rgb(" . getRGB(($depth * 36) % 360, 80, 95) . ");",
	"margin-left: " . ($depth * $indent) . "px;",
	"padding-left: 10px;",
	"padding-top: 8px;",
	"overflow: auto;"
];
@endphp

@foreach($comments as $comment)
	<div style="{{ implode(" ", $css) }}">
		<strong>
			<a href="{{ action('User@view', ['username' => $comment->getAuthor()->getUsername()]) }}">
				{{"@" . $comment->getAuthor()->getUsername() }}
			</a>
		</strong>

		@if(auth()->guard()->check() && $depth < $maxDepth -1)
			<a href="#collapse-{{$comment->getId()}}" data-toggle="collapse" >reply</a>
			<a href="{{ action('Post@removeComment', [$comment->getId()]) }}">delete</a>
		@endif

		@markdown($comment->getComment())

		@if(auth()->guard()->check() && $depth < $maxDepth -1)
		@php
			$id = "reply-{$comment->getId()}";
			$has = $errors->has($id);
			$show = $has ? "show" : "";
			$invalid = $has ? "is-invalid" : "";
			$danger = $has ? "has-danger" : ""
		@endphp
		<div class="collapse {{ $show }}" id="collapse-{{ $comment->getId() }}">
			<!--For performance reasons, render manually-->
			<form method="post" action="{{ action('Post@comment', ["id" => $comment->getId()]) }}" accept-charset="UTF-8">
				@csrf
				<div class="form-group {{ $danger }}">
					<textarea name="{{ $id }}" class="form-control {{ $invalid }}" rows="3">{{ old($id)}}</textarea>
					@if($has)
						<div class="invalid-feedback">{{ $errors->first($id) }}</div>
					@endif
				</div>
				<div class="form-group">
					<input class="btn btn-primary" type="submit" value="Reply">
				</div>
			</form>
		</div>
		@endif
	</div>

	@if($depth < $maxDepth - 1 && $comment->getChildren()->count() > 0)
		@php /** RECURSION????????? **/ @endphp
		@component("main.comments")
			@slot("comments", $comment->getChildren())
			@slot("depth", $depth + 1)
		@endcomponent
	@endif

@endforeach
