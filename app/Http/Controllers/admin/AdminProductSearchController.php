<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductSearchController extends Controller
{
    public function search(Request $request){
        $query = Product::query();
        
        // Filtrare după text de căutare
        if ($request->filled('query')) {
            $search = $request->input('query');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('text', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }
        
        // Filtrare după categorie (include și subcategoriile)
        if ($request->filled('category_id')) {
            $categoryId = $request->input('category_id');
            
            // Găsim toate subcategoriile acestei categorii
            $subcategoryIds = Category::where('subcat', $categoryId)->pluck('id')->toArray();
            
            // Includem atât categoria selectată cât și subcategoriile sale
            $allCategoryIds = array_merge([$categoryId], $subcategoryIds);
            
            $query->whereIn('category_id', $allCategoryIds);
        }
        
        // Filtrare după status
        if ($request->filled('status')) {
            $query->where('active', $request->input('status'));
        }
        
        // Filtrare după interval de preț
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }
        
        // Sortare
        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $produse = $query->paginate(25);
        
        // Obținem cursul valutar și settings pentru calculul prețurilor
        $curs = DB::table('curses')->latest()->first();
        $site_settings = DB::table('settings')->latest()->first();
        
        return view('admin.products.index', [
            'produse' => $produse,
            'curs' => $curs,
            'site_settings' => $site_settings
        ]);
    }
}
