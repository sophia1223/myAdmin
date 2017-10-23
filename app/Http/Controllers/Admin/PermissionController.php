<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/12
 * Time: 10:48
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PermissionService;

class PermissionController extends Controller
{
    protected $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }
    
    /**
     * 自动添加功能
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param int $cid
     */
    public function set()
    {
        return $this->service->set();
    }
    
}