<?php

/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/18
 * Time: 12:15
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetPasswordRequest;
use App\Services\AdminService;
use App\Services\MenuService;

class DashboardController extends Controller
{
    protected $menuService, $adminService;
    
    /**
     * DashboardController constructor.
     * @param MenuService $menuService
     * @param AdminService $adminService
     */
    public function __construct(MenuService $menuService, AdminService $adminService)
    {
        $this->middleware('auth.admin:admin');
        $this->menuService = $menuService;
        $this->adminService = $adminService;
    }

    /**
     * 后台首页
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'route'    => session('route')?:'index',
            'user'     => auth('admin')->user(),
            'menus'    => $this->menuService->getMenuList(false)
        ];
        return view('admin.dashboard.index', $data);
    }
    
    /**
     * 修改用户密码
     *
     * @param SetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(SetPasswordRequest $request)
    {
        $newPassword = $request->input('newPassword');
        $password = $request->input('password');

        return $this->adminService->updatePassword($password, $newPassword);
    }
    
}