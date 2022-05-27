<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Yinka Enoch Adedokun">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <style>
        body {
            display: table;
            width: 98vw;
            height: 100vh;
            overflow-x: auto;
        }
        .tbcell {
            display: table-cell;
            vertical-align: middle
        }
        .main-content {
            width: 50%;
            border-radius: 20px;
            box-shadow: 0px 0px 20px #1C75BC;
            margin: 5em auto;
            display: flex;
        }
        .company__info {
            background-color: whitesmoke;
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
        }
        .fa-dollar-sign {
            font-size: 3em;
        }
        #remember_me {
            margin-top: 6px;
            margin-right: 8px;
            font-weight: 600;
        }
        .login_form {
            background-color: #fff;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            /*border-top: 1px solid #D94B09;*/
            /*border-right: 1px solid #D94B09;*/
        }
        form {
            padding: 0 2em;
        }
        .form__input {
            width: 100%;
            border: 0px solid transparent;
            border-radius: 30px;
            border-bottom: 1px solid #1C75BC;
            padding: .5em .5em .5em;
            padding-left: 10px;
            padding-left: 2em;
            outline: none;
            margin: 1.5em auto;
            transition: all .5s ease;
        }
        .form__input:focus {
            border-bottom-color: #1C75BC;
            box-shadow: 0 0 5px rgba(30 64 128 / 41%);
            border-radius: 4px;
        }
        .signin-btn {
            transition: all .5s ease;
            width: 70%;
            border-radius: 30px;
            color: white;
            font-weight: 600;
            background-color: #1C75BC;
            border: 1px solid #1C75BC;
            margin-top: 1.5em;
            margin-bottom: 1em;
        }
        .signin-btn:hover,
        .signin-btn:focus {
            background-color: #e8f0fe;
            border-bottom: 1px solid #1C75BC;
            color: #1C75BC;
            /*border: 2px solid #1E4080;*/
        }
        .click {
            color: #F97B40;
        }
        .logo {
            width: 100%;
        }
        @media (max-width: 640px) {
            .main-content {
                width: 85%;
            }
        }
        @media (min-width: 642px) and (max-width:800px) {
            .main-content {
                width: 75%;
            }
        }
        @media(max-width:768px) {
            .company__info {
                border-top-left-radius: 20px;
                border-top-right-radius: 20px;
                border-bottom-left-radius: 0px;
            }
            .login_form {
                border-top-right-radius: 0px;
                border-bottom-left-radius: 20px;
                border-bottom-right-radius: 20px;
            }
            .logo {
                width: 50%;
            }
            .form__input{
                padding-left: 10px;
            }
        }
        @media(max-width:375px){
            .reset-text{
                font-size: 30px;
            }
        }
    </style>
</head>

<body>
<!-- Main Content -->
<div class="tbcell">
    <div class="container">
        <div>
{{--            <img src="{{asset('public/logo.png')}}" alt="" class="logo py-4">--}}
        </div>
        <div class="row text-center">
            <div class="main-content login_form">
                <div class="row">
                    <div class="col-12">
                        <h2 class="pt-4">Sign in to your account</h2>
                    </div>
                    <div class="col-12">
                        <form class="form-group" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="row {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" name="email" value="{{ old('email') }}" id="username" class="form__input" placeholder="Email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row {{ $errors->has('password') ? ' has-error' : '' }}">
                                <input type="password" name="password" id="password" class="form__input" placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @if($response = session('response'))
                                <div class="alert @if($response['status']) alert-success @else alert-danger @endif alert-dismissible fade show" role="alert">
                                    {{ $response['message'] }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="row justify-content-center">
                                <input type="checkbox" name="remember" id="remember_me" class="" value="1">
                                <label for="remember_me">Remember Me!</label>
                            </div>
                            <div class="row">
                                <input type="submit" value="Submit" class="btn signin-btn mx-auto">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
