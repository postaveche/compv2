<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\admin\B2BAccentController;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoies = Category::orderBy('id', 'desc')->paginate(10);
        return view('admin.category.index', [
            'category' => $categoies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->keywords = $request->keywords;
        $category->subcat = $request->subcat;
        $category->save();
        return redirect()->route('category.index')->with('success', 'Categoria a fost adaugata cu succes!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = Category::where('id', $id)->first();
        return view('admin.category.edit')->with('cat', $cat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->name = $request->name;
        $category->name_ru = $request->name_ru;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->description_ru = $request->description_ru;
        $category->keywords = $request->keywords;
        $category->keywords_ru = $request->keywords_ru;
        $category->subcat = $request->subcat;
        $category->save();
        return redirect()->route('category.index')->with('success', 'Categoria a fost modificata cu succes!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Category::where('id',$id)->first();
        if ($cat == !null){
            $cat->delete();
            return redirect()->back()->with('success','Categoria a fost ștearsă cu success!');
        }
        return redirect()->back()->with('danger','Aceasta categorie nu exista!');
    }
}
