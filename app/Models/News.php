<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\News
 *
 * @property-read \App\Models\Admin $admin
 * @property-read \App\Models\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NewsReview[] $news_reviews
 * @property-read \App\Models\NewsType $news_type
 * @mixin \Eloquent
 */
class News extends Model
{
    protected $table = 'news';
    protected $fillable = ['title', 'image', 'content', 'news_type_id', 'department_id', 'admin_id', 'status','reply'];
    
    /**
     * 返回指定新闻所属的部门对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(){
        return $this->belongsTo(Department::class);
    }
    
    /**
     * 返回指定新闻所属的新闻类型对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function news_type(){
        return $this->belongsTo(NewsType::class);
    }
    
    /**
     * 返回指定新闻所属的管理员对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    
    /**
     * 返回指定新闻拥有的评论对象
     */
    public function news_reviews()
    {
        return $this->hasMany(NewsReview::class);
    }
}
