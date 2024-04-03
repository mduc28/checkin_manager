@extends('admin.layout.main')
@section('title', 'Edit User')
@section('user', 'active')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
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
                                    <input type="hidden" data-id="{{ $user->id }}" id="user-id">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text"
                                               class="form-control"
                                               name="name" id="name" placeholder="Enter name" value="{{ $user->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email"
                                               class="form-control"
                                               name="email" id="email" placeholder="Enter email" value="{{ $user->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text"
                                               class="form-control"
                                               name="phone" id="phone" placeholder="Enter phone" value="{{ $user->phone }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select name="role" id="role" class="form-control">
                                            @foreach ($aryRole as $role)
                                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
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
        $(document).ready(function () {
            $('#sbm-btn').on('click', function () {
                let data = {
                    _token : '{{ csrf_token() }}',
                    _method: 'PUT',
                    id     : $('#user-id').data('id'),
                    name   : $('#name').val(),
                    email  : $('#email').val(),
                    phone  : $('#phone').val(),
                    role   : $('#role').val(),
                }

                let url = '{{ route('users.update') }}'

                commonAjax(data, url)
            })
        })
    </script>
@endpush