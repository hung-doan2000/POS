@extends('main')
@section('content')

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">RSS</h1>
                        <ol class="breadcrumb">
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li class="active">rss</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="user-dashboard page-wrapper">
        <div class="container">
                    <div class="dashboard-wrapper user-dashboard">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Google RSS</th>
                                    <th>Facebook RSS</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($feedscategories as $category)
                                <tr>
                                    <td>{{$category->name}}</td>
                                    @if($category->gg_cate_id)
                                        <td><a href="{{route('ggFeed',$category->id)}}" class="btn btn-default">View</a></td>
                                    @endif
                                    @if($category->fb_cate_id)
                                    <td><a href="{{route('fbfeed',$category->id)}}" class="btn btn-default">View</a></td>
                                    @endif
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    </section>
@stop

