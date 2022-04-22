@foreach($drivers as $driver)
      <div aria-hidden="true" id="photomodal_{{ $driver->id }}" class="modal fade">
        <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Photo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
          <img src="uploads/photo/{{ $driver->photo }}" />
        </div>
      </div>
      </div>
      @endforeach

      <a data-toggle="modal" data-target="#photomodal_{{ $driver->id }}" >Photo</a>