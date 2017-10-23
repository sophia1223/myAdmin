<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/20
 * Time: 12:09
 */

namespace App\Services;

use App\Models\ActionType;
use App\Models\Permission;
use Doctrine\Common\Inflector\Inflector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Mockery\Exception;
use ReflectionClass;
use ReflectionMethod;

class PermissionService
{
    protected $permission;
    protected $actionTypes;
    protected $routes;
    protected $excludedControllers = [
        'IndexController',
        'DashboardController',
        'PermissionController',
        'LoginController',
    ];
    # 控制器路径
    protected $dir = '/media/myAdmin/app/Http/Controllers/Admin';

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function set() {
        
        $actionType = new ActionType();
        $this->actionTypes = $actionType->pluck('id', 'name')->toArray();
        $this->routes = Route::getRoutes()->getRoutes();
        //返回所有控制器的完整路径
        $controllers = $this->scanDirectories($this->dir);
        //返回控制器的完整名字空间路径
        $this->getControllerNamespaces($controllers);
        //去除名字空间路径的控制器名称数组
        $controllerNames = $this->getControllerNames($controllers);
        // remove actions of non-existing controllers
        $ctlrs = $this->permission->groupBy('controller')->get(['controller'])->toArray();
        $existingCtlrs = [];
        foreach ($ctlrs as $ctlr) {
            $existingCtlrs[] = $ctlr['controller'];
        }
        $ctlrDiff = array_diff($existingCtlrs, $controllerNames);
        foreach ($ctlrDiff as $ctlr) {
            $this->permission->where('controller', $ctlr)->delete();
        }
        foreach ($controllers as $controller) {
            $obj = new ReflectionClass(ucfirst($controller));
            $className = $obj->getName();
            $ctlr = $this->getControllerName($className);
            if(!in_array($ctlr, $this->excludedControllers)){
                $methods = $obj->getMethods();
                // remove non-existing methods of current controller
                if (!$this->delNonExistingMethods($methods, $className)) {
                    return false;
                }
                foreach ($methods as $method) {
                    $action = $method->getName();
                    if (
                        $method->class === $className &&
                        !($method->isConstructor()) &&
                        $method->isUserDefined() &&
                        $method->isPublic() &&
                        $this->hasAlias($this->getRoute($ctlr, $action,FALSE))
                    ) {
                        $a = $this->permission->where([
                            ['controller', $ctlr],
                            ['method', $action],
                        ])->first();
                        if($this->getRoute($ctlr, $action)){
                            if ($a) {
                                $a->name = $this->getMethodComment($obj, $method);
                                $a->controller = $ctlr;
                                $a->method = $action;
                                $a->action_type_ids = $this->getActionTypeIds($ctlr, $action);
                                $a->route = $this->getRoute($ctlr, $action);
                                $a->alias = $this->getRoute($ctlr, $action,FALSE);
                                $a->save();
                            } else {
                                $this->permission->create([
                                    'name'            => $this->getMethodComment($obj, $method),
                                    'controller'      => $ctlr,
                                    'method'          => $action,
                                    'action_type_ids' => $this->getActionTypeIds($ctlr, $action),
                                    'route'           => $this->getRoute($ctlr, $action),
                                    'alias'           => $this->getRoute($ctlr, $action,FALSE),
                                ]);
                            }
                        }
                    }
                }
            }
            
        }
        return jsonResponse();
    }
    
    /** Helper functions -------------------------------------------------------------------------------------------- */
    /**
     * 返回所有控制器的完整路径
     *
     * @param $rootDir
     * @param array $allData
     * @return array
     */
    public function scanDirectories($rootDir, $allData = []) {
        
        // set filenames invisible if you want
        $invisibleFileNames = [".", "..", ".htaccess", ".htpasswd"];
        // run through content of root directory
        $dirContent = scandir($rootDir);
        foreach ($dirContent as $key => $content) {
            // filter all files not accessible
            $path = $rootDir . '/' . $content;
            if (!in_array($content, $invisibleFileNames)) {
                // if content is file & readable, add to array
                if (is_file($path) && is_readable($path)) {
                    // save file name with path
                    $allData[] = $path;
                    // if content is a directory and readable, add path and name
                } elseif (is_dir($path) && is_readable($path)) {
                    // recursive callback to open new directory
                    $allData = $this->scanDirectories($path, $allData);
                }
            }
        }
        return $allData;
        
    }
    
    /**
     * 返回控制器的完整名字空间路径
     *
     * @param $controllers
     */
    public function getControllerNamespaces(&$controllers) {
        
        for ($i = 0; $i < sizeof($controllers); $i++) {
            $controllers[$i] = str_replace('/', '\\', $controllers[$i]);
            $controllers[$i] = str_replace('\\media\\myAdmin\\', '', $controllers[$i]);
            $controllers[$i] = str_replace('.php', '', $controllers[$i]);
        }
        
    }
    
    /**
     * 返回去除名字空间路径的控制器名称数组
     *
     * @param $controllers
     * @return array
     */
    public function getControllerNames($controllers) {
        
        $controllerNames = [];
        foreach ($controllers as $controller) {
            $paths = explode('\\', $controller);
            $controllerNames[] = $paths[sizeof($paths) - 1];
        }
        return $controllerNames;
        
    }
    
    /**
     * 移除指定的Action记录
     *
     * @param $actionId
     * @return bool|mixed
     */
    public function remove($actionId) {
        
        $action = $this->permission->find($actionId);
        if (!isset($action)) {
            return false;
        }
        try {
            $exception = DB::transaction(function () use ($actionId, $action) {
                # 删除指定的Action记录
                $action->delete();
            });
            return is_null($exception) ? true : $exception;
        } catch (Exception $e) {
            return false;
        }
        
    }
    
    /**
     * 删除指定控制器中不存在的方法
     *
     * @param $methods
     * @param $className
     * @return bool
     */
    private function delNonExistingMethods($methods, $className) {
        
        // remove non-existing methods of current controller
        $currentMethods = $this->getMethodNames($methods);
        $existingMethods = [];
        $controllerName = $this->getControllerName($className);
        $results = $this->permission->where('controller', $controllerName)->get(['method'])->toArray();
        foreach ($results as $result) {
            $existingMethods[] = $result['method'];
        }
        $methodDiffs = array_diff($existingMethods, $currentMethods);
        foreach ($methodDiffs as $method) {
            $a = $this->permission->where([
                ['controller', $controllerName],
                ['method', $method],
            ])->first();
            if (!$this->permission->remove($a->id)) {
                return false;
            };
        }
        return true;
        
    }
    
    /**
     * 获取指定方法的名称
     *
     * @param $methods
     * @return array
     */
    private function getMethodNames($methods) {
        
        $methodNames = [];
        foreach ($methods as $method) {
            /** @noinspection PhpUndefinedMethodInspection */
            $methodNames[] = $method->getName();
        }
        return $methodNames;
        
    }
    
    /**
     * 返回去除名字空间路径的控制器名称
     *
     * @param $controller
     * @return mixed
     */
    public function getControllerName($controller) {
        
        $nameSpacePaths = explode('\\', $controller);
        return $nameSpacePaths[sizeof($nameSpacePaths) - 1];
        
    }
    
    /**
     * 获取方法备注名称
     *
     * @param ReflectionClass $controllerObj
     * @param ReflectionMethod $method
     * @return mixed|string
     */
    private function getMethodComment(ReflectionClass $controllerObj, ReflectionMethod $method) {
        
        $comment = $controllerObj->getMethod($method->getName())->getDocComment();
        $name = 'n/a';
        preg_match_all("#\/\*\*\n\s{5}\*[^\*]*\*#", $comment, $matches);
        if (isset($matches[0][0])) {
            $name = str_replace(str_split("\n/* "), '', $matches[0][0]);
        } else {
            preg_match_all("#\/\*\*\r\n\s{5}\*[^\*]*\*#", $comment, $matches);
            if (isset($matches[0][0])) {
                $name = str_replace(str_split("\n/* "), '', $matches[0][0]);
            }
        }
        return $name;
        
    }
    
    /**
     * 根据控制器名称返回表名称
     *
     * @param $controller string 控制器类名
     * @return string 数据表名称
     */
    private function getTableName($controller) {
        
        $modelName = substr(
            $controller, 0,
            strlen($controller) - strlen('Controller')
        );
        if ($modelName === 'Squad') {
            return 'classes';
        }
        return Inflector::pluralize(Inflector::tableize($modelName));
        
    }
    
    /**
     * 根据控制器名称和action名称返回action对应的路由名称
     *
     * @param $controller string 控制器名称
     * @param $action string action名称
     * @param bool $uri TRUE返回路由，FALSE返回路由别名
     * @return mixed 路由名称
     */
    private function getRoute($controller, $action, $uri = true) {
        
        $route = 'admin/' . $this->getTableName($controller) . '/' . $action;
        /** @var \Illuminate\Routing\Route $r */
        foreach ($this->routes as $r) {
            if (stripos($r->uri, $route) === 0) {
                return $uri ? $r->uri : $r->getName();
            }
        }
        return null;
        
    }
    
    /**
     * 返回指定action的HTTP请求类型名称
     *
     * @param $controller
     * @param $action
     * @return null|string
     */
    private function getActionTypeIds($controller, $action) {
        
        $route ='admin/' . $this->getTableName($controller) . '/' . $action;
        $actionTypeIds = [];
        foreach ($this->routes as $r) {
            if (stripos($r->uri, $route) === 0) {
                foreach ($r->methods as $method) {
                    $actionTypeIds[] = $this->actionTypes[$method];
                }
            }
        }
        return implode(',', $actionTypeIds);
        
    }
    
    /**
     * 判断是否存在(不存在返回true)
     *
     * @param $alias
     * @return null|string
     */
    private function hasAlias($alias) {
        $permission = $this->permission::whereAlias($alias)->first();
        return $permission ? false : true;
    }
}