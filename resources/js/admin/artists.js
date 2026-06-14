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


});
