<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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
        return view('admin.products.index', [
            'produse' => $produse
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
