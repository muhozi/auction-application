@extends('layouts.mainadmin')

@section('body')
<br>
{!! ($unproved>0)?'<div class="text-right approveAll"><button class="btn btn-primary btn-sm" id="approveAll" data-url="'.route('approveall').'">Approve all</button><br><br></div>':'' !!}
@if(count($products)>0)
<table class="table table-bordered table-hover" id="auctions" data-cont="unproved">
    <tr>
        <th>Product name</th>
        <th>Price</th>
        <th>Date and Time</th>
        <th>User</th>
        <th></th>
    </tr>
    @foreach($products as $product)
        <tr>
            <td>{{$product->product_name}}</td>
            <td>Rwf {{$product->minimal_price}}</td>
            <td>{{$product->created_at}}</td>
            <td>{{$product->user()}}</td>
            <td class="text-center"><button class="btn btn-primary btn-xs approve" data-url="{{route('approve',$product->id)}}">Approve</button></td>
        </tr>
    @endforeach
</table>
@else
<h1 class='text-center'>No unproved auction</h2>
@endif
<br>
@endsection