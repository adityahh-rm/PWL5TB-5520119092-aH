@extends('adminlte::page')

@section('title', 'Product Managament')

@section('content_header')
    <h1>Product Managament</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin ---- Product Managament') }}</div>
                <div class="card-body">
                    <button class="btn btn-primary float-left" data-toggle="modal" data-target="#addProductModal">
                        <i class="fa fa-plus"></i>
                        Add Product
                    </button>
                    <table id="table-data" class="table table-borderer">
                        <thead>
                            <tr>
                                <th>N0</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Merk</th>
                                <th>Price</th>
                                <th>Stock</th>
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
                                    <td>{{ $product->qty }}</td>
                                    <td>{{ $product->categories_id }}</td>
                                    <td>{{ $product->brands_id }}</td>
                                    <td>
                                        @if($book->photo !== null)
                                            <img src="{{ asset('storage/product_img/'.$product->photo) }}" width="100px"/>
                                        @else
                                            [ Image not available ]
                                        @endif
                                    </td> 

                                    <!-- Button - Modifikasi Data -->
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" id="btn-edit-product" class="btn btn-success" 
                                                data-toggle="modal" data-target="#editProductModal" data-id="{{ $product->id }}">
                                                Edit
                                            </button>
                                            <!-- Deleting button for modal -->
                                            <button type="button" id="btn-delete-product" class="btn btn-danger" data-toggle="modal" 
                                                data-target="#deleteProductModal" data-id="{{ $product->id }}" 
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
                    Add Data Product
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
                <button type="submit"  value="submit" class="btn btn-primary">Submit</button>
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
                                    <!-- edit-.... ditulis untuk menghindari adanya duplikasi -->
                                    <input type="text" class="form-control" name="name" id="edit-name" required/>
                                </div>
                                <div class="form-group">
                                    <label for="edit-qty">Stock</label>
                                    <input type="text" class="form-control" name="qty" id="edit-qty" required/>
                                </div>
                                <div class="form-group">
                                    <label for="edit-price">Price</label>
                                    <input type="text" class="form-control" name="price" id="edit-price" required/>
                                </div>
                                <div class="form-group">
                                    <label for="edit-category">Category</label>
                                    <input type="year" class="form-control" name="category" id="edit-category" required/>
                                </div>
                                <div class="form-group">
                                    <label for="edit-merk">Merk</label>
                                    <input type="text" class="form-control" name="merk" id="edit-merk" required/>
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
                <!-- hidden --]> memerlukan id untuk mengubah data-nya -->
                <input type="hidden" name="id" id="edit-id"/>
                <input type="hidden" name="photo" id="edit-old-photo"/> <!-- menghapus cover yang terdulu -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- delete -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"> <!-- exampleModalLabel-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModal">
                    Deleting Data
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you Sure you want to Delete??
                <form method="post" action="{{ route('admin.product.delete') }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="delete-id"/>
                <input type="hidden" name="photo" id="delete-old-photo"/>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-danger">
                    Delete
                </button>

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
                        $('#edit-price').val(res.price);
                        $('#edit-category').val(res.categories_id);
                        $('#edit-merk').val(res.brands_id);
                        $('#edit-id').val(res.id);
                        $('#edit-old-photo').val(res.photo);

                        if(res.cover !== null){
                            $('#image-area').append( //reset image cover
                                "<img src='"+baseurl+"/storage/product_img/"+res.cover+"' width='200px'/>"
                            );
                        } else {
                            $('#image-area').append('[Image not available]');
                        }
                    },
                });
            }); 

             // JS DELETING PRODUCT
            $(document).on('click', '#btn-delete-product', function(){
                let id = $(this).data('id');
                let photo = $(this).data('photo');

                $('#delete-id').val(id);
                $('#delete-old-photo').val(photo);
            });
        });
    </script>
@stop
