<?php

namespace App\Http\Controllers;

class ProxyController extends Controller
{

    public function getGiveaways()
    {
        $url = "https://www.gamerpower.com/api/giveaways?platform=steam";
        $response = file_get_contents($url);
        return response()->json(json_decode($response));
    }

}
