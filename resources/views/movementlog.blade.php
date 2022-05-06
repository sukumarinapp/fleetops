@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="content-header" style="padding: 0px 0.5rem !important;">
        <div class="row">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a>Reports</a></li>
              <li class="breadcrumb-item">Running Movement Report</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card card-info">
    <div class="card-header align-items-center">
      <div class="row">
        <div class="col-md-2">
          <label>Running Movement Report</label>
        </div>
           <div class="col-md-10">
         <form class="form-inline" >
          <label for="from">&nbsp;From Date&nbsp;</label>
          <input value="{{ $from }}" class="form-control" type="date" id="from" name="from"  />
          <label for="to">&nbsp;To Date&nbsp;</label>
          <input value="{{ $to }}" class="form-control" type="date" id="to" name="to"  />
          <label>&nbsp;</label>
          <input onclick="load_report()" type="button"  value="Apply" class="form-control text-center btn btn-success btn-sm" />
        </form>
      </div>
    </div>
  </div>

  <div class="card-body" >
    <div class="table-responsive" >
      <table id="example1" class="table table-bordered">
        <thead>
          <tr>
            <th>VNO</th>
            <th>ACC Status</th>
            <th>Start Date</th>
            <th>Start Time</th>
            <th>End Date</th>
            <th>End Time</th>
            <th>Duration</th>
            <th>CML</th>
            <th>CHR</th>
            <th>Engine Idling (%)</th>
            <th></th>
          </tr>
        </thead>
          <tbody>
          @foreach($vehicles as $vehicle)
          <tr>
           <td>{{ $vehicle->VNO }}</td>
           <td>
            @if($vehicle->ACC == 0)
              Off
            @else
              On
            @endif
          </td>
           <td>{{ date("d-m-Y",strtotime($vehicle->SDT)) }}</td>
           <td>{{ $vehicle->STM }}</td>
           <td>{{ date("d-m-Y",strtotime($vehicle->EDT)) }}</td>
           <td>{{ $vehicle->ETM }}</td>
           <td>{{ $vehicle->DUR }}</td>
           <td>{{ $vehicle->CML }}</td>
           <td>{{ $vehicle->CHR }}</td>
           <td>{{ ($vehicle->IDL) * 100 }}</td>
           <td>
            @if($vehicle->ACC == 0)
              <button onclick="show_map({{ $vehicle->latitude }},{{ $vehicle->longitude }})" type="button" class="btn btn-primary btn-sm btn-block"  ><i class="nav-icon fa fa-map-marker"></i></button>
            @else
              &nbsp;
            @endif
            
           </td>
         </tr>
         @endforeach
          </tbody> 
     </table>
     <div class="modal fade" id="myMapModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalLabel">Location</h5> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="map-canvas" style="height: 400px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
   </div>
 </div>
</div>
</div>
@endsection
@push('page_scripts')
<script>

  function show_map(latitude,longitude){
    initialize(new google.maps.LatLng(latitude, longitude));
    $('#myMapModal').modal('show');
  }

  var lat = "";
  var lng = "";
  var map;
  function initialize(myCenter) {
    var marker = new google.maps.Marker({
      position: myCenter
    });
    var mapProp = {
      center: myCenter,
      zoom: 14,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map-canvas"), mapProp);
    marker.setMap(map);
  }

	var movementlog = "{{ url('movementlog') }}";
	function load_report(){
		var from = $("#from").val();
    var to = $("#to").val();
    if(from == ""){
      alert("Please select from Date");
    }else if(to == ""){
      alert("Please select To Date");
    }else{
      var url =  movementlog + "/" + from + "/" +to;  
      window.location.href = url;
    }		
  }

  $(document).ready(function(){
    $('.select2').select2({
     theme: 'bootstrap4'
   });
  });


</script>
@endpush
