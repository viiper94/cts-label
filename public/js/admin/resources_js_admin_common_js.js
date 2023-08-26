(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_admin_common_js"],{

/***/ "./resources/js/admin/common.js":
/*!**************************************!*\
  !*** ./resources/js/admin/common.js ***!
  \**************************************/
/***/ (() => {

$(document).ready(function () {
  $.ajaxSetup({
    type: 'POST',
    cache: false,
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('.alert-toast').toast('show');
  $('.collapse').collapse('hide');
  $(document).on('change', '#uploader', function () {
    readURL(this, '#preview');
  });
});
function readURL(input, selector) {
  if (selector === undefined) selector = '#preview';
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $(selector).attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
  }
}
function getAlertToast() {
  var headingMessage = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
  var bodyMessage = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
  var headingClass = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  var toastClass = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
  return '<div class="toast alert-toast align-items-center position-fixed border-0 m-3 top-0 end-0 ' + toastClass + '" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">\n' + '        <div class="toast-header ' + headingClass + '">\n' + '            <strong class="me-auto">' + headingMessage + '</strong>\n' + '            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>\n' + '        </div>\n' + '        <div class="toast-body">\n' + bodyMessage + '        </div>\n' + '    </div>';
}

/***/ })

}]);