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
  @csrf
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
  @if($assign_approved == 0)
<div class="row">
  <div class="col-md-12">
   <a href="{{ url('vehiclehandover') }}"> <i style="color: blue !important;cursor: pointer;float:right;margin-top: 80px;" class="fa fa-eye"></i></a>
   <div class="row justify-content-center">
    <h5 style="color: lightgray">Tasks</h5>
     <div class="col-md-12">
      <label class="col-form-label">Vehicle Handover</label>
    </div>
    <div class="col-md-12">
     <label class="col-form-label">Assigned Date  : </label> {{ date("d/m/Y",strtotime($LDT)) }}
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
@endif

 @if($licence_approved == 0)
 <div class="row">
  <div class="col-md-12">
    @if($LEX == 1)
   <a href="{{ url('uploadlicence') }}"> <i style="float:right;margin-top: 80px;" class="fa fa-upload"></i></a>
    @endif
   <div class="row justify-content-center">
    
    <div class="col-md-12">
     <label class="col-form-label">Licence Renewal - </label> {{ $DNO }} 
   </div>
   <div class="col-md-12">
     <span>{{ $lstatus }}: {{ date("d/m/Y",strtotime($LEXD)) }}</span>
   </div> 
   <div class="col-md-12">
    <p>Please take a snapshot of renewed license</p>
  </div>
</div>
</div>
</div>
<hr>
@endif

 @if($insurance_approved == 0)
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
     <span>{{ $istatus }}: {{ date("d/m/Y",strtotime($IEXD)) }}</span>
   </div> 
   <div class="col-md-12">
    <p>Please take a snapshot of renewed Insurance</p>
  </div>
</div>
</div>
</div>
<hr>
@endif
 @if($roadworthy_approved == 0)
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
     <span>{{ $rstatus }}: {{ date("d/m/Y",strtotime($REXD)) }}</span>
   </div> 
   <div class="col-md-12">
    <p>Please take a snapshot of renewed Roadworthy Cert</p>
  </div>
</div>
</div>
</div>
<hr>
@endif

 @if($contract_approved == 0)
<div class="row">
  <div class="col-md-12">
   @if($file_name != "")
   <a href="{{ url('contract') }}"> <i style="color: blue !important;cursor: pointer;float:right;margin-top: 80px;" class="fa fa-eye"></i></a>
   @endif
   <div class="row justify-content-center">
     <div class="col-md-12">
      <label class="col-form-label">Contract Renewal</label>
    </div>
    <div class="col-md-12">
     <span >{{ $cstatus }}: {{ date("d/m/Y",strtotime($CEXD)) }}</span>
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
@endif
 @if($service_approved == 0)
<div class="row">
  <div class="col-md-12">
    <a href="{{ url('uploadservice') }}"> <i style="float:right;margin-top: 80px;" class="fa fa-upload"></i></a>
    <div class="row justify-content-center">
     <div class="col-md-12">
       <label class="col-form-label">Vehicle Servicing</label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Scheduled Date  : </label> {{ date("d/m/Y",strtotime($SSD)) }} 
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
@endif
 @if($inspection_approved == 0)
<div class="row">
  <div class="col-md-12">
    @if($inspection == 1)
    <a  onclick="accept_code();" > <i style="color: blue;cursor: pointer;float:right;margin-top: 80px;" class="fa fa-eye"></i></a>
    @endif
    <div class="row justify-content-center">
     <div class="col-md-12">
       <label class="col-form-label">Vehicle Inspection</label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Scheduled Date  : </label> {{ date("d/m/Y",strtotime($ISD)) }} 
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
@endif
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
function accept_code(){
    var CSRF_TOKEN = $("input[name=_token]").val();
    console.log(CSRF_TOKEN);
    $.ajax({
      type: "post",
      url: "/accept_code",
      data: {_token: CSRF_TOKEN },
      dataType: 'JSON',
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