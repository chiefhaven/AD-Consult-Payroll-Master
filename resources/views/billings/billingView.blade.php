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
            <th>paid Amount</th>
            <th>Discount</th>
            <th>Balance</th>
            <th>Tax Amount</th>
            <th>Discount Type</th>
            <th>Discription</th>
            <th>Transaction Terms</th>
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
            <td>{{ $billing->paid_amount }}</td>
            <td>{{ $billing->discount }}</td>
            <td>{{ $billing->balance }}</td>
            <td>{{ $billing->tax_amount }}</td>
            <td>{{ $billing->discount_type }}</td>
            <td>{{ $billing->discription }}</td>
            <td>{{ $billing->transaction_terms }}</td>
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
