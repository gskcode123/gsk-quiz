

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{__('Login')}}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.css')}}">
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="{{asset('assets/vendors/swiper-master/css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/iconfont/flaticon.css')}}">
    <!-- font family -->
    <link rel="stylesheet" href="{{asset('assets/css/proxima-nova.css')}}">
    <!-- Site Style -->
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <!-- Modernizr Js -->
    <script src="{{asset('assets/vendors/modernizr-js/modernizr.js')}}"></script>
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
</head>

<body class="user-body">


<!-- Start user area -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card text-center">
                @include('layout.message')
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 offset-lg-4">
                            <div class="logo">
                                <a href="#">
                                    <img src="{{asset('assets/images/logo2.png')}}" alt="" class="img-fluid">
                                </a>
                            </div>
                            <div class="qz-user-title">
                                <h1>{{__('Sign in')}}</h1>
                            </div>
{{--                            <h5>{{__('Hello there, Sign in and start managing your Admin Template')}}</h5>--}}

                            {{ Form::open(['route' => 'loginProcess']) }}
                            {{csrf_field()}}
                            <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Enter email">
                                    <div class="qz-input-icon">
                                        <span class="flaticon-mail"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                    <div class="qz-input-icon">
                                        <span class="flaticon-lock"></span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{__('Sign in')}}</button>
                            {{ Form::close() }}

                            <div class="qz-user-footer">
                                <h4>{{__('Don\'\t have account ?')}} <a href="{{route('userSignUp')}}">{{__('Sign Up')}}</a> </h4>
                                <h4><a href="{{route('forgetPassword')}}">{{__('Forgot Password')}}</a> </h4>
                                {{--<p>--}}
                                    {{--Or sign in with--}}
                                    {{--<a href="#" class="qz-fb"><i class="fa fa-facebook"></i></a>--}}
                                    {{--<a href="#" class="qz-ing"><i class="fa fa-instagram"></i></a>--}}
                                    {{--<a href="#" class="qz-gp"><i class="fa fa-google-plus"></i></a>--}}
                                {{--</p>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End user area -->



<!-- Jquery plugins -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<!-- Owl Carousel -->
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<!-- Counterup -->
<script src="{{asset('assets/js/waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/counterup.min.js')}}"></script>
<!-- Slicknav -->
<script src="{{asset('assets/js/metisMenu.min.js')}}"></script>
<!-- magnific popup -->
<script src="{{asset('assets/js/magnific-popup.min.js')}}"></script>
<!-- Swiper Slider -->
<script src="{{asset('assets/vendors/swiper-master/js/swiper.min.js')}}"></script>
<!-- main js -->
<script src="{{asset('assets/js/main.js')}}"></script>
</body>

</html>
