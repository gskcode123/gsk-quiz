<!-- Start sidebar -->
<div class="qz-sidebar">

    <div class="qz-logo">
        <a href="{{ route('adminDashboardView') }}">
            <img src="{{asset('assets/images/logo.png')}}" alt="" class="img-fluid">
        </a>
    </div>

    <nav>

        <ul id="metismenu">
            <li class="mm-active"><a href="{{ route('adminDashboardView') }}"><span class="flaticon-dashboard"></span> Dashboard</a></li>
            <li><a href="{{ route('qsCategoryList') }}"><span class="flaticon-menu"></span> Category</a></li>
            <li><a href="{{ route('questionList') }}"><span class="flaticon-info"></span> Question</a></li>
            <li><a href="{{ route('leaderBoard') }}"><span class="flaticon-statistics"></span> Leaderboard</a></li>
            <li><a href="#"><span class="flaticon-user"></span> Profile</a></li>
            <li><a href="#"><span class="flaticon-settings-work-tool"></span> Settings</a></li>
        </ul>

    </nav>

</div>
<!-- End sidebar -->