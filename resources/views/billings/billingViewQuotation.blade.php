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

      <div class="row p-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body ">
                    <div class="row">
                        <div class="col md-5">
                            <div>
                                <h4>QUOTE TO</h4>
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
                            <a href="{{ route('download', ['id' => $billing->id]) }}" class="btn btn-secondary">Download Quote</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">

                        </div>
                        <div class="col-md-5">
                            <p>Quote No:QT00{{ $billing->id }} </p>
                            <p>Date:{{ $billing->issue_date }} </p>
                            <p>Due Date: {{ $billing->due_date }} </p>
                        </div>
                        <div class="col-md-2">

                        </div>
                    </div>
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product/Service</th>
                                    <th>Discription</th>
                                    <th>Quantity/Hours</th>
                                    <th>Rate   (MWK)</th>
                                    <th>Total  (MWK)</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $subtotal = 0; // Initialize subtotal variable
                                @endphp

                                @foreach ($billing->orders as $order)
                                    @php
                                        $orderTotal = $order->quantity * $order->rate; // Calculate total for the current order
                                        $subtotal += $orderTotal; // Sum up to subtotal
                                    @endphp

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
                                    @php
                                        $discountPercentage = $billing->discount; // Assuming this is a percentage
                                        $discountAmount = ($subtotal * $discountPercentage) / 100; // Calculate the discount amount
                                        $adjustedSubtotal = $subtotal - $discountAmount; // Apply discount
                                        $taxAmount = ($adjustedSubtotal * $billing->tax_amount) / 100; // Calculate tax based on adjusted subtotal
                                    @endphp

                                <p>Subtotal:{{ number_format($subtotal,2) }} </p>
                                <p>Discount ({{ number_format($discountPercentage, 2) }}%): {{ number_format($discountAmount, 2) }}</p>
                                <p>Tax Amount:{{ $taxAmount }}</p>
                                <div class="card">TOTAL: {{ number_format($adjustedSubtotal + $taxAmount, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop


@push('js')

@endpush
