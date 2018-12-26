
<!-- login area start -->
<div class="login-area">
    <div class="container">
        <div class="login-box ptb--100">
{{ Form::open(['route' => 'forgetPasswordProcess']) }}
{{csrf_field()}}
<div class="login-form-head">
    <h4>Forgot password</h4>
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
    <a href= {{ route('login') }}>
        <button id="form_submit" type="button">Back <i class="ti-arrow-right"></i></button>
    </a>
    
</div>
{{ Form::close() }}
</div>
</div>
</div>
<!-- login area end -->