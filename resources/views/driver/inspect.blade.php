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

    <h5 class="title" style="text-align:center;">Inspection Checklist</h5>

  </div>
  <div class="card-body">
    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
      <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong> {{ Session::get('error') }} </strong>
    </div>
    @endif
    <input type="hidden" id="VNO" name="VNO" value="">
    <form action="{{ route('acceptinspection') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
      @csrf
   
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
   @foreach($inspect as $ins)
      <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Look under the car for leaks</label>
        <div class="col-sm-8">
           @if($ins->VI01 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
           &nbsp;<span> {{ $ins->CI01 }} </span>
        </div>
      </div> 

      <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check radiator coolant level</label>
        <div class="col-sm-8">
           @if($ins->VI02 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif

          &nbsp;<span> {{ $ins->CI02 }} </span>
         </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check engine oil level</label>
        <div class="col-sm-8">
           @if($ins->VI03 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI03 }} </span>
        </div>
      </div>

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check brake fluid</label>
        <div class="col-sm-8">
           @if($ins->VI04 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif

          &nbsp;<span> {{ $ins->CI04 }} </span>
        </div>
      </div>   

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check windshield washer fluid</label>
        <div class="col-sm-8">
           @if($ins->VI05 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif

          &nbsp;<span> {{ $ins->CI05 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check battery condition</label>
        <div class="col-sm-8">
           @if($ins->VI06 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI06 }} </span>
        </div>
      </div>   

        <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check general cleanliness of engine</label>
        <div class="col-sm-8">
           @if($ins->VI07 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI07 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check tire condition, caps, nuts and tools</label>
        <div class="col-sm-8">
           @if($ins->VI08 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI08 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check brakes (Foot/Hand Brakes)</label>
        <div class="col-sm-8">
           @if($ins->VI09 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI09 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check inside mirror and side mirrors:</label>
        <div class="col-sm-8">
           @if($ins->VI10 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI10 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check all windows left/right window</label>
        <div class="col-sm-8">
           @if($ins->VI11 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI11 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check doors, handles, boot and hood</label>
        <div class="col-sm-8">
           @if($ins->VI12 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI12 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check headlights, brakes lights</label>
        <div class="col-sm-8">
           @if($ins->VI13 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI13 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check ignition key and system</label>
        <div class="col-sm-8">
           @if($ins->VI14 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI14 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check steering wheel</label>
        <div class="col-sm-8">
           @if($ins->VI15 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI15 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check dashboard indicator lights</label>
        <div class="col-sm-8">
           @if($ins->VI16 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI16 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check inside lights</label>
        <div class="col-sm-8">
           @if($ins->VI17 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI17 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check radio and CD player/antenna</label>
        <div class="col-sm-8">
           @if($ins->VI18 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI18 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check seat belts and seat covers</label>
        <div class="col-sm-8">
           @if($ins->VI19 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI19 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check cleanliness of the vehicle's interior</label>
        <div class="col-sm-8">
           @if($ins->VI20 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI20 }} </span>
        </div>
      </div>   

        <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check first aid kit and fire extinguisher</label>
        <div class="col-sm-8">
           @if($ins->VI21 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI21 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check reflective triangles</label>
        <div class="col-sm-8">
           @if($ins->VI22 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI22 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check validity of insurance (Sticker)</label>
        <div class="col-sm-8">
           @if($ins->VI23 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI23 }} </span>
        </div>
      </div>    

       <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Check validity of Roadworthy (Sticker)</label>
        <div class="col-sm-8">
           @if($ins->VI24 == 1)
         <i class="fa fa-check" style="color:green"></i>
         @else
          <i class="fa fa-times" style="color:red"></i>
          @endif
          &nbsp;<span> {{ $ins->CI24 }} </span>
        </div>
      </div>   
   @endforeach
      @foreach($images as $image)
         <div class="form-group row">
          <div class="col-md-4">
           <img class="img-responsive img-rounded" src="../uploads/inspection/{{ $image->filename }}" width="500" height="400">
         </div>
         </div>
         
      @endforeach
      <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red">*</span>Input Acceptence Code</label>
        <div class="col-sm-4">
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