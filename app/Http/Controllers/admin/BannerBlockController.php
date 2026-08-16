<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BannerBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerBlockController extends Controller
{
    public function index()
    {
        $banners = BannerBlock::orderBy('sort_order')->orderByDesc('id')->get();

        return view('admin.bannerblock.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.bannerblock.create', ['banner' => new BannerBlock()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data['image'] = $this->storeImage($request);
        BannerBlock::create($data);

        return redirect()->route('bannerblock.index')->with('success', 'Bannerul a fost adăugat cu succes.');
    }

    public function show($id)
    {
        return redirect()->route('bannerblock.edit', $id);
    }

    public function edit($id)
    {
        return view('admin.bannerblock.edit', ['banner' => BannerBlock::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $banner = BannerBlock::findOrFail($id);
        $data = $this->validated($request, false);

        if ($request->hasFile('uploadimg')) {
            $newImage = $this->storeImage($request);
            $this->deleteImage($banner->image);
            $data['image'] = $newImage;
        }

        $banner->update($data);

        return redirect()->route('bannerblock.index')->with('success', 'Bannerul a fost actualizat cu succes.');
    }

    public function destroy($id)
    {
        $banner = BannerBlock::findOrFail($id);
        $this->deleteImage($banner->image);
        $banner->delete();

        return redirect()->route('bannerblock.index')->with('success', 'Bannerul a fost șters.');
    }

    private function validated(Request $request, bool $imageRequired): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_ru' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'description_ru' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            'uploadimg' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        return [
            'name' => $data['name'],
            'name_ru' => $data['name_ru'],
            'desc' => $data['description'],
            'desc_ru' => $data['description_ru'],
            'link' => trim($data['link'], " \t\n\r\0\x0B/"),
            'active' => $request->boolean('active'),
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ];
    }

    private function storeImage(Request $request): string
    {
        $file = $request->file('uploadimg');
        $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'banner';
        $name = $base.'-'.Str::lower(Str::random(10)).'.'.$file->extension();
        $file->storeAs('public/banners', $name);

        return $name;
    }

    private function deleteImage(?string $image): void
    {
        if ($image) {
            Storage::delete('public/banners/'.$image);
            Storage::delete('public/banners/'.$image.'@300');
        }
    }
}
