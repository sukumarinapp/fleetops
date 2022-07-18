@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
      <div class="content-header">
        <div class="row">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Reports</a></li>
              <li class="breadcrumb-item">Raised flags</li>
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
          <label>Raised Flags</label>
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
  <div class="card-body">
    <div class="table-responsive" >
      <table id="example1" class="table table-bordered">
        <thead>
          <tr>
            <th>Date</th>
            <th>Vehicle Reg#</th>
            <th>Driver Name</th>
            <th>Flag</th>
            <th>Remark</th>
          </tr>
        </thead>
        <tbody>
          @foreach($raisedflags as $raised)
          <tr>
           <td>{{ $raised->flg_date }}</td>
           <td>{{ $raised->VNO }}</td>
           <td>{{ $raised->DNM }} {{ $raised->DSN }}</td>
           <td>
             @if($raised->flg_type == "FLG_IP")
             Inconsistent Parking
             @endif

             @if($raised->flg_type == "FLG_NW")
             Night work
             @endif

             @if($raised->flg_type == "FLG_IR")
             Insufficient rest
             @endif

             @if($raised->flg_type == "FLG_EU")
             Excess usage
             @endif

             @if($raised->flg_type == "FLG_DU")
             Dual user
             @endif

             @if($raised->flg_type == "FLG_OS")
             Over-speeding
             @endif

             @if($raised->flg_type == "FLG_DP")
             Long day-time parking
             @endif

             @if($raised->flg_type == "FLG_VM")
             Vehicle moved
             @endif

             @if($raised->flg_type == "FLG_NG")
             Engine run
             @endif

           </td>
           <td>{{ $raised->remarks }}</td>
         </tr>
         @endforeach
       </tbody>
     </table>
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
	var raisedflags = "{{ url('raisedflags') }}";
	function load_report(){
		var from = $("#from").val();
    var to = $("#to").val();
    if(from == ""){
      alert("Please select from Date");
    }else if(to == ""){
      alert("Please select To Date");
    }else{
      var url =  raisedflags + "/" + from + "/" +to;  
      window.location.href = url;
    }		
  }

</script>
@endpush
