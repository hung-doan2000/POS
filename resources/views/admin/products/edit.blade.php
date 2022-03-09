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
                        <input type="text" name="name" value="{{$product->name}}" class="form-control" placeholder="Nhập tên sản phẩm">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Danh mục</label>
                        <select class="form-control" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"{{$category->id==$product->category_id?'selected':''}}>{{$category->name}}</option>
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
                                <option value={{$brand->id}}>{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nhân viên tạo</label>
                        <input type="hidden" name="created_by" value="{{$product->created_by}}" class="form-control">
                        </select>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Giá sản phẩm</label>
                        <input type="number" name="price" value="{{$product->price}}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Màu sắc</label>
                        <input type="text" name="color" value="{{$product->color}}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="hidden" name="product_code" value="{{$product->product_code}}" class=" form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="hidden" name="barcode" value="{{$product->barcode}}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description" class="form-control">{{$product->description}}</textarea>
            </div>

            <div class="form-group">
                <label for="upload">Ảnh sản phẩm</label>
                <input type="file" class="form-control" id="upload">
                <div id="image_show">
                    <a href="{{$product->photo}}" target="_blank">
                        <img src="{{$product->photo}}"width="100px">
                    </a>
                </div>
                <input type="hidden" id="photo" value="{{$product->photo}}" name="photo">
            </div>
            <div class="form-group">
                <label>Kích Hoạt</label>
                <div class="form-check">
                    <input class="form-check-input" value="1" type="radio" name="active" id="active"
                        {{ $product->active == 1 ? ' checked=""' : '' }}>
                    <label class="form-check-label" for="active">Có</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" value="0" type="radio" name="active" id="no_active"
                        {{ $product->active == 0 ? ' checked=""' : '' }}>
                    <label class="form-check-label" for="no_active">Không</label>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
        </div>
        @csrf
    </form>
@stop

