(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_public_common_js"],{

/***/ "./resources/js/public/common.js":
/*!***************************************!*\
  !*** ./resources/js/public/common.js ***!
  \***************************************/
/***/ (() => {

// Common

$(document).ready(function () {
  $('.alert-toast').toast('show');
  $('.switch-btn').click(function () {
    setCookie('lang', $(this).data('lang'), {
      expires: 3600 * 24 * 365,
      path: '/'
    });
  });
});
function setCookie(name, value, options) {
  options = options || {};
  var expires = options.expires;
  if (typeof expires == "number" && expires) {
    var d = new Date();
    d.setTime(d.getTime() + expires * 1000);
    expires = options.expires = d;
  }
  if (expires && expires.toUTCString) {
    options.expires = expires.toUTCString();
  }
  value = encodeURIComponent(value);
  var updatedCookie = name + "=" + value;
  for (var propName in options) {
    updatedCookie += "; " + propName;
    var propValue = options[propName];
    if (propValue !== true) {
      updatedCookie += "=" + propValue;
    }
  }
  document.cookie = updatedCookie;
}

/***/ })

}]);