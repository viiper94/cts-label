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

});
