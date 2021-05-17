@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="container-xl">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h2 class="page-title">Edit User</h2>
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

                        <form action='{{ url("/admin/user-management/update", base64_encode($user->id)) }}' method="POST">
                            <div class="accordion" id="accordionExample">
                                <div class="card" style="margin-bottom:0px;">
                                    <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        General Information
                                        </button>
                                    </h2>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-label required">Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                        </div>
                                        <br/>
                                        <div class="form-group">
                                            <label class="form-label required">Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                            <div class="invalid-feedback email-error-msg">Invalid feedback</div>
                                        </div>
                                        <br/>
                                        <div class="form-group">
                                            <div class="form-label required">Role</div>
                                            <div>
                                                <select class="form-select" name="role_id" required>
                                                    <option value="">Choose role ...</option>
                                                    @if(count($role) > 0)
                                                        @foreach($role as $rl)
                                                            <?php
                                                                $isSelected = '';
                                                                if ($rl->id == $user->role_id) {
                                                                    $isSelected = 'selected';
                                                                }
                                                            ?>

                                                            <option value='{{ $rl->id }}' {{ $isSelected }}>{{ $rl->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <br/>
                                    </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Security
                                        </button>
                                    </h2>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="text-muted">
                                            Left blank if you do not want to change the password
                                            <hr />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label required">Password</label>
                                            <input type="password" minlength="8" class="form-control password-main" name="">
                                            <div class="invalid-feedback password-error-msg"></div>
                                        </div>
                                        <br/>
                                        <div class="form-group">
                                            <label class="form-label required">Password Confimation</label>
                                            <input type="password" minlength="8" class="form-control password-confirmation" name="password">
                                            <div class="invalid-feedback password-error-msg"></div>
                                        </div>
                                        <br/>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Save">
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
            'email' : email,
            'exception' : '{{ $user->email }}'
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

$('.password-confirmation, .password-main').keyup(function (e) {
    var passwordMainValue = $('.password-main').val();
    var passwordConfirmValue = $('.password-confirmation').val();
    
    if (passwordMainValue != passwordConfirmValue) {
        $('input[type=password]').addClass('is-invalid');
        $('input[type=submit]').attr('disabled','');
        $('.password-error-msg').text('Password does\'t match');
        return;
    } else {
        $('input[type=password]').removeClass('is-invalid');
        $('input[type=password]').addClass('is-valid');
        $('.password-error-msg').text('');
        $('input[type=submit]').removeAttr('disabled','');
    }
});
</script>
@endsection