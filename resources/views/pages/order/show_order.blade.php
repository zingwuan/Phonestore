@extends('layouts.layout1')
@section('content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="container-status">
        @if ($order[0]->order_status == -1)
        <p class="text text-default" style="text-align: center">Đơn hàng đã bị hủy</p>
        @elseif ($order[0]->order_status == 0)
            <p class="text text-primary" style="text-align: center">Đơn hàng chưa xác nhận</p>
        @elseif ($order[0]->order_status == 1)
            <p class="text text-info" style="text-align: center">Đơn hàng đã xác nhận</p>
        @elseif ($order[0]->order_status == 2)
            <p class="text text-warning" style="text-align: center">Đơn hàng đang giao</p>
        @elseif ($order[0]->order_status == 3)
            <p class="text text-success" style="text-align: center">Đơn hàng đã hoàn thành</p>
        @endif
    </div>

    <div class="panel-heading" style="text-align: center; font-size: 1.8rem">
      Thông tin người mua
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên người đặt</th>
            <th>Số điện thoại</th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$order[0]->customer_name}}</td>
                <td>{{$order[0]->customer_phone}}</td>
            </tr>
        </tbody>
      </table>
    </div>
    <div class="panel-heading" style="text-align: center; font-size: 1.8rem">
        Thông tin vận chuyển
    </div>
       <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>Tên người nhận</th>
              <th>Địa chỉ</th>
              <th>Số điện thoại</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                  <td>{{$order[0]->shipping_name}}</td>
                  <td>{{$order[0]->shipping_address}}</td>
                  <td>{{$order[0]->shipping_phone}}</td>
              </tr>
          </tbody>
        </table>
      </div>
      <div class="panel-heading" style="text-align: center; font-size: 1.8rem">
        Chi tiết đơn hàng
      </div>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th style="width:20px;">
                <label class="i-checks m-b-none">
                  <input type="checkbox"><i></i>
                </label>
              </th>
              <th>Mã sản phẩm</th>
              <th>Tên sản phẩm</th>
              <th>Giá</th>
              <th>Số lượng</th>
              <th>Tổng</th>
            </tr>
          </thead>
          <tbody>
            @foreach ( $order as $key => $order_d)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{ $order_d->product_id }}</td>
                    <td>{{ $order_d->product_name }}</td>
                    <td>{{ $order_d->product_price }}</td>
                    <td>{{ $order_d->product_sales_quantity}}</td>
                    <td>{{ $order_d->product_sales_quantity * $order_d->product_price}}</td>
                </tr>
            @endforeach
          </tbody>
          <tfoot>
                <tr class="info">
                    <td colspan="5" class="text-right">Tổng tiền:</td>
                    <td>{{$order[0]->order_total}}</td>
                </tr>
          </tfoot>
        </table>
      </div>

    </div>
</div>
@endsection
