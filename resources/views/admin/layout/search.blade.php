<form role="search" enctype="application/x-www-form-urlencoded" class="input-group"
    action="{{ route(preg_replace('/([a-zA-Z_]+)$/', 'index', \Request::route()->getName())) }}">
    <input type="text" name="q" class="form-control form-dark" id="search" placeholder="@lang('shared.search')" value="{{ Request::input('q') }}">
    <button type="submit" class="btn btn-outline border-0"><i class="fa-solid fa-magnifying-glass"></i></button>
</form>
<hr>
