<form role="search" enctype="application/x-www-form-urlencoded">
    <div class="form-floating">
        <input type="text" name="q" class="form-control text-bg-dark" id="search" placeholder="Поиск" value="{{ Request::input('q') }}">
        <label for="floatingInput">Поиск</label>
    </div>
</form>
<hr>
