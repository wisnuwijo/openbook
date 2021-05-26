@extends('layouts.docs-builder')

@section('head')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/code@2.7.0/dist/bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/warning@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/raw"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>

<!-- Load React. -->
<!-- Note: at development, replace "production.min.js" with "development.js". -->
<!-- Note: when deploying, replace "development.js" with "production.min.js". -->
<script src="https://unpkg.com/react@17/umd/react.production.min.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js" crossorigin></script>
@endsection

@section('title', 'Docs Builder - '. $topic->name)

@section('content')
<div id="docs-builder"></div>
<!-- Load our React component. -->
<script src="{{ url('js/docs-builder/index.js') }}" type="module"></script>
<script>
// save laravel csrf _token
localStorage.setItem('_token', "{{ csrf_token() }}");
// save laravel endpoint
localStorage.setItem('endpoint', "{{ url('/api') }}");
// save laravel initial topic name
localStorage.setItem('initial-topic-name', "{{ $topic->name }}");
// save laravel main url
localStorage.setItem('main-url','{{ url("/admin/documentation/view") }}')
</script>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>
<script src="{{ url('js/main-editor.js') }}" type="module" user-id="{{ Auth::user()->id }}" endpoint="{{ url('/api') }}" token="{{ csrf_token() }}"></script>
@endsection