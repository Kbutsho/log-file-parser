<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Logs</title>
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- DataTable --}}
    <link href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.13.4/datatables.min.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.13.4/datatables.min.js"></script>
    {{-- iconify --}}
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    {{-- font awesome --}}
    <script src="https://kit.fontawesome.com/5301593776.js" crossorigin="anonymous"></script>
    {{-- google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">


    {{-- sweet alart  --}}
    <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
    <style>
        body {
            font-family: 'Josefin Sans', sans-serif;
        }

        th,
        td {
            font-size: 16px;
        }
    </style>

<body>
    @include('layout.navBar')
    <div class="container my-3">
        @if (session('message'))
            <div id="myDiv">
                <div class="d-flex w-100 alert alert-success justify-content-between">
                    <div class="fw-bold"> {{ session('message') }}</div>
                    <span class="iconify" style="cursor: pointer" data-icon="bi-x-lg" onclick="toggleDiv()"></span>
                </div>
            </div>
        @endif
        <button onclick="showSweetAlert()">Click me!</button>

        <table id="data" class="pt-3 table table-hover table-striped table-borderless">
            <thead class="bg-primary">
                <tr class="text-center text-white">
                    <th>ID</th>
                    <th>Remote Host</th>
                    <th>Time Stamp</th>
                    <th>HTTP Method</th>
                    <th>Protocol Version</th>
                    <th>HTTP Status Code</th>
                    <th>Bytes Sent</th>
                    <th>User Agent</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <script>
        function showSweetAlert() {
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    } else {
                        swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
        }
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var successAlert = document.getElementById('myDiv');
                successAlert.parentNode.removeChild(successAlert);
            }, 3000);
        });
        const toggleDiv = () => {
            let myDiv = document.getElementById("myDiv");
            myDiv.style.transition = "all 0.3s";
            myDiv.style.opacity = "0";
            myDiv.style.pointerEvents = "none";
            setTimeout(() => {
                myDiv.remove();
            }, 300)
        }
        $(document).ready(function() {
            $('#data').DataTable({
                ajax: '{{ route('logs') }}',
                processing: true,
                serverSide: true,
                language: {
                    "processing": "<div class='my-5' style='height: 25vh'></div>"
                },
                lengthMenu: [10, 25, 50, 100, 250, 500, 1000],
                columns: [{
                        data: 'id',
                        name: 'id',
                        className: 'text-center'
                    },
                    {
                        data: 'remote_host',
                        name: 'remote_host',
                        className: 'text-center'
                    },
                    {
                        data: 'time_stamp',
                        name: 'time_stamp',
                        className: 'text-center',
                        render: function(data) {
                            let date = new Date(data);
                            let year = date.getFullYear();
                            let month = ('0' + (date.getMonth() + 1)).slice(-2);
                            let day = ('0' + date.getDate()).slice(-2);
                            return year + '-' + month + '-' + day;
                        }
                    },
                    {
                        data: 'http_method',
                        name: 'http_method',
                        className: 'text-center'
                    },
                    {
                        data: 'protocol_version',
                        name: 'protocol_version',
                        className: 'text-center'
                    },
                    {
                        data: 'http_status_code',
                        name: 'http_status_code',
                        className: 'text-center'
                    },
                    {
                        data: 'bytes_sent',
                        name: 'bytes_sent',
                        className: 'text-center'
                    },
                    {
                        data: "user_agent",
                        name: "user_agent",
                        className: 'text-center',
                        render: function(data, type, row) {
                            var parts = data.split('/');
                            return parts[0];
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'text-center'
                    }
                ]
            });
        });
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this log!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = url;
                    }
                });
        });
    </script>
</body>

</html>
