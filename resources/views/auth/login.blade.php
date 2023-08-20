<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <style>
        .login-box {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 400px;
        padding: 40px;
        margin: 20px auto;
        transform: translate(-50%, -55%);
        background: rgba(0,0,0,.9);
        box-sizing: border-box;
        box-shadow: 0 15px 25px rgba(0,0,0,.6);
        border-radius: 10px;
        }

        .login-box p:first-child {
        margin: 0 0 30px;
        padding: 0;
        color: #fff;
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
        letter-spacing: 1px;
        }

        .login-box .user-box {
        position: relative;
        }

        .login-box .user-box input {
        width: 100%;
        padding: 10px 0;
        font-size: 16px;
        color: #fff;
        margin-bottom: 30px;
        border: none;
        border-bottom: 1px solid #fff;
        outline: none;
        background: transparent;
        }

        .login-box .user-box label {
        position: absolute;
        top: 0;
        left: 0;
        padding: 10px 0;
        font-size: 16px;
        color: #fff;
        pointer-events: none;
        transition: .5s;
        }

        .login-box .user-box input:focus ~ label,
        .login-box .user-box input:valid ~ label {
        top: -20px;
        left: 0;
        color: #fff;
        font-size: 12px;
        }

        .login-box form a {
        position: relative;
        display: inline-block;
        padding: 10px 20px;
        font-weight: bold;
        color: #fff;
        font-size: 16px;
        text-decoration: none;
        text-transform: uppercase;
        overflow: hidden;
        transition: .5s;
        margin-top: 40px;
        letter-spacing: 3px
        }

        .login-box a:hover {
        background: #fff;
        color: #272727;
        border-radius: 5px;
        }

        .login-box a span {
        position: absolute;
        display: block;
        }

        .login-box a span:nth-child(1) {
        top: 0;
        left: -100%;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #03f40f);
        animation: btn-anim1 1.5s linear infinite;
        }

        @keyframes btn-anim1 {
        0% {
            left: -100%;
        }

        50%,100% {
            left: 100%;
        }
        }

        .login-box a span:nth-child(2) {
        top: -100%;
        right: 0;
        width: 2px;
        height: 100%;
        background: linear-gradient(180deg, transparent, #03f40f);
        animation: btn-anim2 1.5s linear infinite;
        animation-delay: .375s
        }

        @keyframes btn-anim2 {
        0% {
            top: -100%;
        }

        50%,100% {
            top: 100%;
        }
        }

        .login-box a span:nth-child(3) {
        bottom: 0;
        right: -100%;
        width: 100%;
        height: 2px;
        background: linear-gradient(270deg, transparent, #03f40f);
        animation: btn-anim3 1.5s linear infinite;
        animation-delay: .75s
        }

        @keyframes btn-anim3 {
        0% {
            right: -100%;
        }

        50%,100% {
            right: 100%;
        }
        }

        .login-box a span:nth-child(4) {
        bottom: -100%;
        left: 0;
        width: 2px;
        height: 100%;
        background: linear-gradient(360deg, transparent, #03f40f);
        animation: btn-anim4 1.5s linear infinite;
        animation-delay: 1.125s
        }

        @keyframes btn-anim4 {
        0% {
            bottom: -100%;
        }

        50%,100% {
            bottom: 100%;
        }
        }

        .login-box p:last-child {
        color: #aaa;
        font-size: 14px;
        }

        .login-box a.a2 {
        color: #fff;
        text-decoration: none;
        }

        .login-box a.a2:hover {
        background: transparent;
        color: #aaa;
        border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="login-box">
            @if(session()->has('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
        
            @if(session()->has('loginError'))
              <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                {{ session('loginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            
            <h1 class="h3 mb-3 fw-normal text-center text-white">Login</h1>
        <form action="/login" method="post">
            @csrf
          <div class="user-box">
            <input name="username" type="username" id="username" autofocus required value="{{ old('username') }}">
            <label>Username</label>
          </div>
          <div class="user-box">
            <input name="password" type="password" id="password" required>
            <label for="password">Password</label>
          </div>
          <center>
            <button type="submit" class="text-white" style="border: none; background: none">
                <a>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Submit
                </a>
            </button>
          </center>
        </form>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
  </script>
</body>

</html>