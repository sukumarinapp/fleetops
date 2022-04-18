<div class="row">
<table>
@foreach($result as $res)
    <tr>
        <td>Starting Mileage</td>
        <td>{{ $res->CF01 }} </td>
    </tr>
    <tr>
        <td>Warning Triangle</td>
        <td>{{ $res->CC02 }} </td>
    </tr>
@endforeach
</table>
</div>
