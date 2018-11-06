@extends('theme.base')
@section('title', 'Listen')
@push('scripts')
	<script src="/js/feed.js"></script>
@endpush
@section('content')

	<div class="jumbotron p-2">
		<h1>This page receives live updates</h1>
	</div>

	<p class="js-init">No posts, discussions, or comments have been made since opening this page.</p>

<div id="target">

</div>

@verbatim
<script id="template-post" type="x-tmpl-mustache">
	<div class="jumbotron p-2">
		<h5 class="mb-0 pb-0"><i>New Post</i></h5>
		<i><small>from <a href="/user/{{ author }}">{{ author }}</a></small></i>
		<h3>Title: <a href="/post/{{ id }}">{{ title }}</a></h3>
		{{ body }}<br>
	</div>
</script>

<script id="template-discussion" type="x-tmpl-mustache">
	<div class="jumbotron p-2">
		<h5 class="mb-0 pb-0"><i>New Discussion on {{ postTitle }}</a></i></h5>
		<i><small>from <a href="/user/{{ author }}">{{ author }}</a></small></i>
		 <h4>Title: <a href="/post/{{ id }}">{{ discTitle }}</a></h4>
		{{ comment }}<br>
	</div>
</script>

<script id="template-comment" type="x-tmpl-mustache">
	<div class="jumbotron p-2">
		<h5 class="mb-0 pb-0"><i>New Comment @ {{ discTitle }} on {{ postTitle }}</a></i></h5>
		<i><small>from <a href="/user/{{ author }}">{{ author }}</a></small></i>
		<h5>{{ author }} said: <a href="/post/{{ id }}">"{{ comment }}"</a></h5>
	</div>
</script>
@endverbatim

@endsection