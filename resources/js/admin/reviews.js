// Reviews

$(document).ready(function(){

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

    $('.add-review-btn').click(function(){
        let $button = $(this);
        let index = $button.data('index');
        $.ajax({
            data: {
                index: index,
                target: $button.data('target')
            },
            url : '/cts-admin/reviews/template',
            success: function(response){
                $button.data('index', index+1);
                $button.before(response.html);
                $('.star-rating').rating(starRatingConfig);
            }
        });
    });

    $(document).on('click','.delete-review-btn', function(){
        if(confirm('Удалить?')){
            $(this).parents('.review-card').remove();
        }
    });

});
