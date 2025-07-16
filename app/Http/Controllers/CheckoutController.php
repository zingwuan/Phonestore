<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetail;
session_start();

class CheckoutController extends Controller
{
    public function login_checkout(){
        $cates = DB::table('tbl_category_product')->orderby('category_name','desc')->get();
        $brands = DB::table('tbl_brand')->orderby('brand_name','desc')->get();
        return view('pages.checkout.login_checkout')->with('cates',$cates)->with('brands',$brands);
    }

    public function login_customer(Request $request)
    {
        $email =  $request->email_account;
        $password =  md5($request->password_account);
        $result = DB::table('tbl_customer')->where('customer_email',$email)
        ->where('customer_password',$password)->first();
        if($result){
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/show-checkout');
        }else{
            return Redirect::to('/login-checkout');
        }
    }

    public function logout_customer(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }

    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;
        $customer_id = DB::table('tbl_customer')->insertGetId($data);
        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return Redirect::to('/show-checkout');
    }

    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_note'] = $request->shipping_note;
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id',$shipping_id);

        $data_payment = array();
        $data_payment['payment_method'] = $request->payment_option;
        $data_payment['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data_payment);

        $total = 0;
        foreach($_SESSION['cart'] as $key => $value){
            $total += $value['total'];
        }
        //Apply coupon
        $coupon = Session::get('coupon');
        if($coupon){
            if($coupon['coupon_condition'] == 0){
                $total = $total - $total * ($coupon['coupon_number']/100);
            }elseif($coupon['coupon_condition'] == 1){
                $total = $total - ($coupon['coupon_number']);
            }
        }
        $data_order = array();
        $data_order['customer_id'] = Session::get('customer_id');
        $data_order['shipping_id'] = Session::get('shipping_id');
        $data_order['payment_id'] = $payment_id;
        $data_order['order_total'] = $total;
        $data_order['order_status'] = 'Đang chờ xử lý';
        $order_id = DB::table('tbl_order')->insertGetId($data_order);

        foreach($_SESSION['cart'] as $key => $value){
            $data_order_details = array();
            $data_order_details['order_id'] = $order_id;
            $data_order_details['product_id'] = $value['id'];
            $data_order_details['product_name'] = $value['name'];
            $data_order_details['product_price'] = $value['price'];
            $data_order_details['product_sales_quantity'] = $value['quantity'];
            $order_id = DB::table('tbl_order_details')->insertGetId($data_order_details);
        }
        // clear cart
        if($_SESSION['cart'] == true){
            foreach($_SESSION['cart'] as $key => $value){
                unset($_SESSION['cart'][$key]);
            }
            Session::put('success','Bạn đã xóa giỏ hàng thành công');
        }
        return Redirect::to('/payment');
    }

    public function order_place(Request $request){
        $customer_id = Session::get('customer_id');
        $cart = $_SESSION['cart'];

        if($customer_id == true && $cart == true){
            //add shipping
            $data = $request->all();
            $tempShipping = new Shipping();
            $tempShipping->shipping_name = $data['shipping_name'];
            $tempShipping->shipping_email = $data['shipping_email'];
            $tempShipping->shipping_phone = $data['shipping_phone'];
            $tempShipping->shipping_address = $data['shipping_address'];
            $tempShipping->shipping_note = $data['shipping_note'];
            $tempShipping->save();

            //caculate total
            $total = 0;
            foreach($cart as $key => $value){
                $total += $value['total'];
            }
            //Apply coupon
            $coupon = Session::get('coupon');
            if($coupon){
                if($coupon['coupon_condition'] == 0){
                    $total = $total - $total * ($coupon['coupon_number']/100);
                }elseif($coupon['coupon_condition'] == 1){
                    $total = $total - ($coupon['coupon_number']);
                }
            }

            $tempOrder = new Order();
            $tempOrder->customer_id = $customer_id;
            $tempOrder->shipping_id = $tempShipping->shipping_id;
            $tempOrder->payment_method = $data['payment_method'];
            $tempOrder->order_total = $total;
            $tempOrder->order_status = 0;
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $tempOrder->created_at = now();
            $tempOrder->save();
            Session::put('order_id',$tempOrder->order_id);

            foreach($cart as $key => $value){
                $order_details = new OrderDetail();
                $order_details->order_id = $tempOrder->order_id;
                $order_details->product_id = $value['id'];
                $order_details->product_name = $value['name'];
                $order_details->product_price = $value['price'];
                $order_details->product_sales_quantity = $value['quantity'];
                $order_details->save();
            }

            // clear cart
            if($_SESSION['cart'] == true){
                foreach($_SESSION['cart'] as $key => $value){
                    unset($_SESSION['cart'][$key]);
                }
            }
        }else{
            echo 'Lỗi đặt hàng :))))';
        }
    }

    public function payment(){
        $cates = DB::table('tbl_category_product')->orderby('category_name','desc')->get();
        $brands = DB::table('tbl_brand')->orderby('brand_name','desc')->get();
        return view('pages.checkout.payment')->with('cates',$cates)->with('brands',$brands);
    }

    public function show_checkout(){
        $brands = DB::table('tbl_brand')->orderby('brand_name','desc')->get();
        if($_SESSION['cart'] == false){
            Session::put('error','Giỏ hàng trống không thể thanh toán');
            return Redirect::to('/');
        }
        $cities = City::orderby('matp','ASC')->get();
        return view('pages.checkout.show_checkout')->with('cities',$cities)
        ->with('brands',$brands);
    }

    public function show_order(){
        $cates = DB::table('tbl_category_product')->orderby('category_name','desc')->get();
        $brands = DB::table('tbl_brand')->orderby('brand_name','desc')->get();
        $customer_id = Session::get('customer_id');
        if($customer_id){
            $temp_order = Order::where('customer_id',$customer_id)
            ->orderBy('order_id','DESC')->first();
            $order =  DB::table('tbl_order')
            ->join('tbl_customer','tbl_customer.customer_id','=','tbl_order.customer_id')
            ->join('tbl_shipping','tbl_shipping.shipping_id','=','tbl_order.shipping_id')
            ->join('tbl_order_details','tbl_order_details.order_id','=','tbl_order.order_id')
            ->where('tbl_order.order_id',$temp_order->order_id)->get();
            return view('pages.order.show_order')->with('order',$order)
            ->with('cates',$cates)->with('brands',$brands);
        }
        return Redirect::to('/');
    }

    // backend

    public function all_order(){
        AdminController::AuthAdmin();
        $all_order =  DB::table('tbl_order')
        ->join('tbl_customer','tbl_customer.customer_id','=','tbl_order.customer_id')
        ->select('tbl_order.*','tbl_customer.customer_name')->orderby('order_id','desc')
        ->paginate(20);
        $manager_order = view('admin.order.all_order')->with('all_order',$all_order);
        // return view('admin_layout')->with('admin.all_category_product',$manager_category_product);
        return $manager_order;
    }

    public function edit_order($order_id){

        AdminController::AuthAdmin();
        $order =  DB::table('tbl_order')
        ->join('tbl_customer','tbl_customer.customer_id','=','tbl_order.customer_id')
        ->join('tbl_shipping','tbl_shipping.shipping_id','=','tbl_order.shipping_id')
        ->join('tbl_order_details','tbl_order_details.order_id','=','tbl_order.order_id')
        ->where('tbl_order.order_id',$order_id)->get();
        $manager_order = view('admin.order.edit_order')->with('order',$order);
        // return view('admin_layout')->with('admin.all_category_product',$manager_category_product);
        return $manager_order;
        // echo '<pre>';
        // print_r($order);
        // echo '</pre>';
    }


    public function delete_order($order_id){
        AdminController::AuthAdmin();
        $order = Order::find($order_id);
        $order->delete();
        Session::put('success','Xóa đơn hàng thành công');
        return redirect()->back();
    }

    public function confirm_order($order_id){
        AdminController::AuthAdmin();
        $order = Order::find($order_id);
        $order->order_status = 1;
        $order->save();
        Session::put('success','Xác nhận đơn hàng thành công');
        return redirect()->back();
    }
    public function cancel_order($order_id){
        AdminController::AuthAdmin();
        $order = Order::find($order_id);
        $order->order_status = -1;
        $order->save();
        Session::put('success','Đơn hàng đã được hủy');
        return redirect()->back();
    }
    public function confirm_delivery_order($order_id){
        AdminController::AuthAdmin();
        $order = Order::find($order_id);
        $order->order_status = 2;
        $order->save();
        Session::put('success','Đơn hàng đã được xác nhận');
        return redirect()->back();
    }
    public function confirm_finish_order($order_id){
        AdminController::AuthAdmin();
        $order = Order::find($order_id);
        $order->order_status = 3;
        $order->save();
        Session::put('success','Bạn đã hoàn thành đơn hàng');
        return redirect()->back();
    }

    public function select_delivery(Request $request){
        $data = $request->all();
        $output = '';
        if($data['action'] == 'city'){
            $provinces = Province::where('maqh',$data['ma_id'])->orderby('maqh','ACS')->get();
            $output.= '<option value="">--Chọn quận/huyện--</option>';
            foreach($provinces as $key => $value){
                $output.= '<option value="'.$value->maqh.'">'.$value->name_province.'</option>';
            }
        }else{
            $wards = Wards::where('xaid',$data['ma_id'])->orderby('xaid','ACS')->get();
            $output.= '<option value="">--Chọn xã/phường--</option>';
            foreach($wards as $key => $value){
                $output.= '<option value="'.$value->xaid.'">'.$value->name_wards.'</option>';
            }
        }
        echo $output;
    }
}
