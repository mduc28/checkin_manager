@extends('admin.layout.main')
@section('title', 'Check-In')
@section('checkin', 'active')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Check-In</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ Auth::user()->role_id == config('handle.role.admin') ? route('dashboard') : route('check_in.create') }}">Home</a></li>
                            <li class="breadcrumb-item active">Check-In</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <form style="display: inline">
            <div class="card col-12 col-md-12 col-lg-12">
                <div class="card-body">
                    <div class="form-group">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs"
                                    id="custom-tabs-three-tab"
                                    role="tablist" >
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#member" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Member</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#guest" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Guest</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active"
                                        id="member"
                                        role="tabpanel"
                                        aria-labelledby="custom-tabs-three-home-tab">
                                    <div>
                                        <div class="form-group">
                                            <label>Code</label>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <input class="form-control" name="id" id="search-text">
                                                </div>
                                                <div class="col-lg-4">
                                                    <button id="search-btn" type="button" class="btn btn-primary"><i class="fas fa-search nav-icon"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <input class="form-control" name="name" id="name-member" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <input class="form-control" name="phone" id="phone-member" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="gender-{{ config('handle.gender.male') }}"
                                                       disabled>
                                                <label class="form-check-label">
                                                    Male
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="gender-{{ config('handle.gender.female') }}"
                                                       disabled>
                                                <label class="form-check-label">
                                                    Female
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="gender-{{ config('handle.gender.other') }}"
                                                       disabled>
                                                <label class="form-check-label">
                                                    Other
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="submit-btn-member" class="btn btn-primary mt-4" disabled>Submit</button>
                                </div>
                                <div class="tab-pane fade"
                                        id="guest"
                                        role="tabpanel"
                                        aria-labelledby="custom-tabs-three-home-tab">
                                    <div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <input class="form-control" name="name" id="name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <input class="form-control" name="phone" id="phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <input class="form-control" name="address" id="address">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Birthday</label>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <input type="date" class="form-control" id="bod">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender-guest" id="male" value="{{ config('handle.gender.male') }}" checked>
                                                <label class="form-check-label" for="male">
                                                    Male
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender-guest" id="female" value="{{ config('handle.gender.female') }}">
                                                <label class="form-check-label" for="female">
                                                    Female
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender-guest" id="another" value="{{ config('handle.gender.other') }}">
                                                <label class="form-check-label" for="another">
                                                    Other
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="submit-btn-guest" class="btn btn-primary mt-4">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('js')
<script>
    $(document).on('click', '#search-btn',function () {
        let searchText = $("#search-text").val();
        $.ajax({
            type: 'POST',
            url: '{{ route('check_in.member') }}',
            data: {
                _token: '{{ csrf_token() }}',
                code: searchText,
            },
            success: function (response) {
                $("#name-member").val(response.data.name)
                $("#phone-member").val(response.data.phone)
                switch (response.data.gender) {
                    case {{ config('handle.gender.male') }}:
                        $("#gender-{{ config('handle.gender.male') }}").prop('checked', true);
                        break;
                    case {{ config('handle.gender.female') }}:
                        $("#gender-{{ config('handle.gender.female') }}").prop('checked', true);
                        break;
                    case {{ config('handle.gender.other') }}:
                        $("#gender-{{ config('handle.gender.other') }}").prop('checked', true);
                        break;
                }
                $('#search-btn').data('id', response.data.id);
                $('#submit-btn-member').prop('disabled', false)
            },
            error: function (xhr){
                toastr.error(xhr.responseJSON.message)
                $("#name-member").val('')
                $("#phone-member").val('')
                $("input[name='gender']").prop('checked', false)
                $('#submit-btn-member').prop('disabled', true)
            }
        });
    });

    $(document).on('click', '#submit-btn-guest', function () {
        $.ajax({
            type: 'POST',
            url: '{{ route('check_in.guest') }}',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#name').val(),
                phone: $('#phone').val(),
                address: $('#address').val(),
                birthday: $('#bod').val(),
                sex: $('input[name="gender-guest"]:checked').val(),
            },
            success: function (response) {
                        toastr.success(response.message)
                    },
            error: function(xhr){
                toastr.error(xhr.responseJSON.message)
            }
        });
    })

    $(document).on('click', '#submit-btn-member', function () {
        let id = $('#search-btn').data('id');
        $.ajax({
            type: 'POST',
            url: '{{ route('check_in.store') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
            },
            success: function (response) {
                toastr.success(response.message)
            },
            error: function(xhr){
                toastr.error(xhr.responseJSON.message)
            }
        });
    })
</script>
@endpush