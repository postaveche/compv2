<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use App\Models\SliderItem;
use Illuminate\Http\Request;

class AdminSliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::withCount('items')->orderBy('sort_order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.sliders.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'position' => 'required|in:home,product,category']);
        Slider::create(['name' => $request->name, 'position' => $request->position, 'category_ids' => $request->category_ids, 'active' => $request->active ?? 0, 'sort_order' => $request->sort_order ?? 0]);
        return redirect()->route('sliders.index')->with('success', 'Creat!');
    }

    public function show($id)
    {
        return redirect()->route('sliders.edit', $id);
    }

    public function edit($id)
    {
        $slider = Slider::with('items')->findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('admin.sliders.edit', compact('slider', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255', 'position' => 'required|in:home,product,category']);
        $slider = Slider::findOrFail($id);
        $slider->update(['name' => $request->name, 'position' => $request->position, 'category_ids' => $request->category_ids, 'active' => $request->active ?? 0, 'sort_order' => $request->sort_order ?? 0]);
        return redirect()->route('sliders.index')->with('success', 'Actualizat!');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        foreach ($slider->items as $item) {
            $p = storage_path('app/public/sliders/' . $item->image);
            if (file_exists($p)) { unlink($p); }
        }
        $slider->delete();
        return redirect()->route('sliders.index')->with('success', 'Sters!');
    }

    public function addItem(Request $request, $sliderId)
    {
        $request->validate(['image' => 'required|image|max:5120']);
        $slider = Slider::findOrFail($sliderId);
        $file = $request->file('image');
        $name = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/sliders', $name);
        $slider->items()->create([
            'title' => $request->title, 'title_ru' => $request->title_ru,
            'description' => $request->description, 'description_ru' => $request->description_ru,
            'image' => $name, 'link' => $request->link,
            'active' => $request->active ?? 1, 'sort_order' => $request->sort_order ?? 0,
        ]);
        return redirect()->route('sliders.edit', $sliderId)->with('success', 'Adaugat!');
    }

    public function updateItem(Request $request, $itemId)
    {
        $item = SliderItem::findOrFail($itemId);
        $item->title = $request->title;
        $item->title_ru = $request->title_ru;
        $item->description = $request->description;
        $item->description_ru = $request->description_ru;
        $item->link = $request->link;
        $item->active = $request->active ?? 0;
        $item->sort_order = $request->sort_order ?? 0;
        if ($request->hasFile('image')) {
            $op = storage_path('app/public/sliders/' . $item->image);
            if (file_exists($op)) { unlink($op); }
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/sliders', $name);
            $item->image = $name;
        }
        $item->save();
        return redirect()->route('sliders.edit', $item->slider_id)->with('success', 'Actualizat!');
    }

    public function deleteItem($itemId)
    {
        $item = SliderItem::findOrFail($itemId);
        $sid = $item->slider_id;
        $p = storage_path('app/public/sliders/' . $item->image);
        if (file_exists($p)) { unlink($p); }
        $item->delete();
        return redirect()->route('sliders.edit', $sid)->with('success', 'Sters!');
    }

    public function stats($id)
    {
        $slider = Slider::with('items')->findOrFail($id);
        $totalViews = $slider->items->sum('views');
        $totalClicks = $slider->items->sum('clicks');
        return view('admin.sliders.stats', compact('slider', 'totalViews', 'totalClicks'));
    }
}
