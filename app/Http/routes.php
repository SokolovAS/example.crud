<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

   /* Route::get('/', function () {
        return view('welcome');
    });*/

    Route::any('/', ['as' => 'articles', 'uses' => 'ArticleController@viewWithFilter']);


    Route::post('/article/addComment', ['as' => 'comment.add', 'uses' => 'ArticleController@addComment']);
    Route::get('/article/viewAddForm', ['middleware' => 'auth', 'as' => 'article.form', 'uses' => 'ArticleController@viewAddForm']);
    Route::post('/article/addArticle', ['middleware' => 'auth', 'as' => 'article.add',  'uses' => 'ArticleController@addArticle']);

    Route::get('auth/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('auth/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@postLogin']);
    Route::get('auth/logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

    //password
    Route::get('password/email', ['as' => 'password.email', 'uses' => 'Auth\PasswordController@getEmail']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\PasswordController@postEmail']);

    // Password reset routes...
    Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@getReset']);
    Route::post('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@postReset']);

    // Registration routes...
    Route::get('auth/register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@getRegister']);
    Route::post('auth/register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@postRegister']);

    Route::get('/article/{id}', ['as' => 'article.one', 'uses' => 'ArticleController@viewOne']);

    //update and delete

    Route::get('article/deleteArticle/{id}', ['as' => 'article.delete', 'uses' => 'ArticleController@deleteArticle']);
    Route::get('article/deleteComment/{id}', ['as' => 'comment.delete', 'uses' => 'ArticleController@deleteComment']);
    Route::post('article/update', ['as' => 'article.update', 'uses' => 'ArticleController@updateArticle']);
    Route::post('article/updateComment', ['as' => 'comment.update', 'uses' => 'ArticleController@updateComment']);

    Route::get('/article/viewArticleUpdate/{id}', ['as' => 'article.update.view', 'uses' => 'ArticleController@viewArticleUpdate']);
    Route::get('/article/viewCommentUpdate/{id}', ['as' => 'view.comment.update', 'uses' => 'ArticleController@viewCommentUpdate']);
});
