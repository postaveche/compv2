@extends('layouts.layouts')

@section('title', 'Reparația imprimantelor, MFU, Copiatoare ')

@section('description', 'Reparația imprimantelor, MFU, Copiatoare')

@section('keywords', 'mfu, xerox, printer, reparatia, remont, copiatoare')

@section('content')
    <div class="wrapper">
        @include('block.print_block')
        <div class="reincarc_index">
            <div class="reincarc_item reincarc_text">
                Reparatia imprimantelor de la 100 Lei
            </div>
            <div class="reincarc_item reincar_photo">
                <img class="reincar_photo_img" src="/img/print_rep.png" alt="Reparatii imprimante">
            </div>
        </div>
        <p>Deservirea si reparatia imprimantelor este un serviciu foarte important in zilele noastre, deoarece
            utilizarea acestor
            dispozitive este foarte frecventa in birouri si in casele noastre. O imprimanta este un dispozitiv
            electronic care utilizeaza toner sau cerneala pentru a imprima documente, fotografii sau alte tipuri de
            informatii pe hartie.</p>
        <p>
            In cazul in care intampinati probleme cu imprimanta dvs., cum ar fi printarea incompleta, calitatea slaba a
            imaginii sau erorile de imprimare, va recomandam sa apelati la serviciile noastre de reparatie a
            imprimantelor (printerelor).
        </p>
        <p>In functie de problema imprimantei, tehnicienii nostri specializati in reparatii pot face reparatii hardware sau
            software, precum si reincarcarea cu toner sau cerneala. Aceasta operatiune este necesara atunci cand
            cartusul de toner sau cerneala s-a terminat sau cand calitatea printurilor a scazut.
        </p>
        <div class="reincarc_index">
            <div class="reincarc_item reincarc_photo">
            <img class="reincar_photo_img" src="/img/print_rep.png" alt="Reparatii imprimante">
            </div>
            <div class="reincarc_item reincarc_text">
                Reparatii hardware si software
            </div>
        </div>
    </div>
@endsection
