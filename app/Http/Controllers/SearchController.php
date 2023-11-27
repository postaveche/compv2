<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Search;

class SearchController extends Controller
{
    public function addsearch($request){
        $ipaddress = request()->ip();
        $fraza = $request;

        $addsearch = new Search();
        $addsearch->expresion = $fraza;
        $addsearch->ipaddress = $ipaddress;
        $addsearch->save();
    }
}
