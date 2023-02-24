$(document).ready(function(){

    $('.debug-email-btn').click(function(){
        $('#testContactsModal input[name=channel]').val($(this).data('channel'));
    });

    $('#select-all-emails').click(function(){
        $('#testContactsModal input[type=checkbox]').prop('checked', true);
    });

    $('#deselect-all-emails').click(function(){
        $('#testContactsModal input[type=checkbox]').prop('checked', false);
    });

});
