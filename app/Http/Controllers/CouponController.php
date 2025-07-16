<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Models\Coupon;
//session_start();
class CouponController extends Controller
{
    public function add_coupon(){
        AdminController::AuthAdmin();
        return view('admin.coupon.add_coupon');
    }

    public function delete_coupon($coupon_id){
        AdminController::AuthAdmin();
        Coupon::find($coupon_id)->delete();
        Session::put('success','Bạn đã xóa mã giảm giá thành công');
        return Redirect::to('/all-coupon');
    }

    public function all_coupon(){
        AdminController::AuthAdmin();
        $coupons = Coupon::orderby('coupon_id','DESC')->paginate(20);
        return view('admin.coupon.all_coupon')->with('coupons',$coupons);
    }

    public function save_coupon(Request $request){
        AdminController::AuthAdmin();
        $data = $request->all();

        $save_data = new Coupon();
        $save_data->coupon_name = $data['coupon_name'];
        $save_data->coupon_time = $data['coupon_time'];
        $save_data->coupon_condition = $data['coupon_condition'];
        $save_data->coupon_number = $data['coupon_number'];
        $save_data->coupon_code = $data['coupon_code'];
        $save_data->save();
        Session::put('success','Bạn đã thêm mã giảm giá thành công');
        return Redirect::to('/add-coupon');
    }

    public function check_coupon(Request $request){
        $coupon = Coupon::where('coupon_code',$request->coupon_code)->first();
        if($coupon == false){
            Session::put('error','Mã giảm giá không đúng');
            return redirect()->back();
        }
        $temp_coupon = array(
            'coupon_id' => $coupon->coupon_id,
            'coupon_name' => $coupon->coupon_name,
            'coupon_code' => $coupon->coupon_code,
            'coupon_time' => $coupon->coupon_time,
            'coupon_condition' => $coupon->coupon_condition,
            'coupon_number' => $coupon->coupon_number,
        );
        if($temp_coupon['coupon_time'] <=0){
            Session::put('error','Mã giảm giá đã hết hạn');
            return redirect()->back();
        }
        Session::put('coupon',$temp_coupon);
        Session::put('success','Áp dụng mã giảm giá thành công');
        Session::save();
        return redirect()->back();
    }

    public function clear_coupon(){
        $coupon = Session::get('coupon');
        if($coupon){
            Session::forget('coupon');
            Session::put('success','Xóa mã giảm giá thành công');
            return redirect()->back();
        }
        Session::put('error','Xóa mã giảm giá thất bại');
        return redirect()->back();
    }
}
