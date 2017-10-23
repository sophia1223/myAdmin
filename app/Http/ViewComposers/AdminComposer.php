<?php
namespace App\Http\ViewComposers;

use App\Models\Role;
use Illuminate\Contracts\View\View;

class AdminComposer {
    
    protected $role;
    
    public function __construct(Role $role) {
        
        $this->role = $role;
        
    }
    
    public function compose(View $view) {
        
        $view->with([
            'roles' => $this->role->pluck('name', 'id'),
        ]);
    }
    
}