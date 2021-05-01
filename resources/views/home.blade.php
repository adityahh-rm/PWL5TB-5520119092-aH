@extends('adminlte::page')

@section('title', 'Firearms')

@section('content_header')
    <h1>Firearms - </h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if ($user->roles_id == 1) 
                        <p class="mb-0">You're Admin</p>
                    @else
                        <p class="mb-0">You're User</p>
                    @endif
                </div>
                <div class="card-body">
                    
                    <table id="table-data" class="table table-borderer">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Merk</th>
                                <th>Quantity</th>
                                <th>Photo</th>
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