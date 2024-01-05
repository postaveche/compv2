<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Settings;
use App\Models\Curs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SearchController;

class ProductsController extends Controller
{
    public function show($locale, $slug)
    {
        //dd($slug);
        $product = Product::where('slug', $slug)->first();
        if (!isset($product)) {
            return response(view('errors.404'), 404);
        }
        $catinfo = Category::with('subcategory')->where('id', $product['category_id'])->first();
        $product_info = json_decode($product->product_info);
        $product_img = json_decode($product['img']);
        return view('pages.product', [
            'product' => $product,
            'product_img' => $product_img,
            'cat' => $catinfo,
            'product_info' => $product_info
        ]);
    }

    public static function price($price_usd)
    {
        $curs = DB::table('curses')->latest()->first();
        $site_settings = DB::table('settings')->latest()->first();
        $proc = $site_settings->price_procent + 100;
        $price_mdl = $price_usd * $curs->usd_sell;
        $price_mdl = ($price_mdl / 100) * $proc;
        $price_eur = $price_mdl / $curs->eur_sell;
        $price_usd = ceil(($price_usd/100) * $proc);
        $price_mdl = ceil($price_mdl);
        $price_eur = ceil($price_eur);
        return view('block.product_price', [
            'price_usd' => $price_usd,
            'price_mdl' => $price_mdl,
            'price_eur' => $price_eur
        ]);
    }

    public static function recomandat($cat){
        $recomandat = Product::where('category_id', $cat)->inRandomOrder()->limit(4)->get();
        return view('block.product_list',[
           'products' => $recomandat
        ]);
    }

    public function search(Request $query)
    {
        $search = $query->input('search');

        $products = Product::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('text', 'LIKE', "%{$search}%")
            ->orWhere('sku', 'LIKE', "%{$search}%")
            ->orderBy('price')
            ->get();

            $products_count = count($products);

            $addtodb = (new SearchController)->addsearch($search);

        return view('pages.search', [
            'products' => $products,
            'query' => $search,
            'products_count' => $products_count
        ]);
    }
}
