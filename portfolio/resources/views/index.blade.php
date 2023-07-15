@extends('layout.base')

@section('content')

    <div class="git">
        <div class="git_section">
            <h2>
                @auth()
                    <img src="{{auth()->user()->getAvatar()}}" alt="" height="50px" width="50px">
                    {{auth()->user()->nickname}}
                @endauth
                @guest()
                    Нет профиля
                @endguest
            </h2>
            <textarea class="commits"></textarea>
            <div>
                <div class="btn_section">
                    <div class="btn_items"><button>Сохранить</button></div>
                    <div class="btn_items"><button>Загрузить</button></div>
                    <div class="btn_items"><button>Отправить</button></div>
                </div>
            </div>
        </div>
        <div class="git_section">
            <h2>Папка команды</h2>
            <div id="multi-derevo" class="git_tree">

                <h4><a href="#">{{$answer[0]}}</a></h4>
                    <ul>
                        @foreach($answer[1] as $file)
                        <li><span><a onclick="load('{{$file['url']}}')">{{$file['name']}}</a></span></li>
                        @endforeach
                    </ul>
            </div>
        </div>
    </div>

    <div class="page">
        <div class="menu">
            <div class="control-buttons">
                <div class="clear button">🔥</div>
                <div class="vert-line"></div>
                <div class="undo button">↺</div>
                <div class="redo button">↻</div>
                <div class="vert-line"></div>
                <div class="bold button">b</div>
                <div class="italic button">i</div>
                <div class="underline button">u</div>
                <div class="strikethrough button">s</div>
                <div class="vert-line"></div>
                <div class="header button">Hн</div>
                <div class="mark button">▢</div>
                <div class="code button">≺≻</div>
                <div class="quote button">❞❝</div>
            </div>
            <div id="view-button" class="view-button button">Preview</div>
        </div>
        <div class="fullsize-editor">
            <textarea id="textarea" class="edit_block block" spellcheck="false">

        </textarea>
            <article id="text-html" class="block">
            </article>

        </div>
    </div>
@endsection
