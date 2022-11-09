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
            <h1 class="page-title mr-sm-auto">Danh mục nhân viên</h1>
            <div class="btn-toolbar">
                {{-- @can('create', App\Models\category::class) --}}
                <div class="input-group-prepend">
                    <button class="btn btn-secondary" type="button" data-toggle="modal"
                        data-target="#modalFilterColumns">Tìm nâng cao</button>
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
                        <a class="nav-link" href="{{ route('users.trash') }}">Thùng rác</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col">
                        <form action="" method="GET" id="form-search">
                            <div class="input-group input-group-alt">
                                <a href="{{ route('users.create') }}" class="btn btn-primary mr-2">
                                    <i class="fa-solid fa fa-plus"></i>
                                    <span class="ml-1">Thêm Mới</span>
                                </a>

                                @include('backend.users.modals.modalFilterColumns')
                        </form>

                    </div>
                </div>
                <div class="container col-12">
                    @if (!count($users))
                    <p class="text-success">
                    <div class="alert alert-danger"> <i class="bi bi-x-circle"aria-hidden="true"></i>
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
                                <th> Ảnh Đại Diện </th>
                                <th> Tên Nhân Viên </th>
                                <th> Chức Vụ </th>
                                <th> Email </th>
                                <th> Tùy Chọn </th>
                            </tr>
                        </thead><!-- /thead -->
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>
                                        <img class=" image_photo rounded-circle" src="{{ asset($user->avatar) }}"
                                            style="width:75px;height:75px">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->group->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <form action="{{ route('users.softDelete', $user->id) }}" method="post">
                                            {{-- @can('update', App\Models\User::class)
                                            @endcan --}}
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-sm btn-icon btn-secondary"><i
                                                    class="fa fa-pencil-alt"></i></a>
                                            @csrf
                                            @method('PUT')
                                            {{-- @can('forceDelete', App\Models\User::class) --}}
                                            <button type="submit" class="btn btn-sm btn-icon btn-secondary"
                                                onclick="return confirm('Bạn chắc chắn muốn xóa?')"><i
                                                    class="far fa-trash-alt"></i></button>
                                            {{-- @endcan --}}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody><!-- /tbody -->
                    </table>
                    {{-- {{ $groups->onEachSide(5)->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
