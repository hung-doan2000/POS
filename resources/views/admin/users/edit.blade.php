@extends('admin.layouts.app')
@section('alert')
    @include('admin.alert')
@stop
@section('content')
    <form action="" method="post">
        <div class="card-body">
            <div class="form-group">
                <label >Tên người dùng</label>
                <input type="text" name="name" value="{{$user->name}}" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" value="{{$user->email}}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" value="{{$user->phone}}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="birthday">Ngày sinh</label>
                <input type="date" name="birthday" value="{{$user->birthday}}" class="form-control">
            </div>            
            <div class="form-group">
                <label for="upload">Ảnh đại diện</label>
                <input type="file" class="form-control" id="upload">
                <div id="image_show">
                    <a href="{{$user->photo}}" target="_blank">
                        <img src="{{$user->photo}}"width="100px">
                    </a>
                </div>
                <input type="hidden" id="photo" value="{{$user->photo}}" name="photo">
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </div>
        @csrf
    </form>
@stop


