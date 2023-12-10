@foreach($tracks as $track)
    <div class="row track-to-sign-item mb-2" data-index="{{ $index }}">
        <div class="col">
            <input type="text" class="form-control form-dark" name="tracks_to_sign[{{ $index }}][name]" placeholder="@lang('tracks.name')" value="{{ $track['name'] }}">
        </div>
        <div class="col">
            <input type="text" class="form-control form-dark" name="tracks_to_sign[{{ $index++ }}][mix]" placeholder="@lang('tracks.mix_name')" value="{{ $track['mix'] }}">
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-outline remove-track-to-sign-btn border-0">
                <i class="fa-solid fa-minus"></i>
            </button>
        </div>
    </div>
@endforeach
