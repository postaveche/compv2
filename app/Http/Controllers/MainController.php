<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Product;

class MainController extends Controller
{
    public static function last_12(){
        $last12 = Product::latest()->where('active', '1')->take(8)->get();
        return view('block.product_list',[
           'products' => $last12
        ]);
    }

    public static function random_main(){
        $products = Product::inRandomOrder()->where('active', '1')->take(12)->get();
        return view('block.product_list',[
           'products' => $products
        ]);
    }

    public function redirect_ro($page){
        return redirect($page, 301);
    }
}
