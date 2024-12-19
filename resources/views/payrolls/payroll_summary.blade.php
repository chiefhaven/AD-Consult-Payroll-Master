@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Payrolls')

@section('content_header')
    <h1>&nbsp; All Payrolls</h1>
@stop

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
<div class="col ">
    <div class="row mb-2">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="tab-monthly" href="#" data-period="Monthly">Monthly</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-biweekly" href="#" data-period="Bi-Weekly">Bi-Weekly</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-weekly" href="#" data-period="Weekly">Weekly</a>
            </li>
        </ul>
    </div>

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
     @foreach ($groupedPayrolls as $monthYear => $data)
                <tr onclick="window.location='{{ route('payrolls.group', ['monthYear' => $monthYear]) }}'" style="cursor: pointer;">
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $monthYear)->format('F Y') }}</td>
                    <td>{{ number_format($data['total_net_pay'], 2) }}</td>
                    <td>{{ $data['employee_count'] }}</td>
                    <td>{{ $data['status'] }}</td>
                </tr>
            @endforeach
    </tbody>
</table>
</div>
@stop

@include('/components/layouts/footer_bottom')

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

            $('.nav-link').on('click', function (e) {
        e.preventDefault();

        const period = $(this).data('period');

        // Update active tab
        $('.nav-link').removeClass('active');
        $(this).addClass('active');

        // Fetch period-specific data (can use AJAX if server interaction is needed)
        const data = @json($groupedPayrolls); // Embed Laravel data

        // Clear table body
        const tableBody = $('#payroll-table-body');
        tableBody.empty();

        // Populate table with the selected period data
        if (data[period]) {
            Object.entries(data[period]).forEach(([monthYear, payrolls]) => {
                const totalNetPay = payrolls.reduce((sum, payroll) => sum + payroll.net_pay, 0).toFixed(2);
                const employeeCount = payrolls.length;
                const status = payrolls.every(p => p.payment_status === 'Draft') ? 'Draft' : 'Paid';

                tableBody.append(`
                    <tr>
                        <td>PY-${monthYear}</td>
                        <td>${totalNetPay}</td>
                        <td>${moment(monthYear, 'Y-M').format('MMMM YYYY')}</td>
                        <td>${employeeCount}</td>
                        <td>${status}</td>
                    </tr>
                `);
            });
        }
    });
        });
    </script>
@endpush




