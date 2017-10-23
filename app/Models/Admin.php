<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\Admin
 *
 * @property-read \App\Models\Department $departments
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @mixin \Eloquent
 * @property int $id
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $realname 真实姓名
 * @property string $status 状态，1：可用 0：不可用
 * @property string|null $remember_token 记住token
 * @property int $department_id 部门id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static Builder|Admin whereCreatedAt($value)
 * @method static Builder|Admin whereDepartmentId($value)
 * @method static Builder|Admin whereId($value)
 * @method static Builder|Admin wherePassword($value)
 * @method static Builder|Admin whereRealname($value)
 * @method static Builder|Admin whereRememberToken($value)
 * @method static Builder|Admin whereStatus($value)
 * @method static Builder|Admin whereUpdatedAt($value)
 * @method static Builder|Admin whereUsername($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activities
 */
class Admin extends Authenticatable { //继承Authenticatable,将Admin模型作为AuthServiceProvider的user存在

    use Notifiable;

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['username', 'password', 'realname', 'department_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * 获取用户拥有的角色
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'roles_admins','admin_id','role_id');
    }
    
    /**
     * 获取用户所属的部门
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departments(){
        return $this->belongsTo(Department::class,'department_id');
    }
 
    public function activities(){
        return $this->hasMany('App\Models\Activity');
    }
    
    /**
     * 获取用户拥有的权限
     *
     * @return mixed
     */
    public function getAdminPermissions(){
        
        $permission = new Permission();
        return $permission->whereHas('roles.users',function($q){
            return $q->where('admins.id',$this->id);
        });
    }

    /**
     * 判断用户是否具有某角色
     *
     * @param string|array $roles
     * @return bool
     */
    public function hasRole($roles)
    {
        if (is_string($roles))
        {
            return $this->roles->contains('name', $roles);
        }
        return !!collect($roles)->pluck('id')->intersect($this->roles->pluck('id'))->count(); //如果是检查多个角色则使用两者交集来判断,这里!!表示三元运算返回true or false
    }
    
    /**
     * 判断用户是否具有某权限
     *
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('alias', $permission)->first();
            if (!$permission) return false;
        }
        return $this->hasRole($permission->roles);
    }


    public function isSuperAdmin()
    {
        if ($this->username == 'admin') {
            return true;
        }
        return false;
    }
}