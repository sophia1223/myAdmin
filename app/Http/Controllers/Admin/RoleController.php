<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/12
 * Time: 10:28
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Services\RoleService;
use Illuminate\Support\Facades\Request;

class RoleController extends Controller
{
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }
    
    /**
     * 角色管理
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->service->dataTable());
        }
        return viewResponse('admin.role.index');
    }
    
    /**
     * 创建角色
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $permissions = $this->service->getPermissions();
        return viewResponse('admin.role.create',['permissions' => $permissions]);
    }
    
    /**
     * 保存角色
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        return $this->service->save($request->all());
    }
    
    /**
     * 编辑角色
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $role = $this->service->find($id);
        if (!$role) {
            return jsonResponse('error',404);
        }
        $permissions = $this->service->getPermissions($id);
        return viewResponse('admin.role.edit',['role' => $role,'permissions' => $permissions]);
    }
    
    /**
     * 更新角色
     *
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request,$id)
    {
        return $this->service->save($request->all(),$id);
    }
    
    /**
     * 删除角色
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->service->deleted($id);
    }
    
}