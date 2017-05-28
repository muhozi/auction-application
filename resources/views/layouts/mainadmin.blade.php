@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading panel-main-menus">
                    <ul class="nav nav-pills">
                        <li {!! (Route::currentRouteName()=='adminHome')?'class="active"':'' !!}><a href="{{route('adminHome')}}">Unproved auction<span class="badge badge-pill badge-deault" id="toProve">{{$unproved}}</span></a></li>
                        <li {!! (Route::currentRouteName()=='allAuctions')?'class="active"':'' !!}><a href="{{route('allAuctions')}}">All auctions<span class="badge badge-pill badge-deault">{{$noAuctions}}</span></a></li>
                    </ul>
                </div>

                <div class="panel-body">
                    @yield("body")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('bottom_scripts')
<script type="text/javascript">
    $('.approve').click(function(e){
        var button = this;
        $(button).attr('disabled',true);
        $.post({
            url: $(this).data('url'),
            success: function(data){
                var a = $('#toProve').text()-1;
                $('#toProve').text(a);
                if($('#auctions').data('cont')=='unproved'){
                    $(button).parent().parent().remove();
                    (a==0)?$("#auctions").replaceWith("<h1 class='text-center'>No unproved auction</h2>"):null;
                }
                else{
                    $(button).parent().html("<b class='text-success'>Approved</b>")
                }
                (a==0)?$(".approveAll").remove():null;
            },
            error:function(data){
                $(button).attr('disabled',false);
                console.log(data.responseText);
            }
        });
    });
    $('#approveAll').click(function(e){
        $(button).attr('disabled',true);
        var button = $(this);
        $.post({
            url:button.data('url'),
            success:function(data){
                $('.approveAll').remove();
                alert(data.message);
                $('#toProve').text('0');
                if($('#auctions').data('cont')=='unproved'){
                    $("#auctions").replaceWith("<h1 class='text-center'>No unproved auction</h2>");
                }
                else{
                    $('.approve').parent().html("<b class='text-success'>Approved</b>");
                }
            },
            error:function(data){
                $(button).attr('disabled',true);
                //console.log(data.responseText)
            }
        });
    });
</script>
@endsection