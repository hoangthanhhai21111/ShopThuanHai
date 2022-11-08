<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::get();
        // $products = Product::orderBy('created_at', 'DESC')->search()->paginate(4);
        // $this->authorize('viewAny', Product::class);
        // dd(12456);
        // return view('backend.products.index', compact('products'));
        $key        = $request->key ?? '';
        $name      = $request->name ?? '';
        $amount      = $request->amount ?? '';
        $price      = $request->price ?? '';
        $category_id      = $request->category_id ?? '';
        $brand_id      = $request->brand_id ?? '';
        $id         = $request->id ?? '';

        $categories = Category::all();
        $brands = Brand::all();

        // thực hiện query
        $query = Product::query(true);
        $query->orderBy('id', 'DESC');
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%')->where('deleted_at', '=', null);
        }
        if ($amount) {
            $query->where('amount', 'LIKE', '%' . $amount . '%')->where('deleted_at', '=', null);
        }
        if ($price) {
            $query->where('price', 'LIKE', '%' . $price . '%')->where('deleted_at', '=', null);
        }
        if ($category_id) {
            $query->where('category_id', 'LIKE', '%' . $category_id . '%')->where('deleted_at', '=', null);
        }
        if ($brand_id) {
            $query->where('brand_id', 'LIKE', '%' . $brand_id . '%')->where('deleted_at', '=', null);
        }
        if ($id) {
            $query->where('id', $id)->where('deleted_at', '=', null);
        }
        if ($key) {
            $query->orWhere('id', $key)->where('deleted_at', '=', null);
            $query->orWhere('name', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
            $query->orWhere('amount', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
            $query->orWhere('category_id', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
            $query->orWhere('brand_id', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
            $query->orWhere('price', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
        }
        $products = $query->where('deleted_at', '=', null)->paginate(5);

        $params = [
            'f_id'        => $id,
            'f_name' => $name,
            'f_amount'     => $amount,
            'f_price'     => $price,
            'f_category_id'     => $category_id,
            'f_brand_id'     => $brand_id,
            'f_key'       => $key,
            'products'    => $products,
            'categories'     => $categories,
            'brands'  => $brands
        ];
        return view('backend.products.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('create', Banner::class);
        // $products = Product::get();
        // return view('backend.products.create', compact('products'));
        $categories = Category::all()->where('deleted_at','=',null);
        $brands = Brand::all()->where('deleted_at','=',null);
        return view('backend.products.create', compact('categories','brands'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $products = new Product();
        $products->name = $request->input('name');
        $products->amount = $request->input('amount');
        $products->price = $request->input('price');
        $products->description = $request->input('description');
        $products->category_id = $request->input('category_id');
        $products->brand_id = $request->input('brand_id');
        if ($request->hasFile('image')) {
            $file = $request->image;
            $fileExtension = $file->getClientOriginalExtension(); //jpg,png lấy ra định dạng file và trả về
            $fileName = time(); //45678908766 tạo tên file theo thời gian
            $newFileName = $fileName . '.' . $fileExtension; //45678908766.jpg
            $path = 'storage/' . $request->file('image')->store('image', 'public'); //lưu file vào mục public/images với tê mới là $newFileName
            $products->image = $path;
        }
        try {
            $products->save();
            Session::flash('success', 'Tạo mới thành công');
            //tao moi xong quay ve trang danh sach task
            return redirect()->route('products.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('products.index')->with('error', 'Tạo mới không thành công');
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
        $products = Product::findOrFail($id);
        return view('backend.products.show',compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // $this->authorize('update', Banner::class);
        $categories = Category::get();
        $brands =  Brand::get();
        $products = Product::findOrFail($id);

        return view('backend.products.edit', compact('products','categories','brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {

        $products = Product::findOrFail($id);
        $products->name = $request->input('name');
        $products->amount = $request->input('amount');
        $products->price = $request->input('price');
        $products->description = $request->input('description');
        $products->category_id = $request->input('category_id');
        $products->brand_id = $request->input('brand_id');
        if ($request->hasFile('image')) {
            $file = $request->image;
            $fileExtension = $file->getClientOriginalExtension(); //jpg,png lấy ra định dạng file và trả về
            $fileName = time(); //45678908766 tạo tên file theo thời gian
            $newFileName = $fileName . '.' . $fileExtension; //45678908766.jpg
            $path = 'storage/' . $request->file('image')->store('image', 'public'); //lưu file vào mục public/images với tê mới là $newFileName
            $products->image = $path;
        }
        try {
            $products->save();
            //dung session de dua ra thong bao
            Session::flash('success', 'Cập nhật thành công');
            //tao moi xong quay ve trang danh sach product
            return redirect()->route('products.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('products.index')->with('error', 'cập nhật không thành công');
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
        $products = Product::onlyTrashed()->findOrFail($id);
        // $this->authorize('delete', Banner::class);


        // $brands = Brand::findOrFail($id);
      

        try {
            // $logo = str_replace('storage', 'public', $products->logo);;
            // Storage::delete($logo);
            $products->forceDelete();
            //dung session de dua ra thong bao
            Session::flash('success', 'Xóa Thành công');
            //xoa xong quay ve trang danh sach banners
            return redirect()->route('products.trash');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('products.trash')->with('error', 'Xóa không thành công');
        }
    }

    public function trashedItems(Request $request){
        $key        = $request->key ?? '';
        $name      = $request->name ?? '';
        $amount      = $request->amount ?? '';
        $price      = $request->price ?? '';
        $category_id      = $request->category_id ?? '';
        $brand_id      = $request->brand_id ?? '';
        $id         = $request->id ?? '';

        $categories = Category::all();
        $brands = Brand::all();

        // thực hiện query
        $query = Product::onlyTrashed();
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
        if ($amount) {
            $query->where('amount', 'LIKE', '%' . $amount . '%');
        }
        if ($price) {
            $query->where('price', 'LIKE', '%' . $price . '%');
        }
        if ($category_id) {
            $query->where('category_id', 'LIKE', '%' . $category_id . '%');
        }
        if ($brand_id) {
            $query->where('brand_id', 'LIKE', '%' . $brand_id . '%');
        }
        if ($id) {
            $query->where('id', $id);
        }
        if ($key) {
            $query->orWhere('id', $key);
            $query->orWhere('name', 'LIKE', '%' . $key . '%');
            $query->orWhere('amount', 'LIKE', '%' . $key . '%');
            $query->orWhere('category_id', 'LIKE', '%' . $key . '%');
            $query->orWhere('brand_id', 'LIKE', '%' . $key . '%');
            $query->orWhere('price', 'LIKE', '%' . $key . '%');
        }
        $products = $query->paginate(10);

        $params = [
            'f_id'        => $id,
            'f_name' => $name,
            'f_amount'     => $amount,
            'f_price'     => $price,
            'f_category_id'     => $category_id,
            'f_brand_id'     => $brand_id,
            'f_key'       => $key,
            'products'    => $products,
            'categories'     => $categories,
            'brands'  => $brands
        ];
        return view('backend.products.trash', $params);
     }

     public function force_destroy($id)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $products = Product::findOrFail($id);
        // $this->authorize('forceDelete',Product::class);

        $products->deleted_at = date("Y-m-d h:i:s");
        try {
            $products->save();
            Session::flash('success', 'Đã chuyển vào thùng rác');
            return redirect()->route('products.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('products.index')->with('error', 'xóa không thành công');
        }
        

    }

    public function restore($id)
    {
        $products = Product::withTrashed()->findOrFail($id);
        // $this->authorize('restore',Banner::class);
        $products->deleted_at = null;
        try {
            $products->save();
            Session::flash('success', 'Khôi phục thành công');
            return redirect()->route('products.trash');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('products.trash')->with('error', 'xóa không thành công');
        }
    }
    public function showStatus($id){

        $products = Product::findOrFail($id);
        $products->status = '1';
        if ($products->save()) {
            return redirect()->back();
        }
    }
    public function hideStatus($id){

        $products = Product::findOrFail($id);
        $products->status = '0';
        if ($products->save()) {
            return redirect()->back();
        }
    }
   
}
