@extends('layouts.customer')
@section('content')
<div class="body-wrap">
    <div class="topHeight"></div>
    <div class="container margin-auto news-body">
        <div class="row center-text">
            <h2 style="margin: -1.5%;"><span style="font-size: 24px; text-transform:uppercase; color:#e50303;"><strong>Đơn hàng</strong></span></h2>
        </div>
        <div class="h50px"></div>
        <div class=" form-search-order ">
            <form method="GET" action="{{ url('tim-don-hang')}}" class='formModal' id='formSearchOrder'>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="form-inline ">
                    <div class="form-group">
                        <label>Ngày bắt đầu: </label>
                        <input type="date" name='start_date' id="start-date" /></li>
                        <p class="text-danger" id='error-start-date'></p>
                    </div>
                    <div class="form-group ">
                        <label>Ngày kết thúc: </label>
                        <input type="date" name='end_date' id="end-date" /></li>
                        <p class="text-danger" id='error-end-date'></p>
                    </div>
                    <div class="form-group" style="margin-left:1em">
                        <button type="submit" class="btn btn-danger" disabled id="btnSearchOrder">Tìm</button>
                    </div>
                    <div class="form-group" style="float: right;"> <label class="">Tổng tiền:<span id='total-price'> {{ number_format($sum_order)}} VNĐ</span> </label></div>
                </div>
            </form>
        </div>
    </div>
    <div class="h50px"></div>
    <div class="container-fuild">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <ul class="nav nav-pills tab-order">
                    <li class="active"><a data-toggle="pill" href="#home" onclick="totalPriceAll();">Tất cả ({{$order->total()}})</a></li>
                    <li><a data-toggle="pill" onclick="totalPrice(1);" href="#menu1">Chờ ({{$order_watting->total()}})</a></li>
                    <li><a data-toggle="pill" onclick="totalPrice(2);" href="#menu2">Chưa giao ({{$order_no_delivery->total()}})</a></li>
                    <li><a data-toggle="pill" onclick="totalPrice(3);" href="#menu3">Đang giao ({{$order_beging_delivery->total()}})</a></li>
                    <li><a data-toggle="pill" onclick="totalPrice(4);" href="#menu4">Đã hoàn thành ({{$order_done_delivery->total()}})</a></li>
                    <li><a data-toggle="pill" onclick="totalPrice(5);" href="#menu5">Khách hủy ({{$order_customer_cancel->total()}})</a></li>
                    <li><a data-toggle="pill" onclick="totalPrice(6);" href="#menu6">IHTGo hủy ({{$order_iht_cancel->total()}})</a></li>
                    <li><a data-toggle="pill" onclick="totalPrice(7);" href="#menu7">Không thành công ({{$order_fail->total()}})</a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        {{ $order->links() }}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên đơn hàng</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th>Địa chỉ gửi</th>
                                    <th>Địa chỉ nhận</th>
                                    <th>Ngày tạo</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order as $o)
                                <tr>
                                    <td><a href="chi-tiet-don-hang/id={{$o->id}}">
                                            <!-- Giao hỏa tốc -->
                                            @if($o->is_speed==1)
                                            <i class="fas fa-rocket"></i>
                                            @endif
                                            #{{$o->code}}</a></td>
                                    <td>{{$o->name}} </td>

                                    <!-- Trạng thái đơn hàng -->
                                    @if($o->status==1)
                                    <td>
                                        <p class="bage-warning">Chờ </p>
                                    </td>
                                    @elseif($o->status==2)
                                    <td>
                                        <p class="bage-info">Chưa giao</p>
                                    </td>
                                    @elseif($o->status==3)
                                    <td>
                                        <p class="bage-info">Đang giao </p>
                                    </td>
                                    @elseif($o->status==4)
                                    <td>
                                        <p class="bage-success">Đã hoàn thành</p>
                                    </td>
                                    @elseif($o->status==5)
                                    <td>
                                        <p class="bage-basic">Khách hủy </p>
                                    </td>
                                    @elseif($o->status==6)
                                    <td>
                                        <p class="bage-basic">IHTGo hủy</p>
                                    </td>
                                    @elseif($o->status==7)
                                    <td>
                                        <p class="bage-danger">Không thành công</p>
                                    </td>
                                    @endif

                                    <!-- Trạng thái đơn hang -->
                                    @if($o->is_payment==0)
                                    <td>
                                        <p class="bage-basic"> Chưa thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==1)
                                    <td>
                                        <p class="bage-success"> Đã thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==2)
                                    <td>
                                        <p class="bage-danger">Ghi nợ</p>
                                    </td>
                                    @endif

                                    <td>{{$o->sender_district_name}},{{$o->sender_province_name}} </td>
                                    <td>{{$o->receive_district_name}},{{$o->receive_province_name}}</td>
                                    <td>{{$o->created_at}}</td>
                                    <td>{{number_format($o->total_price).' VNĐ'}} </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="menu1" class="tab-pane fade in">
                        {{ $order_watting->links() }}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên đơn hàng</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th>Địa chỉ gửi</th>
                                    <th>Địa chỉ nhận</th>
                                    <th>Ngày tạo</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order_watting as $o)
                                <tr>
                                    <td><a href="chi-tiet-don-hang/id={{$o->id}}">
                                            <!-- Giao hỏa tốc -->
                                            @if($o->is_speed==1)
                                            <i class="fas fa-rocket"></i>
                                            @endif
                                            #{{$o->code}}</a></td>
                                    <td>{{$o->name}} </td>

                                    <!-- Trạng thái đơn hàng -->
                                    @if($o->status==1)
                                    <td>
                                        <p class="bage-warning">Chờ </p>
                                    </td>
                                    @elseif($o->status==2)
                                    <td>
                                        <p class="bage-info">Chưa giao</p>
                                    </td>
                                    @elseif($o->status==3)
                                    <td>
                                        <p class="bage-info">Đang giao </p>
                                    </td>
                                    @elseif($o->status==4)
                                    <td>
                                        <p class="bage-success">Đã hoàn thành</p>
                                    </td>
                                    @elseif($o->status==5)
                                    <td>
                                        <p class="bage-basic">Khách hủy </p>
                                    </td>
                                    @elseif($o->status==6)
                                    <td>
                                        <p class="bage-basic">IHTGo hủy</p>
                                    </td>
                                    @elseif($o->status==7)
                                    <td>
                                        <p class="bage-danger">Không thành công</p>
                                    </td>
                                    @endif

                                    <!-- Trạng thái đơn hang -->
                                    @if($o->is_payment==0)
                                    <td>
                                        <p class="bage-basic"> Chưa thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==1)
                                    <td>
                                        <p class="bage-success"> Đã thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==2)
                                    <td>
                                        <p class="bage-danger">Ghi nợ</p>
                                    </td>
                                    @endif

                                    <td>{{$o->sender_district_name}},{{$o->sender_province_name}} </td>
                                    <td>{{$o->receive_district_name}},{{$o->receive_province_name}}</td>
                                    <td>{{$o->created_at}}</td>
                                    <td>{{number_format($o->total_price).' VNĐ'}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="menu2" class="tab-pane fade in ">
                        {{ $order_no_delivery->links() }}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên đơn hàng</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th>Địa chỉ gửi</th>
                                    <th>Địa chỉ nhận</th>
                                    <th>Ngày tạo</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order_no_delivery as $o)
                                <tr>
                                    <td><a href="chi-tiet-don-hang/id={{$o->id}}">
                                            <!-- Giao hỏa tốc -->
                                            @if($o->is_speed==1)
                                            <i class="fas fa-rocket"></i>
                                            @endif
                                            #{{$o->code}}</a></td>
                                    <td>{{$o->name}} </td>

                                    <!-- Trạng thái đơn hàng -->
                                    @if($o->status==1)
                                    <td>
                                        <p class="bage-warning">Chờ </p>
                                    </td>
                                    @elseif($o->status==2)
                                    <td>
                                        <p class="bage-info">Chưa giao</p>
                                    </td>
                                    @elseif($o->status==3)
                                    <td>
                                        <p class="bage-info">Đang giao </p>
                                    </td>
                                    @elseif($o->status==4)
                                    <td>
                                        <p class="bage-success">Đã hoàn thành</p>
                                    </td>
                                    @elseif($o->status==5)
                                    <td>
                                        <p class="bage-basic">Khách hủy </p>
                                    </td>
                                    @elseif($o->status==6)
                                    <td>
                                        <p class="bage-basic">IHTGo hủy</p>
                                    </td>
                                    @elseif($o->status==7)
                                    <td>
                                        <p class="bage-danger">Không thành công</p>
                                    </td>
                                    @endif

                                    <!-- Trạng thái đơn hang -->
                                    @if($o->is_payment==0)
                                    <td>
                                        <p class="bage-basic"> Chưa thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==1)
                                    <td>
                                        <p class="bage-success"> Đã thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==2)
                                    <td>
                                        <p class="bage-danger">Ghi nợ</p>
                                    </td>
                                    @endif

                                    <td>{{$o->sender_district_name}},{{$o->sender_province_name}} </td>
                                    <td>{{$o->receive_district_name}},{{$o->receive_province_name}}</td>
                                    <td>{{$o->created_at}}</td>
                                    <td>{{number_format($o->total_price).' VNĐ'}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="menu3" class="tab-pane fade in ">
                        {{ $order_beging_delivery->links() }}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên đơn hàng</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th>Địa chỉ gửi</th>
                                    <th>Địa chỉ nhận</th>
                                    <th>Ngày tạo</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order_beging_delivery as $o)
                                <tr>
                                    <td><a href="chi-tiet-don-hang/id={{$o->id}}">
                                            <!-- Giao hỏa tốc -->
                                            @if($o->is_speed==1)
                                            <i class="fas fa-rocket"></i>
                                            @endif
                                            #{{$o->code}}</a></td>
                                    <td>{{$o->name}} </td>

                                    <!-- Trạng thái đơn hàng -->
                                    @if($o->status==1)
                                    <td>
                                        <p class="bage-warning">Chờ </p>
                                    </td>
                                    @elseif($o->status==2)
                                    <td>
                                        <p class="bage-info">Chưa giao</p>
                                    </td>
                                    @elseif($o->status==3)
                                    <td>
                                        <p class="bage-info">Đang giao </p>
                                    </td>
                                    @elseif($o->status==4)
                                    <td>
                                        <p class="bage-success">Đã hoàn thành</p>
                                    </td>
                                    @elseif($o->status==5)
                                    <td>
                                        <p class="bage-basic">Khách hủy </p>
                                    </td>
                                    @elseif($o->status==6)
                                    <td>
                                        <p class="bage-basic">IHTGo hủy</p>
                                    </td>
                                    @elseif($o->status==7)
                                    <td>
                                        <p class="bage-danger">Không thành công</p>
                                    </td>
                                    @endif

                                    <!-- Trạng thái đơn hang -->
                                    @if($o->is_payment==0)
                                    <td>
                                        <p class="bage-basic"> Chưa thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==1)
                                    <td>
                                        <p class="bage-success"> Đã thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==2)
                                    <td>
                                        <p class="bage-danger">Ghi nợ</p>
                                    </td>
                                    @endif

                                    <td>{{$o->sender_district_name}},{{$o->sender_province_name}} </td>
                                    <td>{{$o->receive_district_name}},{{$o->receive_province_name}}</td>
                                    <td>{{$o->created_at}}</td>
                                    <td>{{number_format($o->total_price).' VNĐ'}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="menu4" class="tab-pane fade in ">
                        {{ $order_done_delivery->links() }}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên đơn hàng</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th>Địa chỉ gửi</th>
                                    <th>Địa chỉ nhận</th>
                                    <th>Ngày tạo</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order_done_delivery as $o)
                                <tr>
                                    <td><a href="chi-tiet-don-hang/id={{$o->id}}">
                                            <!-- Giao hỏa tốc -->
                                            @if($o->is_speed==1)
                                            <i class="fas fa-rocket"></i>
                                            @endif
                                            #{{$o->code}}</a></td>
                                    <td>{{$o->name}} </td>

                                    <!-- Trạng thái đơn hàng -->
                                    @if($o->status==1)
                                    <td>
                                        <p class="bage-warning">Chờ </p>
                                    </td>
                                    @elseif($o->status==2)
                                    <td>
                                        <p class="bage-info">Chưa giao</p>
                                    </td>
                                    @elseif($o->status==3)
                                    <td>
                                        <p class="bage-info">Đang giao </p>
                                    </td>
                                    @elseif($o->status==4)
                                    <td>
                                        <p class="bage-success">Đã hoàn thành</p>
                                    </td>
                                    @elseif($o->status==5)
                                    <td>
                                        <p class="bage-basic">Khách hủy </p>
                                    </td>
                                    @elseif($o->status==6)
                                    <td>
                                        <p class="bage-basic">IHTGo hủy</p>
                                    </td>
                                    @elseif($o->status==7)
                                    <td>
                                        <p class="bage-danger">Không thành công</p>
                                    </td>
                                    @endif

                                    <!-- Trạng thái đơn hang -->
                                    @if($o->is_payment==0)
                                    <td>
                                        <p class="bage-basic"> Chưa thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==1)
                                    <td>
                                        <p class="bage-success"> Đã thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==2)
                                    <td>
                                        <p class="bage-danger">Ghi nợ</p>
                                    </td>
                                    @endif

                                    <td>{{$o->sender_district_name}},{{$o->sender_province_name}} </td>
                                    <td>{{$o->receive_district_name}},{{$o->receive_province_name}}</td>
                                    <td>{{$o->created_at}}</td>
                                    <td>{{number_format($o->total_price).' VNĐ'}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="menu5" class="tab-pane fade in ">
                        {{ $order_customer_cancel->links() }}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên đơn hàng</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th>Địa chỉ gửi</th>
                                    <th>Địa chỉ nhận</th>
                                    <th>Ngày tạo</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order_customer_cancel as $o)
                                <tr>
                                    <td><a href="chi-tiet-don-hang/id={{$o->id}}">
                                            <!-- Giao hỏa tốc -->
                                            @if($o->is_speed==1)
                                            <i class="fas fa-rocket"></i>
                                            @endif
                                            #{{$o->code}}</a></td>
                                    <td>{{$o->name}} </td>

                                    <!-- Trạng thái đơn hàng -->
                                    @if($o->status==1)
                                    <td>
                                        <p class="bage-warning">Chờ </p>
                                    </td>
                                    @elseif($o->status==2)
                                    <td>
                                        <p class="bage-info">Chưa giao</p>
                                    </td>
                                    @elseif($o->status==3)
                                    <td>
                                        <p class="bage-info">Đang giao </p>
                                    </td>
                                    @elseif($o->status==4)
                                    <td>
                                        <p class="bage-success">Đã hoàn thành</p>
                                    </td>
                                    @elseif($o->status==5)
                                    <td>
                                        <p class="bage-basic">Khách hủy </p>
                                    </td>
                                    @elseif($o->status==6)
                                    <td>
                                        <p class="bage-basic">IHTGo hủy</p>
                                    </td>
                                    @elseif($o->status==7)
                                    <td>
                                        <p class="bage-danger">Không thành công</p>
                                    </td>
                                    @endif

                                    <!-- Trạng thái đơn hang -->
                                    @if($o->is_payment==0)
                                    <td>
                                        <p class="bage-basic"> Chưa thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==1)
                                    <td>
                                        <p class="bage-success"> Đã thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==2)
                                    <td>
                                        <p class="bage-danger">Ghi nợ</p>
                                    </td>
                                    @endif

                                    <td>{{$o->sender_district_name}},{{$o->sender_province_name}} </td>
                                    <td>{{$o->receive_district_name}},{{$o->receive_province_name}}</td>
                                    <td>{{$o->created_at}}</td>
                                    <td>{{number_format($o->total_price).' VNĐ'}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="menu6" class="tab-pane fade in ">
                        {{ $order_iht_cancel->links() }}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên đơn hàng</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th>Địa chỉ gửi</th>
                                    <th>Địa chỉ nhận</th>
                                    <th>Ngày tạo</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order_iht_cancel as $o)
                                <tr>
                                    <td><a href="chi-tiet-don-hang/id={{$o->id}}">
                                            <!-- Giao hỏa tốc -->
                                            @if($o->is_speed==1)
                                            <i class="fas fa-rocket"></i>
                                            @endif
                                            #{{$o->code}}</a></td>
                                    <td>{{$o->name}} </td>

                                    <!-- Trạng thái đơn hàng -->
                                    @if($o->status==1)
                                    <td>
                                        <p class="bage-warning">Chờ </p>
                                    </td>
                                    @elseif($o->status==2)
                                    <td>
                                        <p class="bage-info">Chưa giao</p>
                                    </td>
                                    @elseif($o->status==3)
                                    <td>
                                        <p class="bage-info">Đang giao </p>
                                    </td>
                                    @elseif($o->status==4)
                                    <td>
                                        <p class="bage-success">Đã hoàn thành</p>
                                    </td>
                                    @elseif($o->status==5)
                                    <td>
                                        <p class="bage-basic">Khách hủy </p>
                                    </td>
                                    @elseif($o->status==6)
                                    <td>
                                        <p class="bage-basic">IHTGo hủy</p>
                                    </td>
                                    @elseif($o->status==7)
                                    <td>
                                        <p class="bage-danger">Không thành công</p>
                                    </td>
                                    @endif

                                    <!-- Trạng thái đơn hang -->
                                    @if($o->is_payment==0)
                                    <td>
                                        <p class="bage-basic"> Chưa thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==1)
                                    <td>
                                        <p class="bage-success"> Đã thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==2)
                                    <td>
                                        <p class="bage-danger">Ghi nợ</p>
                                    </td>
                                    @endif

                                    <td>{{$o->sender_district_name}},{{$o->sender_province_name}} </td>
                                    <td>{{$o->receive_district_name}},{{$o->receive_province_name}}</td>
                                    <td>{{$o->created_at}}</td>td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="menu7" class="tab-pane fade in ">
                        {{ $order_fail->links() }}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên đơn hàng</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th>Địa chỉ gửi</th>
                                    <th>Địa chỉ nhận</th>
                                    <th>Ngày tạo</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order_fail as $o)
                                <tr>
                                    <td><a href="chi-tiet-don-hang/id={{$o->id}}">
                                            <!-- Giao hỏa tốc -->
                                            @if($o->is_speed==1)
                                            <i class="fas fa-rocket"></i>
                                            @endif
                                            #{{$o->code}}</a></td>
                                    <td>{{$o->name}} </td>

                                    <!-- Trạng thái đơn hàng -->
                                    @if($o->status==1)
                                    <td>
                                        <p class="bage-warning">Chờ </p>
                                    </td>
                                    @elseif($o->status==2)
                                    <td>
                                        <p class="bage-info">Chưa giao</p>
                                    </td>
                                    @elseif($o->status==3)
                                    <td>
                                        <p class="bage-info">Đang giao </p>
                                    </td>
                                    @elseif($o->status==4)
                                    <td>
                                        <p class="bage-success">Đã hoàn thành</p>
                                    </td>
                                    @elseif($o->status==5)
                                    <td>
                                        <p class="bage-basic">Khách hủy </p>
                                    </td>
                                    @elseif($o->status==6)
                                    <td>
                                        <p class="bage-basic">IHTGo hủy</p>
                                    </td>
                                    @elseif($o->status==7)
                                    <td>
                                        <p class="bage-danger">Không thành công</p>
                                    </td>
                                    @endif

                                    <!-- Trạng thái đơn hang -->
                                    @if($o->is_payment==0)
                                    <td>
                                        <p class="bage-basic"> Chưa thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==1)
                                    <td>
                                        <p class="bage-success"> Đã thanh toán</p>
                                    </td>
                                    @elseif($o->is_payment==2)
                                    <td>
                                        <p class="bage-danger">Ghi nợ</p>
                                    </td>
                                    @endif

                                    <td>{{$o->sender_district_name}},{{$o->sender_province_name}} </td>
                                    <td>{{$o->receive_district_name}},{{$o->receive_province_name}}</td>
                                    <td>{{$o->created_at}}</td>
                                    <td>{{number_format($o->total_price).' VNĐ'}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<script>
    //thay đổi tổng tiền trên trang list đơn hàng
    function totalPriceAll() {
        $.ajax({
            type: "GET",
            url: 'total-price-order-all',
            success: function(data) {
                $('#total-price').empty();
                $('#total-price').html(' ' + formatCurrency(data));
            }
        })
    }

    function totalPrice(id) {
        $.ajax({
            type: "GET",
            url: 'total-price-order',
            data: {
                id: id
            },
            success: function(data) {
                $('#total-price').empty();
                $('#total-price').html(' ' + formatCurrency(data));
            }
        })
    }

    function formatCurrency(number) {
        var n = number.split('').reverse().join("");
        var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");
        return n2.split('').reverse().join('') + ' VNĐ';
    }
</script>
@endsection