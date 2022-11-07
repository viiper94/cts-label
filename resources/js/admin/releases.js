$(document).ready(function(){

    $('.translate_description').click(function(){
        let button = this;
        let target = $(this).data('to-lang');
        let query = enEditor.getData().trim();
        if(query.length > 0){
            $.ajax({
                data : {
                    query: query,
                    target : target
                },
                url : '/cts-admin/releases/translate',
                success : function(response){
                    if(response.status === 'ok'){
                        switch(target){
                            case 'ru':
                                ruEditor.setData(response.data); break;
                            case 'uk':
                                uaEditor.setData(response.data); break;
                        }
                        $(button).before('<span class="text-success">Успех</span>');
                    }else{
                        $(button).before('<span class="text-danger">Ошибка</span>');
                    }
                }
            });
        }
    });

});
