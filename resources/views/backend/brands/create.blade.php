@extends('backend.masster')
@section('content')
    <div class="page-inner">
        <header class="page-title-bar">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a href="{{ route('brands.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý
                            Khách
                            Hàng</a>
                    </li>
                </ol>
            </nav>
            <h1 class="page-title">Thêm Ảnh bìa</h1>
        </header>

        <div class="page-section">
            <form action="{{ route('brands.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT') --}}
                <div class="card">
                    <div class="card-body">
                        <legend>Thông tin cơ bản</legend>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="tf1">Vị trí<abbr name="Trường bắt buộc">*</abbr></label> <input
                                        name="name" type="text" class="form-control" value="{{ old('name') }}"
                                        placeholder="Nhập tên vị trí">
                                    <small id="" class="form-text text-muted"></small>
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                </div>
                            </div>
                          
                        <div class="form-group">
                            <label class="control-label" for="flatpickr01">Ảnh Bìa</label><br>
                            <input accept="image/*" type='file' id="inputFile" name="logo" /><br>
                            <br>
                            <img type="hidden" width="90px" height="90px" id="blah" src="#"
                                alt="" />
                        </div>
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                        <div class="form-actions">
                            <a class="btn btn-secondary float-right" href="{{ route('brands.index') }}">Hủy</a>
                            <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
