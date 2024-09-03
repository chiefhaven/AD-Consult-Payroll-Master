@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>&nbsp;</h1>
@stop

@section('content')
    <div class="row p-4">
        <div class="col-md-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="border border-primary mb-3 p-4">
                        <div class="box-body">
                            <h3>Good Morning</h3>
                            {!! \Illuminate\Foundation\Inspiring::quote() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <x-adminlte-small-box title="{{ App\Models\Employee::get()->count() }}" text="Employees" icon="fas fa-users"
                                theme="information"/>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-small-box title="{{ App\Models\Client::get()->count() }}" text="Clients" icon="fas fa-file-invoice"
                            theme="information"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p><strong>Upcoming events</strong></p>

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
