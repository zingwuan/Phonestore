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
            <th>Tên thương hiệu</th>
            <th>Mô tả</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach ( $all_brand_product as $key => $brand_pro)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{ $brand_pro->brand_name }}</td>
                    <td><span class="text-ellipsis">{{$brand_pro->brand_desc}}</span></td>
                    <td><span class="text-ellipsis">
                        <?php
                            if($brand_pro->brand_status == 0){
                        ?>
                            <a href="{{URL::to('/active-brand-product/'.$brand_pro->brand_id)}}">
                            <i class="fa-thumbs-down-styling fa fa-thumbs-down"></i></a>;
                        <?php
                            }else {
                        ?>
                            <a href="{{URL::to('/unactive-brand-product/'.$brand_pro->brand_id)}}">
                            <i class="fa-thumbs-up-styling fa fa-thumbs-up"></i></a>;
                        <?php
                            }
                        ?>
                    </span></td>
                    <td>
                    <a href="{{URL::to('/edit-brand-product/'.$brand_pro->brand_id)}}" class="active styling-edit" ui-toggle-class="">
                        <i class="fa fa-pencil-square-o text-success text-active"></i>
                    </a>
                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này không ?');" href="{{URL::to('/delete-brand-product/'.$brand_pro->brand_id)}}" class="active styling-delete" ui-toggle-class="">
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
                    Hiển thị {{($all_brand_product->count()>=20)?20:$all_brand_product->count()}}
                    /{{$all_brand_product->count()}} thương hiệu
                </small>
            </div>
            <div class="col-sm-7 text-right text-center-xs">
                {{$all_brand_product->links()}}
            </div>
        </div>
    </footer>
  </div>
</div>
@endsection
