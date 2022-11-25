<div class="header">
    <div class="header_section">
        <a class="header_item header_logo" href="{{route('main')}}">#Дневник Хакатонщика</a>
    </div>
    <div class="header_section">
        <a class="header_item header_button" href="{{route('redactor.select')}}">Редактор</a>
        <a class="header_item header_button" href="#">Архив</a>
    </div>

    <div class="header_section">
        @auth()
            <div class="header_item header_button">
                <a href="{{ route('auth.delete') }}" style="text-decoration: none; color: black">
                    Выход
                </a>
            </div>
        @endauth
        @guest()
            <div class="header_item header_button">
                <a href="{{ route('auth.social') }}" style="text-decoration: none; color: black">
                    Вход
                </a>
            </div>
        @endguest


    </div>
</div>
