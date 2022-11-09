<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          //Lấy params trên url
          $key                    = $request->key ?? '';
          $name                   = $request->name ?? '';
          $id                     = $request->id ?? '';
          $description            = $request->description ?? '';
          // thực hiện query
          $query = Group::query(true);
          // $query->orderBy('id', 'DESC');
          if ($name) {
              $query->where('name', 'LIKE', '%' . $name . '%')->where('deleted_at', '=', null);
          }
          if ($description) {
              $query->where('description', 'LIKE', '%' . $description . '%')->where('deleted_at', '=', null);
          }
          if ($id) {
              $query->where('id', $id)->where('deleted_at', '=', null);
          }
          if ($key) {
              $query->orWhere('id', $key)->where('deleted_at', '=', null);
              $query->orWhere('name', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
          }
          //Phân trang
          $groups = $query->where('deleted_at', '=', null)->paginate(3);

          $params = [
              'f_id'           => $id,
              'f_name'         => $name,
              'f_key'          => $key,
              'groups'         => $groups,
              'description'    => $description,
          ];
          return view('backend.groups.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('backend.groups.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $groups = new Group();
        $groups->name = $request->name;
        $groups->description = $request->description;

        try {
            $groups->save();
            //dung session de dua ra thong bao
            Session::flash('success', 'Tạo mới thành công');
            return redirect()->route('groups.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'Thêm không thành công');
            return redirect()->route('groups.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::find($id);
        $roles = Role::all()->toArray();
        $userRoles = $group->roles->pluck('id', 'name')->toArray();
        $group_names = [];
        foreach ($roles as $role) {
            $group_names[$role['group_name']][] = $role;
        }
        $params = [
            'group' => $group,
            'userRoles' => $userRoles,
            'group_names' => $group_names
        ];
        return view('backend.groups.edit', $params);
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
        $group = Group::findOrFail($id);
        $group->name = $request->name;
        $group->description = $request->description;
        // dd($request->all());
        try {
            $group->save();
             //detach xóa hết tất cả các record của bảng trung gian hiện tại
             $group->roles()->detach();
             //attach cập nhập các record của bảng trung gian hiện tại
             $group->roles()->attach($request->roles);
            //dung session de dua ra thong bao
            Session::flash('success', 'Cập nhật thành công');
            return redirect()->route('groups.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('groups.index')->with('error', 'Cập nhật' . ' ' . $request->name . ' ' .  ' không thành công');
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
        $group = Group::findOrFail($id);

        try {
            $group->delete();
            Session::flash('success', 'Xóa '.$group->name.' thành công');
            return redirect()->route('groups.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'Xóa không thành công');
            return redirect()->route('groups.index');
        }
    }
}
