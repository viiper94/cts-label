// Studio School
$(document).ready(function(){

    $('.service-lang .sortable').sortable({
        stop: function(event, ui){
            let $box = $(this);
            let url = $box.data('action');
            let data = {};
            $.map($(this).find('img'), function(el){
                data[$(el).index()] = $(el).data('id');
            });
            $.ajax({
                url: url,
                data: {
                    'data': data
                },
                beforeSend: function(){
                    $box.parent().find('.msg').html('Сортировка...');
                },
                success: function(response){
                    $box.parent().find('.msg').html('Пересортировано');
                },
            });
        }
    });

    $('.add-service').click(function(){
        $('#serviceModal').find('#preview').attr('src', '/images/studio/services/default.png');
        $('#serviceModal').find('[name=name]').val('');
        $('#serviceModal').find('#service_alt').val('');
        $('#serviceModal').find('#visible').prop('checked', false);
        $('#serviceModal').find('#lang option[value=en]').prop('selected', true);
        $('#serviceModal').find('#modal-form').attr('action', $(this).data('action'));
        $('#serviceModal #delete-form').hide();
        if($('#serviceModal #modal-form [name=_method]').length > 0) $('#serviceModal #modal-form [name=_method]').remove();
        $('#serviceModal').modal('show');
    });

    $('.service-lang .service-img').click(function(){
        $('#serviceModal').find('#preview').attr('src', $(this).attr('src'));
        $('#serviceModal').find('[name=name]').val($(this).data('name'));
        $('#serviceModal').find('#service_alt').val($(this).attr('alt'));
        $('#serviceModal').find('#visible').prop('checked', $(this).data('visible') == '1');
        $('#serviceModal').find('#lang option[value='+$(this).data('lang')+']').prop('selected', true);
        $('#serviceModal').find('#modal-form').attr('action', $(this).data('action'));
        $('#serviceModal #delete-form').css('display', 'inline-block').attr('action', $(this).data('action'));
        if($('#serviceModal #modal-form [name=_method]').length === 0) $('#serviceModal #modal-form').append('<input type="hidden" name="_method" value="PUT">');
        $('#serviceModal').modal('show');
    });

});
