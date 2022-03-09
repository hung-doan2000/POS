@extends('admin.layouts.app')
@section('alert')
    @include('admin.alert')
@stop
@section('content')
    <table id="example2" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td>ID</td>
                <td>Category</td>
                <td>FB_cate_id</td>
                <td>GG_cate_id</td>
                <td>&nbsp;</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$store->id}}</td>
                <td>{{$store->name}}</td>
                <td>{{$store->address}}</td>
                <td>{{$store->phone}}</td>

                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a class="btn btn-primary" href="{{ route('admin.stores.edit',$store->id) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="delete btn btn-danger" data="{{$store->id}}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        
            <tr>
                <td colspan="5"><p>No stores</p></td>
            </tr>
        
        </tbody>
    </table>
@stop
