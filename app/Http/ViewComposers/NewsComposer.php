<?php
namespace App\Http\ViewComposers;

use App\Models\NewsType;
use Illuminate\Contracts\View\View;

class NewsComposer {
    
    protected $newsTypes;
    
    public function __construct(NewsType $newsTypes) {
        
        $this->newsTypes = $newsTypes;
        
    }
    
    public function compose(View $view) {
        
        $view->with([
            'newsTypes' => $this->newsTypes->pluck('name', 'id'),
        ]);
    }
    
}