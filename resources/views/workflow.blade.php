@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
				<div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item">Operations</li>
              <li class="breadcrumb-item">Workflow Manager</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
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
				<div class="card-header">
					<h3 class="card-title">WorkFlow</h3>
				</div>
				<div class="card-body" style="overflow-x: auto;" >
						<table id="example1" class="table table-bordered">
          <thead>
          <tr>
            <th>Open Date</th>
            <th>VNO</th>
            <th>Workflow No</th>
            <th>Workflow Type</th>
            <th>Case Initiator</th>
            <th>Action</th>
            <th>Remarks</th>
          </tr>
          </thead>
          <tbody>
            @foreach($vehicles as $vehicle)
            	@if($vehicle->DES =="A4" || ($vehicle->DES =="A3" && $vehicle->alarm_off == 0))
		            <tr>
		              <td>{{ date("d-m-Y",strtotime($vehicle->DDT)) }}</td>
		              <td>{{ $vehicle->VNO }}</td>
		              <td>WFL{{ str_pad($vehicle->id,3,'0',STR_PAD_LEFT) }}</td>
		              @if($vehicle->DES =="A4")
		              	<td>Vehicle Blocked</td>
		              @elseif($vehicle->DES =="A3" && $vehicle->alarm_off == 0)
		              	<td>Buzzer On</td>

		              @endif
		              <td>{{ $vehicle->DNM }} {{ $vehicle->DSN }}</td>              
		              <td><a href="{{ url('override') }}/{{ $vehicle->vid }}">Resolve</a></td>
		              <td></td>
		            </tr>
	            @endif
	            @if($vehicle->VBM == "Ride Hailing" && $vehicle->RMT > 0 && $vehicle->ADT == 0)
		            <tr>
		              <td>{{ date("d-m-Y",strtotime($vehicle->DDT)) }}</td>
		              <td>{{ $vehicle->VNO }}</td>
		              <td>WFL{{ str_pad($vehicle->id,3,'0',STR_PAD_LEFT) }}</td>
		              <td>Sales Audit Request</td>
		              <td>{{ $vehicle->DNM }} {{ $vehicle->DSN }}</td>    
		              <td><a href="{{ url('auditing') }}/{{ $vehicle->vid }}/{{ $vehicle->id }}">Resolve</a></td> 
		              <td></td>
		            </tr>
	            @endif
            @endforeach
            @foreach($inspect as $insp)
            	<tr 
            	@if($insp->file_name != "" && ($insp->doc_type == "RdWCert" || $insp->doc_type == "Insurance" || $insp->doc_type == "Licence" || $insp->doc_type == "Contract")) 
            		style="font-weight:bold" 
            	@endif
            	@if($insp->current_mileage != "" && ($insp->doc_type == "Service")) 
            		style="font-weight:bold" 
            	@endif
            	@if($insp->inspection == "1" && ($insp->doc_type == "Inspection")) 
            		style="font-weight:bold" 
            	@endif
            	>
		              <td>{{ date("d-m-Y",strtotime($insp->expired_date)) }}</td>
		              <td>{{ $insp->VNO }}</td>
		              	@if($insp->doc_type == "Inspection")
								      	<td>INP{{ str_pad($insp->id,3,'0',STR_PAD_LEFT) }}</td>
								    @elseif($insp->doc_type == "RdWCert")
								      	<td>RDW{{ str_pad($insp->id,3,'0',STR_PAD_LEFT) }}</td>
								  	@elseif($insp->doc_type == "Service")
								  		<td>SER{{ str_pad($insp->id,3,'0',STR_PAD_LEFT) }}</td>
								  	@elseif($insp->doc_type == "Insurance")
								      	<td>INS{{ str_pad($insp->id,3,'0',STR_PAD_LEFT) }}</td>
								  	@elseif($insp->doc_type == "Licence")
								      	<td>LIC{{ str_pad($insp->id,3,'0',STR_PAD_LEFT) }}</td>
								  	@elseif($insp->doc_type == "Contract")
								      	<td>CTR{{ str_pad($insp->id,3,'0',STR_PAD_LEFT) }}</td>
								  	@endif
		              <td>{{ $insp->doc_type }}</td>
		              <td>{{ $insp->DNM }} {{ $insp->DSN }}</td>    
		              @if($insp->doc_type == "Inspection")
		              	<td><a href="{{ url('inspection') }}/{{ $insp->id }}">Resolve</a></td>
		              	@if($insp->inspection == "0")
		              	<td>Inspect Vehicle</td>
		              	@else
		              	<td>Driver Acceptance Pending</td>
		              	@endif
		              @elseif($insp->doc_type == "RdWCert")
		              	<td><a href="{{ url('roadworthy') }}/{{ $insp->id }}">Resolve</a></td> 
		              	@if($insp->file_name == "")
		              	<td>Pending driver action</td>
		              	@elseif($insp->rejected == 1)
		              	<td>Rejected</td>
		              	@else
		              	<td>Approval Pending</td>
		              	@endif
	              	@elseif($insp->doc_type == "Service")
	              		<td><a href="{{ url('service') }}/{{ $insp->id }}">Resolve</a></td>
	              		@if($insp->current_mileage == "")
		              	<td>Pending driver action</td>
		              	@else
		              	<td>Approval Pending</td>
		              	@endif
	              	@elseif($insp->doc_type == "Insurance")
		              	<td><a href="{{ url('insurance') }}/{{ $insp->id }}">Resolve</a></td>
		              	@if($insp->file_name == "")
		              	<td>Pending driver action</td>
		              	@elseif($insp->rejected == 1)
		              	<td>Rejected</td>
		              	@else
		              	<td>Approval Pending</td>
		              	@endif
	              	@elseif($insp->doc_type == "Licence")
		              	<td><a href="{{ url('licence') }}/{{ $insp->id }}">Resolve</a></td>
		              	@if($insp->file_name == "")
		              	<td>Pending driver action</td>
		              	@elseif($insp->rejected == 1)
		              	<td>Rejected</td>
		              	@else
		              	<td>Approval Pending</td>
		              	@endif 
	              	@elseif($insp->doc_type == "Contract")
		              	<td><a href="{{ url('renew') }}/{{ $insp->id }}">Resolve</a></td> 
		              	@if($insp->file_name == "")
		              	<td>Upload Contract</td>
		              	@else
		              	<td>Driver Acceptance Pending</td>
		              	@endif
	              	@endif
		            </tr>
            @endforeach
            @foreach($assign as $ass)
							<tr style="font-weight:bold">
								<td>{{ date("d-m-Y",strtotime($ass->LDT)) }}</td>
						      	<td>{{ $ass->VNO }}</td>
						      	<td>ASN{{ str_pad($ass->id,3,'0',STR_PAD_LEFT) }}</td>
						      	<td>Assign Vehicle</td>
						      	<td>{{ $ass->DNM }} {{ $ass->DSN }}</td> 
						      	<td></td>
						      	<td>Driver Acceptance Pending</td>
							</tr>
						@endforeach
          </tbody>
      </table>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection

@push('page_css')
<style>
	
</style>
@endpush

@push('page_scripts')
<script>
	var override = "{{ url('override') }}";
	function load_vehicle(){
		var VNO = $("#VNO").val();
		var url =  override + "/" + VNO;
		window.location.href = url;
	}
</script>
@endpush
