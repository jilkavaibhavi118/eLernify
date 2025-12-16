<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    function showSuccessToast(message) {
        Toast.fire({
            icon: 'success',
            title: message
        });
    }

    function showErrorToast(message) {
        Toast.fire({
            icon: 'error',
            title: message
        });
    }

    $(document).on('click', '#crudFormSave', function(e) {
        e.preventDefault();
        $(this).prop('disabled', true);
        var URL = $('#crudForm').attr('action');
        let formData = new FormData(document.getElementById('crudForm'));
        $.ajax({
            type: 'POST',
            url: URL,
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function(result) {
                if (result.error) {
                    $('#crudFormSave').prop('disabled', false);

                    // Assuming showErrorToast is defined elsewhere, or use CoreUI toast/alert
                    if (typeof showErrorToast === 'function') {
                        showErrorToast(result.error);
                    } else {
                        alert("Error: " + result.error);
                    }
                    return false;
                } else {
                    // Assuming showSuccessToast is defined elsewhere
                    if (typeof showSuccessToast === 'function') {
                        showSuccessToast(result.success);
                    } else {
                        alert("Success: " + result.success);
                    }
                    setTimeout(() => {
                        window.location.href = result.url;
                    }, 1000); // Reduced delay for better UX
                }
            },
            error: function(err) {
                console.log(err);
                if (err.responseJSON && err.responseJSON.errors) {
                    $.each(err.responseJSON.errors, function(key, value) {
                        if (typeof showErrorToast === 'function') {
                            showErrorToast(value);
                        } else {
                            alert("Error: " + value);
                        }
                    });
                } else {
                    let errorMsg = (err.responseJSON && err.responseJSON.error) ? err
                        .responseJSON.error : "An error occurred";
                    if (typeof showErrorToast === 'function') {
                        showErrorToast(errorMsg);
                    } else {
                        alert(errorMsg);
                    }
                }
                $("#crudFormSave").prop('disabled', false);
            },
        });
    });

    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();

        let url = $(this).data('url');

        // Check if Swal is defined, otherwise fallback to confirm
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: "Are you sure?",
                text: "This item will be permanently deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    performDelete(url);
                }
            });
        } else {
            if (confirm("Are you sure? This item will be permanently deleted!")) {
                performDelete(url);
            }
        }
    });

    function performDelete(url) {
        $.ajax({
            url: url,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: "Deleted!",
                        text: response.message,
                        icon: "success",
                    });
                } else {
                    alert(response.message);
                }

                // Reload datatable if it exists and uses AJAX, otherwise reload page
                if ($.fn.DataTable && $.fn.DataTable.isDataTable('#table') && $('#table').DataTable().ajax
                    .url()) {
                    $('#table').DataTable().ajax.reload();
                } else {
                    location.reload();
                }
            },
            error: function(err) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: "Error!",
                        text: "Something went wrong.",
                        icon: "error",
                    });
                } else {
                    alert("Something went wrong.");
                }
            }
        });
    }
</script>
