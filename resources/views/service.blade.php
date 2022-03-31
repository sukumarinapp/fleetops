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
								<li class="breadcrumb-item"><a href="{{ route('vehicle.index') }}">Vehicle</a></li>
								<li class="breadcrumb-item">Add Vehicle</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Renew Vehicle Service Due Date</h3>
				</div>
				<div class="table-responsive">
					<div class="card-body">
						<form action="{{ route('save_new_licence') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
							@csrf
							<input type="hidden" name="driver_id" value="{{ $driver_id }}" />
							<input type="hidden" name="upload_id" value="{{ $upload_id }}" />
							<input type="hidden" name="VNO" value="{{ $VNO }}" />
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
										<label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Driver Name</label>
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
										<label for="SSD" class="col-sm-4 col-form-label"><span style="color:red">*</span>New Service Due Date</label>
										<div class="col-sm-4">
											<input min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required="required" onkeydown="return false" type="date" class="form-control" name="SSD" id="SSD" >
										</div>
									</div>
									<div class="form-group row">
										<label for="SSM" class="col-sm-4 col-form-label"><span style="color:red">*</span>New Service Due Mileage</label>
										<div class="col-sm-4">
											<input required="required" maxlength="8" type="text" class="form-control number" name="SSM" id="SSM" >
										</div>
									</div>
									
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