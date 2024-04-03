@extends('admin.login.layout.main')
@section('title', 'Login')
@section('content')
<div class="register-box">
    <div class="register-logo">
        <p><b>Admin</b>LTE</p>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Please change your password after the first login</p>

            <form action="../../index.html" method="post">
                @if(\Illuminate\Support\Facades\Auth::user()->first_login == config('handle.first_login.false'))
                    <div class="input-group mb-3">
                        <input type="password" id="current-password" class="form-control" placeholder="Current password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="input-group mb-3">
                    <input type="password" id="new-password" class="form-control" placeholder="New password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" id="re-new-password" class="form-control" placeholder="Retype password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                    </div>
                    <div class="col-4">
                        <button type="button" id="submit-btn" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#submit-btn').on('click', function() {
            let newPass = $('#new-password').val()
            let reNewPass = $('#re-new-password').val()
            let currentPass = $('#current-password')
            let url = '{{ route('change.pass.first') }}'

            let data = {
                _token: '{{ csrf_token() }}',
                password: newPass,
                re_password: reNewPass,
            }

            if(currentPass){
                if(currentPass.val() !== undefined) {
                    url = '{{ route('change.password') }}'
                    data.current_password = currentPass.val()
                }
            }

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(response) {
                    toastr.success(response.message)

                    setTimeout(() => {
                        window.location.href = response.route;
                    }, 2500);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message)
                }
            });
        });
    });
</script>
@endpush