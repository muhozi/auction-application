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
  <div class="col-md-8 col-sm-12">
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
    <b>Status</b>: {{($product->approved)?'Proved':'Pending'}}  
    {!! ($product->sold || $product->isEnded())?' | <span class="badge badge-danger">Auction closed</span>':'' !!}
    <br>
    <br>
    <b>Description: </b><p>{{$product->description}}</p><br>
    @if($product->isBidden() && !$product->sold)
        <div><p class="text-center">Close auction to stop bidding and get contact information of the top bidder<br><br>   
                
                    <button class="btn btn-danger btn-xs" data-toggle="modal" data-target=".confirmBox"> Close auction</button>
            
            </p>
        </div>
        <hr>
    @endif
    @if(!$product->isBidden())
        <div><p class="text-center">You may also delete this auction record because no one has bade on this product <br><br>
        <a href="{{route('soldDelete',$product->id)}}" onclick="event.preventDefault();document.getElementById('deleteAuction').submit();">
            <button class="btn btn-danger btn-xs"> Delete auction</button></p>
        </a>    
        <form id="deleteAuction" action="{{ route('soldDelete',$product->id) }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
        </div>
        <hr>
    @endif
    @if(session()->has('message'))
        <div class="text-center text-success">{{session()->get('message')}}</div><br>
    @endif
    @if($product->isBidden())
    <h3 class="text-center">Auction bids</h3>
<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped" id="auctions" data-cont="all">
    <thead>
    <tr>
        <th>#</th>
        <th>Names</th>
        <th>Bid price</th>
        <th>Date and Time</th>
    </tr>
    </thead>
    <tbody>
    <?php $a=1; ?>
    @foreach($product->bids() as $bid)
        <tr {!!($product->maxBid()==$bid->price)?'class="success" style="border-left:5px solid green;"':''!!}  {!! ($product->isBidden() && $product->sold)?'data-toggle="modal" data-target=".contactDetails" id="pointer"':''!!}>
            <td>{{$a}}</td>
            <td>{{$bid->user()->firstname.' '.$bid->user()->lastname}}</td>
            <td>Rwf {{$bid->price}}</td>
            <td>{!!$bid->date()!!}</td>
            
        </tr>
        <?php $a++; ?>
    @endforeach
    </tbody>

</table>
</div>
@else
<h3 class="text-center">No bids placed on this auction</h3>
@endif
@if($product->isBidden() && $product->sold)
<div class="modal fade contactDetails" tabindex="-1" role="dialog" {{--data-backdrop="static"--}}data-keyboard="false" aria-labelledby="boxTitle">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="boxTitle">Contact details of top bidder</h5>
      </div>
      <div class="modal-body">
      <?php $details = $product->maxBidDetails()->user(); ?>
        <b>Names</b>: {{$details->firstname. ' ' . $details->lastname}}<br>
        <b>Email</b>: {{$details->email}}<br>
        <b>Phone</b>: {{$details->phone}}<br>
      </div>
      <div class="modal-footer">
        <p>Use the above details to contact the top bidder to proceed with payment process</p>
      </div>
    </div>
  </div>
</div>
@endif

  </div>
</div>
@else
<h2 class="text-center">No product found</h2>  
@endif

<div class="modal fade confirmBox" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="boxTitle">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="boxTitle" onclick="$('.close').addClass('.disabled')">Delete?</h5>
      </div>
      <div class="modal-body">
        Do you really want to close this Auction,
        Users will no longer be able to bid again.<br>
        
        <br><br>
        <b class="text-warning">Note that this action can not be undone</b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
        <a href="{{route('soldClose',$product->id)}}" onclick="event.preventDefault();document.getElementById('closeAuction').submit();"><button type="button" class="btn btn-danger btn-sm">Yes, Close</button></a>
      </div>
    </div>
  </div>
</div>
<form id="closeAuction" action="{{ route('soldClose',$product->id) }}" method="POST" style="display: none;">{{ csrf_field() }}</form>

@endsection