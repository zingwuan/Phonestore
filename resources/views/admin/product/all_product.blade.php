@extends('layouts.admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách sản phẩm
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <form action="{{URL::to('/search-product')}}" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" class="input-sm form-control" name="search_product_input" placeholder="Nhập tên sản phẩm cần tìm">
                <span class="input-group-btn">
                  <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                </span>
              </div>
        </form>
      </div>
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
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Danh mục</th>
            <th>Thương hiệu</th>
            <th>Nội dung</th>
            <th>Mô tả</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach ( $all_product as $key => $pro)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{ $pro->product_name }}</td>
                    <td>{{ number_format($pro->product_price)}} VND</td>
                    <td><img src="public/upload/product/{{$pro->product_image}}" width="100" height="100"></td>
                    <td>{{ $pro->category_name }}</td>
                    <td>{{ $pro->brand_name }}</td>
                    <td class="overflow-none"><span>{{$pro->product_content}}</span></td>
                    <td class="overflow-none" ><span>{{$pro->product_desc}}</span></td>
                    <td><span class="text-ellipsis">
                        <?php
                            if($pro->product_status == 0){
                        ?>
                            <a href="{{URL::to('/active-product/'.$pro->product_id)}}">
                            <i class="fa-thumbs-down-styling fa fa-thumbs-down"></i></a>;
                        <?php
                            }else {
                        ?>
                            <a href="{{URL::to('/unactive-product/'.$pro->product_id)}}">
                            <i class="fa-thumbs-up-styling fa fa-thumbs-up"></i></a>;
                        <?php
                            }
                        ?>
                    </span></td>
                    <td>
                    <a href="{{URL::to('/edit-product/'.$pro->product_id)}}" class="active styling-edit" ui-toggle-class="">
                        <i class="fa fa-pencil-square-o text-success text-active"></i>
                    </a>
                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không ?');" href="{{URL::to('/delete-product/'.$pro->product_id)}}" class="active styling-delete" ui-toggle-class="">
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
                Hiển thị {{($all_product->count()>=20)?20:$all_product->count()}}/{{$all_product->count()}} sản phẩm
            </small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">
            {{$all_product->links()}}
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection
