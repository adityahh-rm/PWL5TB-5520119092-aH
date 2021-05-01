@extends('adminlte::page')

@section('title', 'Income Product')

@section('content_header')
    <h1>Income Product</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Income') }}</div>
                <div class="card-body">
                    <a class="btn btn-primary float-right" href="{{ route('admin.print.incomes') }}" target="_blank">
                        <i class="fa fa-print"></i>
                            Income Product
                    </a>
                    <table id="table-data" class="table table-borderer">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Entry</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($income_reports as $inc)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $inc->name }}</td>
                                    <td>{{ $inc->created_at->format('M, d Y H:i') }}</td>     
                                    <td>{{ $inc->qty }}</td>
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