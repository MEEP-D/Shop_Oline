<!--Trang thêm danh mục (Create Categories)-->
<!-- resources/views/categories/create.blade.php -->
<!-- resources/views/categories/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Thêm Danh Mục Mới</h2>
            </div>
            
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.categories.index') }}">Quay Lại</a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="name"><strong>Tên:</strong></label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Tên danh mục" value="{{ old('name') }}">
                    @error('name')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Gửi</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .margin-tb {
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .form-group label {
        font-weight: bold;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
</style>
@endpush
