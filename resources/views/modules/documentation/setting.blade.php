@extends('layouts.admin')
@section('title', 'Edit Topic')
@section('content')
    <div class="container-xl">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h2 class="page-title">Setting - {{ $topic->name }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action='{{ url("/admin/documentation/setting", base64_encode($topic->id)) }}' method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label required">Topic name</label>
                                <input type="text" class="form-control" name="name" placeholder="Example : Firecek" value="{{ $topic->name }}" required>
                            </div>
                            <br/>
                            <div class="form-group">
                                <label class="form-label required">Topic URL</label>
                                <input type="text" class="form-control topic-url" name="url" placeholder="Example : app1" value="{{ $topic->url }}" required>
                                <div class="invalid-feedback topic-url-error-msg"></div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <label class="form-label">Assignees</label>
                                <select class="form-control assignees" name="assignees[]" multiple="multiple">
                                    @foreach($user as $usr)
                                        <option value="{{ $usr->id }}">{{ $usr->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="form-label required">Public access</div>
                                <div>
                                    <select class="form-select" name="open_for_public" required>
                                        <option value=0 {{ $topic->open_for_public == 1 ? '' : 'selected' }}>Not allowed</option>
                                        <option value=1 {{ $topic->open_for_public != 1 ? '' : 'selected' }}>Allowed</option>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <input type="submit" class="btn btn-primary" value="Save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container--default .select2-selection--multiple {
    border: 1px solid #e2e3e6 !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: white !important;
}
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function() {
    var assignees = '{{ $assignees }}',
        assigneesArr = assignees.split(',');

    $('.assignees').select2();
    $('.assignees').val(assigneesArr).trigger('change');
})

function validateUrl(value) {
    // only allow alphabets, number and dash
    var charRegExp = /^[a-zA-Z0-9-]+$/;
    if (value.search(charRegExp) != 0) {
        return false;
    }
 
    return true;
}

$('.topic-url').change(function (e) {
    var validateUrlSymbol = validateUrl($('.topic-url').val());
    if (!validateUrlSymbol) {
        $('input[type=submit]').attr('disabled','');
        $('.topic-url').addClass('is-invalid');
        $('.topic-url-error-msg')
            .show()
            .text('You only allowed to use alphabet (a-z/A-Z), number (0-9) and dash (-) symbol');
        
        return;
    }
    
    $.ajax({
        url: '{{ url("/admin/documentation/validate-topic-url") }}',
        method: 'GET',
        data: {
            'url' : $(this).val(),
            'topic_id': '{{ $topic->id }}',
            'exception': '{{ $topic->url }}'
        },
        success: function (res) {
            if (!res.status) {
                $('input[type=submit]').attr('disabled','');
                $('.topic-url').addClass('is-invalid');
                $('.topic-url-error-msg')
                    .show()
                    .text('URL is taken, please use another');

                return;
            }

            $('input[type=submit]').removeAttr('disabled');
            $('.topic-url').removeClass('is-invalid');
            $('.topic-url-error-msg')
                .hide()
                .text('');
        },
        error: function (err) {
            console.log(err);
        }
    });
})
</script>
@endsection