@extends('backend.masster')
@section('content')
    <div class="page-inner">
        <header class="page-title-bar">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a href="{{ route('customers.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý
                            Khách
                            Hàng</a>
                    </li>
                </ol>
            </nav>
            <h1 class="page-title">Thêm khách hàng</h1>
        </header>

        <div class="page-section">
            <form action="{{ route('customers.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT') --}}
                <div class="card">
                    <div class="card-body">
                        <legend>Thông tin cơ bản</legend>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tf1">Tên khách hàng<abbr name="Trường bắt buộc">*</abbr></label> <input
                                        name="name" type="text" class="form-control" value="{{ old('name') }}"
                                        placeholder="Nhập tên vị trí">
                                    <small id="" class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tf1">Số điện thoại<abbr name="Trường bắt buộc">*</abbr></label> <input
                                        name="phone" type="text" class="form-control" value="{{ old('phone') }}"
                                        placeholder="Nhập tên vị trí">
                                    <small id="" class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('phone') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tf1">Email<abbr name="Trường bắt buộc">*</abbr></label> <input
                                        name="email" type="email" class="form-control" value="{{ old('email') }}"
                                        placeholder="Nhập tên vị trí">
                                    <small id="" class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tf1">Mật khẩu<abbr name="Trường bắt buộc">*</abbr></label> <input
                                        name="password" type="password" class="form-control" value="{{ old('password') }}"
                                        placeholder="Nhập tên vị trí">
                                    <small id="" class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('password') }}</p>
                                    @endif
                                </div>
                            </div>
                          
                        <div class="form-group">
                            <label class="control-label" for="flatpickr01">Ảnh</label><br>
                            <input accept="image/*" type='file' id="inputFile" name="avatar" /><br>
                            <br>
                            <img type="hidden" width="90px" height="90px" id="blah" src="#"
                                alt="" />
                        </div>
                        @if ($errors->any())
                            <p style="color:red">{{ $errors->first('avatar') }}</p>
                        @endif
                        <div class="form-actions">
                            <a class="btn btn-secondary float-right" href="{{ route('customers.index') }}">Hủy</a>
                            <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
