@extends('admin.layout.main')
@section('title', 'Dashboard')
@section('dashboard', 'active')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="form-group">
                                <form action="" method="GET">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div>
                                                    <label for="">Date</label>
                                                    <div class="d-flex">
                                                        <input value="{{ request('date_start') }}" type="date" id="start" class="form-control" name="date_start">
                                                        <input value="{{ request('date_end') }}" type="date" id="end" class="form-control" name="date_end">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="">Type Member</label>
                                                    <div class="d-flex">
                                                        <select id="type-picker" class="form-control" name="type_member">
                                                            <option value="" selected>--All--</option>
                                                            <option value="{{ config('handle.is_member.guest') }}"
                                                            @if (request('type_member') == config('handle.is_member.guest')) selected @endif
                                                            >Guest</option>
                                                            <option value="{{ config('handle.is_member.member') }}"
                                                            @if (request('type_member') == config('handle.is_member.member')) selected @endif
                                                            >Member</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div>
                                                    <label for="">Type Statistics</label>
                                                    <div class="d-flex">
                                                        <select class="form-control" name="type_date" id="type">
                                                            <option value="{{ config('handle.type_date.day') }}" selected>Day</option>
                                                            <option value="{{ config('handle.type_date.month') }}"
                                                            @if (request('type_date') == config('handle.type_date.month')) selected @endif
                                                            >Month</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="">Type Age</label>
                                                    <div class="d-flex">
                                                        <select id="type-picker" name="type_age" class="form-control">
                                                            <option value="" selected>--All--</option>
                                                            <option value="{{ config('handle.type_age.under18') }}"
                                                            @if (request('type_age') == config('handle.type_age.under18')) selected @endif
                                                            >Under 18</option>
                                                            <option value="{{ config('handle.type_age.upper19') }}"
                                                            @if (request('type_age') == config('handle.type_age.upper19')) selected @endif
                                                            >Upper 19</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center align-items-center mt-5">
                                            <div class="">
                                                <a href="{{ route('dashboard') }}" class="btn btn-danger mr-3"><i class="fas fa-eraser nav-icon mr-2"></i>Clear</a>
                                                <button id="statistic_submit" type="submit" class="btn btn-primary"><i class="fas fa-search nav-icon mr-2"></i>Statistic</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Thong ke -->
                        <div class="card" id="chart-form"
                        @if (empty(request('type_date')))
                            style="display: none"
                        @else
                            style="display: block"
                        @endif
                        >
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Members</h3>
                                </div>
                            </div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var datas = null;
            @if(isset($arrayDatas))
                datas = Object.values(@json($arrayDatas));
            @endif

            const dataMember = [];
            const dataGuest = [];

            datas.forEach(element => {
                dataMember.push({ date: element.created_date, value: element.member_count });
            });

            datas.forEach(element => {
                dataGuest.push({ date: element.created_date, value: element.guest_count });
            });

            // Tạo mảng chứa các ngày
            const memberDates = dataMember.map(data => data.date);
            const guestDates = dataGuest.map(data => data.date);

            // Tạo mảng chứa các giá trị tương ứng
            const memberValues = dataMember.map(data => data.value);
            const guestValues = dataGuest.map(data => data.value);

            // Tạo biểu đồ
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [...new Set([...memberDates, ...guestDates])],
                    datasets: [
                        {
                            label: 'Members Statistics',
                            data: memberValues,
                            backgroundColor: '#007bff',
                            borderColor: '#007bff',
                            borderWidth: 1
                        },
                        {
                            label: 'Guests Statistics',
                            data: guestValues,
                            backgroundColor: '#ced4da',
                            borderColor: '#ced4da',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks:{
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    </script>
@endpush
