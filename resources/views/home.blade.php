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
                            <x-adminlte-small-box title="Employees" text="{{ App\Models\Employee::get()->count() }}" theme="secondary" />
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('leaveView') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Leaves" text="{{ App\Models\Leave::where('status', 'Pending')->get()->count() }}" theme="secondary" />
                            </a>
                        </div>

                         <div class="col-md-3">
                            <a href="{{ route('payrollsummary') }}" style="text-decoration: none;">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
      <div class="row p-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Billing Trend</h2>

                </div>
                <div class="card-body">
                    <canvas id="monthlyBillingChart" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Education Spread</h2>
                </div>
                <div class="card-body">
                    <canvas id="education_levelPieChart" style="height: 250px;"></canvas>
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

      {{-- billing chart --}}
        <script>
            var billingMonths = {!! json_encode($monthly_billings->pluck('month')) !!};
            var billingTotals = {!! json_encode($monthly_billings->pluck('total')) !!};
        </script>
        <script>
            $(function() {
                var ctx = document.getElementById('monthlyBillingChart').getContext('2d');
                var monthlyBillingChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: billingMonths,
                        datasets: [{
                            label: 'Monthly Billings',
                            data: billingTotals,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4 // Smooth curves
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month',
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Billing Amount ($)',
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
</script>


@stop
