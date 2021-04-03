<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\CategoryHelper;

Route::resources([
    '/post'      => 'PostController',
    '/user'      => 'UserController',
    '/fotos'     => 'FotoController',
    // '/comentario'=> 'ComentarioController',
]);

Route::get('/', function () {
    return redirect('post');
});
Auth::routes();

Route::get('/post/categoria/{categoria}', 'PostController@categoria')->name('post.categoria');
Route::get('/post/{name}/{id}', 'PostController@user')->name('post.user');

Route::post('/comentario/store/{texto}/{idpost}', 'ComentarioController@store')->name('comentario.store');
Route::delete('/comentario/destroy/{id}', 'ComentarioController@destroy');

Route::patch('/user/{id}/imagem/upload', 'UserController@imagem')->name('user.imagem');
Route::delete('/user/{id}/imagem/delete', 'UserController@destroyImagem')->name('user.imagem.delete');

Route::get('/home', 'HomeController@index')->name('home');
