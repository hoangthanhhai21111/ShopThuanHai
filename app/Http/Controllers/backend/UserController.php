<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        //Lấy params trên url
        $key                    = $request->key ?? '';
        $name                   = $request->name ?? '';
        $id                     = $request->id ?? '';
        $email                  = $request->email  ?? '';
        // thực hiện query
        $query = User::select('*');
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
        if ($email) {
            $query->where('email', 'LIKE', '%' . $email . '%');
        }
        if ($id) {
            $query->where('id', $id);
        }
        if ($key) {
            $query->orWhere('id', $key);
            $query->orWhere('name', 'LIKE', '%' . $key . '%');
            $query->orWhere('email', 'LIKE', '%' . $key . '%');
        }
        //Phân trang
        $users = $query->paginate(5);


        $params = [
            'f_id'           => $id,
            'f_name'         => $name,
            'f_key'          => $key,
            'f_email'        => $email,
            'users'          => $users
        ];
        return view('backend.users.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $groups = Group::get();
        return view('backend.users.add', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all)
        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $users->password = bcrypt('admin');
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $fileExtension = $file->getClientOriginalExtension(); //jpg,png lấy ra định dạng file và trả về
            $fileName = time(); //45678908766 tạo tên file theo thời gian
            $newFileName = $fileName . '.' . $fileExtension; //45678908766.jpg
            $path = 'storage/' . $request->file('avatar')->store('avatar', 'public'); //lưu file vào mục public/images với tê mới là $newFileName
            $users->avatar = $path;
        }
        $users->group_id = $request->group_id;
        $users->address = $request->address;
        try {
            $users->save();
            Session::flash('success', 'Thêm mới thành công');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'Thêm mới thất bại');
            return redirect()->route('users.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::findOrFail($id);
        $groups = Group::get();
        $this->authorize('update', $users);
        return view('backend.users.edit', compact('users','groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $users = User::find($id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $users->password = bcrypt('admin');
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $fileExtension = $file->getClientOriginalExtension(); //jpg,png lấy ra định dạng file và trả về
            $fileName = time(); //45678908766 tạo tên file theo thời gian
            $newFileName = $fileName . '.' . $fileExtension; //45678908766.jpg
            $path = 'storage/' . $request->file('avatar')->store('avatar', 'public'); //lưu file vào mục public/images với tê mới là $newFileName
            $users->avatar = $path;
        }
        $users->group_id = $request->group_id;
        $users->address = $request->address;
        try {
            $users->save();
            Session::flash('success', 'Cập nhật thành công');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'Cập nhật thất bại');
            return redirect()->route('users.index');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // $this->authorize('delete',User::class);
        try {
            $users = User::withTrashed()->findOrFail($id);
            $image = str_replace('storage', 'public', $users->avatar);
            Storage::delete($image);
            $users->forceDelete();
            Session::flash('success', 'Xóa thành công');
            return redirect()->route('users.trash');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'Xóa thất bại');
            return redirect()->route('users.trash');
        }
    }
    function RestoreDelete($id)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $users = User::withTrashed()->findOrFail($id);
        $this->authorize('restore', User::class);
        $users->deleted_at = null;
        try {
            $users->save();
            Session::flash('success', 'Khôi phục ' . $users->title . ' thành công');
            return redirect()->route('users.trash');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('users.trash')->with('error', 'Khôi phục thành công');
        }
    }
    function softDelete($id)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $users = User::findOrFail($id);
        $this->authorize('forceDelete', $users);
        $users->deleted_at = date("Y-m-d h:i:s");
        try {
            $users->save();
            Session::flash('success', 'Xóa Thành công');
            return redirect()->route('users.index');
        } catch (\Exception $e) {

            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('users.index')->with('error', 'xóa không thành công');
        }
    }
    function trash(Request $request)
    {
        $key                    = $request->key ?? '';
        $name                   = $request->name ?? '';
        $id                     = $request->id ?? '';
        $email                  = $request->email  ?? '';
        // thực hiện query
        $query = User::onlyTrashed();

        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
        if ($email) {
            $query->where('email', 'LIKE', '%' . $email . '%');
        }
        if ($id) {
            $query->where('id', $id);
        }
        if ($key) {
            $query->orWhere('id', $key);
            $query->orWhere('name', 'LIKE', '%' . $key . '%');
            $query->orWhere('email', 'LIKE', '%' . $key . '%');
        }
        //Phân trang
        $users = $query->paginate(5);
        $params = [
            'f_id'           => $id,
            'f_name'         => $name,
            'f_key'          => $key,
            'f_email'        => $email,
            'users'          => $users
        ];
        return view('backend.users.trash', $params);
    }

}
