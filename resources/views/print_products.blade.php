<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <h1 class="text-center">Report Data</h1>
    <h4 class="text-center">- Fireguns - </h4>
    <br/>
    <table id="table-data" class="table table-bordered">
        <thead>
            <tr>
                <th>NO</th>
                <th>NAME</th>
                <th>CATEGORY</th>
                <th>MERK</th>
                <th>QUANTITY</th>
                <th>PHOTO</th>
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
                            <img src="{{ public_path('storage/product_img/'.$product->photo) }}" width="100px"/>
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