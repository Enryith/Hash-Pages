@php /** @var $discussion App\Entities\Discussion */ @endphp
<div class="btn-group mr-2" role="group" aria-label="Second group">
	<a class="btn btn-secondary" href="">+</a>
	<a class="btn btn-secondary" href="">#{{ $discussion->getTag()->getTag() }}</a>
	<a class="btn btn-secondary" href="">-</a>
</div>