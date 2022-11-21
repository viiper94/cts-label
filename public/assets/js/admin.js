$(document).ready(function(){

    $('.related_last_five').click(function(e){
        e.preventDefault();
        $('.related label input').prop('checked', false);
        for(let i = 0; i < 5; i++){
            $($('.related label input')[i]).prop('checked', true);
        }
    });

    $('#search-reviewer').keyup(function(){
        let query = $(this).val().trim();
        if(query.length > 2){
            $.ajax({
                data : {
                    query : query
                },
                url : '/cts-admin/reviews/search',
                success : function(response){
                    $('.founded').html('');
                    if(response.status === 'ok'){
                        let span = '';
                        $.each(response.data, function(key, item){
                            span += '<p><b>'+item.author+'</b> - '+item.location+'</p>';
                        });
                        $('.founded').append(span);
                    } else {
                        $('.founded').append('<span>Нет результатов</span>');
                    }
                }
            });
        }
    });

    $(document).on('change', 'input[name*=tracks]', function(){
        let id = $(this).data('id');
        let title = $(this)[0].value;
        title = title.substr(12).replace('.mp3', '');
        let target = $('#feedback-'+id).find('input[name*=title]');
        if($(target).val() === '') $(target).val(title)
    });




});
