import ClipboardJS from "clipboard";

$(document).ready(function(){

    let clipboard = new ClipboardJS('.copy-link');
    clipboard.on('success', function(e) {
        $(e.trigger).html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>\n' +
            '                                <span class="hidden-xs hidden-sm">Скопировано!</span>');

        e.clearSelection();
    });

    $('.related_last_five').click(function(e){
        e.preventDefault();
        $('.related-all-feedback input').prop('checked', false);
        for(let i = 0; i < 5; i++){
            $($('.related-all-feedback input')[i]).prop('checked', true);
        }
    });

    $('.deselect-btn').click(function(e){
        e.preventDefault();
        $('.related-all-feedback input').prop('checked', false);
    });

});
