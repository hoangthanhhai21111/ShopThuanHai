<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $key                    = $request->key ?? '';
        $id                     = $request->id ?? '';
        $name                   = $request->name ?? '';
        $phone                   = $request->phone ?? '';
        // thực hiện query
        $query = Customer::select('*');
        $query->orderBy('id', 'DESC');
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%')->where('deleted_at', '=', null);
        }
        if ($phone) {
            $query->where('phone', 'LIKE', '%' . $phone . '%')->where('deleted_at', '=', null);
        }
        if ($id) {
            $query->where('id', $id)->where('deleted_at', '=', null);
        }
        if ($key) {
            $query->orWhere('id', $key)->where('deleted_at', '=', null);
            $query->orWhere('name', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
            $query->orWhere('phone', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
        }
        //Phân trang
        $customers = $query->where('deleted_at', '=', null)->paginate(5);

        $params = [
            'f_id'           => $id,
            'f_name'         => $name,
            'f_key'          => $key,
            'customers'         => $customers,
            'phone'    => $phone,
        ];
        return view('backend.customers.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::get();
        return view('backend.customers.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customers = new Customer();
        $customers->name = $request->name;
        $customers->email = $request->email;
        $customers->phone = $request->phone;
        $customers->password = $request->password;
       

        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $fileExtension = $file->getClientOriginalExtension(); //jpg,png lấy ra định dạng file và trả về
            $fileName = time(); //45678908766 tạo tên file theo thời gian
            $newFileName = $fileName . '.' . $fileExtension; //45678908766.jpg
            $path = 'storage/' . $request->file('avatar')->store('avatar', 'public'); //lưu file vào mục public/avatars với tê mới là $newFileName
            $customers->avatar = $path;
        }

        try {
            $customers->save();
            Session::flash('success', 'Tạo mới thành công');
            //tao moi xong quay ve trang danh sach task
            return redirect()->route('customers.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('customers.index')->with('error', 'Tạo mới không thành công');
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
        $customers = Customer::findOrFail($id);
        // $this->authorize('update', categorie::class);

        return view('backend.customers.edit', compact('customers'));
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
        $customers = Customer::findOrFail($id);
        $customers->name = $request->name;
        $customers->email = $request->email;
        $customers->phone = $request->phone;
        $customers->password = $request->password;
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $fileExtension = $file->getClientOriginalExtension(); //jpg,png lấy ra định dạng file và trả về
            $fileName = time(); //45678908766 tạo tên file theo thời gian
            $newFileName = $fileName . '.' . $fileExtension; //45678908766.jpg
            $path = 'storage/' . $request->file('avatar')->store('avatar', 'public'); //lưu file vào mục public/avatars với tê mới là $newFileName
            $customers->avatar = $path;
        }
        try {
            $customers->save();
            //dung session de dua ra thong bao
            Session::flash('success', 'Cập nhật thành công');
            //tao moi xong quay ve trang danh sach product
            return redirect()->route('customers.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('customers.index')->with('error', 'cập nhật không thành công');
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
        $customers = Customer::onlyTrashed()->findOrFail($id);
        try {
            $customers->forceDelete();
            Session::flash('success', 'Xóa thanh công');
            return redirect()->route('customers.trash');
        } catch (\Exception $e) {

            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('customers.trash')->with('error', 'xóa không thành công');
        }
    
    }

    public function trashedItems(Request $request){
        $key                    = $request->key ?? '';
        $id                     = $request->id ?? '';
        $name                   = $request->name ?? '';
        $phone                   = $request->phone ?? '';
        // thực hiện query
        $query = Customer::onlyTrashed();
        $query->orderBy('id', 'DESC');
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
        if ($phone) {
            $query->where('phone', 'LIKE', '%' . $phone . '%');
        }
        if ($id) {
            $query->where('id', $id);
        }
        if ($key) {
            $query->orWhere('id', $key);
            $query->orWhere('name', 'LIKE', '%' . $key . '%');
            $query->orWhere('phone', 'LIKE', '%' . $key . '%');
        }
        //Phân trang
        $customers = $query->paginate(5);

        $params = [
            'f_id'           => $id,
            'f_name'         => $name,
            'f_key'          => $key,
            'phone'    => $phone,
            'customers'         => $customers,
        ];
        return view('backend.customers.trash', $params);
     }

     public function force_destroy($id)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $customers = Customer::findOrFail($id);
        // $this->authorize('forceDelete',Category::class);

        $customers->deleted_at = date("Y-m-d h:i:s");
        try {
            $customers->save();
            Session::flash('success', 'Đã chuyển vào thùng rác');
            return redirect()->route('customers.index');
        } catch (\Exception $e) {

            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('customers.index')->with('error', 'xóa không thành công');
        }

    }

    public function restore($id)
    {
        $customers = Customer::findOrFail($id);
        // $this->authorize('restore',Category::class);
        $customers->deleted_at = null;
        try {
            $customers->save();
            Session::flash('success', 'Khôi phục thành công');
            return redirect()->route('customers.trash');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('customers.trash')->with('error', 'xóa không thành công');
        }
    }

    public function showStatus($id){

        $customers = Customer::findOrFail($id);
        $customers->status = '1';
        if ($customers->save()) {
            return redirect()->back();
        }
    }
    public function hideStatus($id){

        $customers = Customer::findOrFail($id);
        $customers->status = '0';
        if ($customers->save()) {
            return redirect()->back();
        }
    }
}
