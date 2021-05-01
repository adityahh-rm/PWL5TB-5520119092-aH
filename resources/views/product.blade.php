@extends('adminlte::page')

@section('title', 'Firearms Product Managament')

@section('content_header')
    <h1> Firearms Product</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin ---- Product Managament') }}</div>
                <div class="card-body">
                    <div class="btn-group" roles="group">
                        <button class="btn btn-primary float-left" data-toggle="modal" data-target="#addProductModal">
                            <i class="fa fa-print"></i>
                            Add Product
                        </button>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('admin.print.products') }}" target="_blank" class="btn btn-secondary">
                            <i class="fa fa-file-pdf"></i>
                                PDF
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('admin.product.export') }}" class="btn btn-info" target="_blank">
                            <i class="fa fa-file-excel"></i>
                            Excel
                        </a>
                    </div> 
                    <hr/>
                    <table id="table-data" class="table table-borderer">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Merk</th>
                                <th>Quantity</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->brand->name }}</td>
                                    <td>{{ $product->qty }}</td>
                                    <td>
                                        @if($product->photo !== null)
                                            <img src="{{ asset('storage/product_img/'.$product->photo) }}" width="100px"/>
                                        @else
                                            [ Image not available ]
                                        @endif
                                    </td> 
                                    <!-- Button - Modifikasi Data -->
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" id="btn-edit-product" class="btn btn-success" data-toggle="modal" data-target="#editProductModal" data-id="{{ $product->id }}">
                                                Edit
                                            </button>
                                            <button type="button" id="btn-delete-product" class="btn btn-danger" data-toggle="modal" data-target="#deleteProductModal" data-id="{{ $product->id }}" data-name="{{ $product->name }}" 
                                                data-cover="{{ $product->photo }}">
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
<div  class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModal">
                    Add Product
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.product.submit') }}" enctype="multipart/form-data">
                    @csrf 
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control" name="name" id="name" required/>
                        </div>
                        <div class="form-group">
                            <label for="categories_id">Category</label>
                            <select name="categories_id" id="categories" class="form-control">
                                <option selected disabled> -- Select One --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                                   {{ $category->name }}
                                    </option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brands_id">Merk</label>
                            <select name="brands_id" id="brands" class="form-control">
                                <option selected disabled> -- Select One --</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">
                                                   {{ $brand->name }}
                                    </option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="qty">Quantity</label>
                            <input type="text" class="form-control" name="qty" id="qty" required/>
                        </div> 
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" class="form-control" name="photo" id="photo"/>
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

<!-- update -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModal">Update Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.product.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') 
                        <!-- form yg dikirimkan sesuai dengan route::patch -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit-name">Product Name</label>
                                    <input type="text" class="form-control" name="name" id="edit-name" required/>
                                </div>
                                <div class="form-group">
                                    <label for="edit-qty">Stock</label>
                                    <input type="text" class="form-control" name="qty" id="edit-qty" required/>
                                </div>
                                <div class="form-group">
                                    <label for="edit-category">Category</label>
                                    <select name="categories_id" id="categories" class="form-control">
                                        <option selected disabled> -- Select One --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                        {{ $category->name }}
                                            </option>
                                        @endforeach 
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit-brand">Merk</label>
                                    <select name="brands_id" id="brands" class="form-control">
                                        <option selected disabled> -- Select One --</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">
                                                        {{ $brand->name }}
                                            </option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="image-area"></div>
                                <div class="form-group">
                                    <label for="edit-photo">Photo</label>
                                    <input type="file" class="form-control" name="photo" id="edit-photo"/>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="edit-id"/>
                <input type="hidden" name="old-description" id="edit-old-description"/> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- delete -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModal">
                    Deleting Product
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you Sure you want to Delete <strong><span id="caption"></span></strong>? 
                <form method="post" action="{{ route('admin.product.delete') }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="delete-id"/>
                <input type="hidden" name="old_photo" id="delete-old-photo"/>
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
            $(document).on('click', '#btn-edit-product', function(){
                let id = $(this).data('id');

                $('#image-area').empty();

                $.ajax({
                    type: "get",
                    url: baseurl+'/admin/ajaxadmin/dataProduct/'+id,
                    dataType: 'json',
                    success: function(res){
                        $('#edit-name').val(res.name);
                        $('#edit-qty').val(res.qty);
                        $('#edit-category').val(res.categories_id);
                        $('#edit-brand').val(res.brands_id);
                        $('#edit-id').val(res.id);
                        $('#edit-old-photo').val(res.photo);

                        if(res.photo !== null){
                            $('#image-area').append( //reset image cover
                                "<img src='"+baseurl+"/storage/product_img/"+res.photo+"' width='200px'/>"
                            );
                        } else {
                            $('#image-area').append('[Image not available]');
                        }
                    },
                });
            }); 
        });
    </script>

    <script>
        $(document).on('click', '#btn-delete-product', function(){
                let id = $(this).data('id');
                let photo = $(this).data('photo');
                let name = $(this).data('name');

                $('#delete-id').val(id);
                $('#delete-old-photo').val(photo);
                $('#caption').text(name);
            });
    </script>
@stop
