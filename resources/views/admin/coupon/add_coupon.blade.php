@extends('layouts.admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm mã giảm giá
                </header>
                <?php
                    $msg = Session::get('message');
                    if($msg){
                        echo '<span class="text-alert-success">'.$msg.'</span>';
                        Session::put('message',null);
                    }
                ?>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/save-coupon')}}" method="POST">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên giảm giá</label>
                            <input type="text" name="coupon_name" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mã giảm giá</label>
                            <input type="text" name="coupon_code" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Số lượng mã</label>
                            <input type="text" name="coupon_time" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tính năng mã</label>
                            <select class="form-control input-sm m-bot15" name="coupon_condition">
                                <option value="0">Giảm theo %</option>
                                <option value="1">Giảm theo tiền</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nhập % hoặc số tiền giảm</label>
                            <input type="text" name="coupon_number" class="form-control" id="exampleInputEmail1">
                        </div>
                        <button type="submit" name="add_brand_product" class="btn btn-info">Thêm mã giảm giá</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
</div>
@endsection
