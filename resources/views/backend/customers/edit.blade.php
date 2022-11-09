@extends('backend.masster')
@section('content')
    <!-- .page-title-bar -->
    <div class="page-inner">
        <header class="page-title-bar">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a href="{{ route('customers.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý
                            danh
                            sách</a>
                    </li>
                </ol>
            </nav>
            <h1 class="page-title"> Chỉnh Sửa Khách hàng</h1>
        </header>
        <div class="page-section">
            <div class="card">
                <div class="card-body">
                    <legend>Thông tin cơ bản</legend>
                    <form action="{{ route('customers.update', $customers->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tf1">Tên Khách hàng</label> <input type="text" name="name"
                                        value="{{ $customers->name }}" class="form-control">
                                    <small class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tf1">Số điện thoại</label> <input type="text" name="phone"
                                        value="{{ $customers->phone }}" class="form-control">
                                    <small class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('phone') }}</p>
                                    @endif
                                </div>
                            </div>
                           
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tf1">Email</label> <input type="text" name="email"
                                        value="{{ $customers->email }}" class="form-control">
                                    <small class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tf1">Mật khẩu</label> <input type="text" name="password"
                                        value="{{ $customers->password }}" class="form-control">
                                    <small class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('password') }}</p>
                                    @endif
                                </div>
                            </div>
                            
                        <div class="form-group">
                            <label for="tf1">Ảnh logo<abbr name="Trường bắt buộc">*</abbr></label>
                            {{-- <input name="banner"
                                type="file" value="{{ old('banner') }}" class="form-control" id=""> --}}
                            <input accept="image/*" type='file' id="inputFile" name="logo" /><br>
                            <br>
                            <img type="hidden" width="90px" height="90px" id="blah1"
                                src="{{ asset($customers->logo) }}" alt="" />
                            @if ($errors->any())
                                <p style="color:red">{{ $errors->first('logo') }}</p>
                            @endif
                        </div>
                        <div class="form-actions">
                            <a class="btn btn-secondary float-right" href="{{ route('customers.index') }}">Hủy</a>
                            <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
