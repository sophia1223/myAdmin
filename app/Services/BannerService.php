<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/20
 * Time: 12:17
 */

namespace App\Services;


use App\Models\Banner;
use App\Facades\DatatableFacade as DataTable;
use Illuminate\Support\Facades\Storage;

class BannerService
{
    protected $banner;

    public function __construct(Banner $banner)
    {
        $this->banner = $banner;
    }
    
    /**
     * 获取banner图dataTable数据
     *
     * @return array
     */
    public function dataTable() {
        
        $columns = [
            ['db' => 'Banner.id', 'dt' => 0],
            [
                'db' => 'Banner.image', 'dt' => 1,
                'formatter' => function ($d) {
                    return '<img
                    src="'.asset("storage/{$d}").'"
                    style="width:200px; height: 120px;max-width: 200px;max-height: 120px;"
                    >';
                }
            ],
            ['db' => 'Banner.remark', 'dt' => 2],
            [
                'db' => 'Banner.belongs', 'dt' => 3,
                'formatter' => function ($d) {
                    $belongs = ['首页'];
                    return $belongs[$d];
                }
            
            ],
            ['db' => 'Banner.created_at', 'dt' => 4],
            ['db' => 'Banner.updated_at', 'dt' => 5],
            [
                'db'        => 'Banner.id as banner_id', 'dt' => 6,
                'formatter' => function ($d) {
                    return DataTable::dtOps($d);
                },
            ],
        ];
        return DataTable::simple($this->banner, $columns);
    }
    
    /**
     * 保存
     *
     * @param $data
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function save($data, $id = 0){
        if($id){
            $banner = $this->banner->find($id);
            if (!$banner) {
                return jsonResponse('error',404);
            }
            $result =  $banner->update($data);
        }else{
            $result = $this->banner->create($data);
        }
        return $result ? jsonResponse() : jsonResponse('failed',500);
    }
    
    /**
     * 查找
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function find($id){
        return $this->banner->find($id);
    }
    
    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleted($id){
        
        $banner = $this->banner->find($id);
        if (!$banner) {
            return jsonResponse('error',404);
        }
        Storage::delete($banner->path);
        $result = $banner->delete();
        
        return $result ? jsonResponse('删除成功') : jsonResponse('failed',500);
    }
}