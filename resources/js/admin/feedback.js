import ClipboardJS from "clipboard";

$(document).ready(function(){

    let clipboard = new ClipboardJS('.copy-link');
    clipboard.on('success', function(e) {
        $(e.trigger).html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>\n' +
            '                                <span class="hidden-xs hidden-sm">Скопировано!</span>');

        e.clearSelection();
    });

});
