<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/12
 * Time: 10:28
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Services\MenuService;
use Illuminate\Support\Facades\Request;

class MenuController extends Controller
{
    protected $service;

    public function __construct(MenuService $service)
    {
        $this->service = $service;
    }
    
    /**
     * 菜单管理
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->service->dataTable());
        }
        return viewResponse('admin.menu.index');
    }
    
    /**
     * 创建菜单
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return viewResponse('admin.menu.create');
    }
    
    /**
     * 保存菜单
     *
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MenuRequest $request)
    {
        return $this->service->save($request->all());
    }
    
    /**
     * 编辑菜单
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $menu = $this->service->find($id);
        if (!$menu) {
            return jsonResponse('error',404);
        }
        return viewResponse('admin.menu.edit',['menu' => $menu]);
    }
    
    /**
     * 更新菜单
     *
     * @param MenuRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MenuRequest $request,$id)
    {
        return $this->service->save($request->all(),$id);
    }
    
    /**
     * 删除指定的菜单
     * @param $id
     * @return bool|null
     */
    public function destroy($id)
    {
        return $this->service->deleted($id);
    }
    
}