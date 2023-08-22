(function() {

    function readURL(input, selector){
        if(selector === undefined) selector = '#preview';
        if (input.files && input.files[0]){
            let reader = new FileReader();
            reader.onload = function (e) {
                $(selector).attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function getAlertToast(
        headingMessage = null,
        bodyMessage = null,
        headingClass = null,
        toastClass = null){

        let toastHeader = headingMessage ?
            '        <div class="toast-header '+headingClass+'">\n' +
            '            <strong class="me-auto">'+headingMessage+'</strong>\n' +
            '            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>\n' +
            '        </div>\n' : '';
        let toastBodyClass = 'toast-body ' + (toastHeader !== '' ? '' : headingClass)
        let toastBody = bodyMessage ?
            '        <div class="'+toastBodyClass+'">\n' +
                        bodyMessage +
            '        </div>\n' : '';

        return '<div class="toast alert-toast align-items-center position-fixed border-0 m-3 top-0 end-0 '+toastClass+'" ' +
            'role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">\n' +
                    toastHeader + toastBody +
            '    </div>';
    }

    function spinner(props = {}){
        let spinnerClass = props.class ?? '';
        let wrapperClass = props.wrapperClass ?? '';
        let wrapper = !!props.wrapper;
        let html = '<div class="spinner-border ' + spinnerClass + '" role="status"></div>';
        if(wrapper){
            html = '<div class="spinner d-flex justify-content-center ' + wrapperClass + '">\n' +
                    html + '\n' +
                '</div>';
        }
        return html;
    }

    window.utils = {
        getAlertToast,
        spinner,
        readURL
    };

})();
