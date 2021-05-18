@extends('layouts.admin')

@section('title', 'Profile')

@section('css')
<style>
.is-invalid {
    border-bottom-width: 1px !important;
    border-bottom: 1px solid #CD2120 !important;
}

.dynamic-input {
    text-align: center;
    border: 0px;
    outline: none;
}

.dynamic-input:focus {
    border-bottom: 1px solid #E2E3E6;
}
</style>
@endsection

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header loading" style="display:none">
                        <div class="loading-wrapper">
                            <div class="spinner-border text-primary loading-spinner" style="display:inline-block;margin-right:10px;" role="status"></div>
                            <div style="display:inline;" class="text-muted loading-text"></div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <input type="file" accept="image/png, image/jpeg" style="display:none">
                            <span class="avatar avatar-xl avatar-rounded" onclick="chooseFile()" style="background-image: url('{{ url(Auth::user()->profile_picture) }}')"></span>
                        </div>
                        <div class="card-title mb-1">
                            <input class="dynamic-input profile-field" value="{{ Auth::user()->name }}" field-type="name" />
                        </div>
                        <div class="text-muted">
                            <input class="dynamic-input profile-field" type='email' style="color:#6E7682" value="{{ Auth::user()->email }}" field-type="email" />
                            <div class="invalid-feedback email-error-msg"></div>
                        </div>
                    </div>
                    <a href="#" class="card-btn">
                        <button class="btn btn-md btn-outline-success">{{ Auth::user()->role->name }}</button>
                    </a>
                </div>

                <div class="card">
                    <div class="card-header loading-password" style="display:none">
                        <div class="loading-password-wrapper">
                            <div class="spinner-border text-primary loading-password-spinner" style="display:inline-block;margin-right:10px;" role="status"></div>
                            <div style="display:inline;" class="text-muted loading-password-text"></div>
                        </div>
                    </div>
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

                        <form class="password-update-form" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label required">Password</label>
                                <input type="password" class="form-control password-main" placeholder="*************" minlength="8" required>
                                <div class="invalid-feedback password-error-msg">123</div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <label class="form-label required">Password Confirmation</label>
                                <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                                <input type="password" class="form-control password-confirmation" placeholder="*************" minlength="8" name="password" required>
                                <div class="invalid-feedback password-error-msg">123</div>
                            </div>
                            <br/>
                            
                            <input type="submit" class="btn btn-primary" value="Change Password">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
var loading = {
    show: function () {
        $('.loading').show();
    },
    hide: function () {
        $('.loading').hide();
    },
    setText: function (text) {
        $('.loading-text').text(text);
    },
    showSpinner: function () {
        $('.loading-spinner').show();
    },
    hideSpinner: function () {
        $('.loading-spinner').hide();
    }
}

var loadingPassword = {
    show: function () {
        $('.loading-password').show();
    },
    hide: function () {
        $('.loading-password').hide();
    },
    setText: function (text) {
        $('.loading-password-text').text(text);
    },
    showSpinner: function () {
        $('.loading-password-spinner').show();
    },
    hideSpinner: function () {
        $('.loading-password-spinner').hide();
    }
}

function chooseFile() {
    $('input[type=file]').click();
}

function uploadFile(file) {
    var formData = new FormData();
    formData.append("_token", "{{ csrf_token() }}");
    formData.append("avatar", file, file.name);
    formData.append("user_id", "{{ Auth::user()->id }}");

    $.ajax({
       url: '{{ url("/admin/profile/update/avatar") }}',
       method: 'POST',
       processData: false,
       contentType: false,
       data: formData,
       beforeSend: function (res) {
           loading.show();
           loading.showSpinner();
           loading.setText('Saving ...');
       },
       success: function (res) {
           setTimeout(function () {
                loading.hideSpinner();
                loading.setText('Change saved');
           }, 500);
       },
       error: function (err) {
           setTimeout(function () {
                loading.hide();
                loading.hideSpinner();
                loading.setText('Oops, look like something went wrong');
           }, 500);
       }
    })
}

function updateNameEmailOrPassword(type, value) {
    var endpoint = '';
    var formData = new FormData();

    formData.append('user_id','{{ Auth::user()->id }}');
    formData.append('_token','{{ csrf_token() }}');

    if (type == 'name') {
        endpoint = '{{ url("/admin/profile/update/name") }}';
        formData.append('name', value);
    } else if (type == 'email') {        
        endpoint = '{{ url("/admin/profile/update/email") }}';
        formData.append('email', value);
    } else if (type == 'password') {
        endpoint = '{{ url("/admin/profile/update/password") }}';
        formData.append('password', value);
    }

    $.ajax({
        url: endpoint,
        method: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function (res) {
           loading.show();
           loading.showSpinner();
           loading.setText('Saving ...');
       },
        success: function (res) {            
            if (type == 'email') {
                if (!res.status) {
                    if (res.msg == 'EMAIL_IS_NOT_AVAILABLE') {
                        $('input[type=email]').addClass('is-invalid');
                        $('.email-error-msg').show();
                        $('.email-error-msg').text('Email is taken, please use another email address');

                        loading.hideSpinner();
                        loading.setText('');
                        return;
                    }
                }

                $('input[type=email]').removeClass('is-invalid');
                $('.email-error-msg').hide();
                $('.email-error-msg').text('');
            }

            if (!res.status) {
                setTimeout(function () {
                    loading.hideSpinner();
                    loading.setText('Oops, looks like something went wrong');
                }, 500);
            }

            setTimeout(function () {
                loading.hideSpinner();
                loading.setText('Change saved');
            }, 500);
        },
        error: function (err) {
            console.log(err);
        }
    });
}

$('.profile-field').change(function (e) {
    var type = $(this).attr('field-type');
    var value = e.target.value;

    updateNameEmailOrPassword(type, value);
});

$('input[type=file]').change(function (e) {
    var file = $(this).get(0).files[0];

    if (file) {
        var reader = new FileReader();

        reader.onload = function(){
            $(".avatar").css("background-image", 'url("'+ reader.result +'")');
            uploadFile(file);
        }

        reader.readAsDataURL(file);
    }
});

$('input[type=password]').keyup(function (e) {
    var passwordMain = $('.password-main').val(),
        passwordConfirmation = $('.password-confirmation').val();

    if (passwordMain != passwordConfirmation) {
        $('input[type=password]').addClass('is-invalid');
        $('input[type=submit]').attr('disabled','');
        $('.password-error-msg').show().text('Password does not match');
    } else {
        $('input[type=password]').removeClass('is-invalid');
        $('input[type=submit]').removeAttr('disabled');
        $('.password-error-msg').hide().text('');
    }
});

$('.password-update-form').submit(function (e) {
    e.preventDefault();

    $.ajax({
        url: '{{ url("/admin/profile/update/password") }}',
        method: 'POST',
        data: $(this).serialize(),
        beforeSend: function () {
            loadingPassword.show();
            loadingPassword.showSpinner();
            loadingPassword.setText('Saving ...');
        },
        success: function (res) {
            setTimeout(function () {
                loadingPassword.hideSpinner();
                loadingPassword.setText('Change saved');
            }, 500);
        },
        error: function (err) {
            setTimeout(function () {
                loadingPassword.hideSpinner();
                loadingPassword.setText('Oops, looks like something went wrong');
            }, 500);
        }
    })
});
</script>
@endsection