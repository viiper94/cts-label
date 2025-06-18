// Tracks and reviews
$(document).ready(function(){

    $('.show-reviews').click(function(){
        let $btn = $(this);
        loadTrackReviewsToModal($btn.data('url'));
    });

    $(document).on('click', '.edit-review', function(){
        let $btn = $(this);
        $.ajax({
            url: $btn.data('url'),
            type: 'get',
            success: function(response){
                $('#editReviewModal .modal-body').remove();
                $('#editReviewModal .modal-footer').remove();
                $('#editReviewModal .modal-header').after(response.html);
                $('#editReviewModal input[name=track_id]').val($btn.data('track-id'));
                let starRatingConfig = {
                    min: 0,
                    max: 5,
                    step: 1,
                    showCaption: false,
                    size: 'sm',
                    emptyStar: '<i class="fa-regular fa-star"></i>',
                    filledStar: '<i class="fa-solid fa-star"></i>',
                    animate: false,
                    showClear: false,
                }
                $('.star-rating').rating(starRatingConfig);
                $('#trackReviewsModal').modal('hide');
                $('#editReviewModal').modal('show');
            }
        });
    });

    $(document).on('change', '[name=show_reviews]', function(){
        let $checkbox = $(this);
        $.ajax({
            url: $checkbox.parent().data('url'),
            data: {
                show_reviews: $checkbox[0].checked
            },
            success: function(response){
                $('main').append(utils.getAlertToast(null, response.message, 'text-bg-success', 'status-toast'));
            },
            error: function(response){
                $('main').append(utils.getAlertToast(null, xhr.responseJSON.message, 'text-bg-danger', 'status-toast'));
            },
            complete: function(){
                $('.status-toast').toast('show').on('hidden.bs.toast', fn => ($('.save-review-toast').remove()));
            }
        });
    });

    $('#editReviewModal').on('hide.bs.modal', function(){
        $('#trackReviewsModal').modal('show');
    });

    $(document).on('click','.save-review', function(){
        let $btn = $(this);
        $.ajax({
            url: $btn.data('url'),
            type: $btn.data('method'),
            data: {
                result_accept: $('#editReviewModal [name=result_accept]').val(),
                track_id: $('#editReviewModal [name=track_id]').val(),
                author: $('#editReviewModal input[name=author]').val().trim(),
                location: $('#editReviewModal input[name=location]').val().trim(),
                score: $('#editReviewModal input[name=score]').val(),
                review: $('#editReviewModal textarea[name=review]').val().trim(),
                source: $('#editReviewModal input[name=source]').val().trim(),
                target: $('#editReviewModal').data('target'),
                key: $btn.data('key'),
            },
            success: function(response){
                $('main').append(utils.getAlertToast(null, response.message, 'text-bg-success', 'save-review-toast'));
                response.target === 'tracks' ?
                    loadTrackReviewsToModal(response.url) :
                    getResultItem(response.url, response.target, response.key);
                $('#editReviewModal').modal('hide');
            },
            error: function(xhr){
                $('main').append(utils.getAlertToast(null, xhr.responseJSON.message, 'text-bg-danger', 'save-review-toast'));
            },
            complete: function(){
                $('.save-review-toast').toast('show').on('hidden.bs.toast', fn => ($('.save-review-toast').remove()));
            }
        });
    });

    $(document).on('input', '#editReviewModal input[name=author]', function(){
        let input = $(this);
        if(input.val().length > 3){
            $.ajax({
                url: input.data('url'),
                type: 'post',
                data: {
                    query: input.val()
                },
                success: function(response){
                    $('.location-form-group .author-locations').remove();
                    $('.location-form-group input').after(response.html);
                }
            });
        }else if(input.val().length === 0){
            $('.location-form-group .author-locations').remove();
        }
    });

    $(document).on('click', '.copy-author-location', function(){
        $('#editReviewModal input[name=location]').val($(this).html());
    });

    $(document).on('click', '.copy-author', function(){
        $('#editReviewModal input[name=author]').val($(this).html());
    });

    $(document).on('keyup', '#json_raw', function () {
        let raw = $(this).val();
        let isrc = $('#isrc').val().trim();

        let json;
        try {
            json = JSON.parse(raw);
        } catch (e) {
            console.log('Invalid JSON');
            return; // Not valid JSON yet
        }

        if (!isrc) return;

        let match = (json.results || []).find(track => {
            return track.isrc === isrc.replace(/-/g, '');
        });

        if (!match) return;

        $('#bpm').val(match.bpm);
        $('#genre').val(match.genre.name);
        $('#mix_name').val(match.mix_name);
        $('#length').val(match.length);
        $('#beatport_id').val(match.id);
        $('#beatport_slug').val(match.slug);
        $('#beatport_release_id').val(match.release.id);
        $('#beatport_wave').val(match.image.uri);
        $('#beatport_sample').val(match.sample_url);
        $('#beatport_sample_start').val(match.sample_start_ms);
        $('#beatport_sample_end').val(match.sample_end_ms);

    });


});

function loadTrackReviewsToModal(url){
    $.ajax({
        url: url,
        type: 'get',
        success: function(response){
            $('#trackReviewsModal .modal-title').html('Ревью для <b>'+ response.name +'</b>');
            $('#trackReviewsModal .modal-body').html(response.html);
            $('#trackReviewsModal').modal('show');
            let reviewsSortable = [];
            $('#trackReviewsModal table tbody.sortable').each(function(index, el){
                reviewsSortable[index] = Sortable.create(el, {
                    handle: ".sort-handle",
                    animation: 150,
                    onUpdate: function(event, ui){
                        let $table = $(event.from);
                        let url = $table.data('url');
                        let data = {};
                        $.map($table.find('tr'), function(el, i){
                            data[i] = $(el).data('review-id');
                        });
                        $.ajax({
                            url: url,
                            data: {
                                'data': data
                            },
                            success: function(response){
                                $('main').append(utils.getAlertToast(null, response.message, 'text-bg-success', 'sort-toast'));
                            },
                            complete: function(){
                                $('.sort-toast').toast('show').on('hidden.bs.toast', fn => ($('.sort-toast').remove()));
                            },
                        });
                    }
                });
            });
        }
    });

}

function getResultItem(route, target, key = null){
    $.ajax({
        data: {
            target: target,
            key: key
        },
        type: 'post',
        url: route,
        success: function(response){
            $('[data-result-id='+response.id+']').replaceWith(response.html);
        }
    });
}
