@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>&nbsp;</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-9">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card bg-primary mb-3 p-4">
                        <div class="box-body">
                            <h3>Good Morning</h3>
                            Welcome to AD; Believe it possible, its all in your mind! Have a fresh day!.
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3>08:00AM</h3>
                            03/02/2024
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h4>Notifications</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <p>Upcoming events</p>
                    Welcome to AD; Believe it possible, its all in your mind! Have a fresh day!.
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="/css/app.css">
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
