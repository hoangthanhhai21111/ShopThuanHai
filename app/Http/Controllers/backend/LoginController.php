<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
    function login(Request $request)
    {
        // return view('backend.login.login');
        if (Auth::check()) {
            return redirect()->route('users.index');
        } else {
            return view('backend.login.login');
        }
    }
    function loginProcessing(request $request)
    {
        // dd($request);
        $arr=[
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::attempt($arr)) {
            // dd($arr);
            return redirect()->route('users.index');
        } else {
            // dd($arr);
            $kq='tài khoản, hoặc mật khẩu không tồn tại';
            return redirect()->route('login')->with($kq);
        }
    }
}
