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

    {{-- <div class="row p-4">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <a href="{{ route('employees') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Employee Directory" text="{{ App\Models\Employee::get()->count() }}" theme="secondary" />
                            </a>
                        </div>

                         <div class="col-md-4">
                            <a href="{{ route('payrolls') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Payroll" text="{{ App\Models\Payroll::get()->count() }}" theme="secondary" />
                            </a>
                        </div>

                         <div class="col-md-4">
                            <a href="{{ route('billing') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Billings" text="{{ App\Models\Billing::get()->count() }}" theme="secondary" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

      <div class="row p-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body ">
                    {{-- <canvas id="salesChart" style="height: 250px;"></canvas> --}}

                    <div class="row">
                        <div class="col md-5">


                            <div>
                                <h4>INVOICE TO</h4>
                                <p>{{ $billing->client_name }}</p>
                                <p>{{ $billing->client->address }}</p>
                                <p>{{ $billing->client->phone }}</p>
                            </div>


                        </div>

                        <div class="col md-5">
                            <div>
                                <h4>Logo Here</h4>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('download', ['id' => $billing->id]) }}" class="btn btn-secondary">Download Invoice</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">

                        </div>
                        <div class="col-md-5">
                            <p>Invoice No:INV00{{ $billing->id }} </p>
                            <p>Date:{{ $billing->issue_date }} </p>
                            <p>Due Date: {{ $billing->due_date }} </p>
                        </div>
                        <div class="col-md-2">

                        </div>
                    </div>
                    <div class="row">
                        <table>
                            <head>
                                <th>Product/Service</th>
                                <th>Discription</th>
                                <th>Quantity/Hours</th>
                                <th>Rate   (MWK)</th>
                                <th>Total  (MWK)</th>
                            </head>
                            <tbody>
                                 @foreach ($billing->orders as $order)
                                <tr>
                                    <td>{{ $order->product->name ?? 'N/A' }}</td>
                                    <td>{{ $order->product->description ?? 'N/A' }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>{{ number_format($order->rate, 2) }}</td>
                                    <td>{{ number_format($order->quantity * $order->rate, 2) }}</td>

                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="row">
                            <div class="col-md-4">
                                <h4>Transaction Terms</h4>
                                <p>{{ $billing->transaction_terms }}</p>
                            </div>
                        <div class="col-md-4">

                        </div>

                            <div class="col-md-4">
                                <p>Subtotal:{{ number_format($subtotal,2) }} </p>
                                <p>Discount:{{ $billing->discount }} </p>
                                <p>Tax Amount:{{ $billing->tax_amount }}</p>
                                <div class="card">TOTAL: {{number_format($billing->total_amount-$billing->discount-$billing->tax_amount, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

{{-- @push('css')
<style type="text/css">

    {{-- You can add AdminLTE customizations here --}}

    {{-- .card {
        border-radius: none;
    }
    .card-title {
        font-weight: 600;
    }


</style>
@endpush --}}

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
