<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
   
    /**
     * param $request - экземпляр запроса
     * required - валидатор поля проверяет, что поле не пустое
     * если валидация не успешна, то будет выдана станица, которая 
     * соответствует методу get данного маршрута
     * 
     *  обработать данные из формы
     *  зарегистрировать пользователя или выдать ошибку
     */

    public function save(Request $request){
        if(Auth::check()){
            return redirect(rout('user.private'));
            // если пользователь уже аутентифицирован, то отправим его на страницу user.private
        }

         $validateFields = $request->validate([
            'name' => 'required|max:25',
            'email' => 'required|email',
            'password' => 'required'
        ]);


        //обрабтка исключения:
        // если такой email существует в БД, то отправить пользователя на страницу регистрации
        if(User::where('email', $validateFields['email'])->exists()){
           return redirect(route('user.registration'))->withErrors([
                'email' => 'Такой email уже зарегистрирован!'
            ]);
        }

        // если валидация пройдена, то создать пользователя в таблице
        // для это используется модель User, которая есть в Laravel по
        // умолчанию
        // модель User сответствует по умолчанию миграции create_user_table 
        $user = User::create($validateFields);
        // проверим, что пользователь есть и переадресуем его на страницу private
        if($user){
            Auth::login($user); // либо через helper auth()->login('user');
            return redirect(route('user.private'));
        }
       //иначе - передаресуем его на страницу логина и покажем ошибку
        return redirect(route('user.login'))->withErrors([
            'formError' => 'Произошла ошибка при сохранении пользователя'
        ]);

    }

}
