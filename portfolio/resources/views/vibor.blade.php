<!DOCTYPE html>
<html lang="ru">


    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{asset("/css/style.css")}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.9/styles/atom-one-light.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <title>MPIT редактор</title>
    </head>

<body>
    <div class="container">
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Команда</label>
                <select class="form-control" id="sel" aria-describedby="emailHelp">
                    @foreach($files as $item)
                        <option name="nick" value="{{$item[0]}}">{{$item[0]}}</option>
                    @endforeach
                </select>
                <div class="btn" onclick="send()">Отправить</div>
            </div>
        </form>
    </div>

    <script>
        function send() {
            var e = document.getElementById("sel");
            var value = e.value;
            api = "https://hackaton-yakse.store/"+value
            document.location.href = api;
        }
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.9/highlight.min.js"></script>
    <script src="{{asset("/js/jquery-3.6.1.min.js")}}"></script>
    <script src="{{asset("/js/jquery_cookie.js")}}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>
