<?php
namespace App\Http\ViewComposers;

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Contracts\View\View;

class MenuComposer {
    
    protected $permission, $menu;
    
    public function __construct(Permission $permission,Menu $menu) {
        
        $this->permission = $permission;
        $this->menu = $menu;
        
    }
    
    public function compose(View $view) {
        
        $view->with([
            'permissions' => $this->permission->where('method','index')->pluck('name', 'id'),
            'menus' => $this->menu->where('p_id','0')->pluck('name', 'id'),
        ]);
    }
    
}