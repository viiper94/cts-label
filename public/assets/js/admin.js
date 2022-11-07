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

    $(document).on('keyup', '#search-related', function(){
        let query = $(this).val();
        let id = $(this).data('release-id');
        if(query.length > 2){
            let searchBy = $('input[name="search-by"]:checked').val();
            $.ajax({
                data : {
                    query: query,
                    searchBy : searchBy,
                    id : id
                },
                url : '/cts-admin/releases/related',
                success : function(response){
                    let checkedBoxes = $('.checked-releases .related label');
                    // clear checked block from unchecked checkboxes
                    if(checkedBoxes.length > 0){
                        $.each(checkedBoxes, function(i, checkbox){
                            if(!checkbox.children[0].checked){
                                checkbox.remove();
                            }
                        });
                    }
                    // save checked checkboxes
                    if($('.item-list .related').length > 0){
                        $.each($('.item-list .related'), function(j, checkbox){
                            if(checkbox.children[1].children[0].checked){
                                // check if already saved
                                let exist = false;
                                $.each($('.checked-releases .related label'), function(i, related){
                                    if(related.innerText === $(checkbox).find('label').innerText){
                                        exist = true;
                                        return false;
                                    }
                                });
                                if(!exist){
                                    $('.checked-releases').append(checkbox);
                                }
                            }
                        });
                    }
                    $('.item-list').html('');
                    if(response.status === 'ok'){
                        // inserting related releases
                        $.each(response.data, function(i, release){
                            let div = '<div class="related" style="display: block;">' +
                                '<a class="page-link" href="http://cts-label.com/releases/'+release.id+'" target="_blank">Visit page</a>' +
                                '<label style="margin-left: 25px;"><input type="checkbox" '+ (!release.checked ? '' : 'checked') +
                                ' name="related[]" value = "'+release.id+'" class="new-input"/>'+release.title+'</label></div>';
                            // check if already saved
                            let exist = false;
                            $.each($('.checked-releases .related label'), function(i, related){
                                if(related.innerText === release.title){
                                    exist = true;
                                    return false;
                                }
                            });
                            if(!exist){
                                $('.item-list').append(div);
                            }
                        });
                    } else {
                        let div = 'No result';
                        $('.item-list').append(div);
                    }
                }
            });
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
