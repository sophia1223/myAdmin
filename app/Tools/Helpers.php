<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/18
 * Time: 12:10
 */
if (!function_exists('code')) {
    /**
     * code
     * @param $id
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    function code($id) {
        return trans('code.' . $id);
    }
}
if (!function_exists('message')) {
    /**
     * message
     * @param $id
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    function message($id) {
        return trans('message.' . $id);
    }
}
if (!function_exists('checkPermission')) {
    function checkPermission($permission) {
        return \Gate::forUser(\Auth::guard('admin')->user())->check($permission);
    }
}
if (!function_exists('arrayTree')) {
    /**
     *功能:读取树形数组
     * arrayTree
     * @param array $data
     * @param string $p_id
     * @param array $res
     * @return array
     */
    function arrayTree(&$data, $p_id = '0', array $res = []) {
        foreach ($data as $k => $v) {
            if ($v['p_id'] == $p_id) {
                $v['sub'] = arrayTree($data, $v['id']);
                $res[] = $v;
                unset($data[$k]);
            }
        }
        
        return $res;
    }
}
if (!function_exists('jsonResponse')) {
    
    /**
     * Return a new json response from the application.
     *
     * @param int $statusCode
     * @param string $info
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    function jsonResponse($info = 'success', $statusCode = 200, $data = []) {
        return response()->json([
            'statusCode' => $statusCode,
            'message'    => $info,
            'data'       => $data,
        ]);
    }
}
if (!function_exists('viewResponse')) {
    
    /**
     * Return a view response from the application.
     *
     * @param $view
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    function viewResponse($view, $data = []) {
        $route = explode('admin/', $_SERVER['REQUEST_URI'])[1];
        session(['route' => $route]);
        if (\Illuminate\Support\Facades\Request::ajax()){
            return response()->json(view($view, $data)->render());
        }
        return redirect()->action('Admin\DashboardController@index');
    }
}
if (!function_exists('jsonResponseIndex')) {
    
    /**
     * @param string $info
     * @param int $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    function jsonResponseIndex($info = 'success', $code = 200, $data = []) {
        return response()->json([
            'code'    => $code,
            'message' => $info,
            'data'    => $data,
        ]);
    }
}

if (! function_exists('jsonResponseIndex')) {
    
    /**
     * @param string $info
     * @param int $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    function jsonResponseIndex($info = 'success', $code = 200, $data = [])
    {
        return response()->json([
            'code' => $code,
            'message' => $info,
            'data' => $data
        ]);
    }
}

