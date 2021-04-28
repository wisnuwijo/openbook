@extends('layouts.docs-private')

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
<!-- Note: when deploying, replace "development.js" with "production.min.js". -->
<script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>
@endsection

@section('docs-title','Firecek')
@section('title', 'Documentation')

@section('content')
<div id="editorjs">
    <input type="hidden" id="active-breakdown-id-helper" value=0 />
</div>
@endsection

@section('aside-right', 'Documentation')

@section('script')
<!-- Load our React component. -->
<script src="{{ url('js/docs/docs.js') }}"></script>
<script>
// save laravel csrf _token
localStorage.setItem('_token', "{{ csrf_token() }}");
// save laravel endpoint
localStorage.setItem('endpoint', "{{ url('/api') }}");

var docs = ReactDOM.render(React.createElement(Docs), document.querySelector('.sidebar-ul'));

function showMsg(msg) {
    $('.page-content').css('margin-top','100px');
    $('#top-dialog')
        .fadeIn()
        .find('.title')
        .empty()
        .append(msg);

    $('#top-dialog')
        .find('.action')
        .empty();
}

function handleBreadcrumbNameChange(elementId, breakdownId) {
    var inputValue = $('#' + elementId).val();
    
    $.ajax({
        url: '{{ url("/api/doc-breadcrumb/update") }}',
        method: 'post',
        data: {
            '_token': '{{ csrf_token() }}',
            'name': inputValue,
            'id': breakdownId
        },
        success: function (data) {
            // change breakdown text accordingly
            $('#breakdown-' + breakdownId).text(inputValue);
        },
        error: function (err) {
            console.log(err);
        }
    })
}

function dismissDeleteBreakdownConfirmation() {
    $('.page-content').css('margin-top','0px');
    $('#top-dialog')
        .fadeOut()
        .find('.title')
        .empty();

    $('#top-dialog')
        .find('.action')
        .empty();
}

function deleteBreakdownConfirmation(id, name, parentId) {
    $('.page-content').css('margin-top','100px');
    $('#top-dialog')
        .fadeIn()
        .find('.title')
        .empty()
        .append(`Watch out! You\'re about to delete <b>${name}</b>, deleted data can\'t be restored`);

    var actionBtn = `<button onclick="dismissDeleteBreakdownConfirmation()" class="btn btn-xs btn-light" style="margin-right:10px;">Cancel</button><button onclick="deleteBreadcrump(${id}, ${parentId})" class="btn btn-xs btn-danger">Delete</button>`;
    $('#top-dialog')
        .find('.action')
        .empty()
        .append(actionBtn);
}

function deleteBreadcrump(id, parentId) {
    $.ajax({
        url: '{{ url("/api/doc-breadcrumb/delete") }}',
        method: 'post',
        data: {
            '_token': '{{ csrf_token() }}',
            'id': id
        },
        success: function (data) {
            // remove parent element if exist
            const isParentDelete = parentId == null || parentId == 'null';
            if (isParentDelete) {
                document.querySelector('.docs-breadcrumb').innerHTML = '';
            }

            // remove current element
            $('#breadcrumb-item-' + id).remove();

            docs.getDocBreakdown();

            showMsg('Success!');
            setTimeout(function () {
                dismissDeleteBreakdownConfirmation();
            }, 2000);
        },
        error: function (err) {
            console.log(err);
            showMsg('Oops. Something went wrong');
        }
    })
}
</script>

<!-- EditorJS. -->
<script src="{{ url('js/main-editor.js') }}" type="module" user-id="{{ Auth::user()->id }}" endpoint="{{ url('/api') }}" token="{{ csrf_token() }}"></script>
@endsection