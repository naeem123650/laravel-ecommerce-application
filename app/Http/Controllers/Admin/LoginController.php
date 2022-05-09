<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\AdminLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(AdminLoginRequest $request)
    {

        try{
            if(Auth::guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ],$request->get('rememberme'))){
                return redirect()->route('admin.dashboard');
            }

            return back()->withInput($request->only('email','rememberme'));

        } catch (\Exception $e) {
            return $this->responseRedirectBack($e->getMessage(),"error");
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            return redirect()->route('admin.login');
        } catch (\Exception $e) {
            return $this->responseRedirectBack($e->getMessage(),"error");
        }

    }
}
