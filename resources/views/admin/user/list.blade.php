@extends('admin.layout.main')
@section('title', 'List User')
@section('user', 'active')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter -->
        <div class="row" id="filter-form">
            <div class="col-12">
                <div class="card">
                    <form role="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name-filter">Name</label>
                                        <input type="text" name="name" id="name-filter" class="form-control" value="{{ request('name') }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="role-filter">Role</label>
                                    <select class="form-control" name="role" id="role-filter">
                                        <option></option>
                                        @foreach($aryRole as $role)
                                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <div class="">
                                    <a href="{{ route('users.index') }}" type="button" class="btn btn-danger mr-3"><i class="fas fa-eraser nav-icon mr-2"></i>Clear</a>
                                    <button type="submit" id="search-btn" class="btn btn-primary"><i class="fas fa-search nav-icon mr-2"></i>Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Data -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-end align-items-end">
                        <div>
                            <a href="{{ route('users.create') }}" class="btn btn-success"><i class="fas fa-plus nav-icon mr-2"></i>Create</a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th scope="col" class="table-list">No.</th>
                                <th scope="col" class="table-list">Name</th>
                                <th scope="col" class="table-list">Phone</th>
                                <th scope="col" class="table-list">Email</th>
                                <th scope="col" class="table-list">Role</th>
                                <th scope="col" class="table-list">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if($aryUser->isNotEmpty())
                                @foreach ($aryUser as $key => $user)
                                    <tr id="record-{{ $user->id}}">
                                        <td class="table-list">{{($aryUser->currentPage() - 1) * config('handle.paginate') + $key + 1}}</td>
                                        <td class="table-list">{{ $user->name }}</td>
                                        <td class="table-list">{{ $user->phone }}</td>
                                        <td class="table-list">{{ $user->email }}</td>
                                        <td class="table-list">{{ $user->role_id == config('handle.role.admin') ? 'Admin' : 'Staff' }}</td>
                                        <td class="table-list">
                                            @if($user->id != config('handle.example_admin'))
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                            <button type="button" data-id="{{ $user->id }}" class="btn btn-danger" id="del-btn"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">There is no data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3 mr-3">
                        {{ $aryUser->onEachSide(2)->links('admin.partials.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('click', '#del-btn', function () {
            let id = $(this).data('id')
            let url = '{{ route('users.destroy') }}'

            deleteAjax(id, url)
        })
    </script>
@endpush