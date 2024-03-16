<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {  // редирект будет запускаться, если мы не ожидаем от сервера данные в формате JSON
        if (! $request->expectsJson()) {
            // дописан префикс user для отравки пользователя на страницу аутентификации
            return route('user.login');
        }
    }
}
