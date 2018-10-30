@php /** @var $discussion App\Entities\Discussion */ @endphp
<div class="btn-group mr-2" role="group" aria-label="Second group">
	<a class="pt-0 pb-0 btn btn-secondary" href=""><strong style="font-size: 1.2rem;" class="text-success text-lg-center">+</strong></a>
	<a class="btn btn-secondary" href="">#{{ $discussion->getTag()->getTag() }}</a>
	<a class="pt-0 pb-0 btn btn-secondary" href=""><strong style="font-size: 1.2rem;" class="text-danger text-lg-center">-</strong></a>
</div>