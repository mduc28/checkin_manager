@extends('admin.layout.main')
@section('title', 'Check In Manager')
@section('checkin.index', 'active')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Check In Manager</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Check In Manager</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form role="form" id="filter-form">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="form-group col-6">
                                    <label for="date-picker">Date</label>
                                    <input id="date-picker" name="date" type="date" class="form-control" value="{{ request('date') }}">
                                </div>
                                <div class="form-group col-6">
                                    <label for="type-picker">Type</label>
                                    <select id="type-picker" name="type" class="form-control">
                                        <option value="">--All--</option>
                                        <option value="{{ config('handle.is_member.guest') }}" {{ request('type') == config('handle.is_member.guest') ? 'selected' : '' }}>Guest</option>
                                        <option value="{{ config('handle.is_member.member') }}" {{ request('type') == config('handle.is_member.member') ? 'selected' : '' }}>Member</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group justify-content-center d-flex">
                                <a href="{{ route('check_in.index') }}" class="btn btn-danger mr-3"><i class="fas fa-eraser nav-icon mr-2"></i>Clear</a>
                                <button type="submit" id="search-btn" class="btn btn-primary"><i class="fas fa-search nav-icon mr-2"></i>Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-end">
                            <button id="csv-btn" class="btn btn-primary"><i class="nav-icon fas fa-file-export mr-2"></i>CSV</button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col" class="table-list">No</th>
                                    <th scope="col" class="table-list">Code</th>
                                    <th scope="col" class="table-list">Name</th>
                                    <th scope="col" class="table-list">Type</th>
                                    <th scope="col" class="table-list">Check in at</th>
                                    <th scope="col" class="table-list">Phone</th>
                                    <th scope="col" class="table-list">Email</th>
                                    <th scope="col" class="table-list">Address</th>
                                    <th scope="col" class="table-list">Birthday</th>
                                    <th scope="col" class="table-list">Gender</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($aryCheckIn->isNotEmpty())
                                <?php $number = config('handle.start_list') ?>
                                @foreach($aryCheckIn as $key => $check_in)
                                        <?php
                                        $gender = '';
                                        switch ($check_in->members->gender){
                                            case (config('handle.gender.male')):
                                                $gender = 'Male';
                                                break;
                                            case (config('handle.gender.female')):
                                                $gender = 'Female';
                                                break;
                                            case (config('handle.gender.other')):
                                                $gender = 'Other';
                                                break;
                                        }
                                        $number++;
                                        ?>
                                    <tr id="check-in-{{ $check_in->id }}">
                                        <td class="table-list">{{($aryCheckIn->currentPage() - 1) * config('handle.paginate') + $number}}</td>
                                        <td class="table-list">{{ $check_in->members->code }}</td>
                                        <td class="table-list">{{ $check_in->members->name }}</td>
                                        <td class="table-list">{{ $check_in->members->is_member == config('handle.is_member.member') ? 'Member' : 'Guest' }}</td>
                                        <td class="table-list">{{ $check_in->created_at->format('m-d-Y H:i:s') }}</td>
                                        <td class="table-list">{{ $check_in->members->phone }}</td>
                                        <td class="table-list">{{ $check_in->members->email }}</td>
                                        <td class="table-list">{{ $check_in->members->address }}</td>
                                        <td class="table-list">{{ \Carbon\Carbon::parse($check_in->members->birthday)->format('m-d-Y') }}</td>
                                        <td class="table-list">{{ $gender }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center">There is no data</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3 mr-3">
                        {{ $aryCheckIn->links('admin.partials.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('click', '#csv-btn',function () {
            let filterForm = $('#filter-form')
            filterForm.attr('action', '{{ route('check_in.export') }}').submit();
            filterForm.attr('action', '')
        });
    </script>
@endpush