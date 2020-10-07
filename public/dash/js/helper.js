$(document).ready(function () {

    // Ajax post helper function
    $.fn.speedPost = function (url, data, formId) {
        $(this).showLoader(true);
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $(this).showLoader(false);
                // toastr.success(data[0], data[1]);
                swal({
                    title: data[0],
                    icon: "success",
                    text: data[1]
                }).then(function(){
                    window.location = "/home";
                });

                if (formId) {
                    $(this).formReset(formId)
                }
            }, error: function (data) {
                $(this).showLoader(false);
                if (data.status === 422) {
                    $(this).showValidationError(data);
                } else if (data.status === 421) {
                    // toastr.error(data.responseJSON[0], data.responseJSON[1]);
                    swal({
                        title: data.responseJSON[0],
                        icon: "error",
                        text: data.responseJSON[1]
                    });
                } else {
                    // toastr.error(data.responseJSON.message);
                    swal({
                        icon: "error",
                        text: data.responseJSON.message
                    });
                }
            }
        })
    };

    // Validation error show
    $.fn.showValidationError = function (data) {
        $.each(data.responseJSON, function (key, data) {
            for (var key in data) {
                if (key.length > 2) {
                    $.each(data[key], function (index, data) {
                        toastr.error('Error', data)
                    })
                }
            }
        });
    };

    // Showing app loader
    $.fn.showLoader = function (style) {
        if (style == true) {
            document.getElementById("loader").style.display = "block";
        } else {
            document.getElementById("loader").style.display = "none";
        }
    };

    $.fn.formReset = function (formID) {
        formID.get(0).reset();
    };

    $.fn.confirmDelete = function (formId) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data again!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                formId.submit();
                if ($.uploadPreview) {
                    $("#image-preview").css('background-image', "url('../../img/boxed-bg.jpg')");
                }
            } else {
                swal("Your data is safe!");
            }
        });
    };

    $.fn.confirmPromote = function () {
        var result = false;
        swal({
            title: 'Are you sure?',
            text: 'To change status',
            icon: 'warning',
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                result = true;
            } else {
                result = false;
            }
        });

        return result;
    };

    $.fn.confirmSubmit = function (formId) {
        swal({
            title: 'Are your sure?',
            text: 'Click confirm to submit form',
            icon: 'warning',
            buttons: true,
            dangerMode: true
        }).then(function (willDelete) {
            if (willDelete) {
                formId.submit();
            } else {

            }
        });
    };

    if ($.fn.DataTable) {
        if (!$.fn.DataTable.isDataTable('#datatable')) {
            $('#datatable').DataTable({
                responsive: true
            });
        }
    }
    ;


    if ($.uploadPreview) {
        $.uploadPreview({
            input_field: "#image-upload",   // Default: .image-upload
            preview_box: "#image-preview",  // Default: .image-preview
            label_field: "#image-label",    // Default: .image-label
            label_default: "Choose File",   // Default: Choose File
            label_selected: "Change File",  // Default: Change File
            no_label: false                 // Default: false
        });
    }

    $("#form").on('submit', function (e) {
        e.preventDefault();
        var data = new FormData(this);
        var form_id = $('#form');
        $(this).speedPost($(this).attr('action'), data, form_id);
    });

    $(".update_form").on('submit', function (e) {
        e.preventDefault();
        var data = new FormData(this);
        $(this).speedPost($(this).attr('action'), data);
    })

    $("#update_form").on('submit', function (e) {
        e.preventDefault();
        var data = new FormData(this);
        $(this).speedPost($(this).attr('action'), data);
    });


});