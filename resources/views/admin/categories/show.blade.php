<!--Trang xem chi tiết thông tin 1 danh mục-->
<!-- resources/views/categories/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Chi Tiết Danh Mục</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.categories.index') }}">Quay Lại</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Tên:</strong>
                <p>{{ $category->name }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .margin-tb {
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    .form-group p {
        margin: 0;
        font-size: 16px;
        color: #333;
    }
</style>
@endpush
