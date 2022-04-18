<div class="row">
<table class="table table-striped table-bordered">
@foreach($result as $res)
    <tr>
        <td>Starting Mileage</td>
        <td>{{ $res->CF01 }} </td>
    </tr>
    <tr>
        <td>Spare Tire</td>
        <td>{{ $res->CF02 }} </td>
        <td>{{ $res->CC01 }} </td>
    </tr> 
    <tr>
        <td>Warning Triangle</td>
        <td>{{ $res->CF03 }} </td>
        <td>{{ $res->CC02 }} </td>
    </tr> 
    <tr>
        <td>Vehicle Tools</td>
        <td>{{ $res->CF04 }} </td>
        <td>{{ $res->CC03 }} </td>
    </tr> 
    <tr>
        <td>Fire Extinguisher</td>
        <td>{{ $res->CF05 }} </td>
        <td>{{ $res->CC04 }} </td>
    </tr>
    <tr>
        <td>Front Lights (Deem) L/R</td>
        <td>{{ $res->CF06 }} </td>
        <td>{{ $res->CC05 }} </td>
    </tr>
    <tr>
        <td>Front Lights (High) L/R</td>
        <td>{{ $res->CF07 }} </td>
        <td>{{ $res->CC06 }} </td>
    </tr>
    <tr>
        <td>Indicator Lights (FL/FR/RL/RR)</td>
        <td>{{ $res->CF08 }} </td>
        <td>{{ $res->CC07 }} </td>
    </tr>
    <tr>
        <td>Parking Lights L/R</td>
        <td>{{ $res->CF09 }} </td>
        <td>{{ $res->CC08 }} </td>
    </tr>
    <tr>
        <td>Brake Lights L/R</td>
        <td>{{ $res->CF10 }} </td>
        <td>{{ $res->CC09 }} </td>
    </tr>
    <tr>
        <td>Reverse Lights L/R</td>
        <td>{{ $res->CF11 }} </td>
        <td>{{ $res->CC10 }} </td>
    </tr>
    <tr>
        <td>Wiper Function</td>
        <td>{{ $res->CF12 }} </td>
        <td>{{ $res->CC11 }} </td>
    </tr>
    <tr>
        <td>Horn</td>
        <td>{{ $res->CF13 }} </td>
        <td>{{ $res->CC12 }} </td>
    </tr>
    <tr>
        <td>Air-Conditioner</td>
        <td>{{ $res->CF14 }} </td>
        <td>{{ $res->CC13 }} </td>
    </tr>
    <tr>
        <td>Radio</td>
        <td>{{ $res->CF15 }} </td>
        <td>{{ $res->CC14 }} </td>
    </tr>
    <tr>
        <td>Wheel Caps (FL/FR/RL/RR)</td>
        <td>{{ $res->CF16 }} </td>
        <td>{{ $res->CC15 }} </td>
    </tr>
    <tr>
        <td>Road Test</td>
        <td>{{ $res->CF17 }} </td>
        <td>{{ $res->CC16 }} </td>
    </tr>

    <tr>
        <td>Comments</td>
        <td>{{ $res->CF18 }} </td>
    </tr>
    <tr>
        <td>Front View</td>
        <td><img class="img-fluid img-thumbnail" src="../uploads/photo/{{ $res->CFP2 }}" style="width:30%;height:40%"></td>
    </tr>
    <tr>
        <td>Right View</td>
        <td><img class="img-fluid img-thumbnail" src="../uploads/photo/{{ $res->CFP3 }}" style="width:30%;height:40%"></td>
    </tr>
    <tr>
        <td>Rear View</td>
        <td> <img class="img-fluid img-thumbnail" src="../uploads/photo/{{ $res->CFP4 }}" style="width:30%;height:40%"></td>
    </tr>
     <tr>
        <td>Left View</td>
        <td> <img class="img-fluid img-thumbnail" src="../uploads/photo/{{ $res->CFP5 }}" style="width:30%;height:40%"></td>
    </tr>



@endforeach
</table>
</div>
