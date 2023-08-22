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

    $(document).on('change', '#uploader', function(){
        utils.readURL(this, '#preview');
    });

});
