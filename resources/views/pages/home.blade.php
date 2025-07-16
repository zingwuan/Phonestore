@extends('layouts.layout')
@section('content')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Sản phẩm mới nhất</h2>
    <div class="container-product">
        @foreach ($products as $key => $pro)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form>
                            @csrf
                            <input type="hidden" value="{{$pro->product_id}}"
                            class="cart_product_id_{{$pro->product_id}}" >
                            <input type="hidden" value="{{$pro->product_name}}"
                            class="cart_product_name_{{$pro->product_id}}" >
                            <input type="hidden" value="{{$pro->product_image}}"
                            class="cart_product_image_{{$pro->product_id}}" >
                            <input type="hidden" value="{{$pro->product_price}}"
                            class="cart_product_price_{{$pro->product_id}}" >
                            <input type="hidden" value="1"
                            class="cart_product_qty_{{$pro->product_id}}" >
                            <a href="{{URL::to('/chi-tiet-san-pham/'.$pro->product_id)}}">
                                <img  src="{{URL::to('public/upload/product/'.$pro->product_image)}}"
                                class="img-size img-grow" alt="" />
                                <img class="img-label" src="{{URL::to('public/frontend/images/label.png')}}" alt="">
                            </a>
                            <h2>{{number_format($pro->product_price).' '.'VND'}}</h2>
                            <p>{{$pro->product_name}}</p>
                            <button type="button" data-id_product="{{$pro->product_id}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                        </form>
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

        @endforeach
    </div>

</div><!--features_items-->

<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Các sản phẩm bán chạy</h2>

    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach ($best_products as $key => $value )
                @if($key == 0 || $key % 3 == 0)
                    @if ($key == 0)
                        <div class="item active">
                    @else
                        <div class="item">
                    @endif
                @endif
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <form>
                                        @csrf
                                        <input type="hidden" value="{{$value['product_id']}}"
                                        class="cart_product_id_{{$value['product_id']}}" >
                                        <input type="hidden" value="{{$value['product_name']}}"
                                        class="cart_product_name_{{$value['product_id']}}" >
                                        <input type="hidden" value="{{$value['product_image']}}"
                                        class="cart_product_image_{{$value['product_id']}}" >
                                        <input type="hidden" value="{{$value['product_price']}}"
                                        class="cart_product_price_{{$value['product_id']}}" >
                                        <input type="hidden" value="1"
                                        class="cart_product_qty_{{$value['product_id']}}" >
                                        <a  href="{{URL::to('/chi-tiet-san-pham/'.$value['product_id'])}}">
                                            <img class="img-size" src="{{URL::to('public/upload/product/'.$value['product_image'])}}" alt="" />
                                        </a>
                                        <h2>{{number_format($value['product_price']).' '.'VND'}}</h2>
                                        <p>{{$value['product_name']}}</p>
                                        <button type="button" data-id_product="{{$value['product_id']}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @if(($key+1) % 3 == 0 || $key == count($best_products)-1)
                    </div>
                @endif
            @endforeach
        </div>
        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
        <i class="fa fa-angle-left"></i>
        </a>
        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
        <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div><!--/recommended_items-->
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
