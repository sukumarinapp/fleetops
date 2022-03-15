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
   @if($LEX == "1")
   <a href="{{ url('uploadlicence') }}"> <i style="float:right;margin-top: 80px;" class="fa fa-upload"></i></a>
   @else
   <a href="{{ url('uploadlicence') }}"> <i style="float:right;margin-top: 80px;display: none;" class="fa fa-upload"></i></a>
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
     @else
     <span></span>
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
   @else
   <a href="{{ url('uploadinsurance') }}"> <i style="float:right;margin-top: 80px;display: none;" class="fa fa-upload"></i></a>
   @endif
   <div class="row justify-content-center">
    <div class="col-md-12">
     <label class="col-form-label">Insurance Renewal</label>
   </div>
   <div class="col-md-12">
     <label class="col-form-label">Expiry Date  : </label> {{ $IEXD }} 
     @if($IEX == "1") 
     <span class="text-danger">(expired)</span>
     @else
     <span></span>
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
   @else
   <a href="{{ url('uploadroadworthy') }}"> <i style="float:right;margin-top: 80px;display: none;" class="fa fa-upload"></i></a>
   @endif
   <div class="row justify-content-center">
    <div class="col-md-12">
     <label class="col-form-label">Roadworthy Cert Renewal</label>
   </div>
   <div class="col-md-12">
     <label class="col-form-label">Expiry Date  : </label> {{ $REXD }} 
     @if($REX == "1") 
     <span class="text-danger">(expired)</span>
     @else
     <span></span>
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
   @if($CEX == "1")
   <a href="{{ url('contract') }}"> <i style="float:right;margin-top: 80px;" class="fa fa-eye"></i></a>
   @else
   <a href="{{ url('contract') }}"> <i style="float:right;margin-top: 80px;display: none;" class="fa fa-eye"></i></a>
   @endif
   <div class="row justify-content-center">
     <div class="col-md-12">
      <label class="col-form-label">Contract Renewal</label>
    </div>
    <div class="col-md-12">
     <label class="col-form-label">Expiry Date  : </label> {{ $CEXD }}
     @if($CEX == "1") 
     <span class="text-danger">(expired)</span>
     @else
     <span></span>
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
    <a href=""> <i style="float:right;margin-top: 80px;" class="fa fa-download"></i></a>
    <div class="row justify-content-center">
     <div class="col-md-12">
       <label class="col-form-label">Vehicle Servicing</label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Expiry Date  : </label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Venue  : </label>
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
    <a href=""> <i style="float:right;margin-top: 80px;" class="fa fa-download"></i></a>
    <div class="row justify-content-center">
     <div class="col-md-12">
       <label class="col-form-label">Vehicle Inspection</label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Expiry Date  : </label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Venue  : </label>
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