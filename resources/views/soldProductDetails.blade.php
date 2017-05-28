@extends('layouts.main')
@section('title') {{$product->product_name}} - @stop
@section('body')
<br>
@if(count($product)>0)
<div class="row">
  <div class="col-md-3 col-sm-6 text-center" style="position: relative;
    min-height: 90px;border-radius: 3px;
    border: 1px solid #e4e4e4;margin-left: 20px">
    <a href="#">
      <img class="" src="{{asset('img/products/'.$product->picture)}}" alt="..." style="margin: auto;width: auto;max-width: 100%;height: auto;max-height: 225px;display: block;text-align: center;">
    </a>
  </div>
  <div class="col-md-8 col-sm-6">
    <h4 class="media-heading">{{$product->product_name}}</h4>
    <b>End on</b> {!! $product->endDate() !!}<br>
    <b>Initial price</b>: Rwf {{$product->minimal_price}}<br>
    @if($product->maxBid())
      <b>Highest bid: </b><u><b>Rwf {{$product->maxBid()}}</b></u>&nbsp;&nbsp;|&nbsp;&nbsp; 
      <span class="badge badge-default">{{$product->bidsCount() . '&nbsp;'.str_plural('Bid',$product->bidsCount())}}</span><br>
    @else
    <b class="text-muted">No bid yet</b><br>
    @endif
    {!! ($product->hasBidden())?'<b>Your bid</b>: Rwf '.$product->userBid()->price.'<br>':'' !!}
    <br>
    <b>Description: </b><p>{{$product->description}}</p><br>
    <form method="post" action="{{ route('bidProduct',$product->id) }}" role="form" class="form-horizontal sell-form col-md-11 col-md-offset-1">
      {{csrf_field()}}
    <h4 class="text-center">Bid this product</h4>
    <hr>
    @if($product->hasBidden())
    <b class="text-info h4"><span class="ion-ios-information-outline"></span> &nbsp;Previous bid on this product:<b> Rwf {{$product->userBid()->price}}</b></b><br><br>
    @endif
    <p class="text-muted">Minimum price to bid is <b>Rwf {{($product->isBidden())?$product->maxBid()+10:$product->minimal_price}}</b></p>
    {!! (session()->has('message'))?'<b class="text-success h5">'.session()->get('message').'</b><br><br>':''!!}
    {!! (session()->has('errors'))?'<b class="text-danger h5">'.session()->get('errors')->first().'</b><br><br>':''!!}
    <br>
      <div class="form-group">
        <div class="col-md-4">Your price</div>
        <div class="col-md-8"><input type="number" name="price" value="{{($product->isBidden())?$product->maxBid()+10:$product->minimal_price}}"class="form-control" placeholder="Enter your bid price (in Rwf)..."/></div>
      </div>

      <div class="form-group text-center">
        <button class="btn btn-primary" type="submit">{{($product->hasBidden())?'Rebid':'Bid'}}</button>
      </div>
    </form>
  </div>
</div>
@else
<h2 class="text-center">No product found</h2>  
@endif
@endsection