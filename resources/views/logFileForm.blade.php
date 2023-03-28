<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>upload log file</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Josefin Sans', sans-serif;
            transition: background-color 0.5s ease-out;
        }

        span {
            font-weight: bold;
            color: red;
            font-size: 14px;
        }
        .box {
            transition: background-color 0.5s ease-out;
        }
    </style>
</head>

<body>
    <div class="">
        @include('layout.navBar')
        <div class="container">
            <div class="container">
                <div class="d-flex justify-content-center align-items-center" style="height: 90vh;">
                    <div class="box p-5" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; border-radius: 10px">
                        @if (session('message'))
                            <div class="alert alert-danger my-3 fw-bold" id="message">{{ session('message') }}</div>
                        @endif
                        <h4 class="mb-4 fw-bold text-primary">Upload Log File</h4>
                        <form id="upload-form" method="POST" action="{{ route('file-parse') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input class="form-control mb-2" type="file" name="file">
                            @error('file')
                                <span>{{ $message }}</span>
                            @enderror
                            <button class="btn btn-primary mt-4 w-100" type="submit">upload File</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var successAlert = document.getElementById('message');
                successAlert.parentNode.removeChild(successAlert);
            }, 5000);
        });
        const box = document.querySelector('.box');
        const form = document.getElementById('upload-form');
        form.addEventListener('submit', () => {
            const button = form.querySelector('button[type="submit"]');
            button.innerText = 'uploading.....';
            document.body.style.backgroundColor = '#f1f1f1';
            box.style.backgroundColor = '#EEF1FF';
        });
        form.addEventListener('load', () => {
            document.body.style.backgroundColor = '';
            box.style.backgroundColor = '';
        });
    </script>
</body>

</html>
