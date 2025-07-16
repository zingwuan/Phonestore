@extends('layouts.admin_layout')
@section('admin_content')
<!-- //market-->
<div class="market-updates">
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-2">
            <div class="col-md-2 market-update-right">
                <i class="fa fa-eye"> </i>
            </div>
            <div class="col-md-10 market-update-left">
                <h4>Truy cập</h4>
            </div>
            <h3>12,108</h3>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-1">
            <div class="col-md-2 market-update-right">
                <i class="fa fa-users" ></i>
            </div>
            <div class="col-md-10 market-update-left">
            <h4>Người dùng</h4>
            </div>
            <h3>{{number_format($count_customer)}}</h3>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-3">
            <div class="col-md-2 market-update-right">
                <i class="fa fa-usd"></i>
            </div>
            <div class="col-md-10 market-update-left">
                <h4>Doanh số</h4>
            </div>
            <h3>{{number_format($sum_sale)}}</h3>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-4">
            <div class="col-md-2 market-update-right">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </div>
            <div class="col-md-10 market-update-left">
                <h4>Đơn hàng</h4>
            </div>
            <h3>{{number_format($count_order)}}</h3>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="clearfix"> </div>
</div>
<div class="row">
    <div class="panel-body">
        <form autocomplete="off" method="POST">
            @csrf
            <div class="col-sm-2">
                <p>Từ ngày</p><input type="text" class="form-control" id="datepicker1"></p>
                <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả">
            </div>
            <div class="col-sm-2">
                <p>Đến ngày</p><input type="text" class="form-control" id="datepicker2"></p>
            </div>
        </form>
    </div>
</div>
<!-- //market-->
<div class="row">
    <div class="panel-body">
        <div class="col-md-12 w3ls-graph">
            <!--agileinfo-grap-->
                <div class="agileinfo-grap">
                    <div class="agileits-box">
                        <header class="agileits-box-header clearfix">
                            <h3>Visitor Statistics</h3>
                                <div class="toolbar">

                                </div>
                        </header>
                        <div class="agileits-box-body clearfix">
                            <div id="hero-area"></div>
                        </div>
                    </div>
                </div>
            <!--//agileinfo-grap-->
        </div>
    </div>
</div>
@endsection
