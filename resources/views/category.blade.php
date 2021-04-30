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
                    <button class="btn btn-primary float-left" data-toggle="modal" data-target="#addCategoryModal">
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

<!-- M O D A L -->
<!-- Proses Input Data Product -->
<div  class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModal">
                    Add Category
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.category.submit') }}" enctype="multipart/form-data">
                    @csrf 
                        <div class="form-group">
                            <label for="name">Category Name</label>
                            <input type="text" class="form-control" name="name" id="name" required/>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" id="description"/>
                        </div>         
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>     
        </div>
    </div>
</div>

<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModal">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.category.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') 
                        <!-- form yg dikirimkan sesuai dengan route::patch -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit-name">Category Name</label>
                                    <input type="text" class="form-control" name="name" id="edit-name" required/>
                                </div>
                                <div class="form-group">
                                    <label for="edit-description">Description</label>
                                    <textarea type="text" class="form-control" name="description" id="edit-description" required></textarea>
                                </div>
                        </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="edit-id"/>
                <input type="hidden" name="description" id="edit-description"/> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModal">
                    Deleting Product
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you Sure you want to Delete <strong><span id="caption"></span></strong>? 
                <form method="post" action="{{ route('admin.category.delete') }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="delete-id"/>
                <input type="hidden" name="description" id="delete-old-description"/>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
        $(function(){
            // JS UPDATING X
            $(document).on('click', '#btn-edit-category', function(){
                let id = $(this).data('id');

                $('#image-area').empty();

                $.ajax({
                    type: "get",
                    url: baseurl+'/admin/ajaxadmin/dataCategory/'+id,
                    dataType: 'json',
                    success: function(res){
                        $('#edit-name').val(res.name);
                        $('#edit-id').val(res.id);
                        $('#edit-description').val(res.description);
                    },
                });
            }); 
        });
    </script>

    <script>
        $(document).on('click', '#btn-delete-category', function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let desc = $(this).data('description');

            $('#delete-id').val(id);
            $('#delete-old-description').val(description);
            $('#caption').text(name);
        });
    </script>
@stop