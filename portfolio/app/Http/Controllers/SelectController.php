<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SelectController extends Controller
{
    public function __invoke()
    {
        $token = auth()->user()->token;
        $api = "https://api.github.com/repos/Animila/".env('REPOSITORY')."/contents/";
        $answer = Http::withToken($token)->get($api);
        $list = $answer->json();
//        print($api."<br>");
//        print_r($answer);
//        print($answer->status()."<br>");
//        print_r($list);
//        return '';
        $files = [];
        foreach ($list as $item) {

            if ($item["type"] == "dir" ) {
                $files[$item['name']] = [$item['name'], $item['type']];
            }
        }
        return view('select', compact('files'));

    }
}
