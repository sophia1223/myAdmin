<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property int $p_id 父级菜单id
 * @property int $permission_id 功能id
 * @property string $name
 * @property string|null $icon 图标
 * @property int $sort 排序
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Permission $permissions
 * @method static Builder|Menu whereCreatedAt($value)
 * @method static Builder|Menu whereIcon($value)
 * @method static Builder|Menu whereId($value)
 * @method static Builder|Menu whereName($value)
 * @method static Builder|Menu wherePId($value)
 * @method static Builder|Menu wherePermissionId($value)
 * @method static Builder|Menu whereSort($value)
 * @method static Builder|Menu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Menu extends Model
{
    protected $guarded = [];
    /**
     * 获取指定菜单所属功能对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permissions(){
        return $this->belongsTo(Permission::class,'permission_id');
    }
}
