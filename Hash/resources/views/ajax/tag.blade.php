@php
	use App\Entities\Vote;
	/** @var $discussion App\Entities\Discussion */
	$type = $discussion->hasVoted(auth()->user());
	$agree = $type == Vote::AGREE ? "active" : "";
	$disagree = $type == Vote::DISAGREE ? "active" : "";
@endphp

<div class="btn-group mr-2" role="group" aria-label="Second group">
	@auth
		<button class="btn btn-secondary js-vote js-agree {{$agree}}" data-discussion="{{ $discussion->getId() }}">
			<strong style="font-size: 1.1rem;" class="text-success text-lg-center js-agree-text">
				{{$discussion->getCachedAgree()}}
			</strong>
		</button>
	@endauth

	<a class="btn btn-secondary" href="{{ url("/tag/{$discussion->getTag()->getTag()}") }}">#{{ $discussion->getTag()->getTag() }}</a>

	@auth
		<button class="btn btn-secondary js-vote js-disagree {{$disagree}}" data-discussion="{{ $discussion->getId() }}">
			<strong style="font-size: 1.1rem;" class="text-danger text-lg-center js-disagree-text">
				{{$discussion->getCachedDisagree()}}
			</strong>
		</button>
	@endauth
</div>