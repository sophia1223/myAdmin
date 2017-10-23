<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/19
 * Time: 11:56
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller {
    
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin', $username;
    
    /**
     * LoginController constructor.
     */
    public function __construct() {
        $this->middleware('guest:admin', ['except' => 'logout']);
        $this->username = config('admin.global.username');
    }
    
    /**
     * 获取登录页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm() {
        return view('admin.auth.login');
    }
    
    public function username() {
        return 'username';
    }
    
    /**
     * @return mixed
     */
    protected function guard() {
        return auth()->guard('admin');
    }
    
    /**
     * 退出登录
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        
        return redirect('admin/login');
    }
}