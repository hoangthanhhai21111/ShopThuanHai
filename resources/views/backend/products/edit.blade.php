@extends('backend.masster')
@section('content')
    <div class="page-inner">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('products.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang danh
                        sách</a>
                </li>
            </ol>
        </nav>
        <header class="page-title-bar">
            <h1 class="page-title">Sửa Sản phẩm </h1>
        </header>
        <div class="page-section">
            <div class="card-deck-xl">
                <div class="card card-fluid">
                    <div class="card-body">
                        <form action="{{ route('products.update', $products->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="control-label" for="flatpickr01">Tên Sản phẩm</label> <input id="flatpickr01"
                                            type="text" class="form-control" value="{{ $products->name }}" name="name"
                                            data-toggle="flatpickr">
                                    </div>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="control-label" for="flatpickr01">Số lượng</label> <input id="flatpickr01"
                                            type="text" class="form-control" value="{{ $products->amount }}" name="amount"
                                            data-toggle="flatpickr">
                                    </div>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('amount') }}</p>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="control-label" for="flatpickr01">Gía</label> <input id="flatpickr01"
                                            type="text" class="form-control" value="{{ $products->price }}" name="price"
                                            data-toggle="flatpickr">
                                    </div>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('price') }}</p>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <div class="form-select" aria-label="Default select example">
                                        <label class="control-label" for="flatpickr01">Danh mục</label>
                                        <select name="category_id" class="form-control " id="inputGroupSelect02">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->any())
                                        <p style="color:red">{{ $errors->first('category_id') }}</p>
                                    @endif
                                </div>
                                <div class="form-select" aria-label="Default select example">
                                    <label class="control-label" for="flatpickr01">Nhãn hiệu</label>
                                    <select name="brand_id" class="form-control " id="inputGroupSelect02">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->any())
                                    <p style="color:red">{{ $errors->first('brand_id') }}</p>
                                @endif
                            </div>

                           

                            

                            

                            <div class="form-group">
                                <label class="control-label" for="flatpickr01">Mô tả</label> <input id="flatpickr01"
                                    type="text" class="form-control" value="{{ $products->description }}"
                                    name="description" data-toggle="flatpickr">
                            </div>
                            @if ($errors->any())
                                <p style="color:red">{{ $errors->first('description') }}</p>
                            @endif
                            
                            <div class="form-group">
                                <label for="tf1"> Hình Ảnh <abbr name="Trường bắt buộc">*</abbr></label>
                                {{-- <input name="banner"
                                type="file" value="{{ old('banner') }}" class="form-control" id=""> --}}
                                <input accept="image/*" type='file' id="inputFile" name="image" /><br>
                                <br>
                                <img type="hidden" width="90px" height="90px" id="blah1"
                                    src="{{ asset($products->image) }}" alt="" />
                                @if ($errors->any())
                                    <p style="color:red">{{ $errors->first('image') }}</p>
                                @endif
                            </div>
                            
                            {{-- <div class="form-group">
                                <label class="control-label" for="flatpickr01">Công Khai</label>
                                <select name="is_published" class="form-control " id="inputGroupSelect02">
                                    <option value="{{1}}">Có</option>
                                    <option value="{{2}}">Không</option>
                                </select>
                            </div>
                            @if ($errors->any())
                            <p style="color:red">{{ $errors->first('is_published') }}</p>
                            @endif --}}
                            <div class="form-actions">
                                <a class="btn btn-secondary float-right" href="{{ route('products.index') }}">Hủy</a>
                                <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endsection
