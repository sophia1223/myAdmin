<?php

use Illuminate\Routing\Router;

Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');
Route::get('/', ['as' => 'admin.index', 'uses' => 'DashboardController@index']);
Route::get('index', ['as' => 'admin.index', 'uses' => 'IndexController@index']);
Route::get('/getMenu', ['as' => 'admin.index', 'uses' => 'DashboardController@getMenu']);
Route::get('permissions/set', 'PermissionController@set');

Route::group(['middleware' => ['auth:admin', 'permission', 'auth.admin']], function(Router  $router) {
    //富文本编辑器不能使用xss中间件，否则编辑的样式保存不上
    $router->post('news/store', ['as' => 'admin.news.create', 'uses' => 'NewsController@store']);
    $router->post('news/update/{id}', ['as' => 'admin.news.edit', 'uses' => 'NewsController@update']);
});

Route::group(['middleware' => ['auth:admin', 'xss', 'permission', 'auth.admin']], function(Router  $router) {
    $router->get('changePassword', ['as' => 'admin.update-pwd', 'uses' => 'DashboardController@changePassword']);
    $router->post('updatePassword', ['as' => 'admin.update-pwd', 'uses' => 'DashboardController@updatePassword']);
    
    //角色管理路由
    $router->get('roles/index', ['as' => 'admin.roles.index', 'uses' => 'RoleController@index']);
    $router->get('roles/create', ['as' => 'admin.roles.create', 'uses' => 'RoleController@create']);
    $router->post('roles/store', ['as' => 'admin.roles.create', 'uses' => 'RoleController@store']);
    $router->get('roles/edit/{id}', ['as' => 'admin.roles.edit', 'uses' => 'RoleController@edit']);
    $router->post('roles/update/{id}', ['as' => 'admin.roles.edit', 'uses' => 'RoleController@update']);
    $router->delete('roles/destroy/{id}', ['as' => 'admin.roles.destroy', 'uses' => 'RoleController@destroy']);

    //用户管理路由
    $router->get('admins/index', ['as' => 'admin.admins.index', 'uses' => 'AdminController@index']);
    $router->get('admins/create', ['as' => 'admin.admins.create', 'uses' => 'AdminController@create']);
    $router->post('admins/store', ['as' => 'admin.admins.create', 'uses' => 'AdminController@store']);
    $router->get('admins/edit/{id}', ['as' => 'admin.admins.edit', 'uses' => 'AdminController@edit']);
    $router->post('admins/update/{id}', ['as' => 'admin.admins.edit', 'uses' => 'AdminController@update']);
    $router->delete('admins/destroy/{id}', ['as' => 'admin.admins.destroy', 'uses' => 'AdminController@destroy']);
    
    //菜单管理路由
    $router->get('menus/index', ['as' => 'admin.menus.index', 'uses' => 'MenuController@index']);
    $router->get('menus/create', ['as' => 'admin.menus.create', 'uses' => 'MenuController@create']);
    $router->post('menus/store', ['as' => 'admin.menus.create', 'uses' => 'MenuController@store']);
    $router->get('menus/edit/{id}', ['as' => 'admin.menus.edit', 'uses' => 'MenuController@edit']);
    $router->post('menus/update/{id}', ['as' => 'admin.menus.edit', 'uses' => 'MenuController@update']);
    $router->delete('menus/destroy/{id}', ['as' => 'admin.menus.destroy', 'uses' => 'MenuController@destroy']);
    
    //banner管理路由
    $router->get('banners/index', ['as' => 'admin.banners.index', 'uses' => 'BannerController@index']);
    $router->get('banners/create', ['as' => 'admin.banners.create', 'uses' => 'BannerController@create']);
    $router->post('banners/store', ['as' => 'admin.banners.create', 'uses' => 'BannerController@store']);
    $router->get('banners/edit/{id}', ['as' => 'admin.banners.edit', 'uses' => 'BannerController@edit']);
    $router->post('banners/update/{id}', ['as' => 'admin.banners.edit', 'uses' => 'BannerController@update']);
    $router->delete('banners/destroy/{id}', ['as' => 'admin.banners.destroy', 'uses' => 'BannerController@destroy']);
    
    //新闻管理路由
    $router->get('news/index', ['as' => 'admin.news.index', 'uses' => 'NewsController@index']);
    $router->get('news/create', ['as' => 'admin.news.create', 'uses' => 'NewsController@create']);
    $router->get('news/edit/{id}', ['as' => 'admin.news.edit', 'uses' => 'NewsController@edit']);
    $router->delete('news/destroy/{id}', ['as' => 'admin.news.destroy', 'uses' => 'NewsController@destroy']);
    $router->get('news/show/{id}', ['as' => 'admin.news.show', 'uses' => 'NewsController@show']);
    $router->post('news/approval/{id}', ['as' => 'admin.news.approval', 'uses' => 'NewsController@approval']);
    $router->get('news/reviews/{id}', ['as' => 'admin.news.reviews', 'uses' => 'NewsController@reviews']);
    $router->delete('news/reviewsDestroy/{review_id}', ['as' => 'admin.news.reviewsDestroy', 'uses' => 'NewsController@reviewsDestroy']);
});