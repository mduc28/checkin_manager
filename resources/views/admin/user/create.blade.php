@extends('admin.layout.main')
@section('title', 'Create User')
@section('user', 'active')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Create User</li>
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
                                <div class="card-header d-flex align-items-end justify-content-end">
                                    <div>
                                        <a href="{{ route('users.index') }}" class="btn btn-primary"><i class="fas fa-list nav-icon mr-2"></i>List</a>
                                        <button type="button" class="btn btn-success" id="sbm-btn"><i class="fas fa-save nav-icon mr-2"></i>Save</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text"
                                               class="form-control"
                                               name="name" id="name" placeholder="Enter name">

                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email"
                                               class="form-control"
                                               name="email" id="email" placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text"
                                               class="form-control"
                                               name="phone" id="phone" placeholder="Enter phone">
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select name="role" id="role" class="form-control">
                                            @foreach ($aryRole as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password"
                                               class="form-control"
                                               name="password" id="password" placeholder="Password">

                                    </div>
                                    <div class="form-group">
                                        <label for="re-password">Re-password</label>
                                        <input type="password"
                                               class="form-control"
                                               name="re_password" id="re_password" placeholder="Re-password">

                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function (){
            $('#sbm-btn').on('click', function () {
                let data = {
                    _token     : '{{ csrf_token() }}',
                    name       : $('#name').val(),
                    email      : $('#email').val(),
                    phone      : $('#phone').val(),
                    role       : $('#role').val(),
                    password   : $('#password').val(),
                    re_password: $('#re_password').val(),
                }

                let url = '{{ route('users.store') }}'

                commonAjax(data, url)
            })
        })
    </script>
@endpush