<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class AdminProductSearchController extends Controller
{
    public function search(Request $query){
       // dd($query);
        $search = $query->input('query');
        $produse = Product::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('text', 'LIKE', "%{$search}%")
            ->orWhere('sku', 'LIKE', "%{$search}%")
            ->orderBy('price')
            ->paginate(25);
        return view('admin.products.index', [
            'produse' => $produse
        ]);
    }
}
