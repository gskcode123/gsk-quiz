<!-- Start sidebar -->
<div class="qz-sidebar">

    <div class="qz-logo">
        <a href="{{ route('adminDashboardView') }}">
            <img src="{{asset('assets/images/logo.png')}}" alt="" class="img-fluid">
        </a>
    </div>

    <nav>

        <ul id="metismenu">
            <li class="mm-active"><a href="{{ route('adminDashboardView') }}"><span class="flaticon-dashboard"></span>{{__('Dashboard')}} </a></li>
            <li><a href="{{ route('qsCategoryList') }}"><span class="flaticon-menu"></span>{{__('Category')}} </a></li>
            <li><a href="{{ route('questionList') }}"><span class="flaticon-info"></span>{{__('Question')}} </a></li>
            <li><a href="{{ route('leaderBoard') }}"><span class="flaticon-statistics"></span>{{__('Leaderboard')}} </a></li>
            <li><a href="{{ route('userProfile') }}"><span class="flaticon-user"></span>{{__('Profile')}} </a></li>
            <li><a href="{{ route('generalSetting') }}"><span class="flaticon-settings-work-tool"></span>{{__('Settings')}} </a></li>
        </ul>

    </nav>

</div>
<!-- End sidebar -->