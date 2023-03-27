<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-3m7MuC9MgQEr6JlyUDokyb/AH7R1w1jgx5n1N09+PpKLgN+nKd9Vqn25MvCrk5Bh" crossorigin="anonymous">
    </script>
</head>
<body>
    @include('layout.navBar')
    @if (session('success'))
        <div class="alert alert-success text- fw-bold" id="success-alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="container d-flex justify-content-center align-items-center" style="height: 90vh; ">
        <h1 class="text-center">Dashboard</h1>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var successAlert = document.getElementById('success-alert');
                successAlert.parentNode.removeChild(successAlert);
            }, 3000);
        });
    </script>
</body>

</html>
