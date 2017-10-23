<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/20
 * Time: 12:17
 */

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use App\Facades\DatatableFacade as DataTable;

class RoleService
{
    protected $role,$permission;

    public function __construct(Role $role,Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }
    
    /**
     * 获取菜单dataTable数据
     * @return array
     */
    public function dataTable() {
        
        $columns = [
            ['db' => 'Role.id', 'dt' => 0],
            ['db' => 'Role.name', 'dt' => 1],
            ['db' => 'Role.label', 'dt' => 2],
            ['db' => 'Role.description', 'dt' => 3],
            ['db' => 'Role.created_at', 'dt' => 4],
            ['db' => 'Role.updated_at', 'dt' => 5],
            [
                'db'        => 'Role.id as role_id', 'dt' => 6,
                'formatter' => function ($d) {
                    return DataTable::dtOps($d);
                },
            ],
        ];
        return DataTable::simple($this->role, $columns);
    }
    
    public function save($data, $id = 0){
        $permissions = explode(',',$data['permissions']);
        unset($data['permissions']);
        if($id){
            $role = $this->role->find($id);
            if (!$role) {
                return jsonResponse('error',404);
            }
            $role->update($data);
        }else{
            $role = $this->role->create($data);
        }
        $result = $role->permissions()->sync($permissions);
        return $result ? jsonResponse() : jsonResponse('failed',500);
    }
    
    public function find($id){
        return $this->role->with('permissions')->find($id);
    }
    
    public function deleted($id){
        
        $role = $this->role->find($id);
        if (!$role) {
            return jsonResponse('error',404);
        }
        if ($role->users()->count()>0) {
            return jsonResponse('该角色绑定了用户，无法删除',404);
        }
        $role->permissions()->detach();
        $result = $role->delete();
        return $result ? jsonResponse('删除成功') : jsonResponse('failed',500);
    }
    
    /**
     *
     * @param int $id
     * @return string
     */
    public function getPermissions($id = 0){
        $ids = $id ? $this->find($id)->permissions->pluck('id')->toArray() : [];
        $permissions = $this->permission->all();
        $result = [
            [
                'id' => 0,
                'name' => '全部',
                'open' => true,
                'checked' => true
            ]
        ];
        $helps = [];
        foreach ($permissions as $p){
            $helps[$p->controller] []= $p;
            $data['id'] = $p->id;
            $data['name'] = $p->name;
            $data['open'] = true;
            $data['checked'] = in_array($p->id,$ids);
            if($p->method == 'index'){
                $data['pId'] = 0;
            }else{
                $data['pId'] = $helps[$p->controller][0]->id;
            }
            $result []= $data;
        }
        return json_encode($result);
    }
}