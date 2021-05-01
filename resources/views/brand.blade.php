@extends('adminlte::page')

@section('title', 'Firearms Brand Managament')

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
                    <button class="btn btn-primary float-left" data-toggle="modal" data-target="#addBrandModal">
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


<!-- M O D A L -->
<!-- Proses Input Data Product -->
<div  class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBrandModal">
                    Add Brand
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.brand.submit') }}" enctype="multipart/form-data">
                    @csrf 
                        <div class="form-group">
                            <label for="name">Brand Name</label>
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

<div class="modal fade" id="deleteBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"> <!-- exampleModalLabel-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBrandModal">Delete Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you Sure you want to Delete <strong><span id="caption"></span></strong>?
                <form method="post" action="{{ route('admin.brand.delete') }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="delete-id"/>
                <input type="hidden" name="description" id="old-description"/>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close </button>
                <button type="submit" class="btn btn-danger">Delete</button>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBrandModal">Update Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.brand.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') 
                        <!-- form yg dikirimkan sesuai dengan route::patch -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit-name">Brand Name</label>
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
@stop

@section('js')
    <script>
        $(function(){
            // JS UPDATING X
            $(document).on('click', '#btn-edit-brand', function(){
                let id = $(this).data('id');

                $('#image-area').empty();

                $.ajax({
                    type: "get",
                    url: baseurl+'/admin/ajaxadmin/dataBrand/'+id,
                    dataType: 'json',
                    success: function(res){
                        $('#edit-name').val(res.name);
                        $('#edit-description').val(res.description);
                    },
                });
            }); 
        });
    </script>

    <script>
     $(function(){
        $(document).on('click', '#btn-delete-brand', function(){
                let id = $(this).data('id');
                let name = $(this).data('name');

                $('#delete-id').val(id);
                $('#caption').text(name);
            });
    });
    </script>
@stop