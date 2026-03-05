<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $produse = Product::orderby('id', 'DESC')->paginate(25);
        
        // Obținem cursul valutar și settings pentru calculul prețurilor
        $curs = DB::table('curses')->latest()->first();
        $site_settings = DB::table('settings')->latest()->first();
        
        return view('admin.products.index', [
            'produse' => $produse,
            'curs' => $curs,
            'site_settings' => $site_settings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $category = Category::all();
        return view('admin.products.create', [
            'category' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $last_id = Product::latest()->first()->id;
        $next_id = $last_id + 1;
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->keywords = $request->keywords;
        if ($request->slug == null) {
            $product->slug = $next_id.'-'.Str::slug($request->name);
        } else {
            $product->slug = $next_id.'-'.$request->slug;
        }
        $product->sku = $request->sku;
        if ($request->hasFile('uploadimg')){
            $i = 1;
            foreach ($request->file('uploadimg') as $file){
                $name = $product->slug.'_'.$i.'.'.$file->extension();
                $file->storeAs('public/products/', $name);
                $i = $i + 1;
                $data[] = $name;
            }
        }
        $product->img = json_encode($data);
        $product->text = $request->text;
        $product->price = $request->price;
        $product->special_price = $request->specialprice;
        $product->category_id = $request->category_id;
        $product->user_id = $request->user_id;
        $product->active = $request->active;
        //dd($product);
        $product->save();
        return redirect()->route('products.index')->with('success', 'Produsul a fost adaugat cu succes!!!');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        $category = Category::all();
        return view('admin.products.edit', [
            'produs' => $product,
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        $product = Product::where('id', $id)->first();
        $product->name = $request->name;
        $product->name_ro = $request->name_ro;
        $product->name_ru = $request->name_ru;
        $product->description = $request->description;
        $product->description_ru = $request->description_ru;
        $product->keywords = $request->keywords;
        $product->sku = $request->sku;
        $product->text = $request->text;
        $product->text_ru = $request->text_ru;
        $product->price = $request->price;
        $product->special_price = $request->specialprice;
        $product->category_id = $request->category_id;
        $product->user_id = $request->user_id;
        $product->active = $request->active;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Produsul a fost editat cu succes!!!');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Șterge imaginile asociate cu produsul
        if ($product->img) {
            $images = json_decode($product->img, true);
            
            if (is_array($images)) {
                foreach ($images as $image) {
                    $imagePath = storage_path('app/public/products/' . $image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
        }
        
        // Șterge produsul din baza de date
        $product->delete();
        
        return redirect()->route('products.index')->with('success', 'Produsul și imaginile asociate au fost șterse cu succes!');
    }

    /**
     * Update multiple products status
     *
     * @param Request $request
     * @return Response
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'bulk_action' => 'required|in:activate,deactivate,change_category',
            'selected_products' => 'required|array|min:1',
            'selected_products.*' => 'exists:product,id',
            'category_id' => 'required_if:bulk_action,change_category|exists:category,id'
        ]);

        $productIds = $request->selected_products;
        $action = $request->bulk_action;
        
        $updatedCount = 0;
        $successMessage = '';
        
        switch ($action) {
            case 'activate':
                $updatedCount = Product::whereIn('id', $productIds)->update(['active' => 1]);
                $successMessage = "Au fost activate {$updatedCount} produse cu succes!";
                break;
                
            case 'deactivate':
                $updatedCount = Product::whereIn('id', $productIds)->update(['active' => 0]);
                $successMessage = "Au fost dezactivate {$updatedCount} produse cu succes!";
                break;
                
            case 'change_category':
                $categoryId = $request->category_id;
                $category = Category::findOrFail($categoryId);
                $updatedCount = Product::whereIn('id', $productIds)->update(['category_id' => $categoryId]);
                $successMessage = "Au fost mutate {$updatedCount} produse în categoria \"{$category->name}\" cu succes!";
                break;
        }
        
        return redirect()->route('products.index')->with('success', $successMessage);
    }
}
