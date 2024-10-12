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
@stop

{{-- Rename section content to content_body --}}

@section('content')
<div class="row">
    <table>
    <thead>
        <tr>
            <th>Client Name</th>
            <th>Type</th>
            <th>Amount</th>
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
                @if($billing->bill_type == 'invoice')
                    ${{ number_format($billing->invoice_amount, 2) }}
                @elseif($billing->bill_type == 'quotation')
                    ${{ number_format($billing->quotation_amount, 2) }}
                @endif
            </td>
            <td>{{ $billing->status }}</td>
            <td>{{ $billing->issue_date }}</td>
            <td>{{ $billing->due_date }}</td>
            {{-- <td>
                <!-- Actions like edit, delete, etc. -->
                <a href="{{ route('billingView') }}">View</a>
                <a href="{{ route('billingEdit') }}">Edit</a>
                <form action="{{ route('billings.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td> --}}
        </tr>
        @endforeach
    </tbody>
</table>

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
@push('css')
<style type="text/css">

    {{-- Table styles --}}
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        border: 1px solid #dee2e6; /* Border for table cells */
        padding: 8px; /* Padding for content */
        text-align: left; /* Align text to the left */
    }

    table th {
        background-color: #f8f9fa; /* Light background for table headers */
        font-weight: bold; /* Bold font for headers */
    }

    {{-- Custom styles for AdminLTE card component --}}
    .card {
        border-radius: none;
    }
    .card-title {
        font-weight: 600;
    }

</style>
@endpush

