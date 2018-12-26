
<!-- login area start -->
<div class="login-area">
    <div class="container">
        <div class="login-box ptb--100">
{{ Form::open(['route' => 'userSave']) }}
{{csrf_field()}}
<div class="login-form-head">
    <h4>Sign up</h4>
    <p>Hello there, Sign up and Join with Us</p>
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
        <label for="exampleInputName1">First Name</label>
        <input type="text" id="exampleInputName1" name="first_name">
        <span class="text-danger" id='nameError' ></span>
        <i class="fa fa-user"></i>
    </div>
    <div class="form-gp">
        <label for="exampleInputName1">Last Name</label>
        <input type="text" id="exampleInputName1" name="last_name">
        <span class="text-danger" id='nameError' ></span>
        <i class="fa fa-user"></i>
    </div>
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
    <div class="form-gp">
        <label for="exampleInputPassword2">Confirm Password</label>
        <input type="password" id="exampleInputPassword2" name="password_confirmation">
        <span class="text-danger" id='conPassError'></span>
        <i class="fa fa-lock"></i>
    </div>
    <div class="submit-btn-area">
        <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
    </div>
    <div class="form-footer text-center mt-5">
        <p class="text-muted">Already have an account? <a href="{{route('login')}}">Sign in</a></p>
    </div>
</div>
{{ Form::close() }}
</div>
</div>
</div>
<!-- login area end -->