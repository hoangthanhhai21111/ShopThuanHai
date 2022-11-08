@extends('backend.masster')
@section('content')
    <div class="page-inner">
        <header class="page-title-bar">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a href="{{route('products.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý danh mục</a>
                    </li>
                </ol>
            </nav>
            <h1 class="page-title">Thêm danh mục</h1>
        </header>

        <div class="page-section">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT') --}}
                <div class="card">
                    <div class="card-body">
                        <legend>Thông tin cơ bản</legend>
                        <div class="row">
                                <div class="form-group">
                                    <label for="tf1">Tên Sản phẩm<abbr name="Trường bắt buộc">*</abbr></label> <input
                                        name="name" type="text" class="form-control" value="{{ old('name') }}"
                                        placeholder="Nhập tên Sản phẩm">
                                    <small id="" class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="tf1"> Số lượng<abbr name="Trường bắt buộc">*</abbr></label> <input
                                        name="amount" type="text" class="form-control" value="{{ old('amount') }}"
                                        placeholder="Nhập  Số lượng">
                                    <small id="" class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('amount') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="tf1">Gía<abbr name="Trường bắt buộc">*</abbr></label> <input
                                        name="price" type="text" class="form-control" value="{{ old('price') }}"
                                        placeholder="Nhập Gía">
                                    <small id="" class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('price') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="tf1">Mô tả<abbr name="Trường bắt buộc">*</abbr></label> <input
                                        name="description" type="text" class="form-control" value="{{ old('description') }}"
                                        placeholder="Nhập Mô tả">
                                    <small id="" class="form-text text-muted"></small>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('description') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-lg-3">
                                    <label class="control-label" for="flatpickr01">Danh mục<abbr name="Trường bắt buộc">*</abbr></label>
                                        <select name="category_id" id="" class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">--Vui lòng chọn--</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name}}</option>
                                            @endforeach
                                        </select>
                                    @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-3">
                                    <label class="control-label" for="flatpickr01">Nhãn hiệu<abbr name="Trường bắt buộc">*</abbr></label>
                                        <select name="brand_id" id="" class="form-control @error('brand_id') is-invalid @enderror">
                                            <option value="">--Vui lòng chọn--</option>
                                            @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name}}</option>
                                            @endforeach
                                        </select>
                                    @error('brand_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="flatpickr01">Hình Ảnh</label><br>
                                    <input accept="image/*" type='file' id="inputFile" name="image" /><br>
                                    <br>
                                    <img type="hidden" width="90px" height="90px" id="blah" src="#"
                                        alt="" />
                                </div>
                                @if ($errors->any())
                                    <p style="color:red">{{ $errors->first('image') }}</p>
                                @endif
                        <div class="form-actions">
                            <a class="btn btn-secondary float-right" href="{{ route('products.index') }}">Hủy</a>
                            <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
