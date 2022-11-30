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

    $(document).on('click','.delete-track-btn', function(){
        if(confirm('Удалить?')){
            $(this).parents('.track-card').remove();
        }
    });

});
