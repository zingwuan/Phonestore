@extends('layouts.admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhập sản phẩm
                </header>
                <?php
                    $msg = Session::get('message');
                    if($msg){
                        echo '<span class="text-alert-success">'.$msg.'</span>';
                        Session::put('message',null);
                    }
                ?>
                <div class="panel-body">
                    @foreach($edit_product as $key => $pro)
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-product/'.$pro->product_id)}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="text" value="{{$pro->product_name}}" name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá sản phẩm</label>
                            <input type="text" value="{{$pro->product_price}}" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Nhập giá sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                            <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                            <img src="{{URL::to('public/upload/product/'.$pro->product_image)}}" width="100" height="100">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea name="product_desc" id="editor1">{{$pro->product_desc}}</textarea>
                        </div>
                        {{-- <div class="form-group">
                            <textarea name="editor1" id="ckeditor1" rows="10" cols="80">
                                This is my textarea to be replaced with CKEditor 4.
                            </textarea>
                        </div> --}}
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                            <textarea name="product_content" id="editor2">{{$pro->product_content}}</textarea>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                            <select class="form-control input-sm m-bot15" name="category_id">
                                @foreach ($cates as $key => $cate)
                                    @if($pro->category_id == $cate->category_id)
                                        <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @else
                                        <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @endif

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Thương hiệu</label>
                            <select class="form-control input-sm m-bot15" name="brand_id">
                                @foreach ($brands as $key => $brand)
                                    @if($pro->brand_id == $brand->brand_id)
                                        <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @else
                                        <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" name="edit_product" class="btn btn-info">Cập nhật sản phẩm</button>
                    </form>
                    </div>
                    @endforeach
                </div>
            </section>

    </div>
</div>
@endsection
