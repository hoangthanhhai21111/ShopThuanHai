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
                <h1 class="page-title mr-sm-auto">Danh mục Nhãn hiệu</h1>
                <div class="btn-toolbar">


                    {{-- @can('create', App\Models\brand::class) --}}


                    <div class="input-group-prepend">
                        <button class="btn btn-secondary" type="button" data-toggle="modal"
                            data-target="#modalFilterColumns">Tìm nâng cao</button>
                            {{-- @include('backend.brands.modals.modalFilterColumns') --}}
                    </div>

                    <div class="md-5 title_cate d-flex">
                        <div class="form-outline">
                            <form action="">
                                <input type="search" value="" name="key" id="form1"
                                    class="form-control" placeholder="search..." />
                            @include('backend.brands.modals.modalFilterColumns')

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
                            <a class="nav-link active" href="">Tất Cả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('brands.trash') }}">Thùng Rác</a>
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
                                    <th> logo </th>
                                    <th> Tên Nhãn hiệu </th>
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
                                        <td>
                                            @if ($brand->status == 1)
                                                <a href="{{ route('brands.hideStatus', $brand->id) }}">
                                                    <i class=" fas fa-chevron-circle-down text-success"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('brands.showStatus', $brand->id) }}">
                                                    <i class=" far fa-times-circle text-danger"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('brands.force_destroy', $brand->id) }}"
                                                style="display:inline" method="post">
                                                {{-- @can('update', App\Models\brand::class) --}}
                                                <a href="{{ route('brands.edit', $brand->id) }}"
                                                    class="btn btn-sm btn-icon btn-secondary"><i
                                                        class="fa fa-pencil-alt"></i></a>
                                                {{-- @endcan --}}
                                                {{-- @can('forceDelete', App\Models\brand::class) --}}
                                                <button onclick="return confirm('Xóa {{ $brand->name }} ?')"
                                                    type="submit" class="btn btn-sm btn-icon btn-secondary"><i
                                                        class="far fa-trash-alt"></i></button>
                                                {{-- @endcan --}}
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $brands->onEachSide(5)->links() }}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
