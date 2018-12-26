
<!-- login area start -->
<div class="login-area">
    <div class="container">
        <div class="login-box ptb--100">
{{ Form::open(['route' => 'loginProcess']) }}
{{csrf_field()}}
<div class="login-form-head">
    <h4>Sign in</h4>
</div>
<!-- start: status -->
<div class="error-success-message">
    @if(Session::has('success'))
        <div class="alert-float alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{Session::get('success')}}
        </div>
    @endif

    @if(Session::has('dismiss'))
        <div class="alert-float alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {!! Session::get('dismiss') !!}
        </div>
    @endif

    @if(count($errors) > 0)
        <div class="alert-float alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <ul class="list-unstyled">
                @foreach($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<!-- end: status -->

<div class="login-form-body">
    <div class="form-gp">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" id="exampleInputEmail1" name="email">
        <span class="text-danger" id='emailError'></span>
        <i class="fa fa-envelope"></i>
    </div>
    <div class="form-gp">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" id="exampleInputPassword1" name="password">
        <span class="text-danger " id='passError'></span>
        <i class="fa fa-lock"></i>
    </div>
    <div class="submit-btn-area">
        <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
    </div>
    <div class="form-footer text-center mt-5">
        <p class="text-muted">Don't have account? <a href="{{route('userSignUp')}}">Sign Up</a></p>
    </div>
    <div class="form-footer text-center mt-5">
        <p class="text-muted"> <a href="{{route('forgetPassword')}}">Forgot Password</a></p>
    </div>
</div>
{{ Form::close() }}
</div>
</div>
</div>
<!-- login area end -->