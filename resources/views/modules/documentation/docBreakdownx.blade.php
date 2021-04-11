@extends('layouts.docs-private')

@section('docs-title','Firecek')
@section('title', 'Documentation')

@section('content')
<div id="editorjs">
    <div id="app"></div>
</div>
@endsection

@section('aside-right', 'Documentation')

@section('script')
<script>
function handleSubmit(e) {
    e.preventDefault();
}

$('.add-heading-form').on('submit', function (e) {
    e.preventDefault();
    console.log($(this).serialize());
});
</script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/code@2.7.0/dist/bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/warning@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/raw"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>

<script src="{{ url('js/main-editor.js') }}" type="module" endpoint="{{ url('/api') }}" token="{{ csrf_token() }}"></script>

<!-- Load React. -->
<!-- Note: when deploying, replace "development.js" with "production.min.js". -->
<script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>

<!-- Load our React component. -->
<script src="{{ url('js/docs/docs.js') }}" endpoint="{{ url('/api') }}" token="{{ csrf_token() }}"></script>
@endsection