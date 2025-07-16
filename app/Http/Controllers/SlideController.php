<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class SlideController extends Controller
{
    public function add_slide(){
        AdminController::AuthAdmin();
        return view('admin.slide.add_slide');
    }

    public function delete_slide($slide_id){
        AdminController::AuthAdmin();
        $slide = Slide::find($slide_id);
        $slide->delete();
        Session::put('success','Bạn đã xóa slide thành công');
        return Redirect::to('/all-slide');
    }

    public function active_slide($slide_id){
        AdminController::AuthAdmin();
        $slide = Slide::find($slide_id);
        $slide->slide_status = 1;
        $slide->save();
        Session::put('success','Bạn đã hiển thị thành công slide');
        return Redirect::to('/all-slide');
    }

    public function unactive_slide($slide_id){
        AdminController::AuthAdmin();
        $slide = Slide::find($slide_id);
        $slide->slide_status = 0;
        $slide->save();
        Session::put('success','Bạn đã ẩn thành công slide');
        return Redirect::to('/all-slide');
    }

    public function all_slide(){
        AdminController::AuthAdmin();
        $slides = Slide::orderby('slide_id','DESC')->paginate(20);
        return view('admin.slide.all_slide')->with('slides',$slides);
    }

    public function save_slide(Request $request){
        AdminController::AuthAdmin();
        $slide = new Slide();
        $slide->slide_name = $request->slide_name;
        $slide->slide_desc = $request->slide_desc;
        $slide->slide_status = $request->slide_status;

        $get_img = $request->file('slide_image');
        if($get_img){
            $new_img_name = $get_img->getClientOriginalName();
            $new_name = current(explode('.',$new_img_name));
            $new_img = $new_name.rand(0,99).'.'.$get_img->getClientOriginalExtension();
            $get_img->move('public/upload/slide',$new_img);
            $slide->slide_image = $new_img;
            $slide->save();
            Session::put('success','Bạn đã thêm slide thành công');
            return Redirect::to('/add-slide');
        }
        $slide->slide_image = "";
        $slide->save();
        Session::put('success','Bạn đã thêm slide thành công');
        return Redirect::to('/add-slide');
    }

}
