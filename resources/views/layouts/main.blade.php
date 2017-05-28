@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading panel-main-menus">
                    <ul class="nav nav-pills">
                        <li {!! (Route::currentRouteName()=='sell')?'class="active"':'' !!}><a href="{{url('sell')}}">Sell a product</a></li>
                        <li {!! (Route::currentRouteName()=='sold' || Route::currentRouteName()=='soldDetails')?'class="active"':'' !!}><a href="{{url('soldproducts')}}">Your auctions</a></li>
                        <li {!! (Route::currentRouteName()=='buy' || Route::currentRouteName()=='buyProduct')?'class="active"':'' !!}><a href="{{route('buy')}}">Buy (Bid)</a></li>
                      
                      {{--<li role="presentation"><a href="#">Messages</a></li>--}}
                    </ul>
                </div>

                <div class="panel-body" id="body">
                    @yield("body")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection