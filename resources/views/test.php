@section('content')
<div class="container-fluid">
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
</div>
   @endforeach
@endsection