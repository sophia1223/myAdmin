<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/12
 * Time: 10:28
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Services\NewsService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;


class NewsController extends Controller
{
    protected $service;

    public function __construct(NewsService $service)
    {
        $this->service = $service;
    }
    
    /**
     * 新闻管理
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->service->dataTable());
        }
        return viewResponse('admin.news.index');
    }
    
    /**
     * 新增新闻
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return viewResponse('admin.news.create');
    }
    
    /**
     * 保存新闻
     *
     * @param NewsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NewsRequest $request)
    {
        if(!$this->service->createPeriodRestrict()){
            return jsonResponse('两次新闻发布间隔不得小于3分钟', 500);
        }
    
        if(!$this->service->createDayRestrict()){
            return jsonResponse('一天最多只能发布20条新闻', 500);
        }
        
        $input = $request->all('title','content','news_type_id');
        $input['image'] = $request->file('image')->store('news');
        return $this->service->save($input);
    }
    
    /**
     * 编辑新闻
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $news = $this->service->find($id);
        if (!$news) {
            return jsonResponse('error',404);
        }
        return viewResponse('admin.news.edit',['news' => $news]);
    }
    
    /**
     * 更新新闻
     *
     * @param NewsRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NewsRequest $request,$id)
    {
        $input = $request->all('title','content','news_type_id','status','old_path');
        if($request->file('image')){
            Storage::delete($input['old_path']);
            $input['image'] = $request->file('image')->store('news');
        }
        return $this->service->save($input,$id);
    }
    
    /**
     * 删除指定的新闻
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->service->deleted($id);
    }
    
    /**
     * 展示新闻
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $news = $this->service->find($id);
        if (!$news) {
            return jsonResponse('error',404);
        }
        return viewResponse('admin.news.show',['news' => $news]);
    }
    
    /**
     * 审批新闻
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function approval($id)
    {
        $input['reply'] = Request::get('reply');
        $input['status'] = Request::get('status') ? 1 : 2;
    
        return $this->service->save($input,$id);
    }
    
    /**
     * 查看新闻评论
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function reviews($id){
        return response()->json($this->service->reviewsDataTable($id));
    }
    
    /**
     * 删除新闻评论
     *
     * @param $review_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function reviewsDestroy($review_id){
        return $this->service->reviewDeleted($review_id);
    }
    
}