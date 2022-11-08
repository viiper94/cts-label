require('../functions');

$(document).ready(function(){

    $.ajaxSetup({
        type : 'POST',
        cache: false,
        dataType : 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.alert-toast').toast('show');
    $('.collapse').collapse('hide');

    $('#uploader').change(function(){
        readURL(this, '#preview');
    });

});
