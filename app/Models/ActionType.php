<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActionType 功能HTTP请求类型
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $remark
 * @property int $enable
 * @method static Builder|ActionType whereEnable($value)
 * @method static Builder|ActionType whereId($value)
 * @method static Builder|ActionType whereName($value)
 * @method static Builder|ActionType whereRemark($value)
 */
class ActionType extends Model {
    
    protected $fillable = ['name', 'remark', 'enabled'];
    
}

