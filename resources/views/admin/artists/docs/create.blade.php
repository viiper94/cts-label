<div class="modal-body">
    <form action="{{ $doc->id ? route('artists.docs.update', $doc->id) : route('artists.docs.store') }}" id="edit_form"
          enctype="multipart/form-data" method="post">
        @csrf
        @if($doc->id)
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-md-5 col-xs-12 mb-3">
                <input type="file" name="file" class="form-control form-dark" multiple>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    @if($doc->id)
        <form action="{{ route('artists.docs.destroy', $doc->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger" onclick="return confirm('@lang('artists.delete_doc')?')">
                <i class="fa-solid fa-trash me-2"></i>@lang('artists.doc.delete')
            </button>
        </form>
    @endif
    <button class="btn btn-primary" form="edit_form" type="submit">
        <i class="fa-solid fa-check me-2"></i>@lang('artists.doc.save')
    </button>
</div>
