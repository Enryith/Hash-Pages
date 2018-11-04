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
		<h3><a href="/post/{{ id }}">{{ title }}</a></h3>
		{{ body }}
		{{ author }}
	</div>
</script>
@endverbatim

@endsection