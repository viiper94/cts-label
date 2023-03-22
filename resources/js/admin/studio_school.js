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
                    $box.parents('.service-lang').find('.msg').removeClass('text-danger').removeClass('text-success').html('Сортировка...');
                },
                success: function(response){
                    $box.parents('.service-lang').find('.msg').addClass('text-success').html('Пересортировано');
                },
                error: function(){
                    $box.parents('.service-lang').find('.msg').addClass('text-danger').html('Ошибка');
                }
            });
        }
    });

    $('.add-service').click(function(){
        $('#serviceModal').find('#preview').attr('src', '/images/studio/services/default.png');
        $('#serviceModal').find('[name=name]').val('');
        $('#serviceModal').find('#service_alt').val('');
        $('#serviceModal').find('#teacher_hinfo').val('');
        $('#serviceModal').find('#teacher_binfo').val('');
        $('#serviceModal').find('#visible').prop('checked', false);
        $('#serviceModal').find('#lang option[value=en]').prop('selected', true);
        $('#serviceModal').find('#modal-form').attr('action', $(this).data('action'));
        $('#serviceModal #delete-form').hide();
        if($('#serviceModal #modal-form [name=_method]').length > 0) $('#serviceModal #modal-form [name=_method]').remove();
        $('#serviceModal').modal('show');
    });

    $('.service-lang .service-img, .service-lang .teacher button').click(function(){
        $('#serviceModal').find('#preview').attr('src', $(this).attr('src') ?? $(this).data('src'));
        $('#serviceModal').find('[name=name]').val($(this).data('name'));
        $('#serviceModal').find('#service_alt').val($(this).attr('alt'));
        $('#serviceModal').find('#teacher_hinfo').val($(this).data('hinfo'));
        $('#serviceModal').find('#teacher_binfo').val($(this).data('binfo'));
        $('#serviceModal').find('#visible').prop('checked', $(this).data('visible') == '1');
        $('#serviceModal').find('#lang option[value='+$(this).data('lang')+']').prop('selected', true);
        $('#serviceModal').find('#modal-form').attr('action', $(this).data('action'));
        $('#serviceModal #delete-form').css('display', 'inline-block').attr('action', $(this).data('action'));
        if($('#serviceModal #modal-form [name=_method]').length === 0) $('#serviceModal #modal-form').append('<input type="hidden" name="_method" value="PUT">');
        $('#serviceModal').modal('show');
    });

});
