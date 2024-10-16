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
                        <x-adminlte-select class="form-control" name="product_ids[]" v-model="selectedProductIds" multiple @change="updateProductDetails" required>
                            <option value="" disabled>Select Product</option>
                            <option v-for="product in products" :key="product.id" :value="product.id">@{{ product.name }}</option>
                        </x-adminlte-select>
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
                        <strong>Total Sales: K@{{ formatCurrency(totalSales) }}</strong>
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
    const addSale = createApp({
        setup() {
            // Reactive references
            const selectedProductIds = ref([]); // Array to hold selected product IDs
            const quantities = ref([1]); // Array to hold quantities for each selected product
            const products = ref([]); // This should be populated with your products array from the API

            // Computed property to get product details based on selected IDs
            const productDetails = computed(() => {
                return selectedProductIds.value.map((id, index) => {
                    const product = products.value.find(product => product.id === id);
                    if (product) {
                        return {
                            name: product.name,
                            description: product.description,
                            price: parseFloat(product.price) || 0, // Ensure price is a number
                            quantity: quantities.value[index],
                            total: (parseFloat(product.price) || 0) * quantities.value[index] // Ensure total is also a number
                        };
                    }
                    return null;
                }).filter(Boolean); // Filter out any null values
            });

            // Computed property for total sales amount
            const totalSales = computed(() => {
                return productDetails.value.reduce((acc, item) => acc + item.total, 0);
            });

            // Function to handle adding a new product row
            const addProduct = () => {
                selectedProductIds.value.push(''); // Add an empty entry for product selection
                quantities.value.push(1); // Add a default quantity of 1
            };

            // Function to handle product selection changes
            const updateProductDetails = (index) => {
                if (selectedProductIds.value[index] !== '') {
                    quantities.value[index] = 1; // Reset to 1 for the selected product
                } else {
                    quantities.value[index] = 0; // Set quantity to 0 if no product is selected
                }
            };

            // Function to simulate fetching products from an API
            const fetchProducts = async () => {
                try {
                    const response = await axios.get('/products'); // Adjust the API endpoint
                    products.value = response.data; // Populate the products array
                } catch (error) {
                    console.error('Error fetching products:', error);
                }
            };

            const formatCurrency = (value) => {
                return `K ${Number(value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            };

            // Fetch products when the component is mounted
            onMounted(fetchProducts);

            return {
                selectedProductIds,
                quantities,
                addProduct,
                productDetails,
                totalSales,
                updateProductDetails,
                products,
                formatCurrency
            };
        }
    });

    addSale.mount('#addSale');
</script>
@endpush
