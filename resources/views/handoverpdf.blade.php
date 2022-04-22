<link rel="stylesheet" href="{{ public_path('css/app.css') }}">
<style type="text/css">
.column {
  float: left;
  width: 100px;
  padding: 10px;
  height: 80px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row1:after {
  content: "";
  display: table;
  clear: both;
}
.table-bordered{
  font-size: 10px;
}

</style>
<div class="card-body">
    <h5 class="text-center">Vehicle Collection Form</h5>
    <div class="row1">
        @foreach($result as $res)
<div class="column">
<img  src="{{ public_path("uploads/photo/".$res->photo) }}" style="width: 120px; height: 80px;">
  </div>
  </div>
<div class="row">
<table class="table table-striped table-bordered">
    <thead>
    <tr>
      <th class="col">Description</th>
      <th class="col">Details</th>
      <th class="col">Check</th>
    </tr>
  </thead>
  <tbody>
       <tr>
        <td>Registration(number plate)</td>
        <td>{{ $res->VNO }} </td>
        <td></td>
    </tr>
     
    <tr>
        <td>Chassis No</td>
        <td>{{ $res->chassis_no }} </td>
        <td></td>
    </tr> 
    <tr>
        <td>Insurance</td>
        <td>Expiry Date:{{ date("d-m-Y",strtotime($res->IEX)) }} </td>
        <td></td>
    </tr> 
    <tr>
        <td>Roadworthy Certificate</td>
        <td>Expiry Date:{{ date("d-m-Y",strtotime($res->REX)) }} </td>
        <td></td>
    </tr> 
    
    <tr>
        <td>Starting Mileage</td>
        <td>{{ $res->CF01 }} </td>
        <td></td>
    </tr>
    <tr>
        <td>Spare Tire</td>
        <td>{{ $res->CC01 }} </td>
        <td>@if($res->CF02 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
        
    </tr> 
    <tr>
        <td>Warning Triangle</td>
        <td>{{ $res->CC02 }} </td>
        <td>@if($res->CF03 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
        
    </tr> 
    <tr>
        <td>Vehicle Tools</td>
        <td>{{ $res->CC03 }} </td>
        <td>@if($res->CF04 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
    </tr> 
    <tr>
        <td>Fire Extinguisher</td>
         <td>{{ $res->CC04 }} </td>
        <td>@if($res->CF05 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
       
    </tr>
    <tr>
        <td>Front Lights (Deem) L/R</td>
        <td>{{ $res->CC05 }} </td>
        <td>@if($res->CF06 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
    </tr>
    <tr>
        <td>Front Lights (High) L/R</td>
        <td>{{ $res->CC06 }} </td>
        <td>@if($res->CF07 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
    </tr>
    <tr>
        <td>Indicator Lights (FL/FR/RL/RR)</td>
        <td>{{ $res->CC07 }} </td>
        <td>@if($res->CF08 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
        
    </tr>
    <tr>
        <td>Parking Lights L/R</td>
        <td>{{ $res->CC08 }} </td>
        <td>@if($res->CF09 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
        
    </tr>
    <tr>
        <td>Brake Lights L/R</td>
        <td>{{ $res->CC09 }} </td>
        <td>@if($res->CF10 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
        
    </tr>
    <tr>
        <td>Reverse Lights L/R</td>
        <td>{{ $res->CC10 }} </td>
        <td>@if($res->CF11 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
        
    </tr>
    <tr>
        <td>Wiper Function</td>
        <td>{{ $res->CC11 }} </td>
        <td>@if($res->CF12 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
        
    </tr>
    <tr>
        <td>Horn</td>
        <td>{{ $res->CC12 }} </td>
        <td>@if($res->CF13 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif </td>
        
    </tr>
    <tr>
        <td>Air-Conditioner</td>
        <td>{{ $res->CC13 }} </td>
        <td>@if($res->CF14 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
        
    </tr>
    <tr>
        <td>Radio</td>
        <td>{{ $res->CC14 }} </td>
        <td>@if($res->CF15 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
        
    </tr>
    <tr>
        <td>Wheel Caps (FL/FR/RL/RR)</td>
        <td>{{ $res->CC15 }} </td>
        <td>@if($res->CF16 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
        
    </tr>
    <tr>
        <td>Road Test</td>
        <td>{{ $res->CC16 }} </td>
        <td>@if($res->CF17 == 1)
         <img  src="{{ public_path("check.jpg") }}">
         @else
          <img src="{{ public_path("redmark.jpg") }}">
          @endif</td>
        
    </tr>

    <tr>
        <td>Comments</td>
        <td>{{ $res->CF18 }} </td>
        <td></td>
    </tr>
    <tr>
        <td>Signed By</td>
        <td>{{ $res->DNM }}{{ $res->DSN }} </td>
        <td></td>
    </tr> 
   
   <tr>
        <td>Acceptance Code</td>
        <td>{{ $res->acceptance_code }} </td>
        <td></td>
    </tr> 
    <tr>
        <td>Device Used</td>
        <td> </td>
        <td></td>
    </tr> 
</tbody>




</table>
<div class="row1">
<div class="column">
<img  src="{{ public_path("uploads/photo/".$res->CFP2) }}" style="width: 100px; height: 80px;">
  </div>
  <div class="column" >
   <img src="{{ public_path("uploads/photo/".$res->CFP3) }}" style="width: 100px; height: 80px;">
  </div>
   <div class="column">
     <img src="{{ public_path("uploads/photo/".$res->CFP4) }}" style="width: 100px; height: 80px;">
  </div>
   <div class="column">
    <img src="{{ public_path("uploads/photo/".$res->CFP5) }}" style="width: 100px; height: 80px;">
  </div>
  @endforeach
  </div>
</div>
</div>
