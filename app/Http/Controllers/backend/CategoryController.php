<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $key                    = $request->key ?? '';
        $id                     = $request->id ?? '';
        $name                   = $request->name ?? '';
        $status                   = $request->status ?? '';
        // thực hiện query
        $query = Category::query(true);
        $query->orderBy('id', 'DESC');
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%')->where('deleted_at', '=', null);
        }
        if ($status) {
            $query->where('status', 'LIKE', '%' . $status . '%')->where('deleted_at', '=', null);
        }
        if ($id) {
            $query->where('id', $id)->where('deleted_at', '=', null);
        }
        if ($key) {
            $query->orWhere('id', $key)->where('deleted_at', '=', null);
            $query->orWhere('name', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
        }
        //Phân trang
        $categories = $query->where('deleted_at', '=', null)->paginate(5);

        $params = [
            'f_id'           => $id,
            'f_name'         => $name,
            'f_key'          => $key,
            'categories'         => $categories,
            'status'    => $status,
        ];
        return view('backend.categories.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        return view('backend.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $categories = new Category();
        $categories->name = $request->input('name');
        try {
            $categories->save();
            Session::flash('success', 'Tạo mới thành công');
            //tao moi xong quay ve trang danh sach task
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('categories.index')->with('error', 'Tạo mới không thành công');
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
        $categories = Category::findOrFail($id);
        // $this->authorize('update', categorie::class);

        return view('backend.categories.edit', compact('categories'));
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
        $categories = Category::findOrFail($id);
        $categories->name = $request->input('name');
        try {
            $categories->save();
            //dung session de dua ra thong bao
            Session::flash('success', 'Cập nhật thành công');
            //tao moi xong quay ve trang danh sach product
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('categories.index')->with('error', 'cập nhật không thành công');
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
        try {
            Category::findOrFail($id)->delete();
            Session::flash('success', 'Xóa thanh công');
            return redirect()->route('categories.trash');
        } catch (\Exception $e) {

            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('categories.trash')->with('error', 'xóa không thành công');
        }
    
    }

    public function trashedItems(Request $request){
        $key        = $request->key ?? '';
        $name         = $request->name ?? '';
        $id         = $request->id ?? '';


        // thực hiện query
        $query = Category::query(true);
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%')->where('deleted_at', '!=', null);
        }
        if ($id) {
            $query->where('id', $id)->where('deleted_at', '!=', null);
        }
        if ($key) {
            $query->orWhere('id', $key)->where('deleted_at', '!=', null);
            $query->orWhere('name', 'LIKE', '%' . $key . '%')->where('deleted_at', '!=', null);
        }
        $categories = $query->where('deleted_at', '!=', null)->paginate(5);

        $params = [
            'f_id'        => $id,
            'f_name' => $name,
            'f_key'       => $key,
            'categories'    => $categories,
        ];
        return view('backend.categories.trash', $params);
     }

     public function force_destroy($id)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $categories = Category::findOrFail($id);
        // $this->authorize('forceDelete',Category::class);

        $categories->deleted_at = date("Y-m-d h:i:s");
        try {
            $categories->save();
            Session::flash('success', 'Đã chuyển vào thùng rác');
            return redirect()->route('categories.index');
        } catch (\Exception $e) {

            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('categories.index')->with('error', 'xóa không thành công');
        }

    }

    public function restore($id)
    {
        $categories = Category::findOrFail($id);
        // $this->authorize('restore',Category::class);
        $categories->deleted_at = null;
        try {
            $categories->save();
            Session::flash('success', 'Khôi phục thành công');
            return redirect()->route('categories.trash');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('categories.trash')->with('error', 'xóa không thành công');
        }
    }

    public function showStatus($id){

        $categories = Category::findOrFail($id);
        $categories->status = '1';
        if ($categories->save()) {
            return redirect()->back();
        }
    }
    public function hideStatus($id){

        $categories = Category::findOrFail($id);
        $categories->status = '0';
        if ($categories->save()) {
            return redirect()->back();
        }
    }
}
