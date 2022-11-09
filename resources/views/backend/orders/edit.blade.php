@extends('backend.masster')
@section('content')
    <div class="page-inner">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{route('orders.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang danh sách</a>
                </li>
            </ol>
        </nav>
        <header class="page-title-bar">
            <h1 class="page-title">Chỉnh sửa đơn hàng </h1>
        </header>
        <div class="page-section">
            <div class="card-deck-xl">
                <div class="card card-fluid">
                    <div class="card-body">
                        <form action="{{ route('orders.update', $orders->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="control-label" for="flatpickr01">Ghi chú</label> <input id="flatpickr01"
                                            type="text" class="form-control" value="{{$orders->note}}" name="note" data-toggle="flatpickr">
                                    </div>
                                    @if ($errors->any())
                                    <p style="color:red">{{ $errors->first('note') }}</p>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="control-label" for="flatpickr01">Địa chỉ</label> <input id="flatpickr01"
                                            type="text" class="form-control" value="{{$orders->address}}" name="address" data-toggle="flatpickr">
                                    </div>
                                    @if ($errors->any())
                                    <p style="color:red">{{ $errors->first('address') }}</p>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="control-label" for="flatpickr01">Tổng tiền</label> <input id="flatpickr01"
                                            type="text" class="form-control" value="{{$orders->order_total_price}}" name="order_total_price" data-toggle="flatpickr">
                                    </div>
                                    @if ($errors->any())
                                    <p style="color:red">{{ $errors->first('order_total_price') }}</p>
                                    @endif
        
                                </div>
                                <div class="col-6">
                                    <div class="form-select" aria-label="Default select example">
                                        <label class="control-label" for="flatpickr01">Khách hàng</label> 
                                        <select name="customer_id" class="form-control " id="inputGroupSelect02">
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->any())
                                    <p style="color:red">{{ $errors->first('customer_id') }}</p>
                                    @endif
                                    
                                </div>
                            </div>
                            <div class="form-actions">
                                <a class="btn btn-secondary float-right" href="{{route('orders.index')}}">Hủy</a>
                                <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endsection