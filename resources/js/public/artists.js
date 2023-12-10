// Artists CV
$(document).ready(function(){

    var sortable = Sortable.create(document.querySelector('.sortable'), {
        handle: ".sort-handle",
        animation: 150
    });

    $(document).on('click', '.add-artist-info-btn', function(){
        let $button = $(this);
        let url = $button.data('url');
        $.ajax({
            url: url,
            beforeSend: function(){
                $button.prop('disabled', true).find('i').hide();
                $button.prepend(utils.spinner({
                    class: 'spinner-border-sm'
                }));
            },
            success: function(response){
                $('#artistInfoModal .modal-dialog').html(response.html);
                const picker = new Litepicker({
                    element: document.getElementById('date_of_birth'),
                    lang: response.locale,
                    inlineMode: true,
                    dropdowns: {
                        "minYear": 1950,
                        "maxYear": null,
                        "months": true,
                        "years": true
                    }
                });
                $('#artistInfoModal').modal('show');
            },
            complete: function(){
                $button.prop('disabled', false).find('i').show();
                $button.find('.spinner-border').remove();
            }
        });
    });

    $(document).on('click', '.save-artist-info-btn', function(){
        let $button = $(this);
        let url = $button.data('url');
        let method = $button.data('method');
        let data = {};

        $('#artistInfoModal small.text-danger').hide();
        $('#artistInfoModal').find('input').each(function(){
            let $el = $(this)[0];
            data[$el.name] = $el.value ?? null;
        });

        $.ajax({
            type: method,
            url: url,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            },
            beforeSend: function(){
                $button.prop('disabled', true).find('i').hide();
                $button.prepend(utils.spinner({
                    class: 'spinner-border-sm'
                }));
                $('label[for] + small').remove();
                $('.modal-footer small').remove();
            },
            success: function(response){
                addArtistToArtistsInfoList(response.id, response.html);
                $button.attr('data-id', '0');
                $('#artistInfoModal').modal('hide');
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            error: function(xhr){
                let response = xhr.responseJSON;
                if($(response.errors).length > 0){
                    $button.before('<small class="text-danger d-block">'+response.message+'</small>');
                    $.each(response.errors, function(name, messages){
                        $('label[for='+name+']').after('<small class="text-danger d-block">'+messages[0]+'</small>');
                    });
                }
            },
            complete: function(){
                $button.prop('disabled', false).find('i').show();
                $button.find('.spinner-border').remove();
            }
        });

    });

    $(document).on('click', '.remove-artist-info-btn', function(){
        if(confirm($(this).data('alert'))) $(this).parents('tr').remove();
        if($('tr[data-info-id]').length === 0) $('tr.no-artists').show();
        else return false;
    });

    $(document).on('click', '.add-track-to-sign-btn', function(){
        let $button = $(this);
        let url = $button.data('url');
        $.ajax({
            url: url,
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            },
            data: {
                index: $('.track-to-sign-item').last().data('index')
            },
            success: function(response){
                $('.track-to-sign-item').last().after(response.html)
            },
        });
    });

    $(document).on('click', '.remove-track-to-sign-btn', function(){
        if($('.track-to-sign-item').length === 1) return false;
        $(this).parent().parent().remove();
    });

    function addArtistToArtistsInfoList(id, html){
        if($('tr[data-info-id='+id+']').length > 0){
            $('tr[data-info-id='+id+']').replaceWith(html);
        }else{
            $(html).appendTo($('.anketa table tbody')[0]);
        }
        $('tr.no-artists').hide();
    }

});
