// Feedback
$(document).ready(function(){

    $('.related_last_five').click(function(e){
        e.preventDefault();
        $('.related-all-feedback input').prop('checked', false);
        for(let i = 0; i < 5; i++){
            $($('.related-all-feedback input')[i]).prop('checked', true);
        }
    });

    $('.deselect-btn').click(function(e){
        e.preventDefault();
        $('.related-all-feedback input').prop('checked', false);
    });

    $('.add-track-btn').click(function(){
        let $button = $(this);
        let index = $button.data('index');
        $.ajax({
            data: {
                index: index,
            },
            url : '/cts-admin/feedback/template',
            success: function(response){
                $button.data('index', index+1);
                $('.tracks').append(response.html);
            }
        });
    });

    $(document).on('click','.delete-feedback-track-btn', function(){
        let $btn = $(this);
        let url = $btn.data('url');
        if(url){
            $.ajax({
                type: 'DELETE',
                url: url,
                success: function(response){
                    if(response.status === 'OK'){
                        $btn.parents('.card').remove();
                    }
                }
            });
        }else{
            $btn.parents('.card').remove();
        }
    });

    $(document).on('change', '.edit-feedback .tracks input[type=file]', function(e){
        let size = 0;
        let count = 0;
        $('.edit-feedback .tracks input[type=file]').each(function(){
            if(this.files.length > 0){
                size += this.files[0].size;
                count++;
            }
        });
        if(count > 20){
            alert($('.progress').data('alert-count'));
            $(this).val('');
            return false;
        }
        if(size > 100000000){
            alert($('.progress').data('alert-size'));
            $(this).val('');
            return false;
        }
        let sizeMb = Math.floor(size/1000000);
        let perc = sizeMb/100 * 100;
        $('.edit-feedback .progress-bar').css({'width': perc+'%'}).find('.current').text(sizeMb);
    });

    $('.replace-track').click(function(){
        $('#'+$(this).data('target')+'_player').hide();
        $('#'+$(this).data('target')).show();
    });

    $('.process-review-btn').click(function(){
        let $button = $(this);
        $.ajax({
            type: 'GET',
            url: $button.data('url'),
            success: function(response){
                $('#editReviewModal .modal-content').html(response.html);
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
                $('#editReviewModal').modal('show');
            }
        });
    });

    $(document).on('click', '.mark-accepted-btn, .decline-btn', function(){
        let action = $(this).data('action');
        let url = $(this).data('url');
        $.ajax({
            data: {
                action: action
            },
            type: 'post',
            url: url,
            success: function(response){
                $('main').append(utils.getAlertToast(null, response.message, 'text-bg-success', 'save-review-toast'));
            },
            error: function(xhr){
                $('main').append(utils.getAlertToast(null, xhr.responseJSON.message, 'text-bg-danger', 'save-review-toast'));
            },
            complete: function(){
                $('#editReviewModal').modal('hide');
                $('.save-review-toast').toast('show').on('hidden.bs.toast', fn => ($('.save-review-toast').remove()));
            }
        });
    });

});
