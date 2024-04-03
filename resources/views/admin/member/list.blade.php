@extends('admin.layout.main')
@section('title', 'List Member')
@section('member', 'active')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Members</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ Auth::user()->role_id == config('handle.role.admin') ? route('dashboard') : route('check_in.create') }}">Home</a></li>
                            <li class="breadcrumb-item active">Members</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form role="form" id="filter-form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name-filter">Name</label>
                                        <input id="name-filter" name="name" type="text" class="form-control" value="{{ request('name') }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="code-filter">Code</label>
                                    <input type="text" id="code-filter" name="code" class="form-control" value="{{ request('code') }}">
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <div class="">
                                    <a href="{{ route('members.index') }}" class="btn btn-danger mr-3"><i class="fas fa-eraser nav-icon mr-2"></i>Clear</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search nav-icon mr-2"></i>Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-end align-items-end">
                        <div>
                            @if(!empty($restore))
                                <a href="{{ route('members.index') }}" class="btn btn-light"><i class="fas fa-list nav-icon mr-2"></i>List</a>
                            @else
                                <a href="{{ route('members.restore.index') }}" class="btn btn-light"><i class="fas fa-trash-restore nav-icon mr-2"></i>Restore</a>
                            @endif
                            <button id="csv-btn" class="btn btn-primary"><i class="nav-icon fas fa-file-export mr-2"></i>CSV</button>
                            <a href="{{ route('members.create') }}" class="btn btn-success"><i class="fas fa-plus nav-icon mr-2"></i>Create</a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th scope="col" class="table-list">No</th>
                                <th scope="col" class="table-list">Code</th>
                                <th scope="col" class="table-list">Name</th>
                                <th scope="col" class="table-list">Expire Date</th>
                                <th scope="col" class="table-list">Address</th>
                                <th scope="col" class="table-list">Email</th>
                                <th scope="col" class="table-list">Phone</th>
                                <th scope="col" class="table-list">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($members->isNotEmpty())
                                @foreach ($members as $key => $member)
                                    <tr id="record-{{ $member->id }}">
                                        <td class="table-list">{{ ($members->currentPage() - 1) * config('handle.paginate') + $key + 1 }}</td>
                                        <td class="table-list">{{ $member->code }}</td>
                                        <td class="table-list">{{ $member->name }}</td>
                                        <td class="table-list">{{ \Carbon\Carbon::parse($member->expired_date)->format('m-d-Y') }}</td>
                                        <td class="table-list">{{ $member->address }}</td>
                                        <td class="table-list">{{ $member->email }}</td>
                                        <td class="table-list">{{ $member->phone }}</td>
                                        <td class="table-list">
                                            @if(!empty($restore))
                                                <button id="restore-btn" class="btn btn-primary" data-id="{{ $member->id }}"><i class="fas fa-trash-restore nav-icon"></i></button>
                                            @else
                                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-primary"><i
                                                            class="fas fa-edit"></i></a>
                                                <button type="button" data-id="{{ $member->id }}" class="btn btn-danger" id="del-btn"><i class="fas fa-trash"></i></button>
                                                <button type="button" id="print-btn" data-id="{{ $member->id }}"
                                                        class="btn btn-warning" data-toggle="modal" data-target="#exampleModalCenter">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" style="text-align:center">There is no data</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3 mr-3">
                        {{ $members->links('admin.partials.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        
        $(document).on('click', '#print-btn',function () {
            let id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route('members.print') }}',
                data: {
                    id: id,
                },
                success: function (response) {
                    $('.modal-body').html(response)
                }
            });
        });

        $(document).on('click', '#csv-btn',function () {
            let filterForm = $('#filter-form')
            filterForm.attr('action', '{{ route('members.export') }}').submit();
            filterForm.attr('action', '')
        });

        $(document).on('click', '#del-btn', function () {
            let id = $(this).data('id')
            let url = '{{route('members.destroy')}}'

            let data = {
                _token : '{{ csrf_token() }}',
                _method: 'DELETE',
                id     : id,
            }

            confirmAjax(data, url, "delete")
        })

        $(document).on('click', '#restore-btn', function () {
            let id = $(this).data('id');
            let url = '{{ route('members.restore') }}'

            let data = {
                _token: '{{ csrf_token() }}',
                id    : id,
            }

            confirmAjax(data, url, 'restore')
        });
    </script>
@endpush
