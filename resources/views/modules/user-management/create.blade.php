@extends('layouts.admin')

@section('title', 'New User')

@section('content')
    <div class="container-xl">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h2 class="page-title">New User</h2>
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

                        <form action='{{ url("/admin/user-management/store") }}' method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label required">Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <br/>
                            <div class="form-group">
                                <label class="form-label required">Email</label>
                                <input type="email" class="form-control" name="email" required>
                                <div class="invalid-feedback email-error-msg">Invalid feedback</div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <label class="form-label required">Password</label>
                                <input type="password" minlength="8" class="form-control" name="password" required>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="form-label required">Role</div>
                                <div>
                                    <select class="form-select" name="role_id" required>
                                        <option value="" selected>Choose role ...</option>
                                        @if(count($role) > 0)
                                            @foreach($role as $rl)
                                                <option value='{{ $rl->id }}'>{{ $rl->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <input type="submit" class="btn btn-primary" value="Add">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
function validateEmailAddress() {
    var email = $('input[type=email]').val();

    $.ajax({
        url: '{{ url("/admin/user-management/verify-email") }}',
        method: 'GET',
        data: {
            'email' : email
        },
        success: function (res) {
            var isEmailInvalid = !res.status;
            if (isEmailInvalid) {
                $('input[type=email]').addClass('is-invalid');
                $('input[type=submit]').attr('disabled','');
                $('.email-error-msg').text('Email is taken, please use another email address');
            } else {
                $('input[type=email]').removeClass('is-invalid');
                $('input[type=submit]').removeAttr('disabled');
                $('.email-error-msg').text('');
            }
        },
        error: function (err) {
            console.log(err);
        }
    })
}

$('input[type=email]').change(function (e) {
    validateEmailAddress();
});
</script>
@endsection