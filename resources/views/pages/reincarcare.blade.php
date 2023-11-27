@extends('layouts.layouts')

@section('title', 'Reincarcarea si regenerarea cartuselor in Chisinau, Moldova Comp.md')

@section('description', 'Reincarcarea si regenerarea cartuselor in Chisinau, Moldova')

@section('keywords', 'reincarcarea cartuselor, reincarcarea imprimantelor, laser, toner, injet, alimentarea cartuselor, alimentarea imprimantelor, chisinau, moldova, reincarcarea cartuselor chisinau, reincarcarea caruselor laser, reincarcarea cartuselor canon, lasejet, samsung, hp, canon')

@section('content')
    <div>
        @include('block.print_block')
        <div class="reincarc_index">
            <div class="reincarc_item reincarc_text">
                Reîncărcarea și reparația cartușelor
            </div>
            <div class="reincarc_item reincar_photo">
                <img class="reincar_photo_img" src="/img/reincarc.png" alt="Reîncărcarea și reparația cartușelor">
            </div>
        </div>
        <div class="content_block">
            <p><strong>IT SERVICE GRUP SRL</strong> va ofera servicii de reincarcare si regenerare a cartuselor pentru
                imprimantele dumneavoastra:</p>
            <p>- reincarcare cartuse inkjet (cerneala)<br/> - reincarcare cartuse laserjet (toner)</p>
            <p>- regenerare cartuse inkjet (cerneala)<br/> - regenerare cartuse laserjet (toner)</p>
            <p>Cand imprimanta ramane fara cerneala sau toner in cartuse, veti fi surprinsi sa aflati ca pentru
                achizitionarea altor cartuse noi achitati aproape inca o data pretul imprimantei. Compania noastra are
                tehnologia necesara pentru reincarcarea si regenerarea cartuselor rapid si eficient la doar o parte din
                costul unui cartus original.</p>
            <p>Prin reincarcarea cartuselor ink (cerneala) economisiti pana la 90%, iar prin reincarcarea cartuselor
                laser
                (cartuse cu toner) aproximativ 80% .<strong><br/></strong></p>
        </div>
        <div class="reincarc_index">
            <div class="reincarc_item reincarc_text">
                Reîncărcarea cartușelor laser de la 80 lei
            </div>
            <div class="reincarc_item reincar_photo">
                <img class="reincar_photo_img" src="/img/can725.png" alt="Reîncărcarea cartușelor laser">
            </div>
        </div>
        <div class="content_block">
            <p>***Cartușele pentru imprimante sunt consumabile destinate pentru unica folosință și nimeni nu poate da
                garanție la calitatea tiparului după reincaărcarea lor. Totul depinde de viteza de uzare a componenților
                cartușului care variază de la un model la altul, cel mai repede se uzează fotoreceptorul, lamele și
                valurile
                care es din funcțiune deobicei după 3-4 reîncărcări după care este necesar de făcut regenerarea
                cartușului.
            </p>
            <p>Regenerarea cartușului constă în reîncărcarea cu toner și schimbarea tuturor componentiolor uzate din
                cartuș.
                Regeneraea cartușilui original poate fi efectuată în medie în jur de 5 ori, deobicei totul depinde de
                starea
                carcacasei cartușului și a producătorului, după care este necesar de procurat alt cartuș nou.
            </p>
        </div>
        <div class="reincarc_index">
            <div class="reincarc_item reincar_photo">
                <img class="reincar_photo_img" src="/img/ink.png" alt="Reîncărcarea cartușelor laser">
            </div>
            <div class="reincarc_item reincarc_text">
                Reîncărcarea cartușelor cu vopsea de la 30 lei
            </div>
        </div>
        <div class="content_block">
            @include('block.contactinfo')
        </div>
    </div>
@endsection
