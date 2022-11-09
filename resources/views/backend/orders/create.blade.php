@extends('backend.masster')
@section('content')
    <div class="page-inner">
        <header class="page-title-bar">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a href="{{route('orders.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý danh mục</a>
                    </li>
                </ol>
            </nav>
            <h1 class="page-title">Thêm danh mục</h1>
        </header>

        <div class="page-section">
            <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT') --}}
                <div class="card">
                    <div class="card-body">
                        <legend>Thông tin cơ bản</legend>
                        <div class="row">
                                <div class="form-group">
                                    <label for="tf1">ghi chú<abbr name="Trường bắt buộc">*</abbr></label> <input
                                        name="note" type="text" class="form-control" value="{{ old('note') }}"
                                        placeholder="Nhập tên Sản phẩm">
                                    <small id="" class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('note') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="tf1"> Địa chỉ<abbr name="Trường bắt buộc">*</abbr></label> <input
                                        name="address" type="text" class="form-control" value="{{ old('address') }}"
                                        placeholder="Nhập  Số lượng">
                                    <small id="" class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('address') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="tf1">Tổng tiền<abbr name="Trường bắt buộc">*</abbr></label> <input
                                        name="order_total_price" type="text" class="form-control" value="{{ old('order_total_price') }}"
                                        placeholder="Nhập Gía">
                                    <small id="" class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('order_total_price') }}</p>
                                    @endif
                                </div>
                                
                                <div class="form-select col-lg-3" aria-label="Default select example">
                                    <label class="control-label" for="flatpickr01">Khách hàng<abbr name="Trường bắt buộc">*</abbr></label>
                                        <select name="customer_id" id="" class="form-control @error('customer_id') is-invalid @enderror">
                                            <option value="">--Vui lòng chọn--</option>
                                            @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name}}</option>
                                            @endforeach
                                        </select>
                                    @error('customer_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                        <div class="form-actions">
                            <a class="btn btn-secondary float-right" href="{{ route('orders.index') }}">Hủy</a>
                            <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
