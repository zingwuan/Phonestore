<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class CategoryProduct extends Controller
{
    public function add_category_product(){
        AdminController::AuthAdmin();
        return view('admin.category.add_category_product');
    }

    public function edit_category_product($category_product_id){
        AdminController::AuthAdmin();
        $edit_category_product =  DB::table('tbl_category_product')->where('category_id',$category_product_id)
        ->get();
        $manager_category_product = view('admin.category.edit_category_product')
        ->with('edit_category_product',$edit_category_product);
        //return view('admin_layout')->with('admin.all_category_product',$manager_category_product);
        return $manager_category_product;
    }

    public function all_category_product(){
        AdminController::AuthAdmin();
        $all_category_product =  DB::table('tbl_category_product')->paginate(20);
        $manager_category_product = view('admin.category.all_category_product')
        ->with('all_category_product',$all_category_product);
        //return view('admin_layout')->with('admin.all_category_product',$manager_category_product);
        return $manager_category_product;
    }

    public function active_category_product($category_product_id){
        AdminController::AuthAdmin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)
        ->update(['category_status'=>1]);
        Session::put('success','Bạn đã hiển thị thành công sản phẩm');
        return Redirect::to('/all-category-product');
    }

    public function unactive_category_product($category_product_id){
        AdminController::AuthAdmin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)
        ->update(['category_status'=>0]);
        Session::put('success','Bạn đã ẩn thành công sản phẩm');
        return Redirect::to('/all-category-product');
    }

    public function save_category_product(Request $request){
        AdminController::AuthAdmin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        $data['category_status'] = $request->category_product_status;
        DB::table('tbl_category_product')->insert($data);
        Session::put('success','Bạn đã thêm danh mục thành công');
        return Redirect::to('/add-category-product');
    }

    public function update_category_product(Request $request, $category_product_id){
        AdminController::AuthAdmin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('success','Bạn đã cập nhật danh mục thành công');
        return Redirect::to('/all-category-product');
    }

    public function delete_category_product($category_product_id){
        AdminController::AuthAdmin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
        Session::put('success','Bạn đã xóa danh mục thành công');
        return Redirect::to('/all-category-product');
    }

    // front end

    public function show_category_home($category_product_id,Request $request){
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
        $products = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')
        ->where('tbl_product.category_id',$category_product_id)->orderby('product_id','desc')->get();
        $product_total_quantity = array();
        foreach($products as $key => $value){
            $temp = DB::table('tbl_order_details')
            ->select(DB::raw('SUM(tbl_order_details.product_sales_quantity) AS total_quantity'))
            ->where('tbl_order_details.product_id',$value->product_id)->first();
            $product_total_quantity[] = $temp->total_quantity;
        }
        $slides = DB::table('tbl_slide')->where('slide_status','1')->orderby('slide_id','desc')
        ->limit(3)->get();

        $category_name ='';
        foreach($cates as $key => $cate){
            if($cate->category_id == $category_product_id){
                $category_name = $cate->category_name;
                break;
            }
        }
        $url_canonical = $request->url();
        return view('pages.category.show_category_home')->with('cates',$cates)->with('brands',$brands)
        ->with('products',$products)
        ->with('product_total_quantity',$product_total_quantity)
        ->with('category_name',$category_name)->with('slides',$slides)
        ->with('url_canonical',$url_canonical);
    }
}
