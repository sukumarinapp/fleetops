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
						<li class="breadcrumb-item">Add Contract</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Resolve Contract Expiry</h3>
		</div>
		<div class="table-responsive">
			<div class="card-body">
				<form onsubmit="return validate_all(event)" action="{{ route('save_contract') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
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
								<label for="VCC" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contract</label>
								<div class="col-sm-8">
									<input required="required" accept="application/pdf" name="VCC" type="file" id="VCC">
								</div>
							</div>
							<div class="form-group row">
								<label for="CEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contract Expiry Date</label>
								<div class="col-sm-4">
									<input min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required="required" onkeydown="return false" type="date" class="form-control" name="CEX" id="CEX" >
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
	function validate_all(e){
		var selection = document.getElementById('VCC');
		for (var i=0; i<selection.files.length; i++) {
		    if(selection.files[i].size > 5000000){
		    	alert('Contract file size can be a maximum of 5MB');
		        return false;
		    }
		} 
	}
</script>
@endpush