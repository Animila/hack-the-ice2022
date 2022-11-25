<?php

namespace App\Http\Controllers\Git\Account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use PhpOption\None;

class GetController extends Controller
{

    public function __invoke($nick)
    {
        $token = auth()->user()->token;
        $response = Http::withToken($token);
        $api = "https://api.github.com/repos/Animila/".config('app.event')."/contents/".$nick;
        $answer =  $this->getTree($response, $api, $nick);

        return view('index', compact('answer'));
    }



    public function getTree($response, $api, $nick=None) {
        $answer = $response->get($api);
        $list = $answer->json();
        $files = [];
        foreach ($list as $item) {

            if ($item["type"] == "dir" ) {
                $files[$item['name']] = [$item['name'], $item['type']];
                $api_child = $api.$item['name'].'/';
                $this->getTree($response, $api_child);
            }
            if ($item['type'] == 'file') {
                $files[$item['name']]
                    = [
                        'name'=>$item['name'],
                        'url'=>$item['download_url']];
            }
        }
        print_r($files);

        return [$nick, $files];

    }
}

