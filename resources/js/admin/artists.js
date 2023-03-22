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

});
