@extends('layouts.admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm sản phẩm
                </header>
                <?php
                    $msg = Session::get('message');
                    if($msg){
                        echo '<span class="text-alert-success">'.$msg.'</span>';
                        Session::put('message',null);
                    }
                ?>
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">{{$errorMessage}}</div>
                @endif --}}
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên sản phẩm">
                            @error('product_name')
                                <span style="color: red">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá sản phẩm</label>
                            <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Nhập giá sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                            <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea name="product_desc" id="editor1"></textarea>
                        </div>
                        {{-- <div class="form-group">
                            <textarea name="editor1" id="ckeditor1" rows="10" cols="80">
                                This is my textarea to be replaced with CKEditor 4.
                            </textarea>
                        </div> --}}
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                            <textarea name="product_content" id="editor2"></textarea>
                            {{-- <div id="editor2">
                                <p>conent</p>
                            </div> --}}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                            <select class="form-control input-sm m-bot15" name="category_id">
                                @foreach ($cates as $key => $cate)
                                    <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Thương hiệu</label>
                            <select class="form-control input-sm m-bot15" name="brand_id">
                                @foreach ($brands as $key => $brand)
                                    <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select class="form-control input-sm m-bot15" name="product_status">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>

                        <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
</div>
@endsection
