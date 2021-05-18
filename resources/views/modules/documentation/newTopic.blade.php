@extends('layouts.admin')

@section('title', 'New Topic')

@section('content')
    <div class="container-xl">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h2 class="page-title">New Topic</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{ Session::get('status') }}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action='{{ url("/admin/documentation/new-topic") }}' method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label required">Topic name</label>
                                <input type="text" class="form-control" name="name" placeholder="Example : App 1" required>
                            </div>
                            <br/>
                            <div class="form-group">
                                <label class="form-label required">Topic URL</label>
                                <input type="text" class="form-control topic-url" name="url" placeholder="Example : app1" required>
                                <div class="invalid-feedback topic-url-error-msg"></div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <label class="form-label required">Initial Version</label>
                                <input type="text" class="form-control" name="version_name" placeholder="Example : 1.0" required>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="form-label required">Public access</div>
                                <div>
                                    <select class="form-select" name="open_for_public" required>
                                        <option value=0 selected>Not allowed</option>
                                        <option value=1>Allowed</option>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <input type="submit" class="btn btn-primary" value="Next Step">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
function validateUrl(value) {
    // only allow alphabets, number and dash
    var charRegExp = /^[a-zA-Z0-9-]+$/;
    if (value.search(charRegExp) != 0 || value == 'admin') {
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
            .text('You only allowed to use alphabet (a-z/A-Z), number (0-9), dash (-) symbol and do not use reserved word (admin)');
        
        return;
    }

    $.ajax({
        url: '{{ url("/admin/documentation/validate-topic-url") }}',
        method: 'GET',
        data: {
            'url' : $(this).val()
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