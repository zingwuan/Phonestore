@extends('layouts.layout')
@section('content')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Sản phẩm được tìm kiếm</h2>
    <div class="container-product">
        @foreach ($products as $key => $pro)
        <a href="{{URL::to('/chi-tiet-san-pham/'.$pro->product_id)}}">
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                        <div class="productinfo text-center">
                            <img class="img-size img-grow" src="{{URL::to('public/upload/product/'.$pro->product_image)}}" alt="" />
                            <h2>{{number_format($pro->product_price).' '.'VND'}}</h2>
                            <p>{{$pro->product_name}}</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                        </div>
                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        @if($product_total_quantity[$key] > 0)
                            <li><a>Đã bán: {{$product_total_quantity[$key]}}</a></li>
                        @else
                            <li><a>Hàng mới</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        </a>
        @endforeach
    </div>



</div><!--features_items-->
<div class="row">
    <div class="col-sm-5 text-center">
        <small class="text-muted inline m-t-sm m-b-sm">
            Hiển thị {{($products->count()>=15)?15:$products->count()}}
            /{{$products->count()}} sản phẩm
        </small>
    </div>
    <div class="col-sm-7 text-right text-center-xs">
        {{$products->links()}}
    </div>
</div>
@endsection
