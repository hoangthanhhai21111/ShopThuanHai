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
                <h1 class="page-title mr-sm-auto">Danh mục sản phẩm</h1>
                <div class="btn-toolbar">


                    {{-- @can('create', App\Models\category::class) --}}


                    <div class="input-group-prepend">
                        <button class="btn btn-secondary" type="button" data-toggle="modal"
                            data-target="#modalFilterColumns">Tìm nâng cao</button>
                    </div>

                    <div class="md-5 title_cate d-flex">
                        <div class="form-outline">
                            <form action="">
                                <input type="search" value="{{ $f_key }}" name="key" id="form1"
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
                            <a class="nav-link active" href="">Tất Cả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('categories.trash') }}">Thùng Rác</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col">
                            <form action="" method="GET" id="form-search">
                                <div class="input-group input-group-alt">
                                    <a href="{{ route('categories.create') }}" class="btn btn-primary mr-2">
                                        <i class="fa-solid fa fa-plus"></i>
                                        <span class="ml-1">Thêm Mới</span>
                                    </a>
                                    @include('backend.categories.modals.modalFilterColumns')
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
                    @if (!count($categories))
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
                                    <th> Tên danh mục </th>
                                    <th> Trạng thái </th>
                                    <th> Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="align-middle"> {{ $category->id }} </td>

                                        <td class="align-middle"> {{ $category->name }} </td>
                                        <td>
                                            @if ($category->status == 1)
                                                <a href="">
                                                    <i class=" fas fa-chevron-circle-down text-success"></i>
                                                </a>
                                            @else
                                                <a href="">
                                                    <i class=" far fa-times-circle text-danger"></i>
                                                </a>
                                            @endif
                                        </td>

                                        <td>
                                            <form action="{{ route('categories.force_destroy', $category->id) }}"
                                                style="display:inline" method="post">
                                                {{-- @can('update', App\Models\category::class) --}}
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                    class="btn btn-sm btn-icon btn-secondary"><i
                                                        class="fa fa-pencil-alt"></i></a>
                                                {{-- @endcan --}}
                                                {{-- @can('forceDelete', App\Models\category::class) --}}
                                                <button onclick="return confirm('Xóa {{ $category->name }} ?')"
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
                        {{ $categories->onEachSide(5)->links() }}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
