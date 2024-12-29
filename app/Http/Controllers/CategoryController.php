<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public static function index()
    {
        $category = Category::where('subcat', '0')->get();
        $subcategory = Category::where('subcat', '<>', '0')->orderBy('name')->get();
        return view('block.top_menu', [
            'category' => $category,
            'subcategory' => $subcategory
        ]);
    }

    public static function show_all()
    {
        $category = Category::all();
        return view('admin.block.select_category', [
            'category' => $category
        ]);
    }

    public function show($locale, $category)
    {
        $catinfo = Category::with('subcategory')->where('slug', $category)->first();
        $products = Product::where([['category_id', $catinfo['id']], ['active', '1']])->orderby('price')->paginate(20);
        if (!isset($catinfo)) {
            return response(view('errors.404'), 404);
        }
        if (isset($catinfo->subcategory) and $catinfo['subcat'] == 0) {
            if($locale == 'ru' ){
                $title = $catinfo['title_ru'];
                $description = $catinfo['description_ru'];
                $key = $catinfo['keywords_ru'];
                $full_desc = $catinfo['full_desc_ru'];
            } else {
                $title = $catinfo['title_ro'];
                $description = $catinfo['description'];
                $key = $catinfo['keywords'];
                $full_desc = $catinfo['full_desc_ro'];
            }
            $subcategory_id = Category::where('subcat', $catinfo['id'])->get();
            //dd($subcategory_id);
            foreach ($subcategory_id as $id) {
                $category_id[] = $id->id;
            }
            $products = Product::whereIn('category_id', $category_id)->orderBy('price')->paginate(20);
            //dd($products);
        } else {
            if($locale == 'ru' ) {
                $title = $catinfo->title_ru;
                $description = $catinfo->description_ru;
                $key = $catinfo->keywords_ru;
                $full_desc = $catinfo->full_desc_ru;
                } else {
                $title = $catinfo->title_ro;
                $description = $catinfo->description;
                $key = $catinfo->keywords;
                $full_desc = $catinfo->full_desc_ro;
            }
        }

        $page = request()->get('page', 1);
        if ($page > 1) {
            $title .= " - " . __('pagination.page') . " $page";
            $description .= " - " . __('pagination.page_desc') . " $page";
        }

        return view('pages.category', [
            'cat' => $catinfo,
            'subcateg' => $catinfo->subcategory(),
            'title' => $title,
            'description' => $description,
            'keywords' => $key,
            'products' => $products,
            'full_desc' => $full_desc
        ]);
    }

    public function all_category(){

    }

    public static function produs_thumb($id)
    {
        $produs = Product::where('id', $id)->first();
        $produs_img = $produs['img'];
        $produs_img = json_decode($produs_img);
        $thumb = $produs_img['0'];
        return $thumb;
    }

    public static function category_price($price_usd)
    {
        $curs = DB::table('curses')->latest()->first();
        $site_settings = DB::table('settings')->latest()->first();
        $proc = $site_settings->price_procent + 100;
        $price_mdl = $price_usd * $curs->usd_sell;
        $price_mdl = ($price_mdl / 100) * $proc;
        $price_mdl = ceil($price_mdl);
        return $price_mdl;
    }
}
