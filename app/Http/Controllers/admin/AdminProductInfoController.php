<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\B2BAccentController;
use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AdminProductInfoController extends B2BAccentController
{
    public function all_product_info()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $b2b_code = $product->b2b_code;
            $product_info = $this->add_product_info($b2b_code);
            $update_product = $this->update_product_info($b2b_code, $product_info);
            //echo $product_info."<br>";
        }
    }

    public function add_product_info($b2b_code)
    {
        //$b2b_code = '86149';
        $guid = $this->b2b_authentification();
        $query = 'http://b2brestful.accent.md:8090/hardproperty/' . $guid . '/productid/' . $b2b_code;
        $allproducts = new Client();
        $res2 = $allproducts->request('POST', $query);
        $product_info_body = $res2->getBody();
        return $product_info_body;
    }

    public function update_product_info($b2b_code, $product_info)
    {
        $product = Product::where('b2b_code', $b2b_code)->first();
        if ($product->product_info <> $product_info) {
            $product->product_info = $product_info;
            $product->update();
            echo "Success<br>";
        }
    }

    public function product_in_stoc($b2b_code)
    {
        $guid = $this->b2b_authentification();
        $query = 'http://b2brestful.accent.md:8090/stockstate/' . $guid . '/productcode';
        $data = array(
            'articul' => $b2b_code
        );
        $encodeData = json_encode($data);
        $client = new Client();
        $res = $client->request('POST', $query, $encodeData);
        $b2breply = json_decode($res->getBody());
        dd($b2breply);
    }

    public function product_in_stoc2($b2b_code)
    {
        $guid = $this->b2b_authentification();
        $query = 'http://b2brestful.accent.md:8090/stockstate/' . $guid . '/productcode';
        echo $query;
        $data = array(
            'articul' => $b2b_code
        );
        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => json_encode($data),
                'header' => "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
            )
        );
        echo '<br><br>result:';
        $context = stream_context_create($options);
        $result = file_get_contents($query, false, $context);
        dd($result);
        $response = json_decode($result);
        dd($response);
    }

    public function product_in_stoc3($b2b_code)
    {
        $guid = $this->b2b_authentification();
        $query = 'http://b2brestful.accent.md:8090/stockstate/'.$guid.'/productid/'.$b2b_code;
        $client = new Client();
        $res = $client->request('POST', $query);
        dd($res);
        $b2breply = json_decode($res->getBody());
       // dd($b2breply);
    }
}
