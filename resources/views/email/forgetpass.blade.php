<h3>{{__('Hello')}}, {{ $data->first_name }} {{ $data->last_name }} </h3>
<p>
    {{__('Please click on the following link or paste the link on address bar of your browser and hit - ')}}
</p>

<p>
    <a href="{{route('forgetPasswordChange',['reset_code'=>$data->reset_code])}}">{{__('Password Recovery')}}</a>
</p>

<p>
    {{__('Thanks a lot for being with us.')}} <br />
    {{allsetting()['app_title']}}
</p>

