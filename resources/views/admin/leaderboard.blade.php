@extends('layout.master')
@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection

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
                        <h2>{{__('Leader Board')}}</h2>
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
                        <div class="col-12">
                            <!-- <div class="table-responsive"> -->
                            <table id="category-table" class="table category-table table-bordered  text-center mb-0">
                                <thead>
                                <tr>
                                    <th>SL.</th>
                                    <th>People</th>
                                    <th>Score</th>
                                    <th>Rank</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td align="left">
                                        <div class="people">
                                            <img src="images/avater.jpg" alt="" class="img-fluid mr-2">
                                            charles Dickens
                                        </div>
                                    </td>
                                    <td>4000</td>
                                    <td><span class="text-success">1</span></td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td align="left">
                                        <div class="people">
                                            <img src="images/avater.jpg" alt="" class="img-fluid mr-2">
                                            charles Dickens
                                        </div>
                                    </td>
                                    <td>4000</td>
                                    <td><span class="text-warning">2</span></td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td align="left">
                                        <div class="people">
                                            <img src="images/avater.jpg" alt="" class="img-fluid mr-2">
                                            charles Dickens
                                        </div>
                                    </td>
                                    <td>4000</td>
                                    <td><span class="text-info">3</span></td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td align="left">
                                        <div class="people">
                                            <img src="images/avater.jpg" alt="" class="img-fluid mr-2">
                                            charles Dickens
                                        </div>
                                    </td>
                                    <td>4000</td>
                                    <td><span class="text-dark">4</span></td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td align="left">
                                        <div class="people">
                                            <img src="images/avater.jpg" alt="" class="img-fluid mr-2">
                                            charles Dickens
                                        </div>
                                    </td>
                                    <td>5000</td>
                                    <td><span class="text-dark">5</span></td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td align="left">
                                        <div class="people">
                                            <img src="images/avater.jpg" alt="" class="img-fluid mr-2">
                                            charles Dickens
                                        </div>
                                    </td>
                                    <td>4000</td>
                                    <td><span class="text-dark">6</span></td>
                                </tr>
                                <tr>
                                    <td>7.</td>
                                    <td align="left">
                                        <div class="people">
                                            <img src="images/avater.jpg" alt="" class="img-fluid mr-2">
                                            charles Dickens
                                        </div>
                                    </td>
                                    <td>7000</td>
                                    <td><span class="text-dark">7</span></td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- </div> -->
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