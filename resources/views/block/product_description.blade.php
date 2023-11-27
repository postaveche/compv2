@if (isset($product_info))
<table class="table table-striped">
    <tbody>
    @foreach($product_info as $info)
    <tr>
        @if($info->descriptionRom == !null)
        <td><b>{{$info->propertyNameRom}}</b></td>
        <td>{{$info->descriptionRom}}</td>
        @endif
    </tr>
    @endforeach
  </tbody>
</table>
@endif
