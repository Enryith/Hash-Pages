@extends('theme.base')
@section('title', 'Feed')
@push('scripts')
	<script src="/js/feed.js"></script>
@endpush
@section('content')

	<p class="js-init text-muted text-center">This page receives live updates. No posts, discussions, or comments have been made since opening this page.</p>
	<div id="target"></div>

@verbatim
<script id="template-post" type="x-tmpl-mustache">
	<div class="jumbotron p-3 mb-3">
		<h3 class="mb-0 pb-0">New Post:
			<a href="/post/{{ id }}">
				{{ title }}
			</a>
		</h3>
		<em>
			<small>
				from <a href="/user/{{ author }}">{{ author }}</a>
			</small>
		</em>

		<p class="mb-0">{{ body }}</p>
	</div>
</script>

<script id="template-discussion" type="x-tmpl-mustache">
	<div class="jumbotron p-3 mb-3">
		<h3 class="mb-0 pb-0">
			<em>
				New Discussion on {{ postTitle }}
				called <a href="/post/{{ id }}">{{ discTitle }}</a>
			</em>
		</h3>
		<em>
			<small>
				from <a href="/user/{{ author }}">{{ author }}</a>
			</small>
		</em>

		<p class="mb-0">{{ comment }}</p>
	</div>
</script>

<script id="template-comment" type="x-tmpl-mustache">
	<div class="jumbotron p-3 mb-3">
		<h4 class="mb-0 pb-0"><em>New Comment @ {{ discTitle }} on {{ postTitle }}</em></h4>
		<em>
			<small>
				from <a href="/user/{{ author }}">{{ author }}</a>
			</small>
		</em>

		<p class="mb-0">{{ author }} said:
			<a href="/post/{{ id }}">"{{ comment }}"</a>
		</p>
	</div>
</script>
@endverbatim

@endsection