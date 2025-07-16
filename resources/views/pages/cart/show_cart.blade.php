@extends('layouts.layout1')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Trang chủ</a></li>
              <li class="active">Giỏ hàng sản phẩm</li>
            </ol>
        </div>
        <div class="heading">
            <h3 style="text-align: center;font-size:24px">Thông tin giỏ hàng</h3>
        </div>
        <?php
            $msg = Session::get('message');
            if($msg){
                echo '<span class="text-alert-success">'.$msg.'</span>';
                Session::put('message',null);
            }
        ?>
        <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
        {{ csrf_field() }}
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Mô tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @if ($_SESSION['cart'] == true)
                    @foreach ($_SESSION['cart'] as $key => $value)
                    <tr>
                        <td class="cart_product" style="margin: 0px; margin-left: 6px">
                            <a href="{{URL::to('/chi-tiet-san-pham/'.$value['id'])}}"><img style="max-height: 100px; max-width: 100px;" src="{{URL::to('public/upload/product/'.$value['image'])}}"  alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="{{URL::to('/chi-tiet-san-pham/'.$value['id'])}}">{{$value['name']}}</a></h4>
                            <p>Mã: {{$value['id']}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($value['price'])}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="quantity">
                                <input class="cart_quantity_input" type="number"
                                min="1" max="20" step="1" name="quantity[{{$key}}]" value="{{$value['quantity']}}">
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">{{number_format($value['total'])}}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-cart/'.$key)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            @if ($_SESSION['cart'] == true)
                <div class="pull-right" style="margin: 1%">
                    <button type="submit" class="btn btn-fefault cart">Cập nhập</button>
                    <a href="{{URL::to('/clear-cart')}}" class="btn btn-fefault cart">Xóa tất cả</a>
                </div>
            @else
            <div class="img-contain-empty">
                <img class="img-empty-cart" src="{{URL::to('public/frontend/images/emptycart.png')}}">
            </div>

            @endif

        </form>
        </div>
    </div>
</section> <!--/#cart_items-->
@php
    $sum = 0;
    foreach ($_SESSION['cart'] as $key => $value) {
        $sum += $value['total'];
    }
    $total_coupon = $sum;
@endphp
<section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="total_area" style="padding: 20px">
                    <form action="{{URL::to('/check-coupon')}}" method="POST">
                        @csrf
                        <p style="text-align: center">Nhập mã giảm giá.</p>
                        @if (Session::get('coupon')&& $_SESSION['cart'])
                            <div class="form-group">
                                <input type="text" class="form-control" disabled
                                value="{{Session::get('coupon')['coupon_code']}}" name="coupon_code">
                            </div>
                            <a class="btn btn-default check-coupon" href="{{URL::to('/clear-coupon')}}">
                                Xóa mã
                            </a>
                        @else
                        <div class="form-group">
                            <input type="text" class="form-control" name="coupon_code">
                        </div>
                        <button type="submit"  class="btn btn-default check-coupon" name="check_coupon">
                            Áp dụng mã giảm giá
                        </button>
                        @endif
                    </form>

                </div>
            </div>
            <div class="col-sm-8">
                <div class="total_area">
                    <ul>
                        <li>Tổng: <span>{{number_format($sum)}} VND</span></li>
                            @if(Session::get('coupon')&& $_SESSION['cart'])
                                @php
                                    $coupon = Session::get('coupon');
                                @endphp
                                @if($coupon['coupon_condition'] == 0)
                                    <li>Giảm giá {{$coupon['coupon_number']}}% :
                                        @php
                                            $total_coupon = $sum - $sum * ($coupon['coupon_number']/100);
                                        @endphp
                                        <span>-{{number_format($sum * ($coupon['coupon_number']/100))}} VND</span>
                                    </li>
                                @elseif($coupon['coupon_condition'] == 1)
                                    <li>Giảm giá {{number_format($coupon['coupon_number'])}} VND:
                                        @php
                                            $total_coupon = $sum - ($coupon['coupon_number']);
                                        @endphp
                                        <span>-{{number_format(($coupon['coupon_number']))}}VND</span>
                                    </li>
                                @endif
                            @else
                                <li>Không áp dụng mã giảm giá</li>
                            @endif

                        <li>Phí vận chuyển: <span>Miễn phí</span></li>
                        <li>Thành tiền: <span>{{number_format($total_coupon)}} VND</span></li>
                    </ul>
                    <?php
                        $customer_id = Session::get('customer_id');
                        if($customer_id == null){
                    ?>
                    <a class="btn btn-default check_out pull-right" href="{{URL::to('/login-checkout')}}">Thanh toán</a>
                    <?php
                        }else{
                    ?>
                    <a class="btn btn-default check_out pull-right" href="{{URL::to('/show-checkout')}}">Thanh toán</a>
                    <?php
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->
@endsection
