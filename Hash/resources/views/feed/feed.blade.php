@extends('theme.base')
@section('title', 'Listen')
@push('scripts')
	<script src="/js/feed.js"></script>
@endpush
@section('content')

<div id="target">

</div>

@verbatim
<script id="template-post" type="x-tmpl-mustache">
	<p> {{ title }}, {{ body }}, {{ author }} </p>
</script>
@endverbatim

@endsection