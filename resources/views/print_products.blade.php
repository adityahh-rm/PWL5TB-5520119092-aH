<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <h1 class="text-center">Data Product - Shooting Guns</h1>
    <p class="text-center">Report Data</p>
    <br/>
    <table id="table-data" class="table table-bordered">
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
</body>
</html>