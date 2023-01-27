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
        if(count > 10){
            alert('Достигнут лимит по количеству файлов! Загрузите остаток файлов второй ходкой.');
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

});
