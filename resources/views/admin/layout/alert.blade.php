<div class="container-fluid" >
    @if(session()->get('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger" role="alert"><b>Ошибка:</b><br>{{ $errors->first() }}</div>
    @endif
</div>
