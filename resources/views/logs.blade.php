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
    {{-- google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
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
    <div class="container my-4">
        @if (session('message'))
            <div id="myDiv">
                <div class="d-flex w-100 alert alert-success justify-content-between">
                    <div> {{ session('message') }}</div>
                    <span class="iconify" style="cursor: pointer" data-icon="bi-x-lg" onclick="toggleDiv()"></span>
                </div>
            </div>
        @endif
        {{-- <a class="mb-3 btn btn-success fw-bold w-100" href="/upload">add logs</a> --}}
        <table id="data" class="pt-3 table table-hover table-striped table-borderless">
            <thead class="bg-primary">
                <tr class="text-center text-white">
                    <th>ID</th>
                    <th>Remote Host</th>
                    {{-- <th>Remote Log</th>
                    <th>Remote User</th> --}}
                    <th>Time Stamp</th>
                    <th>HTTP Method</th>
                    {{--                     <th>URL Path</th> --}}
                    <th>Protocol Version</th>
                    <th>HTTP Status Code</th>
                    <th>Bytes Sent</th>
                    {{--                     <th>Referer URL</th> --}}
                    <th>User Agent</th>
                    {{-- <th>Forwarded Info</th> --}}
                </tr>
            </thead>
    
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var successAlert = document.getElementById('myDiv');
                successAlert.parentNode.removeChild(successAlert);
            }, 5000);
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
                    // {
                    //     data: 'remote_log',
                    //     name: 'remote_log',
                    //     className: 'text-center'
                    // },
                    // {
                    //     data: 'remote_user',
                    //     name: 'remote_user',
                    //     className: 'text-center'
                    // },
                    {
                        data: 'time_stamp',
                        name: 'time_stamp',
                        className: 'text-center'
                    },
                    {
                        data: 'http_method',
                        name: 'http_method',
                        className: 'text-center'
                    },
                    // {data: 'url_path',  name: 'url_path' },
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
                    // {data: 'referer_url',  name: 'referer_url' },
                    {
                        "data": "user_agent",
                        "name": "user_agent",
                        className: 'text-center',
                        "render": function(data, type, row) {
                            var parts = data.split('/');
                            return parts[0]; // return the first part of the string
                        }
                    },
                    // {
                    //     data: 'forwarded_info',
                    //     name: 'forwarded_info'
                    // }

                ]
            });
        });
    </script>
</body>

</html>
