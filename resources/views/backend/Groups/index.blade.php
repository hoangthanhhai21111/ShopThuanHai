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
            <h1 class="page-title mr-sm-auto">Danh mục chức vụ</h1>
            <div class="btn-toolbar">
                {{-- @can('create', App\Models\category::class) --}}
                <div class="input-group-prepend">
                    <button class="btn btn-secondary" type="button" data-toggle="modal"
                        data-target="#modalFilterColumns">Tìm nâng cao</button>
                </div>
                <div class="md-5 title_cate d-flex">
                    <div class="form-outline">
                        <form action="">
                            <input type="search" value="{{ $f_key }}" name="search" id="form1"
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
                </ul>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col">
                        <form action="" method="GET" id="form-search">
                            <div class="input-group input-group-alt">
                                <a href="{{ route('groups.create') }}" class="btn btn-primary mr-2">
                                    <i class="fa-solid fa fa-plus"></i>
                                    <span class="ml-1">Thêm Mới</span>
                                </a>

                                {{-- @include('admin.categorys.modals.modalFilterColumns') --}}
                        </form>

                    </div>
                </div>
                <div class="container col-12">
                @if (!count($groups))
                    <p class="text-success">
                    <div class="alert alert-danger"><i class="bi bi-x-circle"aria-hidden="true"></i>
                        không tìm thấy kết quả.
                    </div>
                    </p>
                @endif
                @if (Session::has('success'))
                    <p class="text-success">
                    <div class="alert alert-success"> <i class="fa fa-check" aria-hidden="true"></i>
                        {{ Session::get('success') }}</div>
                    </p>
                @endif
                @if (Session::has('error'))
                    <p class="text-danger">
                    <div class="alert alert-danger"> <i class="bi bi-x-circle"aria-hidden="true"></i>
                        {{ Session::get('error') }}</div>
                    </p>
                @endif
            </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <!-- thead -->
                        <thead class="thead-">
                            <tr>
                                <th style="min-width:50px"> #</th>
                                <th> Tên Nhóm </th>
                                <th> Mô Tả Nhóm</th>
                                <th> Tùy Chọn </th>
                            </tr>
                        </thead><!-- /thead -->
                        <tbody>
                            @foreach ($groups as $group)
                                <tr>
                                    <th scope="row">{{ $group->id }}</th>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->description }}</td>
                                    <td>
                                        <form action="{{ route('groups.destroy', $group->id) }}" method="post">
                                            {{-- @can('update', App\Models\Group::class) --}}
                                            <a href="{{ route('groups.edit', $group->id) }}"
                                                class="btn btn-sm btn-icon btn-secondary"><i
                                                    class="fa fa-pencil-alt"></i></a>
                                            {{-- {{-- @endcan --}}
                                            @csrf
                                            @method('DELETE')
                                            {{-- @can('forceDelete', App\Models\Group::class) --}}
                                            <button type="submit" class="btn btn-sm btn-icon btn-secondary"
                                                onclick="return confirm('Bạn chắc chắn muốn xóa?')"><i
                                                    class="far fa-trash-alt"></i></button>
                                            {{-- {{-- @endcan --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody><!-- /tbody -->
                    </table>
                    {{ $groups->onEachSide(5)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
