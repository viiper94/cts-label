$(document).ready(function(){

    $('.edit-artist').click(function(){
        $card = $(this);
        $.ajax({
            url: $card.data('url'),
            type: 'get',
            success: function(response){
                $('#editArtistModal .modal-body').remove();
                $('#editArtistModal .modal-footer').remove();
                $('#editArtistModal .modal-header').after(response.html);
                $('#editArtistModal').modal('show');
            }
        });
    });

    $('.artists-docs .edit-doc').click(function(){
        $btn = $(this);
        $.ajax({
            url: $btn.data('url'),
            type: 'get',
            success: function(response){
                $('#editArtistDocsModal .modal-body').remove();
                $('#editArtistDocsModal .modal-footer').remove();
                $('#editArtistDocsModal .modal-content').html(response.html);
                $('#editArtistDocsModal').modal('show');
            }
        });
    });

    $(document).on('click', '.artists-docs .add-to-docs', function(){
        $btn = $(this);
        $row = $btn.parent().parent().clone();

        $row.find('.add-to-docs').hide();
        $row.find('.remove-from-docs').show();
        
        $row.appendTo('.artists-docs .assigned-tracks tbody');

        $btn.hide();
        $btn.parent().find('.btn-outline-success').show();

        if($('.assigned-tracks .no-tracks').length > 0){
            $('.assigned-tracks .no-tracks').hide();
        }
    });

    $(document).on('click', '.artists-docs .assigned-tracks .remove-from-docs', function(){
        $btn = $(this);
        id = $btn.parent().find('input').val();
        $row = $btn.parent().parent().remove();

        if($('.search-items input[value='+id+']').length > 0){
            $('.search-items input[value='+id+']').parent().find('.btn-outline-success').hide();
            $('.search-items input[value='+id+']').parent().find('.add-to-docs').show();
        }

        if($('.assigned-tracks .no-tracks').length == 0){
            $('.assigned-tracks .no-tracks').show();
        }
    });

});
