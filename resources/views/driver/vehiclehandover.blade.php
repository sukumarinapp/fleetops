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
<div class="card card-primary">
  <div class="card-header">

    <h5 class="title" style="text-align:center;">Agreement, Terms & Conditions</h5>

  </div>
  <div class="card-body">
    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
      <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong> {{ Session::get('error') }} </strong>
    </div>
    @endif
    <input type="hidden" id="handover_id" name="handover_id" value="handover_id">
    <form action="{{ route('confirm_handover') }}" method="post" class="form-horizontal">
      @csrf
      <div class="row">
        
        <div class="col-md-12 text-center">
         <label>Please read contract to receive Acceptance Code</label> 
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <a onclick="acceptance_code();" class="btn btn-info" style="color:white" >Read Contract</a>
        </div>
      </div><br>

      <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Into</label>
        <div class="col-sm-8">
          {{ $DNM }}
        </div>
      </div>

     <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Vehicle Reg No</label>
        <div class="col-sm-8">
          {{ $VNO }}
        </div>
      </div>

     <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Vehicle Chassis No</label>
        <div class="col-sm-8">
         {{ $chassis_no }}
        </div>
      </div>

      <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Insurance Expiry Date</label>
        <div class="col-sm-8">
          {{ $IEX }}
        </div>
      </div>

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Roadworthy Expiry Date</label>
        <div class="col-sm-8">
          {{ $REX }}
        </div>
      </div>
@foreach($result as $res)

 <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Starting Mileage</label>
        <div class="col-sm-8">
          {{ $res->CF01 }} 
        </div>
      </div>

     <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Spare Tire</label>
        <div class="col-sm-8">
           @if($res->CF02 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC01 }} </span>
        </div>
      </div> 

 <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Warning Triangle</label>
        <div class="col-sm-8">
           @if($res->CF03 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC02 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Vehicle Tools</label>
        <div class="col-sm-8">
           @if($res->CF04 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC03 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Fire Extinguisher</label>
        <div class="col-sm-8">
           @if($res->CF05 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC04 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Front Lights (Deem) L/R</label>
        <div class="col-sm-8">
           @if($res->CF06 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC05 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Front Lights (High) L/R</label>
        <div class="col-sm-8">
           @if($res->CF07 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC06 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Indicator Lights (FL/FR/RL/RR)</label>
        <div class="col-sm-8">
           @if($res->CF08 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC07 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Parking Lights L/R</label>
        <div class="col-sm-8">
           @if($res->CF09 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC08 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Brake Lights L/R</label>
        <div class="col-sm-8">
           @if($res->CF10 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC09 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Reverse Lights L/R</label>
        <div class="col-sm-8">
           @if($res->CF11 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC10 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Wiper Function</label>
        <div class="col-sm-8">
           @if($res->CF12 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC11 }} </span>
        </div>
      </div>

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Horn</label>
        <div class="col-sm-8">
           @if($res->CF13 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC12 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Air-Conditioner</label>
        <div class="col-sm-8">
           @if($res->CF14 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC13 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Radio</label>
        <div class="col-sm-8">
           @if($res->CF15 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC14 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Wheel Caps (FL/FR/RL/RR)</label>
        <div class="col-sm-8">
           @if($res->CF16 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC15 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Road Test</label>
        <div class="col-sm-8">
           @if($res->CF17 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $res->CC16 }} </span>
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Comments</label>
        <div class="col-sm-8">
            {{ $res->CF18 }} 
        </div>
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Front View</label>
       
          <img class="img-fluid img-thumbnail" src="../uploads/photo/{{ $res->CFP2 }}" style="width:30%;height:40%">
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Right View</label>
        
          <img class="img-fluid img-thumbnail" src="../uploads/photo/{{ $res->CFP3 }}" style="width:30%;height:40%">
        
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Rear View</label>
       
          <img class="img-fluid img-thumbnail" src="../uploads/photo/{{ $res->CFP4 }}" style="width:30%;height:40%">
      </div> 

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Left View</label>
          <img class="img-fluid img-thumbnail" src="../uploads/photo/{{ $res->CFP5 }}" style="width:30%;height:40%">
      </div> 

   @endforeach

      <div class="form-group row">
        <p class="col-sm-12 col-form-label">I have read and understood the terms and conditions of this contract (or it has been read and interpreted to you in a language that you understand) and by inputting this acceptance code below I willingly accept it.</p>
     </div>
        <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red">*</span>Input Acceptence Code</label>
        <div class="col-sm-2">
          <input required="required" type="text" maxlength="4" class="form-control number" name="acceptance_code" id="acceptance_code" >
        </div>
      </div>
    </div>

    <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">    
      <a href="{{ url('tasks') }}" class="btn btn-info">Back</a>&nbsp;
      <input required="required" class="btn btn-info"
      type="submit" id="save" name="submit" value="Accept"/>&nbsp;  
      <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
    </nav>
  </form>
</div>
</div>
</div>

@endsection
@push('page_scripts')
<script>
function acceptance_code(){
    var CSRF_TOKEN = $("input[name=_token]").val();
    $.ajax({
      type: "post",
      url: "/accept_handover",
      data: {_token: CSRF_TOKEN },
      dataType: 'JSON',
      success: function(response) {
        window.open  ('../../uploads/VCC/{{ $VCC }}', '_blank');
      },
      error: function (jqXHR, exception) {
        console.log(exception);
      }
  });
}
</script>