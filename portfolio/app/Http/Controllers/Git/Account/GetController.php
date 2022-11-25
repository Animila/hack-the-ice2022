<?php

namespace App\Http\Controllers\Git\Account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class GetController extends Controller
{
    public function __invoke()
    {
        $token = auth()->user()->token;
        $event = "JSON_APPS";
        $response = Http::withToken($token);
        $api = "https://api.github.com/repos/".auth()->user()->nickname."/".$event."/contents/";
        $this->getTree($response, $api);

        return '';
    }



    private function getTree($response, $api) {
        $answer = $response->get($api);
        $list = $answer->json();
//        $count($list)
        foreach ($list as $item) {

            if ($item["type"] == "dir" ) {
                print('<br><h1>ПАПКА</h1><br>');
                print($item['name']);
                print($api.$item['name'].'/');
                $api_child = $api.$item['name'].'/';
                print('<br>');
                $this->getTree($response, $api_child);
            }
            if ($item['type'] == 'file') {
                print($item['name']);
                print('<br><br>');
            }
        }

    }
}

