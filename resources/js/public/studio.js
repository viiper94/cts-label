// Studio
$(document).ready(function(){

    $('.studio, .school').find('.service-link').click(function(){
        $('#service-modal').find('input[name=service]').val($(this).data('name'));
    });

});
