<table class="table pb-20" id="submissions_table">
    <thead>
        <tr>
            <th>Title</th>
            {{-- <th>Submission Count</th> --}}
            <th class="text-center">Attempts Count</th>
            <th class="text-center">Status</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@section('scripts')
<script type="text/javascript">
   function requestServer(element){
        let submission_id = element.attr('data-submission-id');
        let request_type = element.attr('data-request-type');

        switch (request_type) {
            case "delete":
                swal({
                    title: "Are you sure?",
                    text: "You are about to delete this submission!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '/nodejs/submissions/delete/submission',
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token()}}'
                            },
                            data: {
                                submission_id: submission_id,
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(data) {
                                swal({
                                    title: "Success!",
                                    text: "Your submission has been deleted!",
                                    icon: "success",
                                    button: "Ok",
                                }).then(function() {
                                    window.location = "/nodejs/submissions";
                                });
                            },
                            error: function(data) {
                                swal({
                                    title: "Error!",
                                    text: "Something went wrong!",
                                    icon: "error",
                                    button: "Ok",
                                });
                            }
                        });
                    }
                });
                break;
            case "restart":
                swal({
                    title: "Are you sure?",
                    text: "You are about to restart this submission!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willRestart) => {
                    if (willRestart) {
                        $.ajax({
                            url: '/nodejs/submissions/restart/submission',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token()}}'
                            },
                            data: {
                                submission_id: submission_id,
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(data) {
                                swal({
                                    title: "Success!",
                                    text: "Your submission has been restarted!",
                                    icon: "success",
                                    button: "Ok",
                                }).then(function() {
                                    window.location = "/nodejs/submissions";
                                });
                            },
                            error: function(xhr, status, error) {
                                let errorMessage = "Something went wrong!";
                                
                                console.log("Error status:", xhr.status);
                                console.log("Error response:", xhr.responseText);
                                
                                // Check if it's a 403 error (maximum attempts reached)
                                if (xhr.status === 403) {
                                    try {
                                        let response = JSON.parse(xhr.responseText);
                                        errorMessage = response.message || "Maximum attempts reached. Cannot restart submission.";
                                    } catch (e) {
                                        errorMessage = "Maximum attempts reached. Cannot restart submission.";
                                    }
                                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                
                                swal({
                                    title: "Error!",
                                    text: errorMessage,
                                    icon: "error",
                                    button: "Ok",
                                });
                            }
                        });
                    }
                });
                break;
            case "change-source-code":
                // First check if attempts limit is reached via AJAX
                $.ajax({
                    url: '/nodejs/submissions/change/' + submission_id,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token()}}'
                    },
                    success: function(data) {
                        // If successful, redirect to the change source code page
                        window.location = '/nodejs/submissions/change/' + submission_id;
                    },
                    error: function(xhr, status, error) {
                        // Handle 403 error (maximum attempts reached)
                        if (xhr.status === 403) {
                            let errorMessage = "Maximum attempts reached. Cannot change source code.";
                            try {
                                let response = JSON.parse(xhr.responseText);
                                errorMessage = response.message || errorMessage;
                            } catch (e) {
                                // Use default message if parsing fails
                            }
                            
                            swal({
                                title: "Error!",
                                text: errorMessage,
                                icon: "error",
                                button: "Ok",
                            });
                        } else {
                            swal({
                                title: "Error!",
                                text: "Something went wrong!",
                                icon: "error",
                                button: "Ok",
                            });
                        }
                    }
                });
                break;
            default:
                break;
        }
    }

    $(function () {
        var table = $('#submissions_table').DataTable({
            "processing": true,
            "retrieve": true,
            "serverSide": true,
            'paginate': true,
            "bDeferRender": true,
            "responsive": true,
            "autoWidth": false,
            "bLengthChange" : false,
            "aaSorting": [],
            "lengthMenu": [5],
            "searching": false,
            "info" : false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search",
                "paginate": {
                    "previous": "<",
                    "next": ">",
                },
            },
            ajax: "{{ route('submissions') }}",
            columns: [
                {
                    data: 'title',
                    name: 'title',
                    orderable: true,
                    searchable: true,
                    createdCell: function (td) {
                        $(td).attr({
                            'data-step': '1',
                            'data-intro': 'Klik Tittle Project untuk melihat lebih detail submission, anda dapat dapat melihat detail pengujian dan mendownload hasil pengujiannya.',
                            'data-title': 'Submission Detail',
                            'data-position': 'right',
                            'data-disable-interaction': 'false'
                        });
                    }
                },
                {
                    data: 'attempts_count',
                    name: 'attempts_count',
                    orderable: true,
                    searchable: false,
                    className: "text-center"
                },
                {
                    data: 'submission_status',
                    name: 'submission_status',
                    orderable: true,
                    searchable: true,
                    className: "text-center"
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                    createdCell: function (td) {
                        $(td).attr({
                            'data-step': '2',
                            'data-intro': 'Jika anda sudah mensubmit sebuah project, anda dapat mengulang dan menghapus submission project tersebut dengan mengklik tombol yang muncul disini.',
                            'data-title': 'Submission Action',
                            'data-position': 'right',
                            'data-disable-interaction': 'false'
                        });
                    }
                },
            ]
        });
    });

    $('#submissions_table_paginate > span > a').addClass('bg-gray-900 text-gray-300');
</script>
@endsection
