<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



//  маршрут будет называтся user.private (user-префикс маршрута) для доступа к нему 
//  из других частей приложения
//  маршрут только для аутентифицированных пользователей, который ведет на страницу приложения
//  в middleware Authenticate.php прописана передаресация для неаунтефицированных пользователей
// на страницу Входа (аутентификации)
Route::name('user.')->group(function(){
    Route::view('/private', 'private')->middleware('auth')->name('private');

    // маршрут для аутентификации с именем login
Route::get('/login', function(){
    // доступ только для тех пользователей, корорые еще не аутентифицировались
    if(Auth::check()){
        return redirect(route('user.private'));
        // если пользователь уже аутентифицирован, то отправим его 
        //на страницу, упоминаемую выше
    }
    return view('login'); // возвратить представление по имени login.blade.php
})->name('login');

//Аутентификация: вызов контроллера, когда мы нажимаем кнопку Войти
Route::post('/login', [LoginController::class, 'login'] );

//маршрут для выхода из приложения 
// при редиректе на главную страницу происходит разлогиниване через метод logout()
Route::get('/logout', function(){
    Auth::logout();
    return redirect('/');
})->name('logout');

//маршрут для регистрации
Route::get('/registration', function(){
     // если пользователь аутентифицирован, то переадресовать его на страницу private
     // иначе - на страницу регистрации
     if(Auth::check()){
        return redirect(route('user.private'));
     }
    return view('registration');
})->name('registration');

//маршрут для формы регистрации
Route::post('/registration',[RegisterController::class, 'save']);

});


