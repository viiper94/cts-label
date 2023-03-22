// Tracks and reviews
$(document).ready(function(){

    $('.show-reviews').click(function(){
        $btn = $(this);
        loadTrackReviewsToModal($btn.data('url'));
    });

    $(document).on('click', '.edit-review', function(){
        $btn = $(this);
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

    $('#editReviewModal').on('hide.bs.modal', function(){
        $('#trackReviewsModal').modal('show');
    });

    $(document).on('click','.save-review', function(){
        $btn = $(this);
        $.ajax({
            url: $btn.data('url'),
            type: $btn.data('method'),
            data: {
                track_id: $('#editReviewModal input[name=track_id]').val(),
                author: $('#editReviewModal input[name=author]').val(),
                location: $('#editReviewModal input[name=location]').val(),
                score: $('#editReviewModal input[name=score]').val(),
                review: $('#editReviewModal textarea[name=review]').val(),
                source: $('#editReviewModal input[name=source]').val(),
            },
            success: function(response){
                $('main').append(getAlertToast('Успех', response.message, 'text-bg-success', 'save-review-toast'));
                loadTrackReviewsToModal(response.url);
                $('#editReviewModal').modal('hide');
            },
            error: function(xhr){
                $('main').append(getAlertToast('Ошибка', 'Возникла ошибка =(', 'text-bg-danger', 'save-review-toast'));
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
                beforeSend: function(){
                },
                success: function(response){
                    $('.location-form-group .author-locations').remove();
                    $('.location-form-group .input-group').after(response.html);
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

});

function getAlertToast(
    headingMessage = null,
    bodyMessage = null,
    headingClass = null,
    toastClass = null){
    return '<div class="toast alert-toast align-items-center position-fixed border-0 m-3 top-0 end-0 '+toastClass+'" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">\n' +
        '        <div class="toast-header '+headingClass+'">\n' +
        '            <strong class="me-auto">'+headingMessage+'</strong>\n' +
        '            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>\n' +
        '        </div>\n' +
        '        <div class="toast-body">\n' +
        bodyMessage +
        '        </div>\n' +
        '    </div>';
}

function loadTrackReviewsToModal(url){
    $.ajax({
        url: url,
        type: 'get',
        success: function(response){
            $('#trackReviewsModal .modal-title').html('Ревью для <b>'+ response.name +'</b>');
            $('#trackReviewsModal .modal-body').html(response.html);
            $('#trackReviewsModal').modal('show');
            $('#trackReviewsModal table tbody.sortable').sortable(getSortableParams());
        }
    });
}

function getSortableParams(){
    return {
        handle: '.sort-handle',
        update: function(event, ui){
            let url = $(this).data('url');
            let data = {};
            $.map($(this).find('tr'), function(el, i){
                data[i] = $(el).data('review-id');
            });
            $.ajax({
                url: url,
                data: {
                    'data': data
                },
                success: function(response){
                    $('main').append(getAlertToast('Успех', 'Ревью пересортирован', 'text-bg-success', 'sort-toast'));
                },
                error: function(){
                    $('main').append(getAlertToast('Ошибка', 'Возникла ошибка =(', 'text-bg-danger', 'sort-toast'));
                },
                complete: function(){
                    $('.sort-toast').toast('show').on('hidden.bs.toast', fn => ($('.sort-toast').remove()));
                },
            });
        }
    }
}
