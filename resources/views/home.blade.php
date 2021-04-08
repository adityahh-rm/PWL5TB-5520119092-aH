@extends('adminlte::page')

@section('title', 'xPage')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if ($user->roles_id == 1)
                        <p class="mb-0">Anda login sebagai Admin</p>
                    @else
                        <p class="mb-0">Anda login sebagai User</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
<!-- 
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop -->