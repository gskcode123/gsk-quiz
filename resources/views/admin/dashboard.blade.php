@extends('layout.master')
@section('title','Admin | Dashboard')
{{--@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection--}}

@section('left-sidebar')
    @include('layout.include.sidebar')
@endsection

@section('header')
    @include('layout.include.header')
@endsection

@section('main-body')
    <!-- Start page title -->
    <div class="qz-page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>Dashboard</h2>
                        <span class="sidebarToggler">
                            <i class="fa fa-bars d-lg-none d-block"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End page title -->

    <!-- Start content area  -->
    <div class="qz-content-area">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-6 text-center">
                                    <div class="qz-status-bar qz-status-bar1">
                                        <h4 class="qz-blance">120</h4>
                                        <h5 class="qz-total-qustions">Total Qustions</h5>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <div class="qz-status-bar qz-status-bar2">
                                        <h4 class="qz-blance">14</h4>
                                        <h5 class="qz-total-qustions">Total Categories</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="qz-sec-title">
                                        <h5>Recently added category</h5>
                                    </div>
                                    <div class="table-responsive category-table">
                                        <table class="table category-table text-center rounded">
                                            <thead>
                                            <tr>
                                                <th>SL.</th>
                                                <th>Title</th>
                                                <th>Question</th>
                                                <th>Added On</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1.</td>
                                                <td>Politics</td>
                                                <td>40</td>
                                                <td>1 day ago</td>
                                                <td><span class="text-success">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td>2.</td>
                                                <td>Mythology</td>
                                                <td>50</td>
                                                <td>1 month ago</td>
                                                <td><span class="text-success">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td>3.</td>
                                                <td>Politics</td>
                                                <td>40</td>
                                                <td>1 day ago</td>
                                                <td><span class="text-danger">Inactive</span></td>
                                            </tr>
                                            <tr>
                                                <td>4.</td>
                                                <td>Mythology</td>
                                                <td>50</td>
                                                <td>1 month ago</td>
                                                <td><span class="text-success">Active</span></td>
                                            </tr>
                                            <tr class="qz-table-footer">
                                                <td colspan="2"><button class="btn btn-primary px-3">Add New</button></td>
                                                <td></td>
                                                <td colspan="2"><h5><a href="#">see all categories</a></h5></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="qz-laderboard-area">
                                <div class="qz-laderboard-title">
                                    <h4>Laderboard</h4>
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>People</th>
                                        <th>Score</th>
                                        <th>Rank</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="people">
                                                <img src="images/avater.jpg" alt="" class="img-fluid mr-2">
                                                charles Dickens
                                            </div>
                                        </td>
                                        <td>4320</td>
                                        <td class="text-center"><span class="text-success">1</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="people">
                                                <img src="images/avater.jpg" alt="" class="img-fluid mr-2">
                                                charles Dickens
                                            </div>
                                        </td>
                                        <td>4320</td>
                                        <td class="text-center"><span class="text-warning">2</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="people">
                                                <img src="images/avater.jpg" alt="" class="img-fluid mr-2">
                                                charles Dickens
                                            </div>
                                        </td>
                                        <td>4320</td>
                                        <td class="text-center"><span class="text-info">3</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="people">
                                                <img src="images/avater.jpg" alt="" class="img-fluid mr-2">
                                                charles Dickens
                                            </div>
                                        </td>
                                        <td>4320</td>
                                        <td class="text-center"><span>4</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="people">
                                                <img src="images/avater.jpg" alt="" class="img-fluid mr-2">
                                                charles Dickens
                                            </div>
                                        </td>
                                        <td>4320</td>
                                        <td class="text-center"><span>5</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="qz-laderboard-footer">
                                    <a href="#">see more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End content area  -->
@endsection

@section('script')
@endsection