@extends('layouts.admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="container-status">
        @if ($order[0]->order_status == -1)
        <p class="text text-default">Đơn hàng đã bị hủy</p>
        @elseif ($order[0]->order_status == 0)
            <p class="text text-primary">Đơn hàng chưa xác nhận</p>
        @elseif ($order[0]->order_status == 1)
            <p class="text text-info">Đơn hàng đã xác nhận</p>
        @elseif ($order[0]->order_status == 2)
            <p class="text text-warning">Đơn hàng đang giao</p>
        @elseif ($order[0]->order_status == 3)
            <p class="text text-success">Đơn hàng đã hoàn thành</p>
        @endif
    </div>

    <div class="panel-heading">
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
    <div class="panel-heading">
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
      <div class="panel-heading">
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
    <div class="row" style="text-align: center">
      @if ($order[0]->order_status != -1 && $order[0]->order_status != 3 )
        <div class="col-sm-6">
        <a class="btn btn-cancel" href="{{URL::to('/cancel-order/'.$order[0]->order_id)}}" >Hủy đơn hàng</a>
        </div>
        <div class="col-sm-6">
            @if ($order[0]->order_status == 0)
                <a class="btn btn-info" href="{{URL::to('/confirm-order/'.$order[0]->order_id)}}" >Xác nhận đơn hàng</a>
            @elseif ($order[0]->order_status == 1)
                <a class="btn btn-info" href="{{URL::to('/confirm-delivery-order/'.$order[0]->order_id)}}" >Xác nhận giao hàng</a>
            @elseif ($order[0]->order_status == 2)
                <a class="btn btn-success" href="{{URL::to('/confirm-finish-order/'.$order[0]->order_id)}}" >Hoàn thành</a>
            @endif
        </div>
      @endif
    </div>
</div>

<footer class="panel-footer">
    <div class="row">

    </div>
  </footer>
@endsection
