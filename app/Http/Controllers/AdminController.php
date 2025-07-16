<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB as FacadesDB;
use App\Rules\Captcha;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Statistical;
//session_start();
class AdminController extends Controller
{
    public static function AuthAdmin(){
        if(Session::get('admin_id')){
            return;
        }else{
            return Redirect::to('/admin')->send();
        }
    }

    public function index(){
        return view('layouts.admin_login');
    }

    public function show_dashboard(){
        AdminController::AuthAdmin();
        $orders = DB::table('tbl_order')->where('order_status',3)->get();
        $customers = DB::table('tbl_customer')->get();

        $sales = 0;
        foreach($orders as $key => $value){
            $sales += $value->order_total;
        }
        return view('admin.dashboard.dashboard')->with('count_order',$orders->count())
        ->with('count_customer',$customers->count())->with('sum_sale',$sales);
    }

    public function dashboard(Request $request){
        AdminController::AuthAdmin();

        $data = $request->validate([
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|max:30',
            'g-recaptcha-response' => new Captcha(),
        ],[
            'admin_email.required' => 'Tên tài khoản không để trống và là email',
            'admin_email.email' => 'Tên tài khoản không để trống và là email',
            'admin_email.max' => 'Tên tài khoản không để trống và là email',
            'admin_password.required' => 'Mật khẩu không để trống và có chữ cái và số, tối đa 30 kí tự',
            'admin_password.max' => 'Mật khẩu không để trống và có chữ cái và số, tối đa 30 kí tự',
        ]);

        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);
        $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($result){
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            Session::put('success','Bạn đã đăng nhập thành công');
            return Redirect::to('/dashboard');
        }else{
            Session::put('message',"Tài khoản hoặc mật khẩu sai, vui lòng đăng nhập lại");
            return Redirect::to('/admin');
        }
    }

    public function filter_by_date(Request $request){
        $data = $request->all();
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        // $statiticals = Statistical::whereBetween('order_date',[$from_date, $to_date])
        // ->orderBy('order_date','ASC')->get();
        $statiticals = DB::table('tbl_statistical')
        ->whereDate('order_date','<=',$to_date)
        ->whereDate('order_date','>=',$from_date)
        ->orderBy('order_date','ASC')
        ->get();
        // $statiticals = Statistical::get();
        $chart_data = array();
        foreach($statiticals as $key => $value){
            $chart_data[] = array(
                'period' => $value->order_date,
                'sales' => $value->sales,
                'profit' => $value->profit,
                'quantity' => $value->quantity,
                'total' => $value->total_order
            );
        }
        //return $statiticals[0];
        Session::put('success','Số liệu đã được thống kê trên biểu đồ');
        return json_encode($chart_data);
    }

    public function logout(){
        AdminController::AuthAdmin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }
}
