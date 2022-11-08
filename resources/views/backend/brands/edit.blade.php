@extends('backend.masster')
@section('content')
    <!-- .page-title-bar -->
    <div class="page-inner">
        <header class="page-title-bar">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a href="{{ route('brands.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý
                            danh
                            sách</a>
                    </li>
                </ol>
            </nav>
            <h1 class="page-title"> Chỉnh Sửa Logo</h1>
        </header>
        <div class="page-section">
            <div class="card">
                <div class="card-body">
                    <legend>Thông tin cơ bản</legend>
                    <form action="{{ route('brands.update', $brands->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="tf1">Tên Nhãn hiệu</label> <input type="text" name="name"
                                        value="{{ $brands->name }}" class="form-control">
                                    <small class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('name') }}</p>
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
                                    src="{{ asset($brands->logo) }}" alt="" />
                                @if ($errors->any())
                                    <p style="color:red">{{ $errors->first('logo') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-actions">
                            <a class="btn btn-secondary float-right" href="{{ route('brands.index') }}">Hủy</a>
                            <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
