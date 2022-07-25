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
              <li class="breadcrumb-item">Test Tracker Command</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-info">
     <div class="card-header">
      <h3 class="card-title">Test Tracker Command</h3>
    </div>
    <div style="overflow-x: auto;" class="card-body">
      <form action="{{ route('insert_tracker_command') }}" method="post" class="form-horizontal">
        @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="form-group row">
            <label for="VNO" class="col-sm-4 col-form-label"><span style="color:red"></span>Vehicle No</label>
            <div class="col-sm-8">
              <input type="text" value="GN7121-17" class="form-control" name="VNO" id="VNO" maxlength="10" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="TID" class="col-sm-4 col-form-label"><span style="color:red"></span>Terminal ID</label>
            <div class="col-sm-8">
              <input type="text" value="233500628193" class="form-control" name="TID" id="TID" maxlength="10" readonly>
            </div>
          </div>

          <div class="form-group row">
            <label for="command" class="col-sm-4 col-form-label"><span style="color:red"></span>Action</label>
            <div class="col-sm-8">
              <select onchange="load_command()" required="required" class="form-control select2" name="command" id="command" >
                <option value="">Select</option>
                <option value="block">Block</option>
                <option value="unblock">Unblock</option>
                <option value="buzon">Buzzer on</option>
                <option value="buzoff">Buzzer off</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="data_packet" class="col-sm-4 col-form-label"><span style="color:red"></span>Tracker Command</label>
            <div class="col-sm-8">
             <textarea class="form-control" name="data_packet" id="data_packet" rows="4"></textarea>
           </div>
         </div>

          <div class="form-group row">
            <label for="cmd_state" class="col-sm-4 col-form-label"><span style="color:red"></span>State of Output</label>
    <div class="col-sm-8">
      <input type="text" value="{{ $cmd_state }}" class="form-control" name="cmd_state" id="cmd_state" maxlength="10" readonly>
    </div>
  </div>

       </div>
     </div>
     <div class="form-group row">
      <div class="col-md-12 text-center">
       <input required="required" class="btn btn-info"  type="submit" name="submit" value="Send Command"/>
     </div>
   </div> 
   </form> 
  
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('page_scripts')
<script>
  function load_command(){
    var command = $("#command").val();
    var cmd_text = "";
    if(command == "block"){
      cmd_text = "40 40 00 16 36 5D B8 D4 E1 FF FF 41 15 01 02 02 02 02 FF FF 0D 0A"; 
    }else if(command == "unblock"){
      cmd_text = "40 40 00 16 36 5D B8 D4 E1 FF FF 41 15 00 02 02 02 02 FF FF 0D 0A"; 
    }else if(command == "buzon"){
      cmd_text = "40 40 00 16 36 5D B8 D4 E1 FF FF 41 15 02 02 02 01 02 FF FF 0D 0A"; 
    }else if(command == "buzoff"){
      cmd_text = "40 40 00 16 36 5D B8 D4 E1 FF FF 41 15 02 02 02 00 02 FF FF 0D 0A"; 
    }
    $("#data_packet").text(cmd_text);
  }
</script>
@endpush  



