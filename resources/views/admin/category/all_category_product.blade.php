@extends('layouts.admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách danh mục sản phẩm
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
            <th>Tên danh mục</th>
            <th>Mô tả</th>
            <th>Hiện thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach ( $all_category_product as $key => $cate_pro)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{ $cate_pro->category_name }}</td>
                    <td><span class="text-ellipsis">{{$cate_pro->category_desc}}</span></td>
                    <td><span class="text-ellipsis">
                        <?php
                            if($cate_pro->category_status == 0){
                        ?>
                            <a href="{{URL::to('/active-category-product/'.$cate_pro->category_id)}}">
                            <i class="fa-thumbs-down-styling fa fa-thumbs-down"></i></a>;
                        <?php
                            }else {
                        ?>
                            <a href="{{URL::to('/unactive-category-product/'.$cate_pro->category_id)}}">
                            <i class="fa-thumbs-up-styling fa fa-thumbs-up"></i></a>;
                        <?php
                            }
                        ?>
                    </span></td>
                    <td>
                    <a href="{{URL::to('/edit-category-product/'.$cate_pro->category_id)}}" class="active styling-edit" ui-toggle-class="">
                        <i class="fa fa-pencil-square-o text-success text-active"></i>
                    </a>
                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không ?');" href="{{URL::to('/delete-category-product/'.$cate_pro->category_id)}}" class="active styling-delete" ui-toggle-class="">
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
                    Hiển thị {{($all_category_product->count()>=20)?20:$all_category_product->count()}}
                    /{{$all_category_product->count()}} danh mục sản phẩm
                </small>
            </div>
            <div class="col-sm-7 text-right text-center-xs">
                {{$all_category_product->links()}}
            </div>
        </div>
    </footer>
  </div>
</div>
@endsection
