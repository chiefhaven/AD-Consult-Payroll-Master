@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>&nbsp;</h1>
@stop

@section('content')
    <div class="row p-4">
        <div class="col-md-12">

            <div class="row">
                <div class="col-lg-12">
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <x-adminlte-small-box title="Employe Directory" text="{{  App\Models\Employee::get()->count() }}"  theme="primary"/>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-small-box title="Payroll" text="{{ App\Models\Client::get()->count() }}"   theme="primary"/>
                        </div>
                         <div class="col-md-4">
                            <x-adminlte-small-box title="Billings" text="{{ App\Models\Client::get()->count() }}"   theme="primary"/>
                        </div>
                    </div>
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

    <script type="text/javascript">
        function showTime() {
          var date = new Date(),
              utc = new Date(Date.UTC(
                date.getFullYear(),
                date.getMonth(),
                date.getDate(),
                date.getUTCHours(),
                date.getMinutes(),
                date.getSeconds()
              ));

          document.getElementById('time').innerHTML = utc.toLocaleString();
        }

        setInterval(showTime, 1000);
      </script>
@stop
