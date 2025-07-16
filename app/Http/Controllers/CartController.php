<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class CartController extends Controller
{
    public function save_cart(Request $request){
        $quantity = $request->quantity;
        $product_id = $request->product_id_hidden;
        $products = DB::table('tbl_product')->where('product_id',$product_id)->get();

        if(isset($_SESSION['cart'])){

        }else{
            $_SESSION['cart'] = array();
        }

        //check exist product
        foreach($_SESSION['cart'] as $key => $value){
            if($value['id'] == $product_id){
                $_SESSION['cart'][$key]['quantity'] += $quantity;
                $_SESSION['cart'][$key]['total'] += $quantity * $_SESSION['cart'][$key]['price'];
                return Redirect::to('/show-cart');
            }
        }

        foreach($products as $key => $product_info){
            $row_id = substr(md5(microtime()),rand(0,26),5);
            $_SESSION['cart'][$row_id] =
            array('id' => $product_id,
            'name' => $product_info->product_name,
            'quantity' => $quantity,
            'price' => $product_info->product_price,
            'total' => $product_info->product_price * $quantity,
            'image' => $product_info->product_image);
            break;
        }
        Session::put('success','Bạn đã thêm thành công sản phẩm');
        return Redirect::to('/show-cart');
    }

    public function update_cart_quantity(Request $request){
        // $quantity = $request->quantity;
        // $row_id = $request->row_id;
        // $_SESSION['cart'][$row_id]['quantity'] = $quantity;
        // $_SESSION['cart'][$row_id]['total'] = $quantity * $_SESSION['cart'][$row_id]['price'];
        $data = $request->all();
        $cart = $_SESSION['cart'];
        if($cart){
            foreach($data['quantity'] as $key => $value){
                foreach($cart as $row_id => $val){
                    if($row_id == $key){
                        $_SESSION['cart'][$row_id]['quantity'] = $value;
                        $_SESSION['cart'][$row_id]['total'] = $value * $_SESSION['cart'][$row_id]['price'];
                    }
                }
            }
            Session::put('success','Cập nhật giỏ hàng thành công');
            return redirect()->back()->with('success','Cập nhật giỏ hàng thành công');
        }else{
            Session::put('error','Cập nhật giỏ hàng thất bại');
            return redirect()->back()->with('error','Cập nhật giỏ hàng thất bại');
        }
    }

    public function delete_cart($row_id){
        unset($_SESSION['cart'][$row_id]);
        return Redirect::to('/show-cart');
    }

    public function show_cart(Request $request){
        $cates = DB::table('tbl_category_product')->orderby('category_name','asc')->get();
        $brands = DB::table('tbl_brand')->orderby('brand_name','asc')->get();
        $request->url();
        return view('pages.cart.show_cart')->with('cates',$cates)->with('brands',$brands);
    }

    public function add_cart_ajax(Request $request){
        $data = $request->all();
        if(isset($_SESSION['cart'])){

        }else{
            $_SESSION['cart'] = array();
        }
        //check exist product
        foreach($_SESSION['cart'] as $key => $value){
            if($value['id'] == $data['cart_product_id']){
                $_SESSION['cart'][$key]['quantity'] += $data['cart_product_qty'];
                $_SESSION['cart'][$key]['total'] += $data['cart_product_qty'] * $_SESSION['cart'][$key]['price'];
                return;
            }
        }
        $row_id = substr(md5(microtime()),rand(0,26),5);
        $_SESSION['cart'][$row_id] =
        array('id' => $data['cart_product_id'],
        'name' => $data['cart_product_name'],
        'quantity' => $data['cart_product_qty'],
        'price' => $data['cart_product_price'],
        'total' => $data['cart_product_price'] * $data['cart_product_qty'],
        'image' => $data['cart_product_image']);
    }

    public function clear_cart(){
        if($_SESSION['cart'] == true){
            foreach($_SESSION['cart'] as $key => $value){
                unset($_SESSION['cart'][$key]);
            }
        }
        Session::put('success','Bạn đã xóa giỏ hàng');
        return Redirect::to('/show-cart');
    }

}
