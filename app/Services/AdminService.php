<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/7
 * Time: 12:07
 */

namespace App\Services;


use App\Models\Admin;
use App\Facades\DatatableFacade as DataTable;

class AdminService
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }
    
    /**
     * 获取管理员dataTable数据
     *
     * @return array
     */
    public function dataTable() {
        
        $columns = [
            ['db' => 'Admin.id', 'dt' => 0],
            ['db' => 'Admin.username', 'dt' => 1],
            ['db' => 'Admin.realname', 'dt' => 2],
            ['db' => 'Admin.created_at', 'dt' => 3],
            ['db' => 'Admin.updated_at', 'dt' => 4],
            [
                'db'        => 'Admin.status', 'dt' => 5,
                'formatter' => function ($d,$row) {
                    $btn = $d ==1 ?sprintf(DataTable::DT_ON, '已启用') : sprintf(DataTable::DT_OFF, '未启用');
                    return  $btn . DataTable::dtOps($row['id']);
                },
            ],
        ];
        return DataTable::simple($this->admin, $columns);
    }
    
    /**
     * 保存
     *
     * @param $data
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function save($data, $id = 0){
        if($data['password']){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }
        $roles = $data['roles'];
        unset($data['roles']);
        if($id){
            $admin = $this->admin->find($id);
            if (!$admin) {
                return jsonResponse('error',404);
            }
            $admin->update($data);
        }else{
            $admin = $this->admin->create($data);
        }
        $result = $admin->roles()->sync($roles);
        return $result ? jsonResponse() : jsonResponse('failed',500);
    }
    
    /**
     * 查找
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function find($id){
        return $this->admin->with('roles')->find($id);
    }
    
    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleted($id){
        
        $admin = $this->admin->find($id);
        if (!$admin) {
            return jsonResponse('error',404);
        }
        $admin->roles()->detach();
        $result = $admin->delete();
        return $result ? jsonResponse('删除成功') : jsonResponse('failed',500);
    }

    /**
     * 修改管理员密码
     *
     * @param $password
     * @param $newPassword
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword($password, $newPassword)
    {
        $id = auth('admin')->user()->id;
        $where = [
            'id' => $id
        ];
        if (!$adminInfo = $this->admin->where($where)->first()) {
            return jsonResponse('Not Found',404);
        }

        if (!\Hash::check($password, $adminInfo->password)) {
            return jsonResponse('密码不正确','500');
        }

        $adminInfo->password = bcrypt($newPassword);
        if (!$adminInfo->save()) {
            return jsonResponse('系统出错','500');
        }

        return jsonResponse('修改成功，将在下次登录时生效');
    }

}