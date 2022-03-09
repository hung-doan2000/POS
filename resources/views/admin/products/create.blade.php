@extends('admin.layouts.app')
@section('alert')
    @include('admin.alert')
@stop
@section('content')
    <form action="" method="post">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên Sản Phẩm</label>
                        <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="Nhập tên sản phẩm">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Danh mục</label>
                        <select class="form-control" name="category_id">
                            @foreach($categories as $category)
                                <option value={{$category->id}}>{{$category->name}}</option>
                            @endforeach
                                <option value="0">Khác</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label >Tên nhãn hiệu</label>
                        <select class="form-control" name="brand_id">                           
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                            @endforeach
                            <option value="0">Khác</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nhân viên tạo</label>
                        <input type="hidden" name="created_by" value="{{$users->id}}" class="form-control">
                        <input value="{{$users->name}}" class="form-control" disabled>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Giá sản phẩm</label>
                        <input type="number" name="price" value="{{old('price')}}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Màu sắc</label>
                        <input type="text" name="color" value="{{old('color')}}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="hidden" name="product_code" value="{{$product_code}}" class=" form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="hidden" name="barcode" value="{{$barcode}}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description" class="form-control">{{old('description')}}</textarea>
            </div>

            <div class="form-group">
                <label for="upload">Ảnh sản phẩm</label>
                <input type="file" class="form-control" id="upload">
                <div id="image_show"></div>
                <input type="hidden" id="photo" name="photo">
            </div>
            <div class="form-group">
                <label>Kích Hoạt</label>
                <div class="form-check">
                    <input class="form-check-input" value="1" type="radio" name="active" id="active" checked="">
                    <label class="form-check-label" for="active">Có</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" value="0" type="radio" name="active" id="no_active" >
                    <label class="form-check-label" for="no_active">Không</label>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        </div>
        @csrf
    </form>
@stop

