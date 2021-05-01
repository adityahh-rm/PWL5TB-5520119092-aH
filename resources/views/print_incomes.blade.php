<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <h1 class="text-center">Income Product Report</h1>
    <h4 class="text-center">Fireguns - 2021</h4>
    <br/>
    <table id="table-data" class="table table-bordered">
        <thead>
            <tr>
                <th>NO</th>
                <th>NAME</th>
                <th>ENTRY</th>
                <th>QUANTITY</th>
            </tr>
        </thead>
        <tbody>
        @php $no=1; @endphp
        @foreach($income_reports as $incr)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $incr->name }}</td>
                <td>{{ $incr->created_at->format('M, d Y H:i') }}</td>
                <td>{{ $incr->qty }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>