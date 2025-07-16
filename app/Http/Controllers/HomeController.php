<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Mail;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index(Request $request){
        $cates = DB::table('tbl_category_product')
        ->join('tbl_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->select('tbl_category_product.category_id','tbl_category_product.category_name', DB::raw('count(*) as product_count'))
        ->groupBy('tbl_category_product.category_id','tbl_category_product.category_name')
        ->orderby('category_name','asc')->get();
        $brands = DB::table('tbl_brand')
        ->join('tbl_product','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->select('tbl_brand.brand_id','tbl_brand.brand_name', DB::raw('count(*) as product_count'))
        ->groupBy('tbl_brand.brand_id','tbl_brand.brand_name')
        ->orderby('brand_name','asc')->get();

        $products = DB::table('tbl_product')->where('product_status','1')->orderby('product_id','desc')
        ->paginate(15);
        $product_total_quantity = array();
        foreach($products as $key => $value){
            $temp = DB::table('tbl_order_details')
            ->select(DB::raw('SUM(tbl_order_details.product_sales_quantity) AS total_quantity'))
            ->where('tbl_order_details.product_id',$value->product_id)->first();
            $product_total_quantity[] = $temp->total_quantity;
        }

        $best_products = DB::table('tbl_product')
        ->join('tbl_order_details','tbl_order_details.product_id','=','tbl_product.product_id')
        ->select('tbl_product.product_id',DB::raw('SUM(tbl_order_details.product_sales_quantity) AS total_quantity'))
        ->groupBy('tbl_product.product_id')
        ->where('tbl_product.product_status',1)->orderBy('total_quantity','DESC')->limit(6)
        ->get();
        $temp_products = array();
        foreach($best_products as $key => $value){
            $temp = DB::table('tbl_product')->where('product_id',$value->product_id)
            ->first();

            $temp_products[$key] = array();
            $temp_products[$key]['product_id'] = $temp->product_id;
            $temp_products[$key]['product_name'] = $temp->product_name;
            $temp_products[$key]['product_price'] = $temp->product_price;
            $temp_products[$key]['product_image'] = $temp->product_image;
            $temp_products[$key]['total_quantity'] = $value->total_quantity;
        }

        $slides = DB::table('tbl_slide')->where('slide_status','1')->orderby('slide_id','desc')
        ->limit(3)->get();
        $url_canonical = $request->url();
        return view('pages.home')->with('cates',$cates)->with('brands',$brands)
        ->with('products',$products)->with('slides',$slides)
        ->with('product_total_quantity',$product_total_quantity)
        ->with('best_products',$temp_products)
        ->with('url_canonical',$url_canonical);
    }

    public function search_product(Request $request){
        $cates = DB::table('tbl_category_product')
        ->join('tbl_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->select('tbl_category_product.category_id','tbl_category_product.category_name', DB::raw('count(*) as product_count'))
        ->groupBy('tbl_category_product.category_id','tbl_category_product.category_name')
        ->orderby('category_name','asc')->get();
        $brands = DB::table('tbl_brand')
        ->join('tbl_product','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->select('tbl_brand.brand_id','tbl_brand.brand_name', DB::raw('count(*) as product_count'))
        ->groupBy('tbl_brand.brand_id','tbl_brand.brand_name')
        ->orderby('brand_name','asc')->get();
        $products;
        if($request->search_price == 0){
            $products = DB::table('tbl_product')
            ->where('product_name','like','%'.$request->search_input.'%')
            ->orderby('product_id','desc')->paginate(15);
        }else if($request->search_price == 1){
            $products = DB::table('tbl_product')
            ->whereBetween('product_price',[0,5000000])
            ->where('product_name','like','%'.$request->search_input.'%')
            ->orderby('product_id','desc')->paginate(15);
        }else if($request->search_price == 2){
            $products = DB::table('tbl_product')
            ->whereBetween('product_price',[5000000,10000000])
            ->where('product_name','like','%'.$request->search_input.'%')
            ->orderby('product_id','desc')->paginate(15);
        }else if($request->search_price == 3){
            $products = DB::table('tbl_product')
            ->whereBetween('product_price',[10000000,20000000])
            ->where('product_name','like','%'.$request->search_input.'%')
            ->orderby('product_id','desc')->paginate(15);
        }else if($request->search_price == 4){
            $products = DB::table('tbl_product')
            ->whereBetween('product_price',[20000000,30000000])
            ->where('product_name','like','%'.$request->search_input.'%')
            ->orderby('product_id','desc')->paginate(15);
        }else if($request->search_price == 5){
            $products = DB::table('tbl_product')
            ->where('product_price','>',30000000)
            ->where('product_name','like','%'.$request->search_input.'%')
            ->orderby('product_id','desc')->paginate(15);
        }
        $product_total_quantity = array();
        foreach($products as $key => $value){
            $temp = DB::table('tbl_order_details')
            ->select(DB::raw('SUM(tbl_order_details.product_sales_quantity) AS total_quantity'))
            ->where('tbl_order_details.product_id',$value->product_id)->first();
            $product_total_quantity[] = $temp->total_quantity;
        }

        $slides = DB::table('tbl_slide')->where('slide_status','1')->orderby('slide_id','desc')
        ->limit(3)->get();
        return view('pages.product.search')->with('cates',$cates)->with('brands',$brands)
        ->with('products',$products)->with('product_total_quantity',$product_total_quantity)->with('slides',$slides);
    }

    // public function send_mail(){
    //     $to_name = 'Viet Nguyen';
    //     $to_mail = 'nvvietunity3d@gmail.com';

    //     $data = array('name'=>'Mail từ tài khoản khách hàng','body'=>'đây là nội dung nè');
    //     Mail::send('pages.send_mail', $data, function ($message) use ($to_mail,$to_name) {
    //         $message->to($to_mail);
    //         $message->from($to_mail, $to_name);
    //         $message->subject('Test gửi mail');
    //     });

    //     // return Redirect::to('/')->with('message','');
    // }

    public function contact(){
        $cates = DB::table('tbl_category_product')->orderby('category_name','desc')->get();
        $brands = DB::table('tbl_brand')->orderby('brand_name','desc')->get();
        return view('pages.contact.contact')->with('cates',$cates)->with('brands',$brands);;
    }
}
