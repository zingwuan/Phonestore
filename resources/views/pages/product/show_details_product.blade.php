@extends('layouts.layout')
@section('content')
@foreach ($detail_product as $key => $detail_pro)
<div class="product-details"><!--product-details-->
    <div class="col-sm-5">
        <div class="view-product">
            <img src="{{URL::to('public/upload/product/'.$detail_pro->product_image)}}" alt="" />
            <h3>Sale off 12%</h3>
        </div>
        {{-- <div id="similar-product" class="carousel slide" data-ride="carousel">
              <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                      <a href=""><img src="{{URL::to('public/frontend/images/similar1.jpg')}}" alt=""></a>
                      <a href=""><img src="{{URL::to('public/frontend/images/similar2.jpg')}}" alt=""></a>
                      <a href=""><img src="{{URL::to('public/frontend/images/similar3.jpg')}}" alt=""></a>
                    </div>
                    <div class="item">
                      <a href=""><img src="{{URL::to('public/frontend/images/similar1.jpg')}}" alt=""></a>
                      <a href=""><img src="{{URL::to('public/frontend/images/similar2.jpg')}}" alt=""></a>
                      <a href=""><img src="{{URL::to('public/frontend/images/similar3.jpg')}}" alt=""></a>
                    </div>
                    <div class="item">
                      <a href=""><img src="{{URL::to('public/frontend/images/similar1.jpg')}}" alt=""></a>
                      <a href=""><img src="{{URL::to('public/frontend/images/similar2.jpg')}}" alt=""></a>
                      <a href=""><img src="{{URL::to('public/frontend/images/similar3.jpg')}}" alt=""></a>
                    </div>

                </div>

              <!-- Controls -->
              <a class="left item-control" href="#similar-product" data-slide="prev">
                <i class="fa fa-angle-left"></i>
              </a>
              <a class="right item-control" href="#similar-product" data-slide="next">
                <i class="fa fa-angle-right"></i>
              </a>
        </div> --}}

    </div>
    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->
            <img src="{{URL::to('public/frontend/images/new.jpg')}}" class="newarrival" alt="" />
            <h2>{{$detail_pro->product_name}}</h2>
            <p>Mã: {{$detail_pro->product_id}}</p>
            <img src="{{URL::to('public/frontend/images/rating.png')}}" alt="" />
            <form role="form" action="{{URL::to('/save-cart')}}" method="post">
                {{ csrf_field() }}
                <span>
                    <span>{{number_format($detail_pro->product_price).' VND'}}</span>
                    <label>Số lượng:</label>
                    <input type="number" name="quantity" min="1" value="1" />
                    <input type="hidden" name="product_id_hidden" value="{{$detail_pro->product_id}}" />
                    <button type="submit" class="btn btn-fefault cart">
                        <i class="fa fa-shopping-cart"></i>
                        Thêm vào giỏ hàng
                    </button>
                </span>
            </form>
            <p><b>Tình trạng:</b> Còn hàng</p>
            <p><b>Điều kiện:</b> Mới 100%</p>
            <p><b>Thương hiệu:</b> {{$detail_pro->brand_name}}</p>
            <p><b>Danh mục:</b> {{$detail_pro->category_name}}</p>
            <a href=""><img src="{{URL::to('public/frontend/images/share.png')}}" class="share img-responsive"  alt="" /></a>
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->


<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#desc" data-toggle="tab">Mô tả</a></li>
            <li><a href="#details" data-toggle="tab">Chi tiết sản phẩm</a></li>
            <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="desc" >
            @php
                echo $detail_pro->product_desc;
            @endphp
        </div>
        <div class="tab-pane fade" id="details" >
            @php
                echo $detail_pro->product_content;
            @endphp
        </div>

        <div class="tab-pane fade" id="reviews" >
            <div class="col-sm-12">
                <ul>
                    <li><a href=""><i class="fa fa-user"></i>Hải Phòng</a></li>
                    <li><a href=""><i class="fa fa-clock-o"></i>
                    @php
                        echo date("h:i:sa");
                    @endphp
                    </a></li>
                    <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                </ul>
                <p>Chúng tôi rất hân hạnh khi được đón tiếp bạn tại trang web này và sẽ còn vui hơn nữa khi bạn có thể giúp chúng tôi đánh giá về sản phẩm này để chúng tôi càng ngày hoàn thiện hơn nữa cho dịch vụ và vươn tới phát triển bền vững.</p>
                <p><b>Viết về đánh giá của bạn</b></p>

                <form action="#">
                    <span>
                        <input type="text" placeholder="Tên của bạn"/>
                        <input type="email" placeholder="Địa chỉ email"/>
                    </span>
                    <textarea name="" ></textarea>
                    <b>Đánh giá: </b> <img src="{{URL::to('public/frontend/images/rating.png')}}" alt="" />
                    <button type="button" class="btn btn-default pull-right">
                        Gửi
                    </button>
                </form>
            </div>
        </div>

    </div>
</div><!--/category-tab-->
@endforeach
<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Sản phẩm gợi ý</h2>
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach ($related_pros as $key => $value )
                @if($key == 0 || $key % 3 == 0)
                    @if ($key == 0)
                        <div class="item active">
                    @else
                        <div class="item">
                    @endif
                @endif
                <a href="{{URL::to('/chi-tiet-san-pham/'.$value->product_id)}}">
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img class="img-grow" src="{{URL::to('public/upload/product/'.$value->product_image)}}" alt="" />
                                    <h2>{{number_format($value->product_price).' VND'}}</h2>
                                    <p>{{$value->product_name}}</p>
                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                @if(($key+1) % 3 == 0 || $key == count($related_pros)-1)
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
@endsection
