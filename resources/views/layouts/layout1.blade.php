<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Panda Shop</title>
    <title>Panda Shop</title>
    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <script src="{{asset('public/frontend/js/main.js')}}"></script>
</head><!--/head-->

<body>
    <div id="toast"></div>
    @php
        $success = Session::get('success');
        $error = Session::get('error');
        $info = Session::get('info');
        if($success){
            echo '<script>
                    toast({
                    title: "Thành công!",
                    message: "'.$success.'",
                    type: "success",
                    duration: 5000
                    });
                </script>';
            Session::put('success',null);
        }elseif ($error) {
            echo '<script>
                    toast({
                    title: "Thất bại!",
                    message: "'.$error.'",
                    type: "error",
                    duration: 5000
                    });
                </script>';
            Session::put('error',null);
        }elseif ($info) {
            echo '<script>
                    toast({
                    title: "Thông báo!",
                    message: "'.$info.'",
                    type: "info",
                    duration: 5000
                    });
                </script>';
            Session::put('info',null);
        }
    @endphp
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> 0766 479 036</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> viet86710@st.vimaru.edu.vn</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class=" pull-left">
							<a href="{{URL::to('/')}}" class="logo-parent">
                                <img class="logo" src="{{URL::to('public/frontend/images/logovmu.png')}}" alt="" />
                                <span class="logo-title">VMU Shop</span>
                            </a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<?php
                                    $customer_id = Session::get('customer_id');
                                    if($customer_id != null){
                                ?>
                                <li><a href="{{URL::to('/show-order')}}"><i class="fa fa-file"></i> Đơn hàng</a></li>
                                <?php
                                    }else{
                                ?>
                                <li><a href="{{URL::to('/')}}"><i class="fa fa-file"></i> Đơn hàng</a></li>
                                <?php
                                    }
                                ?>
								<?php
                                    $customer_id = Session::get('customer_id');
                                    $shipping_id = Session::get('shipping_id');
                                    if($customer_id != null && $shipping_id ==null){
                                ?>
                                <li><a href="{{URL::to('/show-checkout')}}"><i class="fa fa-credit-card"></i> Thanh toán</a></li>
                                <?php
                                    }else if($customer_id != null && $shipping_id != null){
                                ?>
                                <li><a href="{{URL::to('/payment')}}"><i class="fa fa-credit-card"></i> Thanh toán</a></li>
                                <?php
                                    }else{
                                ?>
                                <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-credit-card"></i> Thanh toán</a></li>
                                <?php
                                    }
                                ?>

								<li><a href="{{URL::to('/show-cart')}}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                                <?php
                                    $customer_id = Session::get('customer_id');
                                    if($customer_id == null){
                                ?>
                                <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                                <?php
                                    }else{
                                ?>
                                <li><a href="{{URL::to('/logout-customer')}}"><i class="fa fa-user"></i> Đăng xuất</a></li>
                                <?php
                                    }
                                ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->

		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-5">
                        <div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="{{URL::to('/')}}" class="active">Trang chủ</a></li>

								<li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach ($brands as $key => $brand)
                                        <li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}}">{{$brand->brand_name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
								<li><a href="{{URL::to('/lien-he')}}">Liên hệ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-7">
                        <form action="{{URL::to('/tim-kiem')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="col-sm-3">
                                <select name="search_price" style="margin-top: 4px">
                                    <option value="0">Tất cả</option>
                                    <option value="1">Dưới 5 triệu</option>
                                    <option value="2">5-10 triệu</option>
                                    <option value="3">10-20 triệu</option>
                                    <option value="4">20-30 triệu</option>
                                    <option value="5">Trên 30 triệu </option>
                                </select>
                            </div>
                            <div class="col-sm-9">
                                <div class="search_box">
                                    <input type="text"name="search_input" class="flex-grow-1" placeholder="Nhập tên sản phẩm"/>
                                    <button type="submit" name="search_product" class="btn btn-primary" style="margin-top: 0px" >Tìm kiếm</button>
                                </div>
                            </div>
                        </form>

					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->

	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 padding-center">
					@yield('content')
				</div>
			</div>
		</div>
	</section>

	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>VMU</span>-shopper</h2>
							<p>Mang đến cho bạn những trải nghiệm tốt nhất</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="https://www.youtube.com/watch?v=9nkD9YG1Tyo&t=5s" target="_blank">
									<div class="iframe-img">
										<img src="{{URL::to('public/frontend/images/ip14.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>REVIEW IPHONE14</p>
								<h2>24 MAR 2023</h2>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="https://www.youtube.com/watch?v=q7drNCpOLyc" target="_blank">
									<div class="iframe-img">
										<img src="{{URL::to('public/frontend/images/sss23.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Review Iphone 14</p>
								<h2>4/5/2023</h2>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="https://www.youtube.com/watch?v=gf64B6Zz6AY"target="_blank">
									<div class="iframe-img">
										<img src="{{URL::to('public/frontend/images/xrnote12.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Review Xiaomi Redmi note 12</p>
								<h2>15/4/2023</h2>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="https://www.youtube.com/watch?v=S-NZVy4CM-M&t=21s"target="_blank">
									<div class="iframe-img">
										<img src="{{URL::to('public/frontend/images/oreno8.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Review Oppo Reno 8</p>
								<h2>11/2/2023</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="images/home/map.png" alt="" />
							<p>Địa chỉ: 484 Lạch Tray, Kênh Dương, Lê Chân, TP Hải Phòng.</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Dịch vụ</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="">Hỗ trợ trực tuyến</a></li>
								<li><a href="">Liên hệ</a></li>
								<li><a href="">Tình trạng đặt hàng</a></li>
								<li><a href="">Thay đổi địa điểm</a></li>
								<li><a href="">FAQ’s</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Chọn nhanh</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="">Điện thoại</a></li>
								<li><a href="">Máy tính bảng</a></li>
								<li><a href="">Phụ kiện</a></li>
								<li><a href="">Thẻ quà tặng</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Chính sách</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="">Giao hàng & Thanh toán</a></li>
								<li><a href="">Chính sách bảo hành</a></li>
								<li><a href="">Chính sách đổi trả</a></li>
								<li><a href="">Hóa đơn điện tử</a></li>
								<li><a href="">Phiếu mua hàng</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Thông tin</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="">Giới thiệu công ty</a></li>
								<li><a href="">Tuyển dụng</a></li>
								<li><a href="">Địa chỉ cửa hàng</a></li>
								<li><a href="">Chương trình liên kết</a></li>
								<li><a href="">Copyright</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>Đăng ký nhận thông báo</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Email của bạn" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Nhận những thông tin mới nhất<br />về các sản phẩm của chúng tôi</p>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Bản quyền thuộc về VMU-Shopper.</p>
				</div>
			</div>
		</div>

	</footer><!--/Footer-->



    <script src="{{asset('public/frontend/js/jquery.js')}}"></script>
	<script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
	<script src="{{asset('public/frontend/js/price-range.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>

    <script src="{{asset('public/frontend/js/sweetalert.js')}}"></script>
    {{-- <script type="text/javascript">
        $(document).ready(function(){
            $('.choose').on('change',function(){
                var action = $(this).attr('id');
                var ma_id = $(this).val();
                var _token = $('input[name="_token"]').val();

                var result = '';
                if(action == 'city'){
                    result = 'province';
                }else{
                    result = 'wards';
                }
                alert('continuew');
                $.ajax({
                    url: `{{url('/select-delivery')}}`,
                    method: 'POST',
                    data: {action:action,ma_id:ma_id,_token:_token},
                    success: function(data){
                        // $('#'+result).html(data);
                        alert('ok');
                    },
                    error: function(){
                        alert('loi');
                    }
                });
            });
        });
    </script> --}}
    <script type="text/javascript">
        $(document).ready(function(){
            $('.add-order').click(function(){
                swal({
                    title: "Bạn chắc chắn đặt hàng",
                    text: "Tôi mong thông tin bạn cung cấp là chính xác, chúng tôi sẽ gọi cho bạn sau để xác nhận đơn hàng !",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonClass: "btn-info",
                    confirmButtonText: "Xác nhận đặt hàng",
                    cancelButtonText: "Hủy",
                    closeOnConfirm: false,
                    closeOnCancel: true
                    },
                    function(isConfirm) {
                    if (isConfirm) {
                        var shipping_email = $('.shipping_email').val();
                        var shipping_name = $('.shipping_name').val();
                        var shipping_phone = $('.shipping_phone').val();
                        var shipping_address = $('.shipping_address').val();
                        var shipping_note = $('.shipping_note').val();
                        var payment_method = $('.payment_method').val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: `{{url('/order-place')}}`,
                            method: 'POST',
                            data:{shipping_email:shipping_email,shipping_name:shipping_name,
                                shipping_phone:shipping_phone,shipping_address:shipping_address,
                                shipping_note:shipping_note,payment_method:payment_method,_token:_token,
                            },
                            success:function(data){
                                swal({
                                    title: "Đặt hàng thành công",
                                    text: "Đơn hàng đang chờ xác nhận!",
                                    type: "success",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Xem đơn hàng",
                                    cancelButtonText: "Tiếp tục mua hàng",
                                    closeOnConfirm: false,
                                    closeOnCancel: false
                                },
                                function(isConfirm){
                                    if(isConfirm){
                                        window.location.href = "{{url('/show-order')}}";
                                    }else{
                                        window.location.href = "{{url('/')}}";
                                    }

                                });
                            }
                        })
                    } else {

                    }
                });

            })
        });
    </script>
    <script>
        jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
        jQuery('.quantity').each(function() {
        var spinner = jQuery(this),
            input = spinner.find('input[type="number"]'),
            btnUp = spinner.find('.quantity-up'),
            btnDown = spinner.find('.quantity-down'),
            min = input.attr('min'),
            max = input.attr('max');

        btnUp.click(function() {
            var oldValue = parseFloat(input.val());
            if (oldValue >= max) {
            var newVal = oldValue;
            } else {
            var newVal = oldValue + 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

        btnDown.click(function() {
            var oldValue = parseFloat(input.val());
            if (oldValue <= min) {
            var newVal = oldValue;
            } else {
            var newVal = oldValue - 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

        });
    </script>
</body>
</html>
