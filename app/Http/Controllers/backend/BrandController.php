<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::get();
        // $banners = banner::orderBy('created_at', 'DESC')->search()->paginate(4);
        // return view('backend.brands.index', compact('brands'));
        // $this->authorize('viewAny', Banner::class);

        $key        = $request->key ?? '';
        $name      = $request->name ?? '';
        $id         = $request->id ?? '';


        // thực hiện query
        $query = Brand::select('*');
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%')->where('deleted_at', '=', null);
        }
       
        if ($id) {
            $query->where('id', $id)->where('deleted_at', '=', null);
        }
        if ($key) {
            $query->orWhere('id', $key)->where('deleted_at', '=', null);
            $query->orWhere('name', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
        }
        $brands = $query->where('deleted_at', '=', null)->paginate(5);

        $params = [
            'f_id'        => $id,
            'f_name' => $name,
            'f_key'       => $key,
            'brands'    => $brands,
        ];
        return view('backend.brands.index', $params);
    }

    public function create()
    {
        // $this->authorize('view', Brand::class);
        $brands = Brand::get();
        return view('backend.brands.create', compact('brands'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $request)
    {
        $brands = new Brand();
        $brands->name = $request->name;
       

        if ($request->hasFile('logo')) {
            $file = $request->logo;
            $fileExtension = $file->getClientOriginalExtension(); //jpg,png lấy ra định dạng file và trả về
            $fileName = time(); //45678908766 tạo tên file theo thời gian
            $newFileName = $fileName . '.' . $fileExtension; //45678908766.jpg
            $path = 'storage/' . $request->file('logo')->store('logo', 'public'); //lưu file vào mục public/logos với tê mới là $newFileName
            $brands->logo = $path;
        }

        try {
            $brands->save();
            Session::flash('success', 'Tạo mới thành công');
            //tao moi xong quay ve trang danh sach task
            return redirect()->route('brands.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('brands.index')->with('error', 'Tạo mới không thành công');
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
        $brands = Brand::findOrFail($id);
        // $this->authorize('update', Brand::class);
        return view('backend.brands.edit', compact('brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrandRequest $request, $id)
    {

        $brands = Brand::findOrFail($id);
        $brands->name = $request->name;
       
        if ($request->hasFile('logo')) {
            $file = $request->logo;
            $fileExtension = $file->getClientOriginalExtension(); //jpg,png lấy ra định dạng file và trả về
            $fileName = time(); //45678908766 tạo tên file theo thời gian
            $newFileName = $fileName . '.' . $fileExtension; //45678908766.jpg
            $path = 'storage/' . $request->file('logo')->store('logo', 'public'); //lưu file vào mục public/logos với tê mới là $newFileName
            $brands->logo = $path;
        }

        try {
            $brands->save();
            //dung session de dua ra thong bao
            Session::flash('success', 'Cập nhật thành công');
            //tao moi xong quay ve trang danh sach product
            return redirect()->route('brands.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('brands.index')->with('error', 'cập nhật không thành công');
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
        $brands = Brand::onlyTrashed()->findOrFail($id);
        // $this->authorize('delete', Student::class);

        try {
            $logo = str_replace('storage', 'public', $brands->logo);;
            Storage::delete($logo);
            $brands->forceDelete();
            //dung session de dua ra thong bao
            Session::flash('success', 'Xóa Thành công');
            //xoa xong quay ve trang danh sach banners
            return redirect()->route('brands.trash');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('brands.trash')->with('error', 'Xóa không thành công');
        }
    }

    public function trashedItems(Request $request)
    {
        $key        = $request->key ?? '';
        $name         = $request->name ?? '';
        $id         = $request->id ?? '';


        // thực hiện query
        // $query = Brand::query(true);
        $query = Brand::onlyTrashed();
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
       
        if ($id) {
            $query->where('id', $id);
        }
        if ($key) {
            $query->orWhere('id', $key);
            $query->orWhere('name', 'LIKE', '%' . $key . '%');
        }
        $brands = $query->paginate(5);

        $params = [
            'f_id'        => $id,
            'f_name'     => $name,
            'f_key'       => $key,
            'brands'    => $brands,
        ];
        return view('backend.brands.trash', $params);
    }

    public function force_destroy($id)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $brands = Brand::findOrFail($id);
        // $this->authorize('forceDelete', Brand::class);

        $brands->deleted_at = date("Y-m-d h:i:s");
        try {
            $brands->save();
            Session::flash('success', 'Đã chuyển vào thùng rác');
            return redirect()->route('brands.index');
        } catch (\Exception $e) {

            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('brands.index')->with('error', 'xóa không thành công');
        }
    }

    public function restore($id)
    {
        $brands = Brand::withTrashed()->findOrFail($id);
        // $this->authorize('restore', Student::class);

        $brands->deleted_at = null;
        try {
            $brands->save();
            Session::flash('success', 'Khôi phục thành công');
            return redirect()->route('brands.trash');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('brands.trash')->with('error', 'xóa không thành công');
        }
    }

    public function showStatus($id){

        $brands = Brand::findOrFail($id);
        $brands->status = '1';
        if ($brands->save()) {
            return redirect()->back();
        }
    }
    public function hideStatus($id){

        $brands = Brand::findOrFail($id);
        $brands->status = '0';
        if ($brands->save()) {
            return redirect()->back();
        }
    }
}
