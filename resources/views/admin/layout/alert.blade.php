@if(session()->get('success'))
    <div class="toast alert-toast align-items-center position-fixed border-0 m-3 top-0 end-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
        <div class="toast-body text-bg-success">
            {{ session()->get('success') }}
        </div>
    </div>
@endif

@if($errors->any())
    <div class="toast alert-toast text-bg-dark align-items-center border-0 m-3 top-0 end-0 position-fixed" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
        <div class="toast-body text-bg-danger">
            {{ $errors->first() }}
        </div>
    </div>
@endif
