<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();
        $banners = Banner::all();
        $param = [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'banners' => $banners,
        ];
        return view('front-end.homes.index', $param);
    }
    public function cart()
    {
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();
        $banners = Banner::all();
        $param = [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'banners' => $banners,
        ];
        return view('front-end.homes.cart', $param);
    }

    public function order(Request $request)
    {
        if ($request->product_id == null) {
            return redirect()->back();
        } else {
            $id = Auth::guard('customers')->user()->id;
            $data = Customer::find($id);
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->password = $request->password;
            if(isset($request->note))
            {
                $data->note=$request->note;
            }
            $data->save();

            $order = new Order();
            $order->customer_id = Auth::guard('customers')->user()->id;
            $order->date_at = date('Y-m-d H:i:s');
            $order->total = $request->totalAll;
            $order->save();
        }
        try {
            if ($order) {
                $count_product = count($request->product_id);
                for ($i = 0; $i < $count_product; $i++) {
                    $orderItem = new OrderDetail();
                    $orderItem->order_id =  $order->id;
                    $orderItem->product_id = $request->product_id[$i];
                    $orderItem->quantity = $request->quantity[$i];
                    $orderItem->total = $request->total[$i];
                    $orderItem->save();
                    session()->forget('cart');
                    DB::table('products')
                        ->where('id', '=', $orderItem->product_id)
                        ->decrement('quantity', $orderItem->quantity);
                }
                Session::flash('Đặt hàng thành công!', 'success', 'top-right');
                return redirect()->route('shop.index');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session::flash('Đặt hàng thấy bại!', 'error', 'top-right');
            return redirect()->route('shop.index');
        }
    }
    
}
