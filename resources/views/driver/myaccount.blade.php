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
  <div class="card-body">
      <input type="hidden" id="VNO" name="VNO" value="{{ $VNO }}">
     <div class="row justify-content-center">
    <div class="col-md-12">
       <label class="col-form-label">Account Name   : </label>{{ $DNM }}
   </div>
   <div class="col-md-12">
       <label class="col-form-label">Vehicle Reg No : </label>{{ $VNO }}
   </div>
   <div class="col-md-12">
     <label class="col-form-label">Reg Phone Number : </label>{{ $DCN }}
  </div>
</div>
  <hr>
<div class="row">
  <div class="col-md-12">
    <div class="row justify-content-center">
      <div class="col-md-12">
         @if($VBM == "Hire Purchase")
          <a href="{{ url('buyerstatement') }}" type="button" class="btn btn-block btn-primary btn-lg text-center">Buyer statement</a>
           @elseif($VBM == "Rental")
            <a href="{{ url('receipts') }}" type="button" class="btn btn-block btn-primary btn-lg text-center">Receipts</a>
             @else
              <a href="{{ url('salesreport') }}" type="button" class="btn btn-block btn-primary btn-lg text-center">Sales Report</a>
               @endif
     </div>
     <div class="col-md-12" style="padding-top:10px;">
          <a href="{{ url('tasks') }}" type="button" class="btn btn-block btn-primary btn-lg text-center">Tasks</a>
      </div>

       <div class="col-md-12" style="padding-top:10px;">
          <a href="" type="button" class="btn btn-block btn-primary btn-lg text-center">E Wallet</a>
      </div>
    </div>
  </div>
</div>
<div class="row" style="margin-top:30px">
<div class="col-md-12">
      <a href="{{ url('agreement') }}">Agreement Summary</a>
   </div>
   <div class="col-md-12">
     @if($acceptance_code != "") 
     <a target='_blank' href='../../uploads/VCC/{{ $VCC }}'>Agreement Terms & Conditions</a>
     <span>(Acceptance Code : {{ $acceptance_code }} )</span>
     @else
     <a>Agreement Terms & Conditions</a>
     @endif
   </div>
   <div class="col-md-12">
    @if($handover_id != 0 && $acceptance_code != "")
     <a target="_blank" href="../../uploads/handover/{{ $handover_id }}.pdf">Vehicle Hand-over Form</a>
    @else
     <a>Vehicle Hand-over Form</a>
    @endif
  </div>
</div>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
  <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
</nav>
</div>
</div>
</div>

@endsection