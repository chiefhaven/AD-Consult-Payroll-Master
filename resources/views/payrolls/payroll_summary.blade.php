@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Billing')

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

    @push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.min.css">
    @endpush

@stop

{{-- Rename section content to content_body --}}

@section('content') 
<div class="row ">

    <table id="myTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Total (MWK)</th>
            <th>Date</th>
            <th>Total Employees </th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payroll as $payroll)
        <tr>
            <td>{{ $payroll->client_name }}</td>
            <td>{{ $payroll->bill_type }}</td>
            <td>{{ $payroll-> }} </td>
            <td>{{ $payroll->status }}</td>
            <td>{{ $payroll->issue_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

@push('js')
    <script src="https://cdn.datatables.net/2.1.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.min.js"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                autoWidth: false,
                responsive: true
                // paging: true,
                // search: true,
                // ordering: true,
                // info: true,
                // lengthChange: true,
                // pageLength: 10,
            });
        });
    </script>
@endpush


@stop


