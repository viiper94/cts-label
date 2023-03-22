<div class="modal-body">
    <form action="{{ $artist->id ? route('artists.update', $artist->id) : route('artists.store') }}" id="edit_form"
          enctype="multipart/form-data" method="post">
        @csrf
        @if($artist->id)
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-md-5 col-xs-12 mb-3">
                <img src="/images/artists/{{ $artist->image ?? 'default.png' }}" id="preview" class="w-100">
                <input type="file" name="image" id="uploader" class="form-control form-dark" accept="image/jpeg, image/png">
            </div>
            <div class="col-md-7 col-xs-12 mb-3">
                <div class="form-check mb-3">
                    <input type="hidden" name="visible" value="0">
                    <input type="checkbox" name="visible" id="visible" class="form-check-input" @checked($artist->visible)>
                    <label for="visible" class="form-check-label">Опубликовано</label>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="name">Имя</label><br>
                    <input type="text" class="form-control form-control-lg form-dark" name="name" id="name"
                           value="{{ $artist->name }}" required>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="link">Ссылка в социальную сеть</label><br>
                    <div class="input-group">
                        <input type="url" class="form-control form-dark" name="link" id="link"
                               value="{{ $artist->link }}">
                        @if($artist->link)
                            <a class="btn btn-outline border-0" href="{{ $artist->link }}" target="_blank">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    @if($artist->id)
        <form action="{{ route('artists.destroy', $artist->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger" onclick="return confirm('Удалить артиста?')">
                <i class="fa-solid fa-trash me-2"></i>Удалить
            </button>
        </form>
    @endif
    <button class="btn btn-primary" form="edit_form" type="submit">
        <i class="fa-solid fa-check me-2"></i>Сохранить
    </button>
</div>
