@extends('layouts.main')
@section('title') My auctions - @stop
@section('body')
<br>
@if(count($products)>0)
@foreach($products as $product)
<div class="row">
  <div class="col-md-3 text-center" style="position: relative;
    min-height: 90px;border-radius: 3px;
    border: 1px solid #e4e4e4;margin-left: 20px">
    <a href="#">
      <img class="" src="{{asset('img/products/'.$product->picture)}}" alt="..." style="margin: auto;width: auto;max-width: 100%;height: auto;max-height: 225px;display: block;text-align: center;">
    </a>
  </div>
  <div class="col-md-8">
    <h4 class="media-heading"><a href="{{route('soldDetails',$product->id)}}">{{$product->product_name}}</a></h4>
    <b>End time</b>: {!!$product->endDate()!!}<br>
    <b>Initial Price</b>: Rwf {{$product->minimal_price}}<br>
    @if($product->maxBid())
      <b>Highest bid: </b><u><b>Rwf {{$product->maxBid()}}</b></u>&nbsp;&nbsp;|&nbsp;&nbsp; 
      <span class="badge badge-default">{{$product->bidsCount() . '&nbsp;'.str_plural('Bid',$product->bidsCount())}}</span><br>
    @else
    <b class="text-muted">No bid yet</b><br>
    @endif
    <b>Status</b>: {{($product->approved)?'Proved':'Pending'}}  
    {!! ($product->sold || $product->isEnded())?' | <span class="badge badge-danger">Auction closed</span>':'' !!}
    <br>
    <br>
    <b>Description: </b><p>{{$product->description}}</p><br>
  </div>
</div><hr>
@endforeach
@else
<div class="h1 text-center">You have not yet sold any product</div>
<div class="text-center"><a href="{{route('sell')}}"><button class="btn btn-primary">Start selling   your product</button></a></div>
@endif
@endsection
