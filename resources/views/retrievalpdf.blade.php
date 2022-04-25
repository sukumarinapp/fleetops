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
    <h5 class="text-center">Vehicle Return Form</h5>
    <div class="row1">
        @foreach($result as $res)
<div class="column">
<img  src="{{ public_path("uploads/photo/".$res->photo) }}" style="width: 120px; height: 80px;">
  </div>
  </div>
<div class="row">
<table class="table table-striped table-bordered">
    <thead>
    
  </thead>
  <tbody>
       <tr>
        <td>Registration(number plate)</td>
        <td>{{ $res->VNO }} </td>
        <td></td>
        <td></td>
    </tr>
     
    <tr>
        <td>Chassis No</td>
        <td>{{ $res->chassis_no }} </td>
        <td></td>
        <td></td>
    </tr> 
    <tr>
        <td>Insurance</td>
        <td>Expiry Date:{{ date("d-m-Y",strtotime($res->IEX)) }} </td>
        <td></td>
        <td></td>
    </tr> 
    <tr>
        <td>Roadworthy Certificate</td>
        <td>Expiry Date:{{ date("d-m-Y",strtotime($res->REX)) }} </td>
        <td></td>
        <td></td>
    </tr> 
    
    <tr>
        <td>Starting Mileage(handover)</td>
        <td>{{ $res->CF01 }} </td>
        <td></td>
        <td></td>
    </tr> 
    <tr>
        <td>Ending Mileage(retrieval)</td>
        <td>{{ $res->RCF01 }} </td>
        <td></td>
        <td></td>
    </tr>
    <tr>
      <th class="col">Description</th>
      <th class="col">Handover</th>
      <th class="col">Retrieval</th>
    </tr>
    <tr>
        <td>Spare Tire</td>
        <td>
            @if($res->CF02 == 1)
                <img  src="{{ public_path('check.jpg') }}">
            @else
                <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
        <td>
            @if($res->RCF02 == 1)
                <img  src="{{ public_path('check.jpg') }}">
            @else
                <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
    </tr> 
    @if($res->CC01 != "" &&  $res->RCC01 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC01 }} </td>
        <td>{{ $res->RCC01 }} </td>
    </tr>
    @endif
    <tr>
        <td>Warning Triangle</td>
        <td>
            @if($res->CF03 == 1)
                <img  src="{{ public_path('check.jpg') }}">
            @else
                <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
          <td>
            @if($res->RCF03 == 1)
                <img  src="{{ public_path('check.jpg') }}">
            @else
                <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
        
    </tr> 

    @if($res->CC02 != "" &&  $res->RCC02 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC02 }} </td>
        <td>{{ $res->RCC02 }} </td>
    </tr>
    @endif

    <tr>
        <td>Vehicle Tools</td>
        <td>
            @if($res->CF04 == 1)
               <img  src="{{ public_path('check.jpg') }}">
            @else
               <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
        <td>
            @if($res->RCF04 == 1)
               <img  src="{{ public_path('check.jpg') }}">
            @else
               <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
    </tr>

    @if($res->CC03 != "" &&  $res->RCC03 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC03 }} </td>
        <td>{{ $res->RCC03 }} </td>
    </tr>
    @endif 
    <tr>
        <td>Fire Extinguisher</td>
        <td>
            @if($res->CF05 == 1)
               <img  src="{{ public_path('check.jpg') }}">
            @else
               <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
        <td>
            @if($res->RCF05 == 1)
               <img src="{{ public_path('check.jpg') }}">
            @else
               <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
    </tr>

    @if($res->CC04 != "" &&  $res->RCC04 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC04 }} </td>
        <td>{{ $res->RCC04 }} </td>
    </tr>
    @endif 

    <tr>
        <td>Front Lights (Deem) L/R</td>
        <td>{{ $res->CC05 }} </td>
        <td>
            @if($res->CF06 == 1)
                <img  src="{{ public_path('check.jpg') }}">
            @else
                <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td> 
        <td>
            @if($res->RCF06 == 1)
                <img  src="{{ public_path('check.jpg') }}">
            @else
                <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
    </tr>

    @if($res->CC05 != "" &&  $res->RCC05 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC05 }} </td>
        <td>{{ $res->RCC05 }} </td>
    </tr>
    @endif 

    <tr>
        <td>Front Lights (High) L/R</td>
        <td>
            @if($res->CF07 == 1)
               <img  src="{{ public_path('check.jpg') }}">
            @else
               <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
        <td>
            @if($res->RCF07 == 1)
               <img  src="{{ public_path('check.jpg') }}">
            @else
               <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
    </tr>

    @if($res->CC06 != "" &&  $res->RCC06 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC06 }} </td>
        <td>{{ $res->RCC06 }} </td>
    </tr>
    @endif 

    <tr>
        <td>Indicator Lights (FL/FR/RL/RR)</td>
        <td>{{ $res->CC07 }} </td>
        <td>
            @if($res->CF08 == 1)
               <img  src="{{ public_path('check.jpg') }}">
            @else
               <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
        <td>
            @if($res->RCF08 == 1)
               <img  src="{{ public_path('check.jpg') }}">
            @else
               <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
    </tr>

    @if($res->CC07 != "" &&  $res->RCC07 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC07 }} </td>
        <td>{{ $res->RCC07 }} </td>
    </tr>
    @endif 

    <tr>
        <td>Parking Lights L/R</td>
        <td>
            @if($res->CF09 == 1)
               <img  src="{{ public_path('check.jpg') }}">
            @else
               <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
        <td>
            @if($res->RCF09 == 1)
               <img  src="{{ public_path('check.jpg') }}">
            @else
               <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
    </tr>

    @if($res->CC08 != "" &&  $res->RCC08 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC08 }} </td>
        <td>{{ $res->RCC08 }} </td>
    </tr>
    @endif 

    <tr>
        <td>Brake Lights L/R</td>
        <td>{{ $res->CC09 }} </td>
        <td>
            @if($res->CF10 == 1)
               <img  src="{{ public_path('check.jpg') }}">
            @else
                <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td> 
        <td>
            @if($res->RCF10 == 1)
                <img  src="{{ public_path('check.jpg') }}">
            @else
                <img src="{{ public_path('redmark.jpg') }}">
            @endif
        </td>
    </tr>

     @if($res->CC09 != "" &&  $res->RCC09 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC09 }} </td>
        <td>{{ $res->RCC09 }} </td>
    </tr>
    @endif 

    <tr>
        <td>Reverse Lights L/R</td>
        <td>@if($res->CF11 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif</td> 
          <td>@if($res->RCF11 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif</td>
    </tr>

     @if($res->CC10 != "" &&  $res->RCC10 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC10 }} </td>
        <td>{{ $res->RCC10 }} </td>
    </tr>
    @endif 

    <tr>
        <td>Wiper Function</td>
        <td>@if($res->CF12 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif</td> 
          <td>@if($res->RCF12 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif</td>
    </tr>

    @if($res->CC11 != "" &&  $res->RCC11 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC11 }} </td>
        <td>{{ $res->RCC11 }} </td>
    </tr>
    @endif 

    <tr>
        <td>Horn</td>
        <td>@if($res->CF13 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif </td> 
          <td>@if($res->RCF13 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif </td>
        
    </tr>
     @if($res->CC12 != "" &&  $res->RCC12 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC12 }} </td>
        <td>{{ $res->RCC12 }} </td>
    </tr>
    @endif 

    <tr>
        <td>Air-Conditioner</td>
        <td>@if($res->CF14 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif</td>
          <td>@if($res->RCF14 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif</td>
        
    </tr>
     @if($res->CC13 != "" &&  $res->RCC13 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC13 }} </td>
        <td>{{ $res->RCC13 }} </td>
    </tr>
    @endif 
    <tr>
        <td>Radio</td>
        <td>@if($res->CF15 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif</td>
          <td>@if($res->RCF15 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif</td>
        
    </tr>
     @if($res->CC14 != "" &&  $res->RCC14 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC14 }} </td>
        <td>{{ $res->RCC14 }} </td>
    </tr>
    @endif 
    <tr>
        <td>Wheel Caps (FL/FR/RL/RR)</td>
        <td>{{ $res->CC15 }} </td>
        <td>@if($res->CF16 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif</td>
          <td>@if($res->RCF16 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif</td>
        
    </tr>
     @if($res->CC15 != "" &&  $res->RCC15 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC15 }} </td>
        <td>{{ $res->RCC15 }} </td>
    </tr>
    @endif 
    <tr>
        <td>Road Test</td>
        <td>@if($res->CF17 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif</td>
          <td>@if($res->RCF17 == 1)
         <img  src="{{ public_path('check.jpg') }}">
         @else
          <img src="{{ public_path('redmark.jpg') }}">
          @endif</td>
        
    </tr>
     @if($res->CC16 != "" &&  $res->RCC16 != "" )
    <tr>
        <td></td>
        <td>{{ $res->CC16 }} </td>
        <td>{{ $res->RCC16 }} </td>
    </tr>
    @endif 

    <tr>
        <td>Comments(handover)</td>
        <td>{{ $res->CF18 }} </td>
        <td></td>
    </tr> 
    <tr>
        <td>Comments(retrieval)</td>
        <td>{{ $res->RCF18 }} </td>
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
    <!-- <tr>
        <td>Device Used</td>
        <td> </td>
        <td></td>
    </tr>  -->
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
  </div>

  <div class="row1">
<div class="column">
<img  src="{{ public_path("uploads/photo/".$res->RCFP2) }}" style="width: 100px; height: 80px;">
  </div>
  <div class="column" >
   <img src="{{ public_path("uploads/photo/".$res->RCFP3) }}" style="width: 100px; height: 80px;">
  </div>
   <div class="column">
     <img src="{{ public_path("uploads/photo/".$res->RCFP4) }}" style="width: 100px; height: 80px;">
  </div>
   <div class="column">
    <img src="{{ public_path("uploads/photo/".$res->RCFP5) }}" style="width: 100px; height: 80px;">
  </div>
  @endforeach
  </div>
</div>
</div>
