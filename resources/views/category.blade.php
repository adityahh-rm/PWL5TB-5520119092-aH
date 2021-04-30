@extends('adminlte::page')

@section('title', 'Category Managament')

@section('content_header')
    <h1>Category Managament</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin ---- Category Managament') }}</div>
                <div class="card-body">
                    <button class="btn btn-primary float-left" data-toggle="modal" data-target="#addProductModal">
                        <i class="fa fa-plus"></i>
                        Add Category
                    </button>
                    <table id="table-data" class="table table-borderer">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <!-- Button - Modifikasi Data -->
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" id="btn-edit-category" class="btn btn-success" data-toggle="modal" data-target="#editCategoryModal" data-id="{{ $category->id }}">
                                                Edit
                                            </button>
                                            <button type="button" id="btn-delete-category" class="btn btn-danger" data-toggle="modal" data-target="#deleteCategoryModal" data-id="{{ $category->id }}" 
                                                data-name="{{ $category->name }}">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop