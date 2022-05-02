@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
  		<div class="col-md-12">
      <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item">Operations</li>
              <li class="breadcrumb-item">Fleet Manager</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Fleet Manager</h3>
			<a href="{{ route('vehicle.create') }}" class="btn btn-secondary float-right"><i class="nav-icon fas fa-plus"></i>&nbsp; Add Vehicle</a>
		    </div>
			<div style="overflow-x: auto;" class="card-body">
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong> {{ session('error') }} </strong>
            </div>
        @endif
        @if(session()->has('message'))
          <div class="alert alert-success alert-dismissable" style="margin: 15px;">
              <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong> {{ session('message') }} </strong>
          </div>
        @endif
        <div class="card-body" style="overflow-x: auto;" >
           <div class="row" style="margin-bottom: 5px;">
      <div class="col-md-4">
        <canvas id="pieChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
      </div>
      <div class="col-md-4">
        <canvas id="pieChart2" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
      </div> 
      <div class="col-md-4">
        <canvas id="pieChart3" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
      </div>
    </div>
			<table id="example1" class="display table table-bordered" cellspacing="0" width="100%">
          <thead>
          <tr>
            <th>CAN</th>
            <th>Vehicle Reg#</th>
            <th>Description</th>
            <th>View</th>
            <th style="width: 150px">Action Status</th>
            <th style="width: 150px"></th>
          </tr>
          </thead> 
          <tbody>
            @foreach($vehicles as $vehicle)
            <tr 
              @if($vehicle->VTV == 0)
                style="color: #FFC300;"
              @endif
              >
              <td>{{ $vehicle->CAN }}<br><small class="text-success">{{ $vehicle->name }}</small></td>
              <td>
                @php
                if($vehicle->VTV == 0){
                   echo "<span><img src='inactive.jpg'></span>";
                }else if($vehicle->VTV == 1 && $vehicle->DNM ==""){
                  echo "<span><img src='parked.jpg'></span>";
                }else{
                  if($vehicle->offline == 0){
                    echo "<span><img src='online.jpg'></span>";
                  }else{
                    echo "<span><img src='offline.jpg'></span>";
                  }
                }
                @endphp
                {{ $vehicle->VNO }} 
                @if($vehicle->DNM !="")
                <br><small class="text-success"><a href="{{ route('fdriver.edit',$vehicle->did) }}">{{ $vehicle->DNM }} 
                  {{ $vehicle->DSN }}</a> - {{ $vehicle->VBM }}</small>
                @endif
              </td>
              <td>{{ $vehicle->VMK }}&nbsp;{{ $vehicle->VMD }}&nbsp;{{ $vehicle->VCL }}</td>
              
              <td> 
                @if($vehicle->status != "pending" && $vehicle->handover_id != 0)
                  <a class="btn btn-secondary btn-xs" target="_blank" href="../../uploads/handover/{{ $vehicle->handover_id }}.pdf"><i class="fa fa-car"></i></a>
                @endif
              </td>
            </td>
              <td>
                    @if(Auth::user()->usertype == "Admin" || Auth::user()->BPF == true)
                      @if($vehicle->status == "pending")
                        <a class="btn btn-danger btn-xs" href="{{ url('cancel_handover') }}/{{ $vehicle->handover_id }}">Cancel Process</a>
                      @elseif($vehicle->driver_id == "")
                        @if($vehicle->VTV == 1)
                          <a href="{{ route('assignvehicle',$vehicle->id) }}" class="btn btn-info btn-xs">Assign Vehicle</a>
                        @else
                          <button class="btn btn-info btn-xs disabled" >Assign Vehicle</button>
                        @endif
                      @else
                        @if($vehicle->DECL == 0)
                        <button class="btn btn-primary btn-xs disabled" >  Payment Pending</button>
                        @else
                        <a href="{{ route('removevehicle',$vehicle->id) }}" class="btn btn-danger btn-xs">Unassign Vehicle</a>
                        @endif
                      @endif
                    @endif
               </td>
               <td>   
                @if($vehicle->VTV == 0 && $vehicle->DNM == "")
                <form action="{{ route('vehicle.destroy', $vehicle->id)}}" method="post">
                @endif
                    @if($vehicle->DECL == 0)
                        <button class="btn btn-primary btn-xs disabled" ><i class="fa fa-edit"></i></button>
                    @else
                    <a href="{{ route('vehicle.edit',$vehicle->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                    @endif
                    @csrf
                    @method('DELETE')
                    @if($vehicle->VTV == 0 && $vehicle->DNM == "")
                    <button onclick="return confirm('Do you want to perform delete operation?')" class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash"></i></button>
                    @else
                    <button class="btn btn-danger btn-xs disabled" ><i class="fa fa-trash"></i></button>
                    @endif
                @if($vehicle->VTV == 0 && $vehicle->DNM == "")                
                </form>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
      </table>
    </div>
			</div>
		</div>
		</div>
	</div>
</div>
@endsection
@push('page_scripts')
<script type="text/javascript" language="javascript" src="{{ asset('js/Chart.min.js') }}"></script>
<script>
  var pieData  = {
    labels: [
    'ONLINE',
    'OFFLINE',
    ],
    datasets: [
    {
      data: [{{ $online }},{{ $offline }}],
      backgroundColor : ['#4CAF50', '#1976D2'],
    }
    ]
  }  
  var pieData2  = {
    labels: [
    'ASSIGNED',
    'NOT ASSIGNED',
    ],
    datasets: [
    {
      data: [{{ $assigned }},{{ $notassigned }}],
      backgroundColor : ['#4CAF50', '#1976D2'],
    }
    ]
  }  

   var pieData3  = {
    labels: [
    'ACTIVE',
    'NOT ACTIVE',
    ],
    datasets: [
    {
      data: [{{ $active }},{{ $inactive }}],
      backgroundColor : ['#4CAF50', '#1976D2'],
    }
    ]
  }  
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
  var pieChartCanvas2 = $('#pieChart2').get(0).getContext('2d')
  var pieChartCanvas3 = $('#pieChart3').get(0).getContext('2d')
  var pieOptions     = {
    maintainAspectRatio : false,
    responsive : true,
  }
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    new Chart(pieChartCanvas2, {
      type: 'pie',
      data: pieData2,
      options: pieOptions
    })

    new Chart(pieChartCanvas3, {
      type: 'pie',
      data: pieData3,
      options: pieOptions
    })

  </script>
  @endpush