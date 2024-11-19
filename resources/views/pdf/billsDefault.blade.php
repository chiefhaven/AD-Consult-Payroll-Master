<!DOCTYPE html>
<html>
<head>
    @include('pdf.css')
</head>
<body>
<div style="width: 100%">
        <div class="col-md-12">
            <div class="mb-3">
                    <div class="col-md-4">
                        <table>
                            <tr>
                                <th>Invoice No.:</th>
                                <td>{{ $bill->invoice_number }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td class="capitalize">{{ $bill->bill_status }}</td>
                            </tr>
                            <tr>
                                <th>Payment Status:</th>
                                <td>
                                    {{--  @if("balance === 0")
                                        Paid
                                    </div>
                                    @elseif("totalPayments > 0 && totalPayments < totalPayable")
                                        Partially paid
                                    </div>
                                    @else("totalPayments === 0 && totalPayable > 0")
                                        Not paid
                                    @endif  --}}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-5">
                        <table>
                            <tr>
                                <th>Client Name:</th>
                                <td>{{ $bill->client->client_name }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>{{ $bill->client->address }}</td>
                            </tr>
                            <tr>
                                <th>City:</th>
                                <td>{{ $bill->client->city }}</td>
                            </tr>
                            <tr>
                                <th>Country:</th>
                                <td>{{ $bill->client->country }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $bill->client->phone }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <table>
                            <tr>
                                <th>Created:</th>
                                <td>{{ $bill->billing_date }}</td>
                            </tr>
                            <tr>
                                <th>Due:</th>
                                <td>{{ $bill->billing_date, $bill->paymentTerms, $bill->termsUnits }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12 pt-5 pb-3">
                        <h5>Products/services:</h5>
                        <table id="invoicesSalesTable" class="table table-striped table-vcenter display nowrap">
                            <thead class="bg-primary">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Discount</th>
                                    <th>Tax</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bill->products as $product)
                                    <tr>
                                        <td>
                                            <strong>{{ $product->name }}</strong><br>
                                            {{ $product->description }}
                                        </td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td>K{{ number_format($product->pivot->price, 2) }}</td>
                                        <td>K{{ number_format($product->pivot->item_discount, 2) }}</td>
                                        <td>K{{ number_format($product->pivot->tax, 2) }}</td>
                                        <td>K{{ number_format($product->pivot->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-8">
                        @if($bill->payments->isNotEmpty())
                            <strong>Payment information</strong>
                            <table class="table table-responsive table-striped">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Reference</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bill->payments as $payment)
                                        <tr>
                                            <td>{{ $payment->payment_date }}</td>
                                            <td>{{ number_format($payment->payment_amount, 2) }}</td>
                                            <td>{{ $payment->payment_method }}</td>
                                            <td>{{ $payment->payment_reference }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                    <div class="col-md-4">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><strong>Total:</strong></td>
                                    <td>{{ number_format($bill->products->sum('pivot.total'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tax:</strong></td>
                                    <td>{{ number_format($bill->products->sum('pivot.tax'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Discount:</strong></td>
                                    <td>{{ number_format($bill->products->sum('pivot.item_discount'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Payable:</strong></td>
                                    <td>{{ number_format($bill->products->sum('pivot.total') - $bill->payments->sum('payment_amount'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Paid:</strong></td>
                                    <td>{{ number_format($bill->payments->sum('payment_amount'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Balance:</strong></td>
                                    <td>{{ number_format($bill->products->sum('pivot.total') - $bill->payments->sum('payment_amount'), 2) }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>

            </div>
        </div>
</div>
</div>
<script>
    window.onload = function() {
        window.print(); // Automatically trigger the print dialog
    }
</script>
</body>
</html>
