<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/5301593776.js" crossorigin="anonymous"></script>
    <style>
        span {
            font-size: 12px;
            font-weight: bold;
        }

        #box {
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            border-radius: 10px;
            transition: box-shadow .3s ease-in-out;
        }

        #box.active {
            box-shadow: 0 0 10px 5px red;
        }

        #box:hover {
            box-shadow: rgba(0, 0, 0, 0.7) 0px 5px 15px;
            border-radius: 10px;
            cursor: pointer;
        }

        .position-relative {
            position: relative;
        }

        .position-absolute {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="div d-flex justify-content-center align-items-center" style="min-height: 100vh">
            <div class="p-4 box" id="box">
                <h3 class="my-4">Login</h3>
                @if (session('success'))
                    <div class="alert alert-danger my-2 fw-bold" id="message"> {{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mt-3 mb-2">
                        <label class="mb-2">Your Email</label>
                        <input style="width: 250px" class="form-control" type="text" placeholder="Email"
                            name="email" value="{{ old('email') }}">
                        @error('email')
                            <span style="color: #ff0000">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-3 mb-2">
                        <label class="mb-2">Your Password</label>
                        <div class="position-relative">
                            <input style="width: 250px" class="form-control" id="password" type="password"
                                placeholder="Password" name="password" value="{{ old('password') }}">
                            <div class="position-absolute top-50 end-10 translate-middle-y">
                                <i id="password-toggle" style="cursor: pointer" class="fas fa-eye"></i>
                            </div>
                        </div>
                        @error('password')
                            <span style="color: #ff0000">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" id="submit" class="w-100 btn btn-primary mt-3 mb-2">Login</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var successAlert = document.getElementById('message');
                successAlert.parentNode.removeChild(successAlert);
            }, 3000);
        });
        const passwordToggle = document.getElementById("password-toggle");
        const passwordInput = document.getElementById("password");
        passwordToggle.addEventListener("click", function() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggle.classList.add("rotate");
                passwordToggle.classList.remove("fa-eye");
                passwordToggle.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                passwordToggle.classList.remove("rotate");
                passwordToggle.classList.remove("fa-eye-slash");
                passwordToggle.classList.add("fa-eye");
            }
        });
        const box = document.getElementById("box");
        const myButton = document.getElementById("submit");
        myButton.addEventListener("click", function() {
            box.classList.add("active");
        });
    </script>
</body>

</html>
