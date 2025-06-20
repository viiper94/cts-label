(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_admin_releases_js"],{

/***/ "./resources/js/admin/releases.js":
/*!****************************************!*\
  !*** ./resources/js/admin/releases.js ***!
  \****************************************/
/***/ (() => {

$(document).ready(function () {
  $('.translate_description').click(function () {
    var button = this;
    var target = $(this).data('to-lang');
    var query = enEditor.getData().trim();
    if (query.length > 0) {
      $.ajax({
        data: {
          query: query,
          target: target
        },
        url: '/cts-admin/releases/translate',
        success: function success(response) {
          if (response.status === 'ok') {
            switch (target) {
              case 'ru':
                ruEditor.setData(response.data);
                break;
              case 'uk':
                uaEditor.setData(response.data);
                break;
            }
          } else {
            console.log(response.status);
          }
          $('main').append(getAlertToast(response.message.header, response.message.body, 'text-bg-' + (response.status === 'ok' ? 'success' : 'danger'), 'translate-toast'));
        },
        completed: function completed() {
          $('.translate-toast').toast('show').on('hidden.bs.toast', function (fn) {
            return $('.translate-toast').remove();
          });
        }
      });
    }
  });
  $('#cat-generate').click(function () {
    var url = $(this).data('url');
    $button = $(this);
    $.ajax({
      url: url,
      success: function success(response) {
        $('[name=release_number]').val(response.cat);
        $button.addClass('btn-outline-success').removeClass('btn-outline').html('<i class="fa-solid fa-check"></i>');
      }
    });
  });
  $(document).on('keyup', '#search-related', function () {
    var query = $(this).val();
    var id = $(this).data('release-id');
    if (query.length > 2) {
      var searchBy = $('input[name="search-by"]:checked').val();
      $.ajax({
        data: {
          query: query,
          searchBy: searchBy,
          id: id
        },
        url: '/cts-admin/releases/related',
        success: function success(response) {
          var checkedBoxes = $('.checked-releases .related');
          // clear checked block from unchecked checkboxes
          if (checkedBoxes.length > 0) {
            $.each(checkedBoxes, function (i, checkbox) {
              if (!$(checkbox).find('input')[0].checked) {
                checkbox.remove();
              }
            });
          }
          // save checked checkboxes
          if ($('.item-list .related').length > 0) {
            $.each($('.item-list .related'), function (j, checkbox) {
              if ($(checkbox).find('input')[0].checked) {
                console.log($(checkbox).find('input')[0].checked);
                // check if already saved
                var exist = false;
                $.each($('.checked-releases .related label'), function (i, related) {
                  if (related.innerText === $(checkbox).find('label').innerText) {
                    exist = true;
                    return false;
                  }
                });
                if (!exist) {
                  $('.checked-releases').append(checkbox);
                }
              }
            });
          }
          $('.item-list').html('');
          if (response.status === 'ok') {
            // inserting related releases
            $.each(response.data, function (i, release) {
              // check if already saved
              var exist = false;
              $.each($('.checked-releases .related label'), function (i, related) {
                if (related.innerText === release.title) {
                  exist = true;
                  return false;
                }
              });
              if (!exist) {
                $('.item-list').append(release.html);
              }
            });
          } else {
            $('.item-list').append('No result');
          }
        }
      });
    }
  });
  $('.deselect-btn').click(function (e) {
    e.preventDefault();
    $('.related input').prop('checked', false);
  });
  $(document).on('click', '.add-track', function () {
    var id = $(this).data('id');
    var url = $(this).data('url');
    var $btn = $(this);
    var inner = $btn.html();
    if ($('#trackModal .save-track').data('id') !== id) {
      $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function beforeSend() {
          $btn.html(btnSpinner());
        },
        success: function success(response) {
          $('#trackModal').find('.modal-content').html(response.modal);
          $('#trackModal').modal('show');
        },
        complete: function complete() {
          $btn.html(inner);
        }
      });
    }
    $('#trackModal').modal('show');
  });
  $('#trackSearchModal input[name=search]').keyup(function () {
    var url = $(this).data('url');
    var query = $(this).val();
    if (query.length > 3) {
      $.ajax({
        url: url,
        data: {
          query: query
        },
        beforeSend: function beforeSend() {
          $('#trackSearchModal').find('.search-items').before(spinner());
        },
        success: function success(response) {
          $('#trackSearchModal').find('.search-items .table-responsive').html(response.modal);
        },
        complete: function complete() {
          $('#trackSearchModal').find('.spinner').remove();
        }
      });
    }
  });
  $(document).on('click', '.add-to-release', function () {
    var id = $(this).data('track-id');
    var url = $(this).data('url');
    addTrackToReleaseTracklist(id, url);
    $(this).addClass('btn-outline-success').removeClass('btn-outline').html('<i class="fa-solid fa-check"></i>');
  });
  $(document).on('click', '.add-isrc-to-release', function () {
    var id = $(this).data('track-id');
    var url = $(this).data('url');
    addTrackToReleaseTracklist(id, url);
    $(this).addClass('btn-outline-success').removeClass('btn-outline').html('<i class="fa-solid fa-check me-2"></i>Добавлен!');
  });
  $('.tracks table tbody.sortable').sortable({
    handle: '.sort-handle'
  });
  $(document).on('click', '.remove-track', function () {
    if (confirm('Удалить трек из релиза?')) $(this).parents('tr').remove();else return false;
  });
  $(document).on('click', '.save-track', function (e) {
    var $btn = $(this);
    var url = $btn.data('url');
    var method = $btn.data('method');
    var data = {};
    var hasEmptyRequiredField = false;
    $('#trackModal label + small.text-danger').remove();
    $('#trackModal').find('input, select').each(function () {
      var _$el$value;
      var $el = $(this)[0];
      if ($el.required && $el.value === '') {
        $('label[for=' + $el.id + ']').after('<small class="text-danger d-block">Обязательное поле</small>');
        hasEmptyRequiredField = true;
      }
      data[$el.name] = (_$el$value = $el.value) !== null && _$el$value !== void 0 ? _$el$value : null;
    });
    if (hasEmptyRequiredField) return false;
    $.ajax({
      type: method,
      url: url,
      data: data,
      beforeSend: function beforeSend() {
        $btn.prop('disabled', true).find('i').hide();
        $btn.prepend(btnSpinner());
      },
      success: function success(response) {
        addTrackToReleaseTracklist(response.id, response.url);
        $('#trackModal').find('.save-track').attr('data-id', '0');
        $('#trackModal').modal('hide');
      },
      error: function error(xhr) {
        var response = xhr.responseJSON;
        if ($(response.errors).length > 0) {
          $('.save-track').before('<small class="text-danger d-block">' + response.message + '</small>');
          $.each(response.errors, function (name, messages) {
            $('label[for=' + name + ']').after('<small class="text-danger d-block">' + messages[0] + '</small>');
          });
        }
      },
      complete: function complete() {
        $btn.prop('disabled', false).find('i').show();
        $btn.find('.spinner-border').remove();
      }
    });
  });
  $(document).on('click', '#isrc-generate', function () {
    var url = $(this).data('url');
    $button = $(this);
    $.ajax({
      url: url,
      success: function success(response) {
        $('#trackModal #isrc').val(response.isrc).removeClass('is-invalid');
        $button.addClass('btn-outline-success').removeClass('btn-outline border-0').html('<i class="fa-solid fa-check"></i>');
        $('.isrc-existed').remove();
      }
    });
  });
  $(document).on('input', '#trackModal #isrc', function () {
    $('.isrc-existed').remove();
    var $input = $(this);
    var inputValue = $(this).val();

    // Remove all non-alphanumeric characters
    inputValue = inputValue.replace(/UA-CT1-/g, "").replace(/[^0-9]/g, "");

    // Add dashes to the appropriate positions
    if (inputValue.length > 2) {
      inputValue = [inputValue.slice(0, 2), "-", inputValue.slice(2)].join("");
    }
    if (inputValue.length > 8) {
      inputValue = inputValue.slice(0, 8);
    }

    // Add static part if not input del or backspace
    var formatted = inputValue.length > 0 ? 'UA-CT1-' + inputValue : inputValue;

    // Set the input field value to the formatted input value
    $(this).val(formatted).attr('value', formatted);
    if (formatted.length === 15) {
      var url = $(this).data('url');
      $.ajax({
        url: url,
        data: {
          isrc: formatted
        },
        success: function success(response) {
          if (response.track && response.html) {
            $input.removeClass('is-valid').addClass('is-invalid').parent().after(response.html);
          } else {
            $input.removeClass('is-invalid').addClass('is-valid');
          }
        }
      });
    }
  });
  $(document).on('click', '.add-promt', function () {
    var text = $(this).text();
    $(this).next().val(text);
    $(this).remove();
  });
  function addTrackToReleaseTracklist(id, url) {
    $.ajax({
      url: url,
      data: {
        id: id
      },
      success: function success(response) {
        if ($('tr[data-track-id=' + id + ']').length > 0) {
          $('tr[data-track-id=' + id + ']').replaceWith(response.html);
        } else {
          $(response.html).appendTo($('.tracks table tbody')[0]);
        }
      }
    });
  }
  $('#show_custom').change(function () {
    $('#tracklist_text').animate({
      height: "toggle"
    });
  });
});
function spinner() {
  return '<div class="spinner d-flex justify-content-center">\n' + '  <div class="spinner-border" role="status">\n' + '    <span class="visually-hidden">Загрузка...</span>\n' + '  </div>\n' + '</div>';
}
function btnSpinner() {
  return '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>\n' + '  <span class="visually-hidden">Загрузка...</span>';
}

/***/ })

}]);