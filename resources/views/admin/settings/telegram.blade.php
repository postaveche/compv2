@extends('admin.layouts.adminlayouts')
@section('title', 'Setari Telegram')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><h1>Setari Notificari Telegram</h1></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
<div class="row">
<div class="col-md-8">
<div class="card card-primary">
<div class="card-header"><h3 class="card-title">Configurare Bot Telegram</h3></div>
<form action="{{ route('admin.telegram.update') }}" method="POST">@csrf @method('PUT')
<div class="card-body">
<div class="custom-control custom-switch mb-3">
<input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $settings->active ? 'checked' : '' }}>
<label class="custom-control-label" for="active"><strong>Notificari active</strong></label>
</div>
<div class="form-group">
<label>Bot Token</label>
<input type="text" name="bot_token" class="form-control" value="{{ $settings->bot_token }}" placeholder="123456789:ABCdefGHIjklMNOpqrsTUVwxyz">
<small class="text-muted">Obtine token de la @BotFather in Telegram</small>
</div>
<div class="form-group">
<label>Chat ID / Channel ID</label>
<input type="text" name="chat_id" class="form-control" value="{{ $settings->chat_id }}" placeholder="-1001234567890">
<small class="text-muted">ID-ul canalului sau grupului. Pentru canal foloseste @userinfobot</small>
</div>
<hr>
<h5>Tipuri de notificari</h5>
<div class="custom-control custom-checkbox mb-2">
<input type="checkbox" class="custom-control-input" id="notify_new" name="notify_new_order" value="1" {{ $settings->notify_new_order ? 'checked' : '' }}>
<label class="custom-control-label" for="notify_new">Comanda noua creata</label>
</div>
<div class="custom-control custom-checkbox mb-2">
<input type="checkbox" class="custom-control-input" id="notify_status" name="notify_status_change" value="1" {{ $settings->notify_status_change ? 'checked' : '' }}>
<label class="custom-control-label" for="notify_status">Schimbare status comanda</label>
</div>
</div>
<div class="card-footer">
<button type="submit" class="btn btn-primary">Salveaza</button>
<a href="{{ route('admin.telegram.test') }}" class="btn btn-success"><i class="fas fa-paper-plane"></i> Trimite mesaj test</a>
</div>
</form></div></div>

<div class="col-md-4">
<div class="card card-info">
<div class="card-header"><h3 class="card-title">Instructiuni</h3></div>
<div class="card-body" style="font-size:13px;">
<p><strong>1. Creaza un bot:</strong><br>Deschide @BotFather in Telegram, trimite /newbot si urmeaza instructiunile. Copiaza token-ul.</p>
<p><strong>2. Creaza un canal/grup:</strong><br>Creaza un canal sau grup in Telegram si adauga botul ca administrator.</p>
<p><strong>3. Obtine Chat ID:</strong><br>Adauga @userinfobot in canal, sau trimite un mesaj si acceseaza:<br><code>api.telegram.org/bot[TOKEN]/getUpdates</code></p>
<p><strong>4. Testeaza:</strong><br>Salveaza setarile si apasa "Trimite mesaj test".</p>
</div></div></div>
</div></div></section></div>
@endsection
