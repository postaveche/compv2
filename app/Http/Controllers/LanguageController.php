<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function setLanguage(Request $request)
    {
        $url = $request->session()->get('_previous.url');
        $segments = explode('/', $url);
        $langIndex = array_search(\session('locale'), $segments);
        $rentPart = implode('/', array_slice($segments, $langIndex + 1));
        Session::put('locale', $request->input('locale'));
        $url = url('/'). '/'. $request->input('locale') .'/' . $rentPart;
        return redirect()->away($url);
    }
}
