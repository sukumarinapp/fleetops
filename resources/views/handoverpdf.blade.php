@section('content')
<div class="row">
<table>
    <tr>
        <th>2323232</th>
        <th>2323232</th>
    </tr><tr>
        <th>2323232</th>
        <th>2323232</th>
    </tr><tr>
        <th>2323232</th>
        <th>2323232</th>
    </tr><tr>
        <th>2323232</th>
        <th>2323232</th>
    </tr>
@foreach($result as $res)
    <tr>
        <td>Starting Mileage</td>
        <td>{{ $res->CF01 }} </td>
    </tr>
@endforeach
</table>
</div>
@endsection