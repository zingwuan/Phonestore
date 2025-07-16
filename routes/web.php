<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('layout');
// });
// Route::get('/trang-chu', function () {
//     return view('layout');
// });

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SlideController;

//frontend
Route::get('/',[HomeController::class, 'index']);
Route::get('/trang-chu',[HomeController::class, 'index']);
Route::post('/tim-kiem',[HomeController::class, 'search_product']);
Route::get('/lien-he',[HomeController::class, 'contact']);
//
Route::get('/danh-muc-san-pham/{category_product_id}',[CategoryProduct::class, 'show_category_home']);
Route::get('/thuong-hieu-san-pham/{brand_product_id}',[BrandProduct::class, 'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_id}',[ProductController::class, 'show_details_product']);

//cart
Route::post('/save-cart',[CartController::class, 'save_cart']);
Route::post('/update-cart-quantity',[CartController::class, 'update_cart_quantity']);
Route::get('/show-cart',[CartController::class, 'show_cart']);
Route::get('/delete-cart/{row_id}',[CartController::class, 'delete_cart']);
Route::post('/add-cart-ajax',[CartController::class, 'add_cart_ajax']);
Route::get('/clear-cart',[CartController::class, 'clear_cart']);



//checkout
Route::post('/login-customer',[CheckoutController::class, 'login_customer']);
Route::get('/logout-customer',[CheckoutController::class, 'logout_customer']);
Route::get('/login-checkout',[CheckoutController::class, 'login_checkout']);
Route::post('/add-customer',[CheckoutController::class, 'add_customer']);
Route::get('/show-checkout',[CheckoutController::class, 'show_checkout']);
Route::post('/save-checkout-customer',[CheckoutController::class, 'save_checkout_customer']);
Route::get('/payment',[CheckoutController::class, 'payment']);
Route::post('/select-delivery',[CheckoutController::class, 'select_delivery']);
Route::post('/order-place',[CheckoutController::class, 'order_place']);
Route::get('/show-order',[CheckoutController::class, 'show_order']);


//mail
Route::get('/send-mail',[HomeController::class, 'send_mail']);

//////////////////////////////////backend////////////////////////
Route::get('/admin',[AdminController::class, 'index']);
Route::get('/dashboard',[AdminController::class, 'show_dashboard']);
Route::get('/logout',[AdminController::class, 'logout']);
Route::post('/admin-dashboard',[AdminController::class, 'dashboard']);

//category product
Route::get('/add-category-product',[CategoryProduct::class, 'add_category_product']);
Route::get('/edit-category-product/{category_product_id}',[CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}',[CategoryProduct::class, 'delete_category_product']);
Route::get('/all-category-product',[CategoryProduct::class, 'all_category_product']);
Route::get('/active-category-product/{category_product_id}',[CategoryProduct::class, 'active_category_product']);
Route::get('/unactive-category-product/{category_product_id}',[CategoryProduct::class, 'unactive_category_product']);

Route::post('/update-category-product/{category_product_id}',[CategoryProduct::class, 'update_category_product']);
Route::post('/save-category-product',[CategoryProduct::class, 'save_category_product']);

//brand
Route::get('/add-brand-product',[BrandProduct::class, 'add_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}',[BrandProduct::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}',[BrandProduct::class, 'delete_brand_product']);
Route::get('/all-brand-product',[BrandProduct::class, 'all_brand_product']);
Route::get('/active-brand-product/{brand_product_id}',[BrandProduct::class, 'active_brand_product']);
Route::get('/unactive-brand-product/{brand_product_id}',[BrandProduct::class, 'unactive_brand_product']);

Route::post('/update-brand-product/{brand_product_id}',[BrandProduct::class, 'update_brand_product']);
Route::post('/save-brand-product',[BrandProduct::class, 'save_brand_product']);

//product
Route::get('/add-product',[ProductController::class, 'add_product']);
Route::get('/edit-product/{product_id}',[ProductController::class, 'edit_product']);
Route::get('/delete-product/{product_id}',[ProductController::class, 'delete_product']);
Route::get('/all-product',[ProductController::class, 'all_product']);
Route::get('/active-product/{product_id}',[ProductController::class, 'active_product']);
Route::get('/unactive-product/{product_id}',[ProductController::class, 'unactive_product']);

Route::post('/update-product/d{product_id}',[ProuctController::class, 'update_product']);
Route::post('/save-product',[ProductController::class, 'save_product']);
Route::post('/search-product',[ProductController::class, 'search_product']);

//order
Route::get('/all-order',[CheckoutController::class, 'all_order']);
Route::get('/edit-order/{order_id}',[CheckoutController::class, 'edit_order']);
Route::get('/delete-order/{order_id}',[CheckoutController::class, 'delete_order']);
Route::get('/confirm-order/{order_id}',[CheckoutController::class, 'confirm_order']);
Route::get('/cancel-order/{order_id}',[CheckoutController::class, 'cancel_order']);
Route::get('/confirm-delivery-order/{order_id}',[CheckoutController::class, 'confirm_delivery_order']);
Route::get('/confirm-finish-order/{order_id}',[CheckoutController::class, 'confirm_finish_order']);


//coupon
Route::get('/add-coupon',[CouponController::class, 'add_coupon']);
Route::get('/delete-coupon/{coupon_id}',[CouponController::class, 'delete_coupon']);
Route::get('/all-coupon',[CouponController::class, 'all_coupon']);
Route::post('/save-coupon',[CouponController::class, 'save_coupon']);
Route::post('/check-coupon',[CouponController::class, 'check_coupon']);
Route::get('/clear-coupon',[CouponController::class, 'clear_coupon']);

//slide
Route::get('/add-slide',[SlideController::class, 'add_slide']);
Route::get('/delete-slide/{slide_id}',[SlideController::class, 'delete_slide']);
Route::get('/all-slide',[SlideController::class, 'all_slide']);
Route::get('/active-slide/{slide_id}',[SlideController::class, 'active_slide']);
Route::get('/unactive-slide/{slide_id}',[SlideController::class, 'unactive_slide']);
Route::post('/save-slide',[SlideController::class, 'save_slide']);

//dashboard
Route::post('/filter-by-date',[AdminController::class, 'filter_by_date']);



