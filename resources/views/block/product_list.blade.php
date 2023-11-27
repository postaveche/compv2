<div class="produse row justify-content-center">
    @foreach($products as $product)
        @php
            $thumb = \App\Http\Controllers\CategoryController::produs_thumb($product['id']) ;
        @endphp
        <article class="product">
            <div class="img_thumb">
                <a href="/{{session('locale')}}/product/{{$product['slug']}}"><img class="img-fluid img_thumb" src="{{Storage::url('public/products/'.$thumb)}}@300" alt="{{$product['name']}}"></a>
            @if(isset($product->special_price))
                <div class="reducere">
                Reducere 10%
            </div>
                @endif
                @if(isset($product->gift))
                <div class="gift"></div>
                @endif
            </div>
            <div class="prod_title d-flex justify-content-center">
                <a href="/{{session('locale')}}/product/{{$product['slug']}}" title="">{{$product['name']}}</a>
            </div>
            <div class="price">{{\App\Http\Controllers\CategoryController::category_price($product['price']);}} MDL</div>
            <!--<div class="btn_com"><a class="btn btn-primary" href="/{{session('locale')}}/product/{{$product['slug']}}" role="button">Vezi detalii...</a></div>-->
        </article>
    @endforeach
</div>
