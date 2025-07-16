@extends('layouts.admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách slide
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
            <th>Tên slide</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach ( $slides as $key => $slide)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{ $slide->slide_name }}</td>
                    <td><img src="public/upload/slide/{{$slide->slide_image}}" width="320" height="80"></td>
                    <td><span class="text-ellipsis">{{$slide->slide_desc}}</span></td>
                    <td><span class="text-ellipsis">
                        <?php
                            if($slide->slide_status == 0){
                        ?>
                            <a href="{{URL::to('/active-slide/'.$slide->slide_id)}}">
                            <i class="fa-thumbs-down-styling fa fa-thumbs-down"></i></a>;
                        <?php
                            }else {
                        ?>
                            <a href="{{URL::to('/unactive-slide/'.$slide->slide_id)}}">
                            <i class="fa-thumbs-up-styling fa fa-thumbs-up"></i></a>;
                        <?php
                            }
                        ?>
                    </span></td>
                    <td>
                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa slide này không ?');" href="{{URL::to('/delete-slide/'.$slide->slide_id)}}" class="active styling-delete" ui-toggle-class="">
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
                    Hiển thị {{($slides->count()>=20)?20:$slides->count()}}
                    /{{$slides->count()}} Slide
                </small>
            </div>
            <div class="col-sm-7 text-right text-center-xs">
                {{$slides->links()}}
            </div>
        </div>
    </footer>
  </div>
</div>
@endsection
