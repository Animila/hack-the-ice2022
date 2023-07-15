<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="{{asset("/css/style.css")}}">
        <title>MPIT</title>
    </head>
    <body>
        @include('layout.navbar')

        @yield('content')
    </body>
</html>
