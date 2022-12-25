// Studio
$(document).ready(function(){

    $('.studio .service-link').click(function(){
        $('#service-modal').find('input[name=service]').val($(this).data('name'))
    });

});
