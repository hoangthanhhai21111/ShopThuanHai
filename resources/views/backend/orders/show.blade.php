@extends('backend.master')
@section('content')
    <div class="container-fluid">

        <div class="container">
            <div class="col-md-12 d-flex">
                <div class="md-3">
                    <a href="{{ route('orders.index') }}" class="btn btn-danger btn-rounded waves-effect waves-light ">
                        <i class=" fas fa-reply-all"></i>
                        Quay Lại</a>
                </div>
            </div>
            <!-- Title -->
            <div class="mb-3 text-center">
                <h2>Chi Tiết Đặt Hàng</h2>
            </div>
            <div class="d-flex justify-content-between align-items-center py-3">
                <h5>ID Đơn hàng: {{ $order->id }}</h5>
            </div>

            <!-- Main content -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- Details -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-between">
                                <div>
                                    <span class="me-3">Ngày Tạo Đơn: {{ $order->created_at }}</span><br>
                                </div>
                            </div>
                            <div class="mb-3">
                                <span class="me-3"> Tên Khách Hàng: <b>{{ $order->customer->name }}</b></span>
                            </div>
                            <div class="mb-3">
                                <span class="me-3">Địa Chỉ:
                                    <b> {{ $order->address }}</b>
                                </span>
                            </div>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Sản Phẩm</td>
                                        <td>Số Lượng</td>
                                        <td class="text-end">Giá</td>
                                        <td class="text-end">Tổng Phụ</td>
                                    </tr>
                                    @php
                                        $totalPriceOrder = 0;
                                    @endphp
                                    @foreach ($order_details as $order_detail)
                                        <tr>
                                            <td>
                                                <div class="d-flex mb-2">
                                                    <div class="flex-lg-grow-1 ms-3">
                                                        <h6 class="small mb-0">
                                                            <a href="#"
                                                                class="text-reset">{{ $order_detail->products->name }}</a>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- <td>
                                                <img style="witdh:50px;height:50px" src="{{asset( $orderDetail->products->image )}}" alt="">
                                            </td> --}}
                                            <td>{{ $order_detail->product_quantity }} chiếc</td>
                                            <td class="text-end">{{ number_format($order_detail->product_price) }} đ</td>
                                            <td class="text-end">
                                                {{ number_format($order_detail->product_price * $order_detail->product_quantity) }} đ
                                            </td>
                                            @php
                                                $totalPriceOrder += $order_detail->product_price * $order_detail->product_quantity;
                                            @endphp
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="fw-bold">
                                        <td colspan="3">
                                            <p>Tổng tiền hóa đơn : </p>
                                        </td>
                                        <td class="text-end">
                                            <h4><strong>{{ number_format($totalPriceOrder) }} đ</strong></h4>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Payment -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3 class="h6">PHƯƠNG THỨC THANH TOÁN</h3>
                                    <p>Thanh Toán Khi Nhận Hàng <br>
                                        Tổng Thanh Toán <b>{{number_format($totalPriceOrder) }}</b> đ</p>
                                </div>
                                <div class="col-lg-6">
                                    <h3 class="h6">Địa chỉ thanh toán</h3>
                                    <address>
                                        <div>
                                            <strong>
                                                {{ $order->address }},
                                            </strong>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Customer Notes -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <b class="h5">Ghi Chú :</b><br><br>
                            <b>{{ $order->note }}</b>
                        </div>
                        <div class="card-body">
                            <b class="h5"> Người Nhận :</b><br><br>
                            <b>{{ $order->name_customer }}</b>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <!-- Shipping information -->
                        <div class="card-body">
                            <h3 class="h6">Thông tin vận chuyển</h3>
                            <strong>Ex</strong>
                            <span><a href="#" class="text-decoration-underline" target="_blank">FF1234567890</a> <i
                                    class="bi bi-box-arrow-up-right"></i> </span>
                            <hr>
                            <h3 class="h6">Địa chỉ</h3>
                            <address>
                                <strong>CodeGym</strong><br>
                                133 Lý Thường Kiệt<br>
                                Thành Phố Đông Hà<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
