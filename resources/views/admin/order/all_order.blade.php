@extends('layouts.admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách đơn hàng
    </div>
    <?php
        $msg = Session::get('message');
        if($msg){
            echo '<span class="text-alert-success">'.$msg.'</span>';
            Session::put('message',null);
        }
    ?>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Mã đơn hàng</th>
            <th>Tên người đặt</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thời gian đặt</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach ( $all_order as $key => $order)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ number_format($order->order_total) }} VND</td>
                    @php
                        if($order->order_status == 0){
                            echo '<td><span class="text-info">'.'Đơn hàng mới'.'</span></td>';
                        }elseif ($order->order_status == 1) {
                            echo '<td><span class="text-warning">'.'Đã xác nhận'.'</span></td>';
                        }elseif ($order->order_status == 2) {
                            echo '<td><span class="text-warning">'.'Đang giao hàng'.'</span></td>';
                        }elseif ($order->order_status == 3) {
                            echo '<td><span class="text-success">'.'Đã hoàn thành'.'</span></td>';
                        }elseif ($order->order_status == -1) {
                            echo '<td><span class="text-default">'.'Đã hủy'.'</span></td>';
                        }
                    @endphp
                    <td>{{$order->created_at}}</td>
                    <td>
                    <a href="{{URL::to('/edit-order/'.$order->order_id)}}" class="active styling-edit" ui-toggle-class="">
                        <i class="fa fa-pencil-square-o text-success text-active"></i>
                    </a>
                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không ?');" href="{{URL::to('/delete-order/'.$order->order_id)}}" class="active styling-delete" ui-toggle-class="">
                        <i class="fa fa-times text-danger text"></i>
                    </a>
                    </td>
                </tr>
            @endforeach


        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
        <div class="row">
            <div class="col-sm-5 text-center">
                <small class="text-muted inline m-t-sm m-b-sm">
                    Hiển thị {{($all_order->count()>=20)?20:$all_order->count()}}
                    /{{$all_order->count()}} đơn hàng
                </small>
            </div>
            <div class="col-sm-7 text-right text-center-xs">
                {{$all_order->links()}}
            </div>
        </div>
    </footer>
  </div>
</div>
@endsection
