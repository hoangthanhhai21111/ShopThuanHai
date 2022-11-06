<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // $orders = Order::get();
        // $orders = Product::orderBy('created_at', 'DESC')->search()->paginate(4);
        // $this->authorize('viewAny', Product::class);
        // dd(12456);
        // return view('backend.orders.index', compact('orders'));
        $key        = $request->key ?? '';
        $note      = $request->note ?? '';
        $address      = $request->address ?? '';
        $order_total_price      = $request->order_total_price ?? '';
        $customer_id      = $request->customer_id ?? '';
        $id         = $request->id ?? '';

        // $categories = Category::all();
        $customers = Customer::all();

        // thực hiện query
        $query = Order::select('*');
        $query->orderBy('id', 'DESC');
        if ($note) {
            $query->where('note', 'LIKE', '%' . $note . '%')->where('deleted_at', '=', null);
        }
        if ($address) {
            $query->where('address', 'LIKE', '%' . $address . '%')->where('deleted_at', '=', null);
        }
        if ($order_total_price) {
            $query->where('order_total_price', 'LIKE', '%' . $order_total_price . '%')->where('deleted_at', '=', null);
        }
        if ($customer_id) {
            $query->where('customer_id', 'LIKE', '%' . $customer_id . '%')->where('deleted_at', '=', null);
        }
       
        if ($id) {
            $query->where('id', $id)->where('deleted_at', '=', null);
        }
        if ($key) {
            $query->orWhere('id', $key)->where('deleted_at', '=', null);
            $query->orWhere('note', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
            $query->orWhere('address', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
            $query->orWhere('customer_id', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
            $query->orWhere('order_total_price', 'LIKE', '%' . $key . '%')->where('deleted_at', '=', null);
        }
        $orders = $query->where('deleted_at', '=', null)->paginate(5);

        $params = [
            'f_id'        => $id,
            'f_note' => $note,
            'f_address'     => $address,
            'f_order_total_price'     => $order_total_price,
            'f_customer_id'     => $customer_id,
            'f_key'       => $key,
            'orders'    => $orders,
            'customers'  => $customers
        ];
        return view('backend.orders.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('create', Banner::class);
        // $orders = Product::get();
        // return view('backend.orders.create', compact('orders'));
        // $categories = Category::all()->where('deleted_at','=',null);
        $customers = Customer::all()->where('deleted_at','=',null);
        return view('backend.orders.create', compact('customers'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orders = new Order();
        $orders->note = $request->input('note');
        $orders->address = $request->input('address');
        $orders->order_total_price = $request->input('order_total_price');
        $orders->customer_id = $request->input('customer_id');
        try {
            $orders->save();
            Session::flash('success', 'Tạo mới thành công');
            //tao moi xong quay ve trang danh sach task
            return redirect()->route('orders.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('orders.index')->with('error', 'Tạo mới không thành công');
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
        $order = Order::findOrFail($id);
        $order_details = $order->order_details;
        $customers=$order->customers;
        $params = [
            'order' => $order,
            'order_details' => $order_details,
            'customers' => $customers
        ];
        return view('backend.orders.show', $params);
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
        // $categories = Category::get();
        $customers =  Customer::get();
        $orders = Order::findOrFail($id);

        return view('backend.orders.edit', compact('orders','customers'));
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

        $orders = Order::findOrFail($id);
        $orders->note = $request->input('note');
        $orders->address = $request->input('address');
        $orders->order_total_price = $request->input('order_total_price');
        $orders->customer_id = $request->input('customer_id');
        try {
            $orders->save();
            //dung session de dua ra thong bao
            Session::flash('success', 'Cập nhật thành công');
            //tao moi xong quay ve trang danh sach product
            return redirect()->route('orders.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('orders.index')->with('error', 'cập nhật không thành công');
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
        $orders = Order::findOrFail($id);
        // $this->authorize('delete', Banner::class);
        try {
            // $logo = str_replace('storage', 'public', $orders->logo);;
            // Storage::delete($logo);
            $orders->Delete();
            //dung session de dua ra thong bao
            Session::flash('success', 'Xóa Thành công');
            //xoa xong quay ve trang danh sach banners
            return redirect()->route('orders.trash');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('orders.trash')->with('error', 'Xóa không thành công');
        }
    }

    public function trashedItems(Request $request){
        $key        = $request->key ?? '';
        $note      = $request->note ?? '';
        $address      = $request->address ?? '';
        $order_total_price      = $request->order_total_price ?? '';
        $customer_id      = $request->customer_id ?? '';
        $id         = $request->id ?? '';

        // $categories = Category::all();
        $customers = Customer::all();

        // thực hiện query
        $query = Order::select('*');
        if ($note) {
            $query->where('note', 'LIKE', '%' . $note . '%');
        }
        if ($address) {
            $query->where('address', 'LIKE', '%' . $address . '%');
        }
        if ($order_total_price) {
            $query->where('order_total_price', 'LIKE', '%' . $order_total_price . '%');
        }
        if ($customer_id) {
            $query->where('customer_id', 'LIKE', '%' . $customer_id . '%');
        }
       
        if ($id) {
            $query->where('id', $id);
        }
        if ($key) {
            $query->orWhere('id', $key);
            $query->orWhere('note', 'LIKE', '%' . $key . '%');
            $query->orWhere('address', 'LIKE', '%' . $key . '%');
            $query->orWhere('customer_id', 'LIKE', '%' . $key . '%');
            $query->orWhere('order_total_price', 'LIKE', '%' . $key . '%');
        }
        $orders = $query->paginate(10);

        $params = [
            'f_id'        => $id,
            'f_note' => $note,
            'f_address'     => $address,
            'f_order_total_price'     => $order_total_price,
            'f_customer_id'     => $customer_id,
            'f_key'       => $key,
            'orders'    => $orders,
            'customers'  => $customers
        ];
        return view('backend.orders.trash', $params);
     }

     public function force_destroy($id)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $orders = Order::findOrFail($id);
        // $this->authorize('forceDelete',Product::class);

        $orders->deleted_at = date("Y-m-d h:i:s");
        try {
            $orders->save();
            Session::flash('success', 'Đã chuyển vào thùng rác');
            return redirect()->route('orders.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('orders.index')->with('error', 'xóa không thành công');
        }
    }

    public function restore($id)
    {
        $orders = Order::findOrFail($id);
        // $this->authorize('restore',Banner::class);
        $orders->deleted_at = date("Y-m-d h:i:s");
        $orders->save();
        try {
            Session::flash('success', 'Khôi phục thành công');
            return redirect()->route('orders.trash');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'xóa thất bại ');
            return redirect()->route('orders.trash')->with('error', 'xóa không thành công');
        }
    }
    // public function restore($id)
    // {
    //     $orders = Order::withTrashed()->findOrFail($id);
    //     // $this->authorize('restore', Order::class);

    //     $orders->deleted_at = null;
    //     try {
    //         $orders->save();
    //         Session::flash('success', 'Khôi phục thành công');
    //         return redirect()->route('orders.trash');
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         Session::flash('error', 'xóa thất bại ');
    //         return redirect()->route('orders.trash')->with('error', 'xóa không thành công');
    //     }
    // }
}
