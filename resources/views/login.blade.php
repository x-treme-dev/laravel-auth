<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSRF Token - контроллер, принимает обработку только из форм, запускаемых в нашем приложении-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Authentification</title>
</head>
<body>
    <h1>Вход</h1>
        <form class="form" method="POST" action="{{ route('user.login') }}">
        <!--плейсхолдер со специальным полем для передачи csrf-токена -->   
        @csrf 
            <div class="form__group">
                <label for="name" class="form__label">Имя</label>
                <input type="text" class="form__input" id="name" name="name" value="" placeholder="Имя">
                <!--выводит обшибки для этого поля-->
                @error('name')
                <div class="form__alert">{{ $message }}</div>
                @enderror
            </div>


            <div class="form__group">
                <label for="email" class="form__label">Ваш email</label>
                <input type="text" class="form__input" id="email" name="email" value="" placeholder="Email">
                <!--выводит обшибки для этого поля-->
                @error('email')
                <div class="form__alert">{{ $message }}</div>
                @enderror
            </div>

            <div class="form__group">
                <label for="password" class="form__label">Пароль</label>
                <input type="password" class="form__input" id="password" name="password" value="" placeholder="Пароль">
                @error('password')
                <div class="form__alert">{{ $message }}</div>
                @enderror
            </div>

            <div class="form__group">
                <button class="form__button" type="submit" name="sendMe" value="1">Войти</button>
            </div>
        </form>
</body>
</html>