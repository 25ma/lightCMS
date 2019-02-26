<?php
/**
 * Date: 2019/2/25 Time: 9:31
 *
 * @author  Eddy <cumtsjh@163.com>
 * @version v1.0.0
 */

Route::group(
    [
        'as' => 'admin::',
    ],
    function () {
        Route::get('/login', 'Auth\LoginController@showLogin')->name('login.show');
        Route::post('/login', 'Auth\LoginController@login')->name('login');

        Route::middleware('auth:admin')->group(function () {
            Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

            Route::get('/index', 'HomeController@showIndex')->name('index');

            // 管理员用户管理
            Route::get('/admin_users', 'AdminUserController@index')->name('adminUser.index');
            Route::get('/admin_users/list', 'AdminUserController@list')->name('adminUser.list');
            Route::get('/admin_users/create', 'AdminUserController@create')->name('adminUser.create');
            Route::post('/admin_users', 'AdminUserController@save')->name('adminUser.save');
            Route::get('/admin_users/{id}/edit', 'AdminUserController@edit')->name('adminUser.edit');
            Route::put('/admin_user/{id}', 'AdminUserController@update')->name('adminUser.update');
        });
    }
);
