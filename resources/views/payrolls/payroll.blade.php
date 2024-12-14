@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Payroll')

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


    <div class="col mt-3">


     <table id="payrollTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>First name</th>
                <th>Surname</th>
                <th>Gross Pay</th>
                <th>Net Pay</th>
                <th>Deductions</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupRecords as $record)
                <tr>
                    <td>EMP-{{ $record->employee->hiredate }}-{{ $record->employee->employee_no  }}</td>
                    <td>{{ $record->employee->fname }}</td>
                    <td>{{ $record->employee->sname }}</td>
                    <td>{{ number_format($record->gross_pay, 2) }}</td>
                    <td>{{ number_format($record->net_pay, 2) }}</td>
                    <td>{{ number_format($record->deductions, 2) }}</td>
                    <td>{{ $record->payment_method }}</td>
                    <td>{{ $record->payment_status }}</td>
                    <td>---</td>
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
