<div class="card-body">
 @if($errors->any())<div class="alert alert-danger"><strong>Verifică datele introduse:</strong><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
 @include('admin.block.translate_button')
 <div class="row">
  <div class="col-md-6"><div class="form-group"><label for="name">Titlu RO</label><input id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$banner->name) }}" maxlength="255" required></div></div>
  <div class="col-md-6"><div class="form-group"><label for="name_ru">Titlu RU</label><input id="name_ru" name="name_ru" class="form-control @error('name_ru') is-invalid @enderror" value="{{ old('name_ru',$banner->name_ru) }}" maxlength="255" required></div></div>
 </div>
 <div class="row">
  <div class="col-md-6"><div class="form-group"><label for="description">Descriere RO</label><textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3" maxlength="255" required>{{ old('description',$banner->desc) }}</textarea></div></div>
  <div class="col-md-6"><div class="form-group"><label for="description_ru">Descriere RU</label><textarea id="description_ru" name="description_ru" class="form-control @error('description_ru') is-invalid @enderror" rows="3" maxlength="255" required>{{ old('description_ru',$banner->desc_ru) }}</textarea></div></div>
 </div>
 <div class="row">
  <div class="col-md-8"><div class="form-group"><label for="link">Link intern</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">/{locale}/</span></div><input id="link" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link',$banner->link) }}" maxlength="255" placeholder="category/laptop" required></div><small class="form-text text-muted">Introdu linkul fără limba și fără slash la început.</small></div></div>
  <div class="col-md-2"><div class="form-group"><label for="sort_order">Ordine</label><input id="sort_order" type="number" min="0" max="9999" name="sort_order" class="form-control" value="{{ old('sort_order',$banner->sort_order ?? 0) }}"></div></div>
  <div class="col-md-2"><div class="form-group"><label>Status</label><div class="custom-control custom-switch mt-2"><input type="hidden" name="active" value="0"><input id="active" type="checkbox" name="active" value="1" class="custom-control-input" @checked((bool) old('active',$banner->exists ? $banner->active : true))><label class="custom-control-label" for="active">Activ</label></div></div></div>
 </div>
 <div class="form-group"><label for="uploadimg">Imagine {{ $imageRequired ? '' : 'nouă (opțional)' }}</label><input id="uploadimg" class="form-control-file @error('uploadimg') is-invalid @enderror" type="file" name="uploadimg" accept="image/jpeg,image/png,image/webp,image/gif" {{ $imageRequired ? 'required' : '' }}><small class="form-text text-muted">JPG, PNG, WEBP sau GIF, maximum 5 MB.</small></div>
 @if($banner->image)<div class="mb-3"><p class="mb-1"><strong>Imagine curentă</strong></p><img src="{{ Storage::url('public/banners/'.$banner->image) }}" alt="{{ $banner->name }}" style="max-width:420px;max-height:180px;object-fit:cover" class="img-thumbnail"></div>@endif
</div>
<div class="card-footer"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ $submitLabel }}</button><a href="{{ route('bannerblock.index') }}" class="btn btn-default ml-2">Anulează</a></div>
