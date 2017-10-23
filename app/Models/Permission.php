<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name 名称
 * @property string|null $remark 备注
 * @property string $controller 控制器
 * @property string $method 方法
 * @property string|null $action_type_ids 请求方法
 * @property string $route 路由
 * @property string|null $alias 路由别名
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Menu $menus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @method static Builder|Permission whereActionTypeIds($value)
 * @method static Builder|Permission whereAlias($value)
 * @method static Builder|Permission whereController($value)
 * @method static Builder|Permission whereCreatedAt($value)
 * @method static Builder|Permission whereId($value)
 * @method static Builder|Permission whereMethod($value)
 * @method static Builder|Permission whereName($value)
 * @method static Builder|Permission whereRemark($value)
 * @method static Builder|Permission whereRoute($value)
 * @method static Builder|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends Model {
    
    public $table = 'permissions';
    public $timestamps = true;
    protected $guarded = [];
    
    /**
     * 获取指定功能所属角色对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions', 'permission_id', 'role_id');
    }
    
    /**
     * 获取指定功能所属菜单对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function menus(){
        return $this->hasOne(Menu::class,'permission_id');
    }
    
    public function remove($id){
        return $this->where('id',$id)->delete();
    }
    
}
