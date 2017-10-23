<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/20
 * Time: 12:17
 */

namespace App\Services;


use App\Models\Menu;
use App\Facades\DatatableFacade as DataTable;

class MenuService
{
    protected $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }
    
    /**
     * 获取菜单dataTable数据
     *
     * @return array
     */
    public function dataTable() {
        
        $columns = [
            ['db' => 'Menu.id', 'dt' => 0],
            ['db' => 'Menu.name', 'dt' => 1],
            [
                'db' => 'Menu.p_id', 'dt' => 2,
                'formatter' => function ($d) {
                    return $this->menu->where('id',$d)->value('name') ?: '（顶级）';
                }
            ],
            ['db' => 'Permission.name as permissionName', 'dt' => 3],
            ['db' => 'Menu.sort', 'dt' => 4],
            ['db' => 'Menu.created_at', 'dt' => 5],
            ['db' => 'Menu.updated_at', 'dt' => 6],
            [
                'db'        => 'Menu.id as menu_id', 'dt' => 7,
                'formatter' => function ($d) {
                    return DataTable::dtOps($d);
                },
            ],
        ];
        $joins = [
            [
                'table'      => 'permissions',
                'alias'      => 'Permission',
                'type'       => 'LEFT',
                'conditions' => [
                    'Menu.permission_id = Permission.id',
                ],
            ]
        ];
        $where = 'Menu.id in (' . implode(',', $this->getMenuList()) . ')';
        return DataTable::simple($this->menu, $columns, $joins, $where);
    }
    
    /**
     * 获取已授权菜单列表
     *
     * @param bool $ids
     * @return mixed
     */
    public function getMenuList($ids = true) {
        $menusAll = $this->menu->orderBy('sort')->get();
    
        if(!auth('admin')->user()->isSuperAdmin()){
            $permissions = auth('admin')->user()->getAdminPermissions()->pluck('id')->toArray() ?? [];
            $permissionMenuIds = $this->menu->whereIn('permission_id',$permissions)->pluck('id');
            $topIds = $this->getMenuParentAndId($permissionMenuIds);
            $menusAll = $menusAll->reject(function ($val) use ($topIds){
                return !in_array($val->id,$topIds);
            });
        }
        $menusAll = $menusAll->map(function($menu){
            $menu->route = $menu->permission_id == 0 ? 'admin/index/index' : $menu->permissions->route;
            unset($menu->permissions);
            return $menu;
        })->toArray();
        
        if($ids){
            return array_column($menusAll, 'id');
        }
        return arrayTree($menusAll);
        
    }
    
    protected function getMenuParentAndId($ids){
        $menuIds = $this->menu->get()->pluck('p_id','id')->toArray();
        if(is_numeric($ids)){
            $ids = [$ids];
        }
        $topIds = [];
        foreach ($ids as $id){
            $topIds []= $id;
            while ($menuIds[$id]){
                $id = $menuIds[$id];
                $topIds []= $id;
            }
        }
        return $topIds;
    }
    
    public function save($data, $id = 0){
        if($id){
            $menu = $this->menu->find($id);
            if (!$menu) {
                return jsonResponse('error',404);
            }
            if(empty($data['icon'])){
                unset($data['icon']);
            }
            $result =  $menu->update($data);
        }else{
            $result = $this->menu->create($data);
        }
        return $result ? jsonResponse() : jsonResponse('failed',500);
    }
    
    public function find($id){
        return $this->menu->find($id);
    }
    
    public function deleted($id){
        
        if (!$this->menu->find($id)) {
            return jsonResponse('error',404);
        }
        $result = $this->menu->where('id',$id)->delete();
        
        return $result ? jsonResponse('删除成功') : jsonResponse('failed',500);
    }
}