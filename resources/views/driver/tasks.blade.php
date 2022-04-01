@extends('layouts.driver')
@section('content')
<div class="container" >
 <div class="row justify-content-center">
  <div class="col-md-12 text-center">
    <a href="#" class="navbar-brand">
      <img src="{{ URL::to('/') }}/images/fleetopslogo.png" alt="AdminLTE Logo">
    </a>
    <h3 style="color: lightgray">My Account</h3>
  </div>
</div>
<div class="card card-success">
  <div class="card-header">
   @if($VBM == "Hire Purchase")
   <h5 class="title" style="text-align:center;">Hire Purchase Customer</h5>
   @elseif($VBM == "Rental")
   <h5 class="title" style="text-align:center;">Vehicle Rental Customer</h5>
   @else
   <h5 class="title" style="text-align:center;">Ride Hailing Driver</h5>
   @endif

 </div>
 <div class="card-body">
   @if(session()->has('success'))
  <div class="alert alert-success alert-dismissable" style="margin: 15px;">
    <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong> {{ Session::get('success') }} </strong>
  </div>
  @endif
  <input type="hidden" id="VNO" name="VNO" value="{{ $VNO }}">
  <div class="row justify-content-center">
    <div class="col-md-12">
     <label class="col-form-label">Account Name:&nbsp; </label>{{ $DNM }}
   </div>
   <div class="col-md-12">
     <label class="col-form-label">Vehicle Reg No:&nbsp; </label>{{ $VNO }}
   </div>
   <div class="col-md-12">
     <label class="col-form-label">Reg Phone Number:&nbsp; </label>{{ $DCN }}
   </div>
 </div>
 <hr>

 <div class="row">
  <div class="col-md-12">
    @if($LEX == 1)
   <a href="{{ url('uploadlicence') }}"> <i style="float:right;margin-top: 80px;" class="fa fa-upload"></i></a>
    @endif
   <div class="row justify-content-center">
    <h5 style="color: lightgray">Tasks</h5>
    <div class="col-md-12">
     <label class="col-form-label">Licence Renewal - </label> {{ $DNO }} 
   </div>
   <div class="col-md-12">
     <label class="col-form-label">Expiry Date  : </label> {{ $LEXD }}
     @if($LEX == "1") 
     <span class="text-danger">(expired)</span>
     @endif
   </div> 
   <div class="col-md-12">
    <p>Please take a snapshot of renewed license</p>
  </div>
</div>
</div>
</div>
<hr>

<div class="row">
  <div class="col-md-12">
   @if($IEX == "1")
   <a href="{{ url('uploadinsurance') }}"> <i style="float:right;margin-top: 80px;" class="fa fa-upload"></i></a>
   @endif
   <div class="row justify-content-center">
    <div class="col-md-12">
     <label class="col-form-label">Insurance Renewal</label>
   </div>
   <div class="col-md-12">
     <label class="col-form-label">Expiry Date  : </label> {{ $IEXD }} 
     @if($IEX == "1") 
     <span class="text-danger">(expired)</span>
     @endif
   </div> 
   <div class="col-md-12">
    <p>Please take a snapshot of renewed Insurance</p>
  </div>
</div>
</div>
</div>
<hr>

<div class="row">
  <div class="col-md-12">
   @if($REX == "1")
   <a href="{{ url('uploadroadworthy') }}"> <i style="float:right;margin-top: 80px;" class="fa fa-upload"></i></a>
   @endif
   <div class="row justify-content-center">
    <div class="col-md-12">
     <label class="col-form-label">Roadworthy Cert Renewal</label>
   </div>
   <div class="col-md-12">
     <label class="col-form-label">Expiry Date  : </label> {{ $REXD }} 
     @if($REX == "1") 
     <span class="text-danger">(expired)</span>
     @endif
   </div> 
   <div class="col-md-12">
    <p>Please take a snapshot of renewed Roadworthy Cert</p>
  </div>
</div>
</div>
</div>
<hr>

<div class="row">
  <div class="col-md-12">
   @if($file_name != "")
   <a href="" onclick="acceptance_code()"> <i style="float:right;margin-top: 80px;" class="fa fa-eye"></i></a>
   @endif
   <div class="row justify-content-center">
     <div class="col-md-12">
      <label class="col-form-label">Contract Renewal</label>
    </div>
    <div class="col-md-12">
     <label class="col-form-label">Expiry Date  : </label> {{ $CEXD }}
     @if($CEX == "1") 
     <span class="text-danger">(expired)</span>
     @endif
   </div> 
   <div class="col-md-12">
    <p>Please read contract fully. Confirm acceptance by
      inputting code that would be sent to you via SMS
    on your registered phone number.</p>
  </div>
</div>
</div>
</div>
<hr>

<div class="row">
  <div class="col-md-12">
    <a href="{{ url('uploadservice') }}"> <i style="float:right;margin-top: 80px;" class="fa fa-upload"></i></a>
    <div class="row justify-content-center">
     <div class="col-md-12">
       <label class="col-form-label">Vehicle Servicing</label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Scheduled Date  : </label> {{ $SSD }} 
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Venue  : </label> {{ $SVE }} 
     </div> 
     <div class="col-md-12">
      <p>Click icon when servicing is complete</p>
    </div>
  </div>
</div>
</div>
<hr>

<div class="row">
  <div class="col-md-12">
    @if($inspection == 1)
    <a href="" onclick="accept_code();" > <i style="float:right;margin-top: 80px;" class="fa fa-eye"></i></a>
    @endif
    <div class="row justify-content-center">
     <div class="col-md-12">
       <label class="col-form-label">Vehicle Inspection</label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Scheduled Date  : </label> {{ $ISD }} 
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Venue  : </label> {{ $IVE }} 
     </div> 
     <div class="col-md-12">
      <p>Click icon when Inspection is complete</p>
    </div>
  </div>
</div>
</div>
<hr>

<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
  <a href="{{ url('myaccount') }}" class="btn btn-info">Back</a>&nbsp;
  <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
</nav>
</div>
</div>
</div>

@endsection

@push('page_scripts')
<script>
var acceptance_code_url = "{{ url('acceptance_code') }}";
function acceptance_code(){
  var url =  acceptance_code_url;
  $.ajax({
      type: "get",
      url: url,
      success: function(response) {
        window.location.href = "{{ url('contract') }}";
      },
      error: function (jqXHR, exception) {
        console.log(exception);
      }
  });
}

var accept_code_url = "{{ url('accept_code') }}";
function accept_code(){
  var url =  accept_code_url;
  $.ajax({
      type: "get",
      url: url,
      success: function(response) {
        window.location.href = "{{ url('inspect') }}";
      },
      error: function (jqXHR, exception) {
        console.log(exception);
      }
  });
}
</script>
@endpush