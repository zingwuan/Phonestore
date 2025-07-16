<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function add_product(){
        AdminController::AuthAdmin();
        $cates = DB::table('tbl_category_product')->orderby('category_name','desc')->get();
        $brands = DB::table('tbl_brand')->orderby('brand_name','desc')->get();
        return view('admin.product.add_product')->with('cates',$cates)->with('brands',$brands);
    }

    public function edit_product($product_id){
        AdminController::AuthAdmin();
        $edit_product =  DB::table('tbl_product')->where('product_id',$product_id)
        ->get();
        $cates = DB::table('tbl_category_product')->orderby('category_name','desc')->get();
        $brands = DB::table('tbl_brand')->orderby('brand_name','desc')->get();
        $manager_product = view('admin.product.edit_product')->with('edit_product',$edit_product)
        ->with('cates',$cates)->with('brands',$brands);
        //return view('admin_layout')->with('admin.all_product',$manager_product);
        return $manager_product;
    }

    public function all_product(){
        AdminController::AuthAdmin();
        $all_product =  DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->orderby('tbl_product.product_id','desc')->paginate(20);
        $manager_product = view('admin.product.all_product')
        ->with('all_product',$all_product);
        //return view('admin_layout')->with('admin.all_product',$manager_product);
        return $manager_product;
    }

    public function active_product($product_id){
        AdminController::AuthAdmin();
        DB::table('tbl_product')->where('product_id',$product_id)
        ->update(['product_status'=>1]);
        Session::put('success','Bạn đã hiển thị thành công sản phẩm');
        return Redirect::to('/all-product');
    }

    public function unactive_product($product_id){
        AdminController::AuthAdmin();
        DB::table('tbl_product')->where('product_id',$product_id)
        ->update(['product_status'=>0]);
        Session::put('success','Bạn đã ẩn thành công sản phẩm');
        return Redirect::to('/all-product');
    }

    public function save_product(Request $request){
        AdminController::AuthAdmin();
        $request->validate([
            'product_name' => 'required|min:3|max:255',
            'product_price' => 'required|integer',
        ],[
            'product_name.required' => 'Tên sản phẩm không được để trống, độ dài 3-255 kí tự',
            'product_name.min' => 'Tên sản phẩm không được để trống, độ dài 3-255 kí tự',
            'product_name.max' => 'Tên sản phẩm không được để trống, độ dài 3-255 kí tự',
            'product_price.required' => 'Giá sản phẩm không được để trống, chỉ nhập số',
            'product_price.integer' => 'Giá sản phẩm không được để trống, chỉ nhập số',

        ]);
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_content'] = $request->product_content;
        $data['product_desc'] = $request->product_desc;
        $data['product_status'] = $request->product_status;
        $data['brand_id'] = $request->brand_id;
        $data['category_id'] = $request->category_id;

        $get_img = $request->file('product_image');
        if($get_img){
            $new_img_name = $get_img->getClientOriginalName();
            $new_name = current(explode('.',$new_img_name));
            $new_img = $new_name.rand(0,99).'.'.$get_img->getClientOriginalExtension();
            $get_img->move('public/upload/product',$new_img);
            $data['product_image'] = $new_img;
            DB::table('tbl_product')->insert($data);
            Session::put('success','Bạn đã thêm sản phẩm thành công');
            return Redirect::to('/add-product');
        }
        $data['product_image'] = "";
        DB::table('tbl_product')->insert($data);
        Session::put('success','Bạn đã thêm sản phẩm thành công');
        return Redirect::to('/add-product');
    }

    public function update_product(Request $request, $product_id){
        AdminController::AuthAdmin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_content'] = $request->product_content;
        $data['product_desc'] = $request->product_desc;
        $data['brand_id'] = $request->brand_id;
        $data['category_id'] = $request->category_id;

        $get_img = $request->file('product_image');
        if($get_img){
            $new_img_name = $get_img->getClientOriginalName();
            $new_name = current(explode('.',$new_img_name));
            $new_img = $new_name.rand(0,99).'.'.$get_img->getClientOriginalExtension();
            $get_img->move('public/upload/product',$new_img);
            $data['product_image'] = $new_img;
            DB::table('tbl_product')->where('product_id',$product_id)->update($data);
            Session::put('success','Bạn đã cập nhật sản phẩm thành công');
            return Redirect::to('/all-product');
        }
        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('success','Bạn đã cập nhật sản phẩm thành công');
        return Redirect::to('/all-product');
    }

    public function delete_product($product_id){
        AdminController::AuthAdmin();
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('success','Bạn đã xóa sản phẩm thành công');
        return Redirect::to('/all-product');
    }

    public function search_product(Request $request){
        AdminController::AuthAdmin();
        $all_product =  DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_name','like','%'.$request->search_product_input.'%')
        ->orderby('tbl_product.product_id','desc')->paginate(20);
        $manager_product = view('admin.product.all_product')
        ->with('all_product',$all_product);
        return $manager_product;
    }

    //front end
    public function show_details_product($product_id,Request $request){
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
        $slides = DB::table('tbl_slide')->where('slide_status','1')->orderby('slide_id','desc')
        ->limit(3)->get();
        $detail_product =  DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id',$product_id)->get();

        $category_id = '';
        foreach($detail_product as $key => $detail){
            $category_id = $detail->category_id;
        }
        $related_products =  DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.category_id',$category_id)
        ->whereNotIn('tbl_product.product_id',[$product_id])->get();

        return view('pages.product.show_details_product')->with('cates',$cates)
        ->with('brands',$brands)->with('detail_product',$detail_product)->with('slides',$slides)
        ->with('related_pros',$related_products)
        ->with('url_canonical',$request->url());
    }
}
