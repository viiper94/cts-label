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

    $('#cat-generate').click(function(){
        let url = $(this).data('url');
        $button = $(this);
        $.ajax({
            url: url,
            success: function(response){
                $('[name=release_number]').val(response.cat);
                $button.addClass('btn-outline-success').removeClass('btn-outline').html('<i class="fa-solid fa-check"></i>');
            }
        });
    });

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
                    let checkedBoxes = $('.checked-releases .related');
                    // clear checked block from unchecked checkboxes
                    if(checkedBoxes.length > 0){
                        $.each(checkedBoxes, function(i, checkbox){
                            if(!$(checkbox).find('input')[0].checked){
                                checkbox.remove();
                            }
                        });
                    }
                    // save checked checkboxes
                    if($('.item-list .related').length > 0){
                        $.each($('.item-list .related'), function(j, checkbox){
                            if($(checkbox).find('input')[0].checked){
                                console.log($(checkbox).find('input')[0].checked);
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
                            // check if already saved
                            let exist = false;
                            $.each($('.checked-releases .related label'), function(i, related){
                                if(related.innerText === release.title){
                                    exist = true;
                                    return false;
                                }
                            });
                            if(!exist){
                                $('.item-list').append(release.html);
                            }
                        });
                    } else {
                        $('.item-list').append('No result');
                    }
                }
            });
        }
    });

    $('.deselect-btn').click(function(e){
        e.preventDefault();
        $('.related input').prop('checked', false);
    });

    $(document).on('click', '.add-track', function(){
        let id = $(this).data('id');
        let url = $(this).data('url');
        if($('#trackModal .save-track').data('id') !== id){
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response){
                    $('#trackModal').find('.modal-content').html(response.modal);
                }
            });
        }
    });

    $('#trackSearchModal input[name=search]').keyup(function(){
        let url = $(this).data('url');
        let query = $(this).val();
        if(query.length > 3){
            $.ajax({
                url: url,
                data: {
                    query: query
                },
                success: function(response){
                    $('#trackSearchModal').find('.search-items .table-responsive').html(response.modal);
                }
            });
        }
    });

    $(document).on('click', '.add-to-release', function(){
        let id = $(this).data('track-id');
        let url = $(this).data('url');
        addTrackToReleaseTracklist(id, url);
        $(this).addClass('btn-outline-success').removeClass('btn-outline').html('<i class="fa-solid fa-check"></i>');
    });

    $('.tracks table tbody.sortable').sortable({
        handle: '.sort-handle',
    });

    $(document).on('click', '.remove-track', function(){
        if(confirm('Удалить трек из релиза?')) $(this).parents('tr').remove();
        else return false;
    });

    $(document).on('click', '.save-track', function(e){
        let url = $(this).data('url');
        let method = $(this).data('method');
        let data = {};
        let hasEmptyRequiredField = false;
        $('#trackModal small.text-danger').remove();
        $('#trackModal').find('input, select').each(function(){
            let $el = $(this)[0];
            if($el.required && $el.value === ''){
                $('label[for='+$el.id+']').after('<small class="text-danger d-block">Обязательное поле</small>');
                hasEmptyRequiredField = true;
            }
            data[$el.name] = $el.value ?? null;
        });
        if(hasEmptyRequiredField) return false;
        $.ajax({
            type: method,
            url: url,
            data: data,
            success: function(response){
                addTrackToReleaseTracklist(response.id, response.url);
                $('#trackModal').find('.save-track').attr('data-id', '0');
                $('#trackModal').modal('hide');
            },
            error: function(xhr){
                let response = xhr.responseJSON;
                if($(response.errors).length > 0){
                    $('.save-track').before('<small class="text-danger d-block">'+response.message+'</small>');
                    $.each(response.errors, function(name, messages){
                        $('label[for='+name+']').after('<small class="text-danger d-block">'+messages[0]+'</small>');
                    });
                }
            }
        });
    });

    $(document).on('click', '#isrc-generate', function(){
        let url = $(this).data('url');
        $button = $(this);
        $.ajax({
            url: url,
            success: function(response){
                $('#trackModal #isrc').val(response.isrc);
                $button.addClass('btn-outline-success').removeClass('btn-outline').html('<i class="fa-solid fa-check"></i>');
            },
        });
    });

    $(document).on('click', '.add-promt', function(){
        let text = $(this).text();
        $(this).next().val(text);
        $(this).remove();
    });

    function addTrackToReleaseTracklist(id, url){
        $.ajax({
            url: url,
            data: {
                id: id
            },
            success: function(response){
                if($('tr[data-track-id='+id+']').length > 0){
                    $('tr[data-track-id='+id+']').replaceWith(response.html);
                }else{
                    $(response.html).appendTo($('.tracks table tbody')[0]);
                }
            }
        });
    }

    $('#show_custom').change(function(){
        if(this.checked){
            $('#tracklist_text').show();
        }else{
            $('#tracklist_text').hide();
        }
    });

});
