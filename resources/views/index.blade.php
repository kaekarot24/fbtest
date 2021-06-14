<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login/Register</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('public/assets/images/logo/favicon.png')}}">

    <!-- page css -->

    <!-- Core css -->
    <link href="{{asset('public/assets/css/app.min.css')}}" rel="stylesheet">

</head>

<body>
    <div class="app">
        <div class="container-fluid p-0 h-100">
            <div class="row no-gutters h-100 full-height">
                <div class="col-lg-4 d-none d-lg-flex bg" style="background-image:url('assets/images/others/login-1.jpg')">
                    <div class="d-flex h-100 p-h-40 p-v-15 flex-column justify-content-between">
                        <div>
                           <h2>Login/Registration</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 bg-white">
                    <div class="container h-100">
                        <div class="row no-gutters h-100 align-items-center">
                            <div class="col-md-8 col-lg-7 col-xl-6 mx-auto">
                                <h2>Sign In</h2>
                                <p class="m-b-30">Enter your credential to get access</p>
                                <form method="post" action="{{route('userlogin')}}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="userName">Username:</label>
                                        <div class="input-affix">
                                            <i class="prefix-icon anticon anticon-user"></i>
                                            <input type="text" name="username" class="form-control" id="userName" placeholder="Username">
                                            @error('username')
                                            <div class="alert-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        
                                        <div class="input-affix m-b-10">
                                            <i class="prefix-icon anticon anticon-lock"></i>
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                            @error('password')
                                            <div class="alert-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="font-size-13 text-muted">
                                                <a class="small btn btn-primary float-left" href="{{route('login')}}"> Login with Facebook</a>
                                            </span>
                                            <button type="submit" class="btn btn-primary">Sign In</button>
                                        </div>
                                        @if(Session::has('failed'))
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            {{Session::get('failed')}}
                                        </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Core Vendors JS -->
    <script src="{{asset('public/assets/js/vendors.min.js')}}"></script>

    <!-- page js -->

    <!-- Core JS -->
    <script src="{{asset('public/assets/js/app.min.js')}}"></script>

</body>

</html>