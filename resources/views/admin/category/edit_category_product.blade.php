@extends('layouts.admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật danh mục sản phẩm
                </header>
                <?php
                    $msg = Session::get('message');
                    if($msg){
                        echo '<span class="text-alert-success">'.$msg.'</span>';
                        Session::put('message',null);
                    }
                ?>
                <div class="panel-body">
                    @foreach ( $edit_category_product as $key => $cate_pro )
                        <div class="position-center">
                            <form role="form" action="{{URL::to('/update-category-product/'.$cate_pro->category_id)}}" method="post">
                                {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên danh mục</label>
                                <input type="text" value="{{$cate_pro->category_name}}" name="category_product_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên danh mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả</label>
                                <textarea class="form-control" style="resize: none;" rows="8" name="category_product_desc" id="exampleInputPassword1">
                                    {{$cate_pro->category_desc}}
                                </textarea>
                            </div>

                            <button type="submit" name="update_category_product" class="btn btn-info">Cập nhật danh mục</button>
                        </form>
                        </div>
                    @endforeach


                </div>
            </section>

    </div>
</div>
@endsection
