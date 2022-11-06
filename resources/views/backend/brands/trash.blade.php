@extends('backend.masster')
@section('content')
    <div class="page-inner">
        <header class="page-title-bar">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a href="#"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang Chủ</a>
                    </li>
                </ol>
            </nav>
            <div class="d-md-flex align-items-md-start">
                <h1 class="page-title mr-sm-auto">Thùng rác</h1>
                <div class="btn-toolbar">


                    {{-- @can('create', App\Models\brand::class) --}}


                    <div class="input-group-prepend">
                        <button class="btn btn-secondary" type="button" data-toggle="modal"
                            data-target="#modalFilterColumns">Tìm nâng cao</button>
                    </div>

                    <div class="md-5 title_cate d-flex">
                        <div class="form-outline">
                            <form action="">
                                <input type="search" value="" name="key" id="form1"
                                    class="form-control" placeholder="search..." />

                                </div>
                                <button type="submit" class="btn btn-primary  waves-effect waves-light ">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                    </div>
                    {{-- @endcan --}}

                </div>

            </div>

        </header>
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('brands.index') }}">Tất Cả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('brands.trash') }}">Thùng Rác</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col">
                            <form action="" method="GET" id="form-search">
                                <div class="input-group input-group-alt">
                                    <a href="{{ route('brands.create') }}" class="btn btn-primary mr-2">
                                        <i class="fa-solid fa fa-plus"></i>
                                        <span class="ml-1">Thêm Mới</span>
                                    </a>
                                    @include('backend.brands.modals.modalFilterColumns')
                            </form>
                        </div>
                    </div><br>

                    @if (Session::has('success'))
                        <p class="text-success">
                        <div class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i>
                            {{ Session::get('success') }}</div>
                        </p>
                    @endif
                    @if (Session::has('error'))
                        <p class="text-danger">
                        <div class="alert alert-danger"> <i class="bi bi-x-circle"></i>
                            {{ Session::get('error') }}</div>
                        </p>
                    @endif
                    @if (!count($brands))
                        <p class="text-danger">
                        <div class="alert alert-danger"> <i class="bi bi-x-circle"></i> Không tìm thấy kết quả
                            {{ Session::get('error') }}</div>
                        </p>
                    @endif
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Tên Nhãn hiệu </th>
                                    <th> logo </th>
                                    <th> Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $brand)
                                    <tr>
                                        <td class="align-middle"> {{ $brand->id }} </td>
                                        <td>
                                            <img style="width:100px; height:70px" src="{{ asset($brand->logo) }}">
                                        </td>

                                        <td class="align-middle"> {{ $brand->name }} </td>
                                        {{-- <td>
                                            @if ($brand->status == 1)
                                                <a href="">
                                                    <i class=" fas fa-chevron-circle-down text-success"></i>
                                                </a>
                                            @else
                                                <a href="">
                                                    <i class=" far fa-times-circle text-danger"></i>
                                                </a>
                                            @endif
                                        </td> --}}

                                        <td>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-2">
                                                        {{-- @can('restore', App\Models\Banner::class) --}}
                                                        <form action="{{ route('brands.restore', $brand->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-sm btn-icon btn-secondary"
                                                                onclick="return confirm('Bạn muốn khôi phục?')">

                                                                <i class="fa fa-trash-restore"></i> </button>
                                                        </form>
                                                        {{-- @endcan --}}
                                                    </div>
                                                    <div class="col-2">
                                                        {{-- @can('delete', App\Models\brand::class) --}}
                                                        <form action="{{ route('brands.destroy', $brand->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-icon btn-secondary"
                                                                onclick="return confirm('Bạn chắc chắn muốn xóa?')"> <i
                                                                    class="far fa-trash-alt"></i></button>
                                                        </form>
                                                        {{-- @endcan --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $brands->onEachSide(5)->links() }} --}}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
