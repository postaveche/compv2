@extends('admin.layouts.adminlayouts')
@section('title', 'Acces Casă')
@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Casă</h1></div></section>
    <section class="content"><div class="container-fluid">
        <div class="row justify-content-center pt-4"><div class="col-sm-8 col-md-5 col-xl-4">
            <div class="card card-outline card-success">
                <div class="card-body p-4">
                    <div class="text-center mb-4"><i class="fas fa-lock fa-2x text-success mb-3" aria-hidden="true"></i><h4>Acces protejat</h4><p class="text-muted mb-0">Introdu parola compartimentului Casă.</p></div>
                    <form method="POST" action="{{ route('cash.authenticate') }}">
                        @csrf
                        <div class="form-group"><label for="cash-password">Parola</label><input id="cash-password" type="password" name="password" class="form-control" autocomplete="current-password" required autofocus></div>
                        <button class="btn btn-success btn-block" type="submit">Deschide compartimentul</button>
                    </form>
                </div>
            </div>
        </div></div>
    </div></section>
</div>
@endsection
