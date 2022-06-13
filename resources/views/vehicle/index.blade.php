@extends('layouts.app')
@section('content')
<style type="text/css">

  .dataTables_filter{
    text-align: right;
  }
  @media screen and (max-width: 767px)
 {
  #sort {
    text-align: center;}
  }
</style>
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

         <div class="row">
       <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h4>Offline: {{ $offline }}</h4>
                <h6>Online: {{ $online }}</h6>
              </div>
              <div class="icon">
                <i class="fa fa-satellite"></i>
              </div>

            </div>
          </div>
          <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4>Unassigned: {{ $notassigned }}</h4>
                <h6>Assigned: {{ $assigned }}</h6>
              </div>
              <div class="icon">
                <i class="fa fa-car"></i>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4>Inactive: {{ $inactive }}</h4>
                <h6>Active: {{ $active }}</h6>
              </div>
               <div class="icon">
                <i class="fas fa-check"></i>
              </div>
              
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-sm-12 col-md-9"></div>
          <div class="col-sm-12 col-md-3">
            <div id="sort" class="dataTables_filter"><label style="font-weight: normal;">Sort by:
            <select onchange="sort_vehicle()" style="margin-left: 0.5em;display: inline-block;width: 180px;" name="sort_by" id="sort_by" class="custom-select">
                <option @if($sort_by == 1) selected @endif value="1" >Payment Pending</option>
                <option @if($sort_by == 2) selected @endif value="2" >Offline</option>
                <option @if($sort_by == 3) selected @endif value="3" >Unassigned</option>
                <option @if($sort_by == 4) selected @endif value="4" >Inactive</option>
              </select>
        </div>
        </div>
      </div>
        <table data-ordering="true" id="example1" class="display table table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>CAN</th>
              <th class="text-right">TST</th>
              <th class="text-right">ASG</th>
              <th class="text-right">BUZ</th>
              <th class="text-right">BLK</th>
              <th>Vehicle Reg#</th>
              <th>Description</th>
              <th style="width: 150px">Activity</th>
              <th>Action</th>
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
            <td class="text-center">
               @php
              if($vehicle->VTV == 0){
                echo "N/R";
              }elseif($vehicle->offline == 1){
                echo "<span><img src='/offline.jpg'></span>";
              }else{
                echo "<span><img src='/online.jpg'></span>";
              }
            @endphp
            </td>
            <td class="text-center">
              @php
              if($vehicle->VTV == 0){
                echo "N/R";
                }elseif($vehicle->driver_id == NULL){
                   echo "<span><img src='/parked.jpg'></span>";
                 }else{
                  echo "<span><img src='/assign.jpg'></span>";
            }
                 @endphp
            </td>

            <td class="text-center">
              @php
              if($vehicle->buz_status == 1 && $vehicle->offline == 0){
                  echo "<span><img src='/buzon.png'></span>";
                 }elseif($vehicle->buz_status == 1 && $vehicle->offline == 1){
                  echo "<span><img src='/buzon.png'></span>";
               }elseif($vehicle->buz_status == 0 && $vehicle->offline == 0){
                  echo "<span><img src='/buzoff.png'></span>";
               }elseif($vehicle->buz_status == 0 && $vehicle->offline == 1){
                  echo "<span><img src='/buzoff.png'></span>";
               }
              @endphp
            </td>

           <td class="text-center">
              @php
              if($vehicle->WARNING == 0){
                if($vehicle->blk_status == 1){
                    echo "<span><img src='/blkon.jpg'></span>";
                 }else{
                    echo "<span><img src='/blkoff.png'></span>";
                }
              }else{
                echo "<span><a href='#' onclick='show_modal(\"$vehicle->WARNING_MSG1\",\"$vehicle->WARNING_MSG2\")'><img src='/warning.png'></a></span>";
              }
              @endphp
            </td>
            <td>
            {{ $vehicle->VNO }} 
            @if($vehicle->DNM !="")
            <br><small class="text-success"><a href="{{ route('fdriver.edit',$vehicle->did) }}">{{ $vehicle->DNM }} 
              {{ $vehicle->DSN }}</a> - {{ $vehicle->VBM }}</small>
              @endif
            </td>
            <td>{{ $vehicle->VMK }}&nbsp;{{ $vehicle->VMD }}&nbsp;{{ $vehicle->VCL }}</td>
            
            
          </td>
          <td style="white-space: nowrap">
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
          <td style="white-space: nowrap"> 
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
    <div class="modal fade" id="mymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 id="msg1" class="text-center"></h4>
        <p id="msg2" class="text-center"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
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
  var allvehicle = "{{ url('allvehicle') }}";
  function sort_vehicle(){
    var sort_by = $("#sort_by").val();
    var url =  allvehicle + "/" + sort_by;  
    window.location.href = url;
  }
  function show_modal(msg1,msg2){
    $("#msg1").html(msg1);
    $("#msg2").html(msg2);
    $('#mymodal').modal('show'); 
  } 
</script>

@endpush