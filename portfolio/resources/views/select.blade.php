@extends('layout.base')

@section('content')
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
            api = "{{env('APP_URL')}}redactor/"+value
            document.location.href = api;
        }
    </script>


@endsection
