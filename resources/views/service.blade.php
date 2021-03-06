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
								<li class="breadcrumb-item"><a href="{{ route('workflow') }}">Workflow</a></li>
								<li class="breadcrumb-item">Vehicle Service</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Complete Vehicle Service</h3>
				</div>
				<div class="table-responsive">
					<div class="card-body">
						<form action="{{ route('saveservice') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
							@csrf
							<input type="hidden" name="driver_id" value="{{ $driver_id }}" />
							<input type="hidden" name="upload_id" value="{{ $upload_id }}" />
							<input type="hidden" name="VNO" value="{{ $VNO }}" />
							<input type="hidden" name="VID" value="{{ $VID }}" />
							<input type="hidden" name="RSS" value="{{ $RSS }}" />
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
										<label for="" class="col-sm-5 col-form-label"><span style="color:red"></span>Driver Name</label>
										<div class="col-sm-7">
											{{ $DNM }}
										</div>
									</div>
									<div class="form-group row">
										<label for="" class="col-sm-5 col-form-label"><span style="color:red"></span>Vehicle Reg No</label>
										<div class="col-sm-7">
											{{ $VNO }}
										</div>
									</div>
									@if($file_name != "")
									<div class="form-group row">
										<a target="_blank" href="../uploads/driver/{{ $file_name }}" >File uploaded by driver</a>
									</div>	
									@endif
									
									<div class="form-group row">
										
										<label 
										@if($current_mileage != "")
											style="color:blue "
										@endif 
										for="current_mileage" class="col-sm-5 col-form-label"><span style="color:red">*</span>Current Odometer Reading</label>
										<div class="col-sm-4">
											<input value="{{ $current_mileage }}" required="required" maxlength="8" type="text" class="form-control number" name="current_mileage" id="current_mileage" >
										</div>
									</div>
									
									@if($RSS == 0)
									<div class="form-group row">
										<label for="service_date" class="col-sm-5 col-form-label"><span style="color:red">*</span>Next Scheduled Date</label>
										<div class="col-sm-4">
											<input min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required="required" onkeydown="return false" type="date" class="form-control" name="SSD" id="service_date" >
										</div>
									</div>
									<div class="form-group row">
										<label for="SSM" class="col-sm-5 col-form-label"><span style="color:red">*</span>Next Scheduled Mileage</label>
										<div class="col-sm-4">
											<input required="required" type="text" class="form-control" name="SSM" id="SSM" >
										</div>
									</div>
									@endif

								</div>
								<!-- /.col -->
							</div>
							<div class="col-md-12 text-center">
								<input id="save" required="required" class="btn btn-info"	type="submit" name="submit" value="Save"/>
								<a href="{{ route('workflow') }}" class="btn btn-info">Back</a>
							</div>
						</div>	
					</div>
				</div>

			</form> 
		</section>

		@endsection
@push('page_scripts')
<script>
var approve_licence_url = "{{ url('approve_licence') }}";
function approve_licence(upload_id){
  var url =  approve_licence_url+"/"+upload_id;
  $.ajax({
      type: "get",
      url: url,
      success: function(response) {
        window.location.href = "{{ url('workflow') }}";
      },
      error: function (jqXHR, exception) {
        console.log(exception);
      }
  });
}
</script>
@endpush