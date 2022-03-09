@extends('admin.layouts.app')
@section('alert')
    @include('admin.alert')
@stop
@section('content')
    <table>
        <thead>
            <tr style="font-weight:600">
                <td>STT</td>
                <td>Tên Nhà Kho</td>
            </tr>
        </thead>
        <tbody>
        @forelse($stores as $store)
            <tr>
                <td>{{$store->id}}</td>
                <td>Kho {{$store->name}}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a type="button" class="btn btn-primary" href="{{ route('admin.warehouses.edit',$store->id) }}">
                            Chi tiết
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5"><p>No warehouse</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
@stop
