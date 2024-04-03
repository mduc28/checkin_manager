@extends('admin.login.layout.main')
@section('title', 'Login')
@section('content')
<div class="login-box">
    <div class="login-logo">
        <p><b>Admin</b>LTE</p>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form role="form">
                <div class="input-group mb-3">
                    <input type="email" id="login-email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" id="login-password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="button" id="login-btn" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#login-btn').on('click', function() {
            let email = $('#login-email').val();
            let pass = $('#login-password').val();
            let remember = $('#remember').is(':checked') ? {{ config('handle.remember_token.checked') }} : {{ config('handle.remember_token.uncheck') }};

            $.ajax({
                type: "POST",
                url: '{{ route('login') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email,
                    password: pass,
                    remember: remember,
                },
                success: function(response) {
                    window.location.href = response;
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message)
                }
            });
        });
    });
</script>
@endpush