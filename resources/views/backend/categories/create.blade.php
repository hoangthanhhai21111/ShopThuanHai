@extends('backend.masster')
@section('content')
    <div class="page-inner">
        <header class="page-title-bar">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a href="{{ route('categories.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý
                            danh mục</a>
                    </li>
                </ol>
            </nav>
            <h1 class="page-title">Thêm danh mục</h1>
        </header>

        <div class="page-section">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT') --}}
                <div class="card">
                    <div class="card-body">
                        <legend>Thông tin cơ bản</legend>
                        <div class="row">
                            <div class="form-group">
                                <label for="tf1">Tên danh mục<abbr name="Trường bắt buộc">*</abbr></label> <input
                                    name="name" type="text" class="form-control" value="{{ old('name') }}"
                                    placeholder="Nhập tên danh mục">
                                <small id="" class="form-text text-muted"></small>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-actions">
                                <a class="btn btn-secondary float-right" href="{{ route('categories.index') }}">Hủy</a>
                                <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection
