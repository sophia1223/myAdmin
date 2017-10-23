<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/11
 * Time: 12:41
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Services\AdminService;
use Illuminate\Support\Facades\Request;

class AdminController extends Controller
{
    protected $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }
    
    /**
     * 管理员管理
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->service->dataTable());
        }
        return viewResponse('admin.manager.index');
    }
    
    /**
     * 创建管理员
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return viewResponse('admin.manager.create');
    }
    
    /**
     * 保存管理员
     *
     * @param AdminRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdminRequest $request)
    {
        return $this->service->save($request->all());
    }
    
    /**
     * 编辑管理员
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->service->find($id);
        if (!$user) {
            return jsonResponse('error',404);
        }
        return viewResponse('admin.manager.edit',['admin' => $user]);
    }
    
    /**
     * 更新管理员
     *
     * @param AdminRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdminRequest $request,$id)
    {
        return $this->service->save($request->all(),$id);
    }
    
    /**
     * 删除管理员
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->service->deleted($id);
    }

}