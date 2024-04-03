<h3 class="text-center"><b>Member information</b></h3>
<br>
<div class="modal-body">
    <div class="row">
      <div class="col-5">
        <p class="text-center">
            @if (isset($qr_code))
                {!! utf8_decode($qr_code) !!}
            @endif
        </p>
      </div>

      <div class="col-1"></div>

      <div class="col-6">
        <label for="">Code</label>
        <input type="text"
        class="form-control"
        value="{{$member->code}}"
        readonly>
        
        <label for="">Name</label>
        <input type="text"
        class="form-control"
        value="{{$member->name}}"
        readonly>

        <label for="">Email</label>
        <input type="text"
        class="form-control"
        value="{{$member->email}}"
        readonly>

        <label for="">Phone</label>
        <input type="text"
        class="form-control"
        value="{{$member->phone}}"
        readonly>
      </div>
    </div>
  </div>
    <div class="modal-footer">
        <a href="{{ route('members.pdf', $member->id) }}" target="_blank" class="btn btn-warning"><b>Print</b></a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>