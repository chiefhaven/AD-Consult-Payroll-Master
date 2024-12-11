@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Employees')

{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title', 'adminlte')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

@stop

{{-- Rename section content to content_body --}}

@section('content')
<div>
<div id="">
    <div class="row">
        <div class="col-md-3">
            <!-- Total Requests Card -->
            <div class="card text-white bg-secondary mb-1">
                <div class="card-body">
                    <h5 class="card-title">Total Payroll Amount</h5>
                    <p class="card-text">
                       
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- Approved Requests Card -->
            <div class="card text-white bg-secondary mb-1">
                <div class="card-body">
                    <h5 class="card-title">No. of Employees</h5>
                    <p class="card-text">

                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- Disapproved Requests Card -->
            <div class="card text-white bg-secondary mb-1">
                <div class="card-body">
                    <h5 class="card-title">Pay Period</h5>
                    <p class="card-text">
                       
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- Disapproved Requests Card -->
            <div class="card text-white bg-secondary mb-1">
                <div class="card-body">
                    <h5 class="card-title">Disbursement Date</h5>
                    <p class="card-text">
                       
                    </p>
                </div>
            </div>
        </div>
    </div>

<div>

     <table id="payrollTable" class="table table-striped table-bordered"> 
        <thead>
            <tr>
                <th>Name</th>
                <th>Total</th>
                <th>Date</th>
                <th>Total Employees</th>
                <th>status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payrolls as $payroll)
                <tr>
                    <td>{{ $payroll->name }}</td>
                    <td>{{ $payroll->total }}</td>
                    <td>{{ $payroll->date }}</td>
                    <td>{{ $payroll->total_employees }}</td>
                    <td>{{ $payroll->status }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>


</div>

</div>
       
   

@stop

{{-- Create a common footer --}}

@include('/components/layouts/footer_bottom')

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script>

    $(document).ready(function() {
        // Add your common script logic here...
    });

</script>
@endpush

{{-- Add common CSS customizations --}}

@push('css')
<style type="text/css">

    {{-- You can add AdminLTE customizations here --}}

    .card {
        border-radius: none;
    }
    .card-title {
        font-weight: 600;
    }


</style>
@endpush
