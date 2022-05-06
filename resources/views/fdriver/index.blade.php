@extends('layouts.app')

@section('content')
<style>
  .img-center {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>
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
              <li class="breadcrumb-item">Driver Manager</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Driver Manager</h3>
			<a href="{{ route('fdriver.create') }}" class="btn btn-secondary float-right"><i class="nav-icon fas fa-plus"></i>&nbsp; Add Driver</a>
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
			<table id="example1" class="table table-bordered">
          <thead>
          <tr>
            <th>Driver Name</th>
            <th>License #</th>
            <th>Contact #</th>
            <th>Business Model</th>
            <th >Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($drivers as $driver)
            <tr
            @if($driver->VNO == "")
              style="color: #FFC300;"
            @endif
            >
              <td>
               @php
                if($driver->VNO != ""){
                   echo "<span><img src='assign.jpg'></span>";
                 }
                 @endphp

                {{ $driver->DNM }} {{ $driver->DSN }}
              @if($driver->VNO !="")
                <br><small class="text-success"><a href="{{ route('vehicle.edit',$driver->vid) }}">{{ $driver->VNO }}</a></small>
              @endif
              </td>
              <td>{{ $driver->DNO }}</td>
              <td>{{ $driver->DCN }}</td>
              <td>{{ $driver->VBM }}</td>
              
              <td style="white-space: nowrap">
                <form action="{{ route('fdriver.destroy', $driver->id)}}" method="post">
                    @csrf
                  
                @if($driver->photo != "")
                <a href="#" data-toggle="modal" data-target="#photomodal_{{ $driver->id }}" class="btn btn-secondary btn-xs"><i class="fa fa-user"></i></a>
                @else
                <button class="btn btn-secondary btn-xs disabled" ><i class="fa fa-user"></i></button>
                @endif
                <a href="#" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#licencemodal_{{ $driver->id }}" ><i class="fa fa-id-card"></i></a>
                @if($driver->VNO != "")
                <a class="btn btn-secondary btn-xs" href="{{ route('agreementdriver',$driver->id) }}"><i class="fa fa-file"></i></a>
                @else
                <a class="btn btn-secondary btn-xs disabled" ><i class="fa fa-file"></i></a>
                @endif

                    <a href="{{ route('fdriver.edit',$driver->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                    @method('DELETE')
                  @if($driver->VNO == "")
                  <button onclick="return confirm('Do you want to perform delete operation?')" class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash"></i></button>
                  @else
                  <button class="btn btn-danger btn-xs disabled" ><i class="fa fa-trash"></i></button>
                  @endif
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
      </table>
			</div>
      @foreach($drivers as $driver)
      @if($driver->photo != "")
      <div aria-hidden="true" id="photomodal_{{ $driver->id }}" class="modal fade">
        <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Photo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="card-body">
          <img class="img-center" src="uploads/photo/{{ $driver->photo }}" width="250" height="200" />
        </div>
        </div>
      </div>
      </div>
      @endif
      <div aria-hidden="true" id="licencemodal_{{ $driver->id }}" class="modal fade">
        <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Licence</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="card-body">
          <img class="img-center" src="uploads/DLD/{{ $driver->DLD }}" width="300" height="200" />
          <p class="text-center">Licence Front</p>
          <img class="img-center" src="uploads/DLD/{{ $driver->DLD2 }}" width="300" height="200" />
          <p class="text-center">Licence Back</p>
        </div>
        </div>
      </div>
      </div>
      @endforeach
		</div>
		</div>
	</div>
</div>
@endsection