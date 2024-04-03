/**
 * Create and update item
 * @param data
 * @param url
 */
function commonAjax(data, url) {
    var formData = new FormData();
    $.each(data, function (index, value) {
        formData.append(index, value);
    });

    $.ajax({
        method     : "POST",
        url        : url,
        cache      : false,
        contentType: false,
        processData: false,
        data       : formData,
        success    : function (response) {
            toastr.success(response.message)
            $('input').removeClass('is-invalid')
        },
        error      : function (xhr) {
            $('input').removeClass('is-invalid')

            $.each(xhr.responseJSON.errors, function(key, error) {
                $('#' + key).addClass('is-invalid')
            });

            toastr.error(xhr.responseJSON.message)
        }
    });
}

function confirmAjax(data, url, type) {
    Swal.fire({
        title            : 'Do you want to ' + type + ' this record?',
        showDenyButton   : true,
        confirmButtonText: 'Yes',
        denyButtonText   : `No`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url    : url,
                method : 'POST',
                data   : data,
                success: function (response) {
                    Swal.fire('Record is ' + type + 'd!', '', 'success')
                    $('#record-' + data.id).remove()
                },
                error  : function (xhr) {
                    Swal.fire('Record is not ' + type + 'd!', '', 'error')
                }
            })
        }
    })
}