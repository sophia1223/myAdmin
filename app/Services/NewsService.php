<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/20
 * Time: 12:17
 */

namespace App\Services;


use App\Models\News;
use App\Facades\DatatableFacade as DataTable;
use App\Models\NewsReview;
use App\Models\NewsType;
use Illuminate\Support\Facades\Storage;

class NewsService
{
    protected $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }
    
    /**
     * 获取新闻dataTable数据
     * @return array
     */
    public function dataTable() {
        
        $columns = [
            ['db' => 'News.id', 'dt' => 0],
            ['db' => 'News.title', 'dt' => 1],
            ['db' => 'NewsType.name', 'dt' => 2],
            ['db' => 'Admin.realname', 'dt' => 3],
            [
                'db' => 'News.status', 'dt' => 4,
                'formatter' => function ($d) {
                    $status = ['未审核','审核通过','拒绝发布'];
                    return $status[$d];
                }
            
            ],
            ['db' => 'News.hits', 'dt' => 5],
            ['db' => 'News.created_at', 'dt' => 6],
            ['db' => 'News.updated_at', 'dt' => 7],
            [
                'db'        => 'News.id as news_id', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    $edit = $row['status']==1 ? false : true;
                    return DataTable::dtOps($d,true,true, $edit);
                },
            ],
        ];
        $joins = [
            [
                'table'      => 'news_types',
                'alias'      => 'NewsType',
                'type'       => 'LEFT',
                'conditions' => [
                    'News.news_type_id = NewsType.id',
                ],
            ],
            [
                'table'      => 'admins',
                'alias'      => 'Admin',
                'type'       => 'LEFT',
                'conditions' => [
                    'News.admin_id = Admin.id',
                ],
            ]
        ];
        
        return DataTable::simple($this->news, $columns, $joins);
    }
    
    /**
     * 发布时间间隔验证
     *
     * @return bool
     */
    public function createPeriodRestrict(){
        $times = $this->news->where([
            ['created_at', '>' ,date("Y-m-d H:i:s",strtotime("-3 minute"))],
            ['admin_id', '=', auth('admin')->user()->id]
            ])->count();
        return $times === 0;
    }
    
    /**
     * 发布日次验证
     *
     * @return bool
     */
    public function createDayRestrict(){
        $times = $this->news->whereDate('created_at', date("Y-m-d"))->where('admin_id', auth('admin')->user()->id)->count();
        return $times <= 20;
    }
    
    public function save($data, $id = 0){
        if($id){
            $news = $this->news->find($id);
            if (!$news) {
                return jsonResponse('error',404);
            }
            $result =  $news->update($data);
        }else{
            $data['admin_id'] = auth('admin')->user()->id;
            $result = $this->news->create($data);
        }
        return $result ? jsonResponse() : jsonResponse('failed',500);
    }
    
    public function find($id){
        return $this->news->find($id);
    }
    
    public function deleted($id){
        
        $news = $this->news->find($id);
        if (!$news) {
            return jsonResponse('error',404);
        }
        Storage::delete($news->image);
        $result = $news->delete();
        
        return $result ? jsonResponse('删除成功') : jsonResponse('failed',500);
    }
}