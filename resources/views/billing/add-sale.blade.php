@extends('adminlte::page')

@section('title', 'Add Ssale')

@section('content_header')
    <h1>Add Sale</h1>
@stop

@section('content')
<div id="addSale">
    <form action="{{ route('store-sale') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card mb-3 p-4">
            <div class="box-body">
                <div class="row">
                    <!-- Client ID -->
                    <div class="col-md-4 form-group">
                        <label for="client_id">Client</label>
                        <select class="form-control" name="client_id" id="client_id" required>
                            <option value="">Select Client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Billing Date -->
                    <div class="col-md-4 form-group">
                        <label for="billing_date">Sale Date</label>
                        <input type="date" class="form-control" name="sale_date" id="sale_date" required>
                    </div>

                    <!-- Due Date -->
                    <div class="col-md-4 form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" name="due_date" id="due_date" required>
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="completed">Draft</option>
                            <option value="failed">Final</option>
                        </select>
                    </div>

                    <!-- Attachment -->
                    <div class="col-md-4 form-group">
                        <label for="attachment_path">Attachment</label>
                        <input type="file" class="form-control" name="attachment_path" id="attachment_path">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Product/Service details</p>
                <div class="row">
                    <!-- Product ID -->
                    <div class="col-md-12 form-group">
                        <x-adminlte-select2 class="form-control" name="product_ids[]" v-model="selectedProductIds" multiple @change="updateProductDetails" required>
                            <option value="" disabled>Select Product</option>
                            <option v-for="product in products" :key="product.id" :value="product.id">@{{ product.name }}</option>
                        </x-adminlte-select2>
                    </div>

                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th style="max-width: 100px;">Product</th>
                                <th style="max-width: 100px;">Price</th>
                                <th style="max-width: 100px;">Quantity</th>
                                <th style="max-width: 100px;">Total</th>
                            </tr>
                        </thead>
                        <tbody id="product-details">
                            <tr v-for="(detail, index) in productDetails" :key="index">
                                <td>
                                    <strong>@{{ detail.name }}</strong>
                                    <p>@{{ detail.description }}</p>
                                </td>
                                <td>K@{{ detail.price.toFixed(2) }}</td>
                                <td>
                                    <x-adminlte-input
                                        type="number"
                                        name="quantities"
                                        v-model="quantities[index]"
                                        min="1"
                                        @input="updateProductDetails(index)"
                                    />
                                </td>
                                <td>K@{{ detail.total.toFixed(2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-right">
                        <strong>Total Sales: @{{ formatCurrency(totalSales) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Payment details</p>
                <div class="row">
                    <!-- Paid Amount -->
                    <div class="col-md-6 form-group">
                        <label for="paid_amount">Paid Amount</label>
                        <input type="number" step="0.01" class="form-control" name="paid_amount" id="paid_amount" value="0">
                    </div>

                    <!-- Payment Method -->
                    <div class="col-md-6 form-group">
                        <label for="payment_method">Payment Method</label>
                        <select class="form-control" name="payment_method" id="payment_method" required>
                            <option value="cash">Cash</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="online">Online</option>
                        </select>
                    </div>

                    <!-- Notes -->
                    <div class="col-md-12 form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Sale</button>
        </div>
    </form>
</div>
@stop
@push('js')
<script>

</script>
@endpush
