<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/12
 * Time: 10:28
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Services\BannerService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    protected $service;

    public function __construct(BannerService $service)
    {
        $this->service = $service;
    }
    
    /**
     * banner管理
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->service->dataTable());
        }
        return viewResponse('admin.banner.index');
    }
    
    /**
     * 新增banner
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return viewResponse('admin.banner.create');
    }
    
    /**
     * 保存banner
     *
     * @param BannerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BannerRequest $request)
    {
        $input = $request->all('remark','belongs');
        $input['path'] = $request->file('path')->store('banners');
        return $this->service->save($input);
    }
    
    /**
     * 编辑banner
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $banner = $this->service->find($id);
        if (!$banner) {
            return jsonResponse('error',404);
        }
        return viewResponse('admin.banner.edit',['banner' => $banner]);
    }
    
    /**
     * 更新banner
     *
     * @param BannerRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BannerRequest $request,$id)
    {
        $input = $request->all('remark','belongs','old_path');
        if($request->file('path')){
            Storage::delete($input['old_path']);
            $input['path'] = $request->file('path')->store('banners');
        }else{
            $input['path'] = $input['old_path'];
        }
        return $this->service->save($input,$id);
    }
    
    /**
     * 删除指定的banner
     * @param $id
     * @return bool|null
     */
    public function destroy($id)
    {
        return $this->service->deleted($id);
    }
    
}