<?php

use App\Http\Controllers\admin\AdminCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminProductController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CursController;
use App\Http\Controllers\admin\B2BAccentController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\admin\AdminProductInfoController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\admin\PagesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group([
    'prefix' => '{locale}',
    'as' => 'locale.',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'where' => ['locale' => '(ru|ro)'],
    'middleware' => 'locale'
], function ($locale) {

    Route::get('/', function () {
        return view('main');
    })->name('acasa');
    Route::get('/reincarcare_imprimante', function () {
        return view('pages.reincarcare');
    })->name('reincarcare');
    Route::get('reparatie', function () {
        return view('pages.reparatie');
    })->name('reparatii');
    Route::get('reparatii_laptop_notebook', function () {
        return view('pages.reparatie_laptop');
    })->name('reparatie_laptop');
    Route::get('reparatii_imprimante', function () {
        return view('pages.reparatii_imprimante');
    })->name('reparatii_imprimate');
    Route::get('specialist', function () {
        return view('pages.specialist');
    })->name('specialist');
    Route::get('freehosting', function () {
        return view('pages.hosting');
    })->name('hosting');
    Route::get('/contacte', function () {
        return view('pages.contacte');
    })->name('contacte');
    Route::get('/rechizite_bancare', function () {
        return view('pages.rechizite');
    })->name('rechizite_bancare');
    Route::get('/category', function () {
        return view('pages.category');
    })->name('all_category');
    Route::get('/board', function () {
        return view('pages.board');
    })->name('board');
    Route::get('/search/', [ProductsController::class, 'search'])->name('search');
    Route::get('get_curs', [CursController::class, 'index'])->name('get_curs');
    Route::get('get_b2b', [B2BAccentController::class, 'b2b_auth'])->name('get_b2b');
    Route::get('/category/{category}', [CategoryController::class, 'show'])->name('list_category');
    Route::get('product/{slug}', [ProductsController::class, 'show'])->name('product_info');
//    Route::get('/ro/{page}', [MainController::class, 'redirect_ro']);
});

if (isset($_SESSION['locale'])){
    Route::get('/', function () { return redirect('/'.$_SESSION['locale'], 301); });
}
else {
    Route::get('/', function () {
        return redirect('/ro', 301);
    });
}

Route::get('set-language', [\App\Http\Controllers\LanguageController::class, 'setLanguage'])->name('set.language');

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/admincp', function () {
    return view('admin.index');
})->middleware('auth');

Route::resource('/admincp/category', AdminCategoryController::class)->middleware('auth');

Route::get('/admincp/import/{code}/{category}', [B2BAccentController::class, 'import_b2b'])->name('b2b_import')->middleware('auth');

Route::get('/admincp/get_b2bfolders', [B2BAccentController::class, 'b2b_folders'])->name('b2b_folders')->middleware('auth');

Route::get('/admincp/get_b2binfo', [AdminProductInfoController::class, 'all_product_info'])->name('get_b2binfo')->middleware('auth');

Route::get('/admincp/get_b2bstok/{b2b_code}', [AdminProductInfoController::class, 'product_in_stoc2'])->name('get_b2bstok');

Route::get('/admincp/get_b2bstok3/{b2b_code}', [AdminProductInfoController::class, 'product_in_stoc3'])->name('get_b2bstok');

Route::get('/admincp/importbycat', [B2BAccentController::class, 'import_by_folders'])->name('import_by_folder')->middleware('auth');

Route::resource('/admincp/products', AdminProductController::class)->middleware('auth');

Route::resource('/admincp/pages', PagesController::class)->middleware('auth');

Route::post('/admincp/pages/upload', [PagesController::class, 'upload'])->name('ckeditor.upload');

Route::get('mysitemap', function(){

    // create new sitemap object
    $sitemap = App::make("sitemap");

    // add items to the sitemap (url, date, priority, freq)
    $sitemap->add(URL::to('/'), '2022-08-25T20:10:00+02:00', '1.0', 'daily');
    $sitemap->add(URL::to('/reincarcare_imprimante'), '2022-08-26T12:30:00+02:00', '0.5', 'monthly');
    $sitemap->add(URL::to('/reparatie'), '2022-08-26T12:30:00+02:00', '0.5', 'monthly');
    $sitemap->add(URL::to('/reparatii_laptop_notebook'), '2022-08-26T12:30:00+02:00', '0.5', 'monthly');
    $sitemap->add(URL::to('/reparatii_imprimante'), '2022-08-26T12:30:00+02:00', '0.5', 'monthly');
    $sitemap->add(URL::to('/freehosting'), '2022-08-26T12:30:00+02:00', '0.5', 'monthly');
    $sitemap->add(URL::to('/contacte'), '2022-08-26T12:30:00+02:00', '0.5', 'monthly');
    $sitemap->add(URL::to('/rechizite_bancare'), '2022-08-26T12:30:00+02:00', '0.5', 'monthly');

    $categories = DB::table('category')->orderBy('created_at', 'desc')->get();

    foreach ($categories as $category)
    {
        $sitemap->add(URL::to('category/'.$category->slug), $category->updated_at, '0.7', 'monthly');
    }

    // get all posts from db
    $products = DB::table('product')->orderBy('created_at', 'desc')->get();

    // add every post to the sitemap
    foreach ($products as $product)
    {
        $sitemap->add(URL::to('product/'.$product->slug), $product->updated_at, '0.5', 'monthly');
    }

    // generate your sitemap (format, filename)
    $sitemap->store('xml', 'sitemap');
    // this will generate file mysitemap.xml to your public folder1

});
