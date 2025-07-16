@extends('layouts.admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật thương hiệu sản phẩm
                </header>
                <?php
                    $msg = Session::get('message');
                    if($msg){
                        echo '<span class="text-alert-success">'.$msg.'</span>';
                        Session::put('message',null);
                    }
                ?>
                <div class="panel-body">
                    {{-- @foreach ( $edit_brand_product as $key => $brand_pro )
                        <div class="position-center">
                            <form role="form" action="{{URL::to('/update-brand-product/'.$brand_pro->brand_id)}}" method="post">
                                {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên thương hiệu</label>
                                <input type="text" value="{{$brand_pro->brand_name}}" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên thương hiệu">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả</label>
                                <textarea class="form-control" style="resize: none;" rows="8" name="brand_product_desc" id="exampleInputPassword1">
                                    {{$brand_pro->brand_desc}}
                                </textarea>
                            </div>

                            <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhật thương hiệu</button>
                        </form>
                        </div>
                    @endforeach --}}
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-brand-product/'.$edit_brand_product->brand_id)}}" method="post">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu</label>
                            <input type="text" value="{{$edit_brand_product->brand_name}}" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên thương hiệu">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea class="form-control" style="resize: none;" rows="8" name="brand_product_desc" id="exampleInputPassword1">
                                {{$edit_brand_product->brand_desc}}
                            </textarea>
                        </div>

                        <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhật thương hiệu</button>
                    </form>
                    </div>


                </div>
            </section>

    </div>
</div>
@endsection
