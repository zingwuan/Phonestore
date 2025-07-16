@extends('layouts.layout1')
@section('content')
<div id="contact-page" class="container">
    	<div class="bg">
	    	<div class="row">
	    		<div class="col-sm-12">
					<h2 class="title text-center">Thông tin <strong>Liên hệ</strong></h2>
					<div id="gmap" class="contact-map">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.8634677951645!2d106.69260161531179!3d20.837219099664477!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a7a9c2ee478df%3A0x6039ffe1614ede5c!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBIw6BuZyBo4bqjaSBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1679487943350!5m2!1svi!2s" width="1138" height="448" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
				</div>
			</div>
    		<div class="row">
	    		<div class="col-sm-8">
	    			<div class="contact-form">
	    				<h2 class="title text-center">Lời nhắn</h2>
	    				<div class="status alert alert-success" style="display: none"></div>
				    	<form id="main-contact-form" class="contact-form row" name="contact-form" action="#">
				            <div class="form-group col-md-6">
				                <input type="text" name="name" class="form-control" required="required" placeholder="Tên của bạn">
				            </div>
				            <div class="form-group col-md-6">
				                <input type="email" name="email" class="form-control" required="required" placeholder="Email">
				            </div>
				            <div class="form-group col-md-12">
				                <input type="text" name="subject" class="form-control" required="required" placeholder="Chủ đề">
				            </div>
				            <div class="form-group col-md-12">
				                <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Tin nhắn của bạn"></textarea>
				            </div>
				            <div class="form-group col-md-12">
				                <input type="submit" name="submit" class="btn btn-primary pull-right" value="Gửi">
				            </div>
				        </form>
	    			</div>
	    		</div>
	    		<div class="col-sm-4">
	    			<div class="contact-info">
	    				<h2 class="title text-center">Thông tin liên hệ</h2>
	    				<address>
	    					<p>Vimaru Shop</p>
							<p>Địa chỉ: 484 Lạch Tray, Kênh Dương, Lê Chân, TP Hải Phòng.</p>
							<p>Việt Nam.</p>
							<p>Điện thoại: 0909090909</p>
							<p>Fax: 0909090909</p>
							<p>Email: info@vimaru.edu.vn</p>
	    				</address>
	    				<div class="social-networks">
	    					<h2 class="title text-center">Mạng xã hội</h2>
							<ul>
								<li>
									<a href="#"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-twitter"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-google-plus"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-youtube"></i></a>
								</li>
							</ul>
	    				</div>
	    			</div>
    			</div>
	    	</div>
    	</div>
    </div><!--/#contact-page-->
@endsection
