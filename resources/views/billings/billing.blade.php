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
            <th>Client Name</th>
            <th>Type</th>
            <th>Amount (MWK)</th>
            <th>Status </th>
            <th>Issue Date</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($billings as $billing)
        <tr>
            <td>{{ $billing->client_name }}</td>
            <td>{{ $billing->bill_type }}</td>
            <td>
                {{-- @if($billing->bill_type == 'invoice')
                    {{ number_format($billing->invoice_amount, 2) }}
                @elseif($billing->bill_type == 'quotation')
                    {{ number_format($billing->quotation_amount, 2) }}
                @endif --}}
                {{ number_format($billing->total, 2)}}
            </td>
            <td>{{ $billing->status }}</td>
            <td>{{ $billing->issue_date }}</td>
            <td>{{ $billing->due_date }}</td>
            <td>
                <a href="{{ route('billingView', ['id' => $billing->id]) }}">View</a>
            </td>
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
                // responsive: true
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


