$(document).ready(function(){

    $.ajaxSetup({
        type : 'POST',
        cache: false,
        dataType : 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.deselect-btn').click(function(e){
        e.preventDefault();
        $('.related label input').prop('checked', false);
    });

    $('.related_last_five').click(function(e){
        e.preventDefault();
        $('.related label input').prop('checked', false);
        for(let i = 0; i < 5; i++){
            $($('.related label input')[i]).prop('checked', true);
        }
    });

    $('#uploader').change(function(){
        readURL(this, '#preview');
    });
    $('.collapse').collapse();

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

    $(document).on('click','.delete-review-btn', function(){
        if(confirm('Удалить?')){
            $(this).parent().remove();
        }
    });
    $('.add-review-btn').click(function(){
        let index = $(this).data('index')+1;
        $(this).data('index', index);
        let template = $('#'+$(this).data('target')+'_template').html().replace(/%i%/g, index);
        $('#'+$(this).data('target')).append(template);
    });

    $('.service-lang .sortable').sortable({
        stop: function(event, ui){
            let data = {};
            $.map($(this).find('img'), function(el){
                data[$(el).index()] = $(el).data('id');
            });
            $.ajax({
                type: 'POST',
                url: '/cts-admin/studio/resort',
                data: {
                    '_token': $('[name=_token]').val(),
                    'data': data
                },
                beforeSend: function(){
                    $('.service-lang .msg').html('Сортировка...');
                },
                success: function(response){
                    $('.service-lang .msg').html('Пересортировано');
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

function readURL(input, selector){
    if(selector === undefined) selector = '#preview';
    if (input.files && input.files[0]){
        let reader = new FileReader();
        reader.onload = function (e) {
            $(selector).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
