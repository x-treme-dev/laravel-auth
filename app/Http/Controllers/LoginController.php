<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //аутентификация
    public function login(Request $request){
        if(Auth::check()){
            return redirect()->intended(route('user.private'));
            // если пользователь уже аутентифицирован, то отправим его на страницу user.private
            // либо на адрес, к которому пытался обратиться пользователь
        }

        $formFields = $request->only(['email', 'password']);
         // при аутентификации пользователь хочет зайти на определенную страницу
        // если такой страницы нет, то будет переадресация на страницу private
        if(Auth::attempt($formFields)){
            return redirect()->intended(route('user.private'));
        }
       // если попытка аутентификации не удалась, то переходим на страницу
       // аутентификации и указываем для поля email ошибку
        return redirect(route('user.login'))->withErrors([
            'email' => 'Не удалось пройти аутентификацию'
        ]);
    }
   
}
