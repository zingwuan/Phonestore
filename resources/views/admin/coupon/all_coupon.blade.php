@extends('layouts.admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách thương hiệu
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
            <th>Tên mã giảm giá</th>
            <th>Mã giảm giá</th>
            <th>Số lượng giảm giá</th>
            <th>Điều kiện giảm giá</th>
            <th>Số giảm</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach ( $coupons as $key => $value)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td><span class="text-ellipsis">{{$value->coupon_name}}</span></td>
                    <td><span class="text-ellipsis">{{$value->coupon_code}}</span></td>
                    <td><span class="text-ellipsis">{{$value->coupon_time}}</span></td>
                        <?php
                            if($value->coupon_condition == 0){
                        ?>
                            <td><span class="text-ellipsis">Giảm theo %</span></td>
                            <td><span class="text-ellipsis">Giảm {{$value->coupon_number}}%</span></td>
                        <?php
                        }else{
                        ?>
                            <td><span class="text-ellipsis">Giảm theo số tiền</span></td>
                            <td><span class="text-ellipsis">Giảm {{number_format($value->coupon_number).' VND'}}</span></td>
                        <?php
                        }
                        ?>
                        <td>
                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này không ?');" href="{{URL::to('/delete-coupon/'.$value->coupon_id)}}" class="active styling-delete" ui-toggle-class="">
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
                    Hiển thị {{($coupons->count()>=20)?20:$coupons->count()}}
                    /{{$coupons->count()}} Mã giảm giá
                </small>
            </div>
            <div class="col-sm-7 text-right text-center-xs">
                {{$coupons->links()}}
            </div>
        </div>
    </footer>
  </div>
</div>
@endsection
