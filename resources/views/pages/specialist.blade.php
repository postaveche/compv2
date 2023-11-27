@extends('layouts.layouts')

@section('title', 'Cheamă un specialist - Comp.MD')

@section('description', 'Cheamă un specialis acasă sau la oficiu pentru a rezolva orice problemă')

@section('keywords', 'cheamă, specialist, deplasare, acasa, oficiu')


@section('content')
    <div>
        @include('block.print_block')
        <div class="reincarc_index">
            <div class="reincarc_item reincarc_text">
                Cheamă un specialist acasă sau la oficiu de la 50 lei
            </div>
            <div class="reincarc_item reincar_photo">
                <img class="reincar_photo_img" style="max-width: 300px" src="/img/remont_comps.png"
                     alt="Cheamă un specialist">
            </div>
        </div>
        <div class="content_block">
            <p>Service Centrul Comp.MD vă propune chemarea unui specialist la domiciliul sau oficiul DVS. pentru
                rezolvarea calitativă a problemei apărute în cel mai scurt timp.</p>
            <p>În cazul în care comandați un specialist, inginerul nostru se va deplasa la adresa indicată de DVS. și va
                încerca să rezolve problema apărută pe loc, iar dacă nu este posibil va lua tehnica defectă la oficiul
                nostru unde va fi reparată în caz că e posibil.</p>
            <p>Prețul serviciului de deplasare a specialistului este de 50 MDL în raza m. Chișinău</p>
            <p>Pentru a comanda un specialist puteti sa ne contactati pe numerele de telefon de mai jos sau prin alta
                metoda care va convine</p>
        </div>
        <p><strong>Contacte:</strong></p>
    </div>
    @include('block.contactinfo')
    @include('block.maps')
@endsection
