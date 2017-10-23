<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        
        View::composer('admin.menu.create_edit', 'App\Http\ViewComposers\MenuComposer');
        View::composer('admin.manager.create_edit', 'App\Http\ViewComposers\AdminComposer');
        View::composer('admin.news.create_edit', 'App\Http\ViewComposers\NewsComposer');
        
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        
        //
    }
    
}
