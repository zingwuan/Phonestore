@extends('layouts.layout1')
@section('content')
<div class="register-req">
    <p>Hãy kiểm tra chính xác thông tin đặt hảng để giúp chúng tôi giao đến bạn nhanh hơn</p>
</div><!--/register-req-->

<div class="shopper-informations">

    <div class="row">
        <div class="col-sm-6 clearfix">
            <div class="bill-to">
                <p >Giỏ hàng của bạn</p>
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
                                    <td class="cart_product" style="margin-left: 4px">
                                        <a href="{{URL::to('/chi-tiet-san-pham/'.$value['id'])}}">
                                            <img src="{{URL::to('public/upload/product/'.$value['image'])}}" width="40" height="40">
                                        </a>
                                    </td>
                                    <td class="cart_description" style="font-size: 1rem">
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
                    </div>
                </form>
                <div class="total_area">
                    @php
                        $sum = 0;
                        foreach ($_SESSION['cart'] as $key => $value) {
                            $sum += $value['total'];
                        }
                        $total_coupon = $sum;
                    @endphp
                    <ul style="padding-top: 40px;padding-left: 0px;">
                        <li>Tổng: <span>{{number_format($sum)}}</span></li>
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


                </div>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            <div class="bill-to">
                <p>Điền thông tin đặt hàng</p>
                <div class="form-one" style="width: 100%" >
                    {{-- <form action="{{URL::to('/save-checkout-customer')}}" method="POST">
                        {{ csrf_field() }} --}}
                        <form>
                            @csrf
                            <input type="text" class="input1 shipping_email" name="shipping_email" placeholder="Email*">
                            <input type="text" class="input1 shipping_name" name="shipping_name" placeholder="Tên người nhận">
                            <input type="text" class="input1 shipping_phone" name="shipping_phone" placeholder="Số điện thoại">
                            <input type="text" class="input1 shipping_address" name="shipping_address" placeholder="Địa chỉ">
                            <textarea name="shipping_note" class="shipping_note"  placeholder="Viết ghi chú cho đơn hàng của bạn tại đây" rows="8"></textarea>
                            <p>Chọn hình thức thanh toán</p>
                            <div style="margin-top: 10px;">
                                <label><input name="payment_method" class="payment_method" value="Bằng tiền mặt" type="radio" checked>Trả tiền mặt</label>
                            </div>
                            <button type="button" name="add-order" class="btn btn-fefault cart btn-order-place add-order">
                                Đặt hàng
                            </button>
                        </form>

                    {{-- </form> --}}
                </div>
            </div>
        </div>
        <!--error city-province-wards-->
        {{-- <div class="col-sm-6 clearfix">
            <div class="bill-to">
                <p>Thông tin nhận hàng</p>
                <div class="form-one" style="width: 100%">
                    <form>
                        @csrf
                        <div class="form-group">
                            <select class="form-control select1 input1 choose city " name="city" id="city">
                                <option value="">--Chọn tỉnh/thành phố--</option>
                                @foreach ($cities as $key => $value )
                                    <option value="{{$value->matp}}">
                                        {{$value->name_city}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control select1 input1 choose province" name="province" id="province">
                                <option value="">--Chọn quận/huyện--</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control select1 input1 wards" name="wards" id="wards">
                                <option value="">--Chọn xã/phường--</option>

                            </select>
                        </div>
                    </form>

                </div>
            </div>
        </div> --}}


    </div>

</div>
@endsection
