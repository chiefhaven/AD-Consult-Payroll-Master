@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>&nbsp; Dashboard</h1>
@stop

@section('content')
    <div class="row p-4">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <a href="{{ route('employees') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Employee Directory" text="{{ App\Models\Employee::get()->count() }}" theme="secondary" />
                            </a>
                        </div>

                        {{-- <div class="col-md-3">
                            <a href="{{ route('employees') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Employee Directory" text="{{ App\Models\Employee::get()->count() }}" theme="secondary" />
                            </a>
                        </div> --}}

                         <div class="col-md-3">
                            <a href="{{ route('payrolls') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Payroll" text="{{ App\Models\Payroll::get()->count() }}" theme="secondary" />
                            </a>
                        </div>

                         <div class="col-md-3">
                            <a href="{{ route('billing') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Billings" text="{{ App\Models\Billing::get()->count() }}" theme="secondary" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="row p-4">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row mt-2">
                        {{-- <div class="col-md-4">
                            <a href="{{ route('reports') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Report" text="{{ App\Models\Reports::get()->count() }}" theme="secondary" />
                            </a>
                        </div> --}}

                         {{-- <div class="col-md-4">
                            <a href="{{ route('leaves') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Leaves" text="{{ App\Models\Leaves::get()->count() }}" theme="secondary" />
                            </a>
                        </div> --}}


                    </div>
                </div>
            </div>
        </div>
    </div>
      <div class="row p-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Productivity Chart</h2>

                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Organizational Chart</h2>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="height: 250px;"></canvas>
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

        //FOR THE PIE CHART
        $(function() {
            var education_levelLabels = {!! json_encode($education_levels->pluck('education_level')) !!};
            var education_levelData = {!! json_encode($education_levels->pluck('total')) !!};

            var ctxPie = document.getElementById('education_levelPieChart').getContext('2d');
            var pieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: education_levelLabels,
                    datasets: [{
                        label: 'Employee education_level Distribution',
                        data: education_levelData,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });


      </script>
@stop
