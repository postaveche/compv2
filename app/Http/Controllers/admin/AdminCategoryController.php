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
        $allCategories = Category::orderBy('name')->get();
        $sorted = collect();
        $this->buildCategoryTree($allCategories, '0', 0, $sorted);
        return view('admin.category.index', ['categories' => $sorted]);
    }

    private function buildCategoryTree($all, $parentId, $level, &$sorted)
    {
        $children = $all->where('subcat', $parentId)->sortBy('name');
        foreach ($children as $cat) {
            $cat->_level = $level;
            $sorted->push($cat);
            $this->buildCategoryTree($all, $cat->id, $level + 1, $sorted);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.category.create', compact('categories'));
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
        $category->name_ru = $request->name_ru;
        $category->title_ro = $request->title_ro;
        $category->title_ru = $request->title_ru;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->description_ru = $request->description_ru;
        $category->keywords = $request->keywords;
        $category->keywords_ru = $request->keywords_ru;
        $category->full_desc_ro = $request->full_desc_ro;
        $category->full_desc_ru = $request->full_desc_ru;
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
        $categories = Category::where('id', '!=', $id)->orderBy('name')->get();
        return view('admin.category.edit', compact('cat', 'categories'));
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
        $category->title_ro = $request->title_ro;
        $category->title_ru = $request->title_ru;
        $category->description = $request->description;
        $category->description_ru = $request->description_ru;
        $category->keywords = $request->keywords;
        $category->keywords_ru = $request->keywords_ru;
        $category->full_desc_ro = $request->full_desc_ro;
        $category->full_desc_ru = $request->full_desc_ru;
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
