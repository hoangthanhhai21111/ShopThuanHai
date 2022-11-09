@extends('backend.masster')
@section('content')
    <div class="page-inner">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{route('groups.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang danh sách</a>
                </li>
            </ol>
        </nav>
        <header class="page-title-bar">
            <h1 class="page-title">Sửa nhóm </h1>
        </header>
        <div class="page-section">
            <div class="card-deck-xl">
                <div class="card card-fluid">
                    <div class="card-body">
                        <form action="{{ route('groups.update', $group->id) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label class="control-label" for="flatpickr01">Tên Nhóm</label> <input id="flatpickr01"
                                    type="text" class="form-control" name="name" value="{{$group->name}}" data-toggle="flatpickr">
                            </div>
                            @if ($errors->any())
                            <p style="color:red">{{ $errors->first('name') }}</p>
                            @endif
                            <div class="form-group">
                                <label class="control-label" for="flatpickr01">Mô Tả Nhóm</label> <input id="flatpickr01"
                                    type="text" class="form-control" name="description" value="{{$group->description}}" data-toggle="flatpickr">
                            </div>
                            @if ($errors->any())
                            <p style="color:red">{{ $errors->first('description') }}</p>
                            @endif
                            <div class="form-group">
                                <label for="tf1">Quyền hạn </label>
                                <div class="row">
                                    @foreach ($group_names as $group_name => $roles)
                                    <div class="list-group list-group-flush list-group-bordered col-lg-4" >
                                        <div class="list-group-header"> {{ __($group_name) }} </div>
                                        @foreach ($roles as $role)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ __($role['name']) }}</span>
                                            <!-- .switcher-control -->
                                            <label class="switcher-control">
                                                <input type="checkbox"
                                                @checked( in_array($role['id'],$userRoles) )
                                                name="roles[]" class="switcher-input" value="{{ $role['id'] }}" >
                                                <span class="switcher-indicator"></span>
                                            </label>
                                            <!-- /.switcher-control -->
                                        </div>
                                    @endforeach
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="form-actions">
                                <a class="btn btn-secondary float-right" href="{{route('groups.index')}}">Hủy</a>
                                <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endsection
