import copy from 'copy-to-clipboard';

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

    $(document).on('click', '.to-clipboard', function(){
        let toCopy  = $(this).html();
        console.log(toCopy);
        copy(toCopy);

        $('main').append(utils.getAlertToast(null, 'Скопійовано', 'text-bg-primary', 'status-toast'));
        $('.status-toast').toast('show').on('hidden.bs.toast', fn => ($('.status-toast-review-toast').remove()));
    });

});
