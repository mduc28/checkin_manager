@extends('admin.layout.main')
@section('title', 'Edit Member')
@section('member', 'active')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ Auth::user()->role_id == config('handle.role.admin') ? route('dashboard') : route('check_in.create') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Member</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <form>
                                <div class="card-header align-items-end justify-content-end d-flex">
                                    <div>
                                        <a href="{{ route('members.index') }}" class="btn btn-primary"><i class="fas fa-list nav-icon mr-2"></i>List</a>
                                        <button type="button" id="save-btn" data-id="{{$member->id}}" class="btn btn-success"><i class="fas fa-save nav-icon mr-2"></i>Save</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="code">Code</label>
                                                <input type="text"
                                                       class="form-control "
                                                       name="code" id="code" placeholder="Enter code"
                                                       value="{{$member->code}}"
                                                       readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text"
                                                       class="form-control "
                                                       name="name" id="name" placeholder="Enter name"
                                                       value="{{$member->name}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="birthday">Birthday</label>
                                                <input type="date"
                                                       class="form-control "
                                                       name="birthday" id="birthday"
                                                       value="{{$member->birthday}}"
                                                >
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Adress</label>
                                                <input type="text"
                                                       class="form-control "
                                                       name="address" id="address" placeholder="Enter address number"
                                                       value="{{$member->address}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email"
                                                       class="form-control "
                                                       name="email" id="email" placeholder="Enter email"
                                                       value="{{$member->email}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- Theem QR -->
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="exdate">QR Code</label>
                                                <div class=" qr-code">
                                                    <div id="qrcode">
                                                        {!! utf8_decode($qr_code) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="expired_date">Expired Date</label>
                                                <input type="date"
                                                       class="form-control "
                                                       name="expired_date" id="expired_date"
                                                       value="{{$member->expired_date}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text"
                                                       class="form-control "
                                                       name="phone" id="phone" placeholder="Enter phone number"
                                                       value="{{$member->phone}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Sex</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" id="sex1"
                                                           value="1"
                                                           @if ($member->gender == 1)
                                                                checked
                                                           @endif
                                                           >
                                                    <label class="form-check-label" for="sex1">
                                                        Male
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" id="sex2"
                                                           value="2"
                                                           @if ($member->gender == 2)
                                                                checked
                                                           @endif>
                                                    <label class="form-check-label" for="sex2">
                                                        Female
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" id="sex3"
                                                           value="3"
                                                           @if ($member->gender == 3)
                                                                checked
                                                           @endif>
                                                    <label class="form-check-label" for="sex3">
                                                        Other
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('js')
    <script>
        $(function () {
            $('#save-btn').on('click', function () {
                let data = {
                    _token: "{{csrf_token()}}",
                    _method:"PUT",
                    id: $(this).data('id'),
                    name: $('#name').val(),
                    birthday: $('#birthday').val(),
                    address: $('#address').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    gender: $('input[name="gender"]:checked').val(),
                    expired_date: $('#expired_date').val(),
                }

                let url = '{{ route('members.update') }}'
                commonAjax(data, url)
            });
        })
    </script>
@endpush