<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MainController;
use phpDocumentor\Reflection\DocBlock\Serializer;
use PHPUnit\Exception;

class B2BAccentController extends Controller
{
    protected function b2b_authentification()
    {
        $client = new Client();
        $res = $client->request('POST', 'http://b2brestful.accent.md:8090/loginuser/getid', [
            'json' =>
                [
                    'userlogin' => 'ITserviceGrup.APIuser',
                    'userpassword' => '63EE5E47B8D62269EF78EB96A79F41EF'
                ]
        ]);
        $b2breply = json_decode($res->getBody());
        $guid = $b2breply->guid;
        return $guid;
    }

    public function b2b_query($query)
    {
        $allproducts = new Client();
        $res2 = $allproducts->request('POST', $query);
        $allproducts_reply = json_decode($res2->getBody());
        return $allproducts_reply;
    }

    public function b2b_auth()
    {
        $guid = $this->b2b_authentification();
        //dd($b2breply->guid);
        $allproducts = new Client();
        $res2 = $allproducts->request('POST', 'http://b2brestful.accent.md:8090/hard/' . $guid);
        $allproducts_reply = json_decode($res2->getBody());
        //echo $res2->getBody();
        foreach ($allproducts_reply as $all) {
            if ($all->parentcode == '22328') {
                echo $all->code . ') ' . $all->parentcode . "-" . $all->hardname . "<br>";
                echo $all->onlineprice;
                $prod_img = explode(',', $all->imagesList);
                for ($i = 1; $i <= $all->imagesqty; $i++) {
                    echo "<img src='https://b2b.accent.md/public/product/20/74820/" . $i . ".jpg'><br>";
                }
                $product_detalii = new Client();
                $res3 = $product_detalii->request('POST', 'http://b2brestful.accent.md:8090/hardproperty/' . $guid . '/productid/' . $all->code);
                $product_detalii_reply = json_decode($res3->getBody());

                dd($product_detalii_reply);

            }
        }

    }

    public function import_b2b($code, $category_id)
    {
        $cod = $code;
        $guid = $this->b2b_authentification();
        $allproducts = new Client();
        $res2 = $allproducts->request('POST', 'http://b2brestful.accent.md:8090/hard/' . $guid);
        $allproducts_reply = json_decode($res2->getBody());

        foreach ($allproducts_reply as $all) {
            if ($all->parentcode == $cod) {
                $product_code = $all->code;
                $product_sku = $all->hardnum;
                $product_fullname = $all->hardname;
                if ($all->hardshortnameRus == null) {
                    $product_name_ru = mb_strimwidth($product_fullname, 0, 100, ".");
                } else {
                    $product_name_ru = $all->hardshortnameRus;
                }
                if ($all->hardshortnameRom == null) {
                    $product_name_ro = mb_strimwidth($product_fullname, 0, 100, ".");
                } else {
                    $product_name_ro = $all->hardshortnameRom;
                }
                $transaction_id = $all->transaction_id;
                $product_dprice = $all->dprice1;
                $product_images = $all->imagesList;
                $product_images = explode(',', $product_images);
                if (isset($data)) {
                    $data = array_diff($data, $data);
                }
                $img_qty = 0;
                foreach ($product_images as $images) {
                    $img_qty = $img_qty + 1;
                    $image_url = 'ftp://ftp.accent.md/aeimages/' . $images;
                    $url = file_get_contents($image_url);
                    //$image_url = 'ftp://ftp.accent.md/aeimages/vasea.jpg';
//                    if($url = file_get_contents($image_url)){
//                        dd($url);
//                    }
//                    else{
//                        dd($image_url);
//                    }

                    //dd($url);
                    Storage::put('public/products/' . $images, $url);
                    $data[] = $images;
                }
                $product_images = json_encode($data);
                $product_garantie = $all->warrantyname;
                $user_id = Auth::id();

                //$last_id = Product::latest()->first()->id;
                if ($last = Product::latest()->first()){
                    $last_id = $last->id;
                    $next_id = $last_id + 1;
                }
                else{
                    $last_id = 0;
                    $next_id = $last_id + 1;
                }

                $product = new Product();
                $product->name = mb_strimwidth($product_fullname, 0, 50, "...");
                $product->name_ro = $product_name_ro;
                $product->name_ru = $product_name_ru;
                $product->description = $product_name_ro;
                $keywords = Str::slug($product_name_ro);
                $keywords = explode('-', $keywords);
                $keywords = implode(',', $keywords);
                $product->keywords = $keywords;
                $product->slug = $next_id . '-' . Str::slug($product_name_ro);
                $product->sku = $product_sku;
                $product->b2b_code = $product_code;
                $product->img = $product_images;
                $product->img_qty = $img_qty;
                $product->text = $product_fullname;
                $product->price = $product_dprice;
                $product->garantie = preg_replace('/[^0-9]/', '', $product_garantie);
                $product->category_id = $category_id;
                $product->b2b_parentcode = $all->parentcode;
                $product->user_id = $user_id;
                $product->active = $all->inpricelist;
                $product->b2b_transaction_id = $transaction_id;
                $product->save();
                //dd($product);
            }
        }

        return view('admin.import.import', [
            'cod' => $cod,
            'product_code' => $product_code,
            'product_sku' => $product_sku,
            'product_full_name' => $product_fullname,
            'product_name_ru' => $product_name_ru,
            'product_name_ro' => $product_name_ro
        ]);
    }

    public function b2b_folders()
    {
        $guid = $this->b2b_authentification();
        $allcategory = new Client();
        $res2 = $allcategory->request('POST', 'http://b2brestful.accent.md:8090/hard/' . $guid . '/folders');
        $allcategory_reply = json_decode($res2->getBody());
        return view('admin.import.b2bfolders', [
            'allcategory_reply' => $allcategory_reply,
            'guid' => $guid
        ]);
    }

    public function import_by_folders(Request $request)
    {
        $code = $request->code;
        $category_id = $request->select_category;
        $guid = $request->guid;

        $query = 'http://b2brestful.accent.md:8090/hard/' . $guid . '/filterbyparent/' . $code;

        $products_reply = self::b2b_query($query);

        //dd($products_reply);

        foreach ($products_reply as $product) {
            $ifexist = Product::where('b2b_code', $product->code)->first();
            if ($ifexist === null) {
                $product_fullname = $product->hardname;
                $product_name = mb_strimwidth($product_fullname, 0, 50, "...");
                if ($product->hardshortnameRus == null) {
                    $product_name_ru = mb_strimwidth($product_fullname, 0, 100, ".");
                } else {
                    $product_name_ru = $product->hardshortnameRus;
                }
                if ($product->hardshortnameRom == null) {
                    $product_name_ro = mb_strimwidth($product_fullname, 0, 100, ".");
                } else {
                    $product_name_ro = $product->hardshortnameRom;
                }
                $keywords = Str::slug($product_name_ro);
                $keywords = explode('-', $keywords);
                $keywords = implode(',', $keywords);

                $product_images = $product->imagesList;
                $product_images = explode(',', $product_images);
                if (isset($data)) {
                    $data = array_diff($data, $data);
                }
                $img_qty = 0;
                foreach ($product_images as $images) {
                    $img_qty = $img_qty + 1;
                    $image_url = 'ftp://ftp.accent.md/aeimages/' . $images;
                    $url = file_get_contents($image_url);
                    Storage::put('public/products/' . $images, $url);
                    $data[] = $images;
                }
                $product_images = json_encode($data);

                //$last_id = Product::latest()->first()->id;
                if ($last = Product::latest()->first()){
                    $last_id = $last->id;
                    $next_id = $last_id + 1;
                }
                else{
                    $last_id = 0;
                    $next_id = $last_id + 1;
                }

                $slug = $next_id . '-' . Str::slug($product_name_ro);

                $product_garantie = $product->warrantyname;
                if ($product_garantie == 'Lifetime') {
                    $product_garantie = 36;
                } elseif ($product_garantie == null) {
                    $product_garantie = 0;
                }
                $garantie = preg_replace('/[^0-9]/', '', $product_garantie);

                $user_id = Auth::id();

                $addproduct = new Product();
                $addproduct->name = $product_name;
                $addproduct->name_ro = $product_name_ro;
                $addproduct->name_ru = $product_name_ru;
                $addproduct->description = $product_name_ro;
                $addproduct->description_ru = $product_name_ru;
                $addproduct->keywords = $keywords;
                $addproduct->slug = $slug;
                $addproduct->sku = $product->hardnum;
                $addproduct->b2b_code = $product->code;
                $addproduct->img = $product_images;
                $addproduct->img_qty = $img_qty;
                $addproduct->text = $product_fullname;
                $addproduct->text_ru = $product_fullname;
                $addproduct->price = $product->dprice1;
                $addproduct->garantie = $garantie;
                $addproduct->category_id = $category_id;
                $addproduct->b2b_parentcode = $product->parentcode;
                $addproduct->user_id = $user_id;
                $addproduct->active = $product->inpricelist;
                $addproduct->b2b_transaction_id = $product->transaction_id;

                //dd($addproduct);
                $addproduct->save();

            } else {
//                if($ifexist->b2b_transaction_id <> $product->transaction_id)
//                dd($product);
            }
        }
        return back()->with('success', 'Produsele au fost adaugate cu succes!!!');
    }

}
