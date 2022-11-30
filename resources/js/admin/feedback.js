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

});
