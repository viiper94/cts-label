$(document).ready(function(){

    $("#sticker").sticky({
        topSpacing : 15,
        zIndex : 2,
        widthFromWrapper : false,
        wrapperClassName : 'is-sticky-btn'
    });

    $('.deselect-btn').click(function(e){
        e.preventDefault();
        $('.related label input').attr('checked', false);
    });

    $('#uploader').change(function(){
        readURL(this, '#preview');
    });

    $(document).on('keyup', '#search-related', function(){
        let query = $(this).val();
        let id = $(this).data('release-id');
        if(query.length > 2){
            let searchBy = $('input[name="search-by"]:checked').val();
            $.ajax({
                type : 'POST',
                data : {
                    _token : $('meta[name=csrf-token]').attr("content"),
                    query: query,
                    searchBy : searchBy,
                    id : id
                },
                cache: false,
                dataType : 'json',
                url : '/cts-admin/releases/searchrelated',
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

    $('.translate_description').click(function(){
        let target = $(this).data('to-lang');
        let query = CKEDITOR.instances.description_en.getData().trim();
        if(query.length > 0){
            $.ajax({
                type : 'POST',
                data : {
                    _token : $('meta[name=csrf-token]').attr("content"),
                    query: query,
                    target : target
                },
                cache: false,
                dataType : 'json',
                url : '/cts-admin/releases/translate',
                success : function(response){
                    if(response.status === 'ok'){
                        CKEDITOR.instances['description_'+target].setData(response.data);
                    }else{
                        console.log(response.status);
                    }
                }
            });
        }
    });

    $('#search-reviewer').keyup(function(){
        let query = $(this).val().trim();
        if(query.length > 2){
            $.ajax({
                type : 'POST',
                data : {
                    _token : $('meta[name=csrf-token]').attr("content"),
                    query : query
                },
                cache: false,
                dataType : 'json',
                url : '/cts-admin/reviews/searchreviewer',
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


    let clipboard = new ClipboardJS('.copy-link');
    clipboard.on('success', function(e) {
        $(e.trigger).html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>\n' +
            '                                <span class="hidden-xs hidden-sm">Скопировано!</span>');

        e.clearSelection();
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
