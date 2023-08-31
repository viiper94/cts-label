// Feedback
import {FeedbackPlayer} from "../feedback_player";

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

    $.ajax({
        url: '/feedback/'+$('.feedback').data('feedback-slug')+'/tracks',
        success: function(response){
            window.players = [];
            $(response.tracks).each(function(key, params){
                window.players.push(new FeedbackPlayer(params))
            });
        },
        error: function(){
            console.log('error');
        }
    });

});
