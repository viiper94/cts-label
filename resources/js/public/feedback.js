// Feedback
$(document).ready(function(){

    let starRatingConfig = {
        min: 0,
        max: 10,
        step: 1,
        showCaption: false,
        size: 'md',
        emptyStar: '<i class="fa-regular fa-star"></i>',
        filledStar: '<i class="fa-solid fa-star"></i>',
        animate: false,
        showClear: false,
    }
    $('.star-rating').rating(starRatingConfig);

});
