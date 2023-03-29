<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Josefin Sans', sans-serif;
        }

        th,
        td {
            font-size: 14px;
        }
    </style>
</head>

<body>
    @include('layout.navBar')
    <div class="container d-flex justify-content-center align-items-center" style="height: 90vh">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive p-3 shadow">
              <table class="table">
                <tbody>
                  <tr>
                    <th>Log ID</th>
                    <td>{{ $log->id }}</td>
                  </tr>
                  <tr>
                    <th>Remote host</th>
                    <td>{{ $log->remote_host }}</td>
                  </tr>
                  <tr>
                    <th>Remote Log</th>
                    <td>{{ $log->remote_log }}</td>
                  </tr>
                  <tr>
                    <th>Remote user</th>
                    <td>{{ $log->remote_user }}</td>
                  </tr>
                  <tr>
                    <th>Time stamp</th>
                    <td>{{ $log->time_stamp }}</td>
                  </tr>
                  <tr>
                    <th>Http method</th>
                    <td>{{ $log->http_method }}</td>
                  </tr>
                  <tr>
                    <th>Url path</th>
                    <td>{{ $log->url_path }}</td>
                  </tr>
                  <tr>
                    <th>Protocol version</th>
                    <td>{{ $log->protocol_version }}</td>
                  </tr>
                  <tr>
                    <th>Protocol version</th>
                    <td>{{ $log->protocol_version }}</td>
                  </tr>
                  <tr>
                    <th>Http code</th>
                    <td>{{ $log->http_status_code }}</td>
                  </tr>
                  <tr>
                    <th>Bytes sent</th>
                    <td>{{ $log->bytes_sent }}</td>
                  </tr>
                  <tr>
                    <th>Referal url</th>
                    <td>{{ $log->referer_url }}</td>
                  </tr>
                  <tr>
                    <th>User agent </th>
                    <td>{{ $log->user_agent }}</td>
                  </tr>
                  <tr>
                    <th>Forwared info</th>
                    <td>{{ $log->forwarded_info }}</td>
                  </tr>
                </tbody>
              </table>
              <a href="{{ route('logs') }}" class="btn btn-primary btn-sm px-3">Back</a>
            </div> 
          </div>
        </div>
      </div>
      
</body>

</html>
