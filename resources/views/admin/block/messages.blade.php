@if (session('success'))
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <i class="icon fa fa-check"> {{ session('success') }}</i>
    </div>
@elseif (session('danger'))
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <i class="fa-solid fa-circle-exclamation"></i> {{ session('danger') }}</i>
    </div>
@endif
