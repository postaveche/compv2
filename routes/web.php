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
use App\Http\Controllers\admin\PagesController;
use App\Http\Controllers\admin\AdminProductSearchController;

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
        return view('pages.reparatie_laptop', [
            'services' => __('laptop.services'),
        ]);
    })->name('reparatie_laptop');
    Route::get('reparatii_laptop_notebook/{service}', function ($locale, $service) {
        $services = __('laptop.services');

        abort_unless(isset($services[$service]), 404);

        return view('pages.reparatie_laptop_service', [
            'service' => $services[$service],
            'serviceSlug' => $service,
            'serviceImage' => config('laptop_service_images.'.$service, 'img/remont-noutbukov-0.jpg'),
            'services' => $services,
        ]);
    })->where('service', '[a-z0-9-]+')->name('laptop_service');
    Route::get('reparatii_imprimante', function () {
        return view('pages.reparatii_imprimante');
    })->name('reparatii_imprimate');
    Route::get('reparatii_proiectoare', function () {
        return view('pages.reparatii_proiectoare');
    })->name('reparatii_proiectoare');
    Route::get('reparatii_aspiratoare', function () {
        return view('pages.reparatii_aspiratoare');
    })->name('reparatii_aspiratoare');
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
    Route::get('/retur', function () {
        return view('pages.retur');
    })->name('retur');
    Route::get('/category', function () {
        return redirect('/', 301);
    })->name('all_category');
    Route::get('/board', function () {
        return view('pages.board');
    })->name('board');
    Route::get('/search/', [ProductsController::class, 'search'])->name('search');
    Route::get('get_curs', [CursController::class, 'index'])->name('get_curs');
    Route::get('get_b2b', [B2BAccentController::class, 'b2b_auth'])->name('get_b2b');
    Route::get('/category/{category}', [CategoryController::class, 'show'])->name('list_category');
    Route::get('product/{slug}', [ProductsController::class, 'show'])->name('product_info');
});

if (isset($_SESSION['locale'])) {
    Route::get('/', function () {
        return redirect('/' . $_SESSION['locale'], 301);
    });
} else {
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

Route::get('/admincp/get_b2bfoldersv2', [B2BAccentController::class, 'b2b_foldersv2'])->name('b2b_foldersv2')->middleware('auth');

Route::get('/admincp/get_b2binfo', [AdminProductInfoController::class, 'all_product_info'])->name('get_b2binfo')->middleware('auth');

Route::get('/admincp/get_b2bsingleinfo/{code}', [AdminProductInfoController::class, 'single_update_info'])->name('single_update_info')->middleware('auth');

Route::get('/admincp/get_b2bstok/{b2b_code}', [AdminProductInfoController::class, 'product_in_stoc2'])->name('get_b2bstok');

Route::get('/admincp/get_b2bstok3/{b2b_code}', [AdminProductInfoController::class, 'product_in_stoc3'])->name('get_b2bstok');

Route::get('/admincp/importbycat', [B2BAccentController::class, 'import_by_folders'])->name('import_by_folder')->middleware('auth');

Route::get('/admincp/products/find/', [AdminProductSearchController::class, 'search'])->middleware('auth')->name('findproducts');

Route::post('/admincp/products/bulk-update', [AdminProductController::class, 'bulkUpdate'])->middleware('auth')->name('products.bulk-update');
Route::get('/admincp/products/service', [AdminProductController::class, 'servicePage'])->middleware('auth')->name('products.service');
Route::post('/admincp/products/deactivate-by-category', [AdminProductController::class, 'deactivateByCategory'])->middleware('auth')->name('products.deactivate-by-category');
Route::post('/admincp/products/activate-by-category', [AdminProductController::class, 'activateByCategory'])->middleware('auth')->name('products.activate-by-category');

Route::resource('/admincp/products', AdminProductController::class)->middleware('auth');

Route::resource('/admincp/pages', PagesController::class)->middleware('auth');

Route::post('/admincp/pages/upload', [PagesController::class, 'upload'])->name('ckeditor.upload');

Route::resource('/admincp/bannerblock', \App\Http\Controllers\admin\BannerBlockController::class)->middleware('auth');

// Utilizatori admin
Route::middleware('auth')->prefix('admincp/users')->name('admin.users.')->group(function () {
    Route::get('/', [\App\Http\Controllers\admin\UserController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\admin\UserController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\admin\UserController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [\App\Http\Controllers\admin\UserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [\App\Http\Controllers\admin\UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [\App\Http\Controllers\admin\UserController::class, 'destroy'])->name('destroy');
});
Route::middleware('auth')->prefix('admincp/roles')->name('admin.roles.')->group(function () {
    Route::get('/', [\App\Http\Controllers\admin\UserController::class, 'roles'])->name('index');
    Route::post('/', [\App\Http\Controllers\admin\UserController::class, 'storeRole'])->name('store');
    Route::delete('/{id}', [\App\Http\Controllers\admin\UserController::class, 'deleteRole'])->name('destroy');
});

// Slidere admin
Route::resource('/admincp/sliders', \App\Http\Controllers\admin\AdminSliderController::class)->middleware('auth');

// Telegram settings
Route::get('/admincp/settings/telegram', [\App\Http\Controllers\admin\TelegramSettingsController::class, 'edit'])->middleware('auth')->name('admin.telegram');
Route::put('/admincp/settings/telegram', [\App\Http\Controllers\admin\TelegramSettingsController::class, 'update'])->middleware('auth')->name('admin.telegram.update');
Route::get('/admincp/settings/telegram/test', [\App\Http\Controllers\admin\TelegramSettingsController::class, 'test'])->middleware('auth')->name('admin.telegram.test');

// Translate API (DeepL)
Route::post('/admincp/api/translate-batch', [\App\Http\Controllers\admin\TranslateController::class, 'translateBatch'])->middleware('auth')->name('admin.translate.batch');
Route::get('/admincp/settings/translate', [\App\Http\Controllers\admin\TranslateController::class, 'settings'])->middleware('auth')->name('admin.translate.settings');
Route::put('/admincp/settings/translate', [\App\Http\Controllers\admin\TranslateController::class, 'updateSettings'])->middleware('auth')->name('admin.translate.settings.update');
Route::get('/admincp/settings/translate/test', [\App\Http\Controllers\admin\TranslateController::class, 'test'])->middleware('auth')->name('admin.translate.test');

// Work Schedule
Route::get('/admincp/settings/schedule', [\App\Http\Controllers\admin\WorkScheduleController::class, 'edit'])->middleware('auth')->name('admin.schedule');
Route::put('/admincp/settings/schedule', [\App\Http\Controllers\admin\WorkScheduleController::class, 'update'])->middleware('auth')->name('admin.schedule.update');
Route::post('/admincp/sliders/{slider}/items', [\App\Http\Controllers\admin\AdminSliderController::class, 'addItem'])->middleware('auth')->name('sliders.items.add');
Route::put('/admincp/sliders/items/{item}', [\App\Http\Controllers\admin\AdminSliderController::class, 'updateItem'])->middleware('auth')->name('sliders.items.update');
Route::delete('/admincp/sliders/items/{item}', [\App\Http\Controllers\admin\AdminSliderController::class, 'deleteItem'])->middleware('auth')->name('sliders.items.delete');
Route::get('/admincp/sliders/{slider}/stats', [\App\Http\Controllers\admin\AdminSliderController::class, 'stats'])->middleware('auth')->name('sliders.stats');

// Slider tracking (AJAX)
Route::post('/slider/track-view', [\App\Http\Controllers\SliderController::class, 'trackView'])->name('slider.track.view');
Route::post('/slider/track-click/{id}', [\App\Http\Controllers\SliderController::class, 'trackClick'])->name('slider.track.click');

// Service Center
Route::middleware('auth')->prefix('admincp/service')->name('service.')->group(function () {
    Route::get('/', [\App\Http\Controllers\admin\ServiceController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\admin\ServiceController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\admin\ServiceController::class, 'store'])->name('store');
    
    // Rute statice - INAINTE de /{id}
    Route::get('/clients/list', [\App\Http\Controllers\admin\ServiceController::class, 'clients'])->name('clients');
    Route::get('/clients/create', [\App\Http\Controllers\admin\ServiceController::class, 'createClient'])->name('clients.create');
    Route::post('/clients', [\App\Http\Controllers\admin\ServiceController::class, 'storeClient'])->name('clients.store');
    Route::get('/clients/{id}/edit', [\App\Http\Controllers\admin\ServiceController::class, 'editClient'])->name('clients.edit');
    Route::put('/clients/{id}', [\App\Http\Controllers\admin\ServiceController::class, 'updateClient'])->name('clients.update');
    Route::get('/clients/{id}/show', [\App\Http\Controllers\admin\ServiceController::class, 'showClient'])->name('clients.show');
    Route::get('/api/search-client', [\App\Http\Controllers\admin\ServiceController::class, 'searchClient'])->name('search.client');
    Route::get('/api/client-orders/{clientId}', [\App\Http\Controllers\admin\ServiceController::class, 'clientOrders'])->name('client.orders');
    Route::get('/device-types', [\App\Http\Controllers\admin\ServiceController::class, 'deviceTypes'])->name('device-types');
    Route::post('/device-types', [\App\Http\Controllers\admin\ServiceController::class, 'storeDeviceType'])->name('device-types.store');
    Route::delete('/device-types/{id}', [\App\Http\Controllers\admin\ServiceController::class, 'deleteDeviceType'])->name('device-types.delete');
    Route::delete('/photos/{photo}', [\App\Http\Controllers\admin\ServiceController::class, 'deletePhoto'])->name('photos.delete');
    
    // Rute cu {id} - LA FINAL
    Route::get('/{id}', [\App\Http\Controllers\admin\ServiceController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [\App\Http\Controllers\admin\ServiceController::class, 'edit'])->name('edit');
    Route::put('/{id}', [\App\Http\Controllers\admin\ServiceController::class, 'update'])->name('update');
    Route::delete('/{id}', [\App\Http\Controllers\admin\ServiceController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/print', [\App\Http\Controllers\admin\ServiceController::class, 'printReceipt'])->name('print');
    Route::get('/{id}/pdf', [\App\Http\Controllers\admin\ServiceController::class, 'downloadPdf'])->name('pdf');
    Route::get('/{id}/delivery', [\App\Http\Controllers\admin\ServiceController::class, 'printDelivery'])->name('delivery');
    Route::get('/{id}/delivery-pdf', [\App\Http\Controllers\admin\ServiceController::class, 'downloadDeliveryPdf'])->name('delivery.pdf');
    Route::get('/{id}/work-report', [\App\Http\Controllers\admin\ServiceController::class, 'printWorkReport'])->name('work-report');
    Route::get('/{id}/work-report-pdf', [\App\Http\Controllers\admin\ServiceController::class, 'downloadWorkReportPdf'])->name('work-report.pdf');
    Route::post('/{id}/photos', [\App\Http\Controllers\admin\ServiceController::class, 'addPhotos'])->name('photos.add');
});

// Hosting si domenii
Route::middleware('auth')->prefix('admincp/hosting')->name('hosting.')->group(function () {
    Route::get('/', [\App\Http\Controllers\admin\HostingController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\admin\HostingController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\admin\HostingController::class, 'store'])->name('store');
    Route::get('/packages', [\App\Http\Controllers\admin\HostingController::class, 'packages'])->name('packages');
    Route::post('/packages', [\App\Http\Controllers\admin\HostingController::class, 'storePackage'])->name('packages.store');
    Route::put('/packages/{id}', [\App\Http\Controllers\admin\HostingController::class, 'updatePackage'])->name('packages.update');
    Route::delete('/packages/{id}', [\App\Http\Controllers\admin\HostingController::class, 'deletePackage'])->name('packages.delete');
    Route::get('/invoices/{id}', [\App\Http\Controllers\admin\HostingController::class, 'invoice'])->name('invoices.show');
    Route::post('/{id}/invoice', [\App\Http\Controllers\admin\HostingController::class, 'generateInvoice'])->name('invoice.generate');
    Route::post('/{id}/paid', [\App\Http\Controllers\admin\HostingController::class, 'markPaid'])->name('paid');
    Route::post('/{id}/reminder', [\App\Http\Controllers\admin\HostingController::class, 'sendReminder'])->name('reminder');
    Route::get('/{id}/edit', [\App\Http\Controllers\admin\HostingController::class, 'edit'])->name('edit');
    Route::put('/{id}', [\App\Http\Controllers\admin\HostingController::class, 'update'])->name('update');
    Route::delete('/{id}', [\App\Http\Controllers\admin\HostingController::class, 'destroy'])->name('destroy');
});
