// Studio School
$(document).ready(function(){

    $('.service-lang .sortable').sortable({
        update: function(event, ui){
            let $box = $(this);
            let url = $box.data('action');
            let data = {};
            $.map($(this).find('img'), function(el, i){
                data[i] = $(el).data('id');
            });
            $.ajax({
                url: url,
                data: {
                    'data': data
                },
                beforeSend: function(){
                    $box.parents('.service-lang').find('.msg').removeClass('text-success').html(utils.spinner({class: 'spinner-border-sm'}));
                },
                success: function(response){
                    $box.parents('.service-lang').find('.msg').addClass('text-success').html(response.status);
                },
                complete: function(){
                    $box.parents('.service-lang').find('.msg .spinner-border').remove();
                }
            });
        }
    });

    $('.service-lang .service-img, .service-lang .teacher button, .add-service').click(function(){
        $btn = $(this);
        $.ajax({
            url: $btn.data('url'),
            type: 'get',
            success: function(response){
                $('#editServiceModal .modal-body').remove();
                $('#editServiceModal .modal-footer').remove();
                $('#editServiceModal .modal-content').html(response.html);
                $('#editServiceModal').modal('show');
            }
        });
    });

});
