@extends('adminlte::page')

@section('title', 'Brand Managament')

@section('content_header')
    <h1>Brand Managament</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin ---- Brand Managament') }}</div>
                <div class="card-body">
                    <button class="btn btn-primary float-left" data-toggle="modal" data-target="#addProductModal">
                        <i class="fa fa-plus"></i>
                        Add Brand
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
                            @foreach($brands as $brand)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $brand->description }}</td>
                                    <!-- Button - Modifikasi Data -->
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" id="btn-edit-brand" class="btn btn-success" data-toggle="modal" data-target="#editBrandModal" data-id="{{ $brand->id }}">
                                                Edit
                                            </button>
                                            <button type="button" id="btn-delete-brand" class="btn btn-danger" data-toggle="modal" data-target="#deleteBrandModal" data-id="{{ $brand->id }}" 
                                                data-name="{{ $brand->name }}">
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