<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SelectController extends Controller
{
    public function __invoke()
    {
        $token = auth()->user()->token;
        $event = "test_rep";
        $response = Http::withToken($token);
        $api = "https://api.github.com/repos/".auth()->user()->nickname."/".$event."/contents/";
        return $api;
        $answer = $response->get($api);
        $list = $answer->json();
        $files = [];
        foreach ($list as $item) {

            if ($item["type"] == "dir" ) {
                $files[$item['name']] = [$item['name'], $item['type']];
            }
        }
        return view('vibor', compact('files'));

    }
}
