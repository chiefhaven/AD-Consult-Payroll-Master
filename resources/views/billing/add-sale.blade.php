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
                        <input
                        class="form-control"
                        id="client"
                        name="client"
                        v-model="client"
                        @input="searchClient"
                        @blur="onClientChange($event)"
                        placeholder="Select client">

                        <div v-if="clientData">
                                <div class="mt-3">
                                    <b>@{{ clientData.client_name }}</b><br>
                                    Phone: @{{ clientData.phone }}<br>
                                    <div v-if="clientData.user && clientData.user.email !== null">
                                        Email: @{{ clientData.user.email }}
                                    </div>
                                    <div v-else>
                                        Email: No email address available
                                    </div>
                                </div>
                            </div>

                    </div>

                    <div class="col-md-8">
                        <div class="row">
                            <!-- Billing Date -->
                            <div class="col-md-6 form-group">
                                <label for="billing_date">Sale Date</label>
                                <input type="date" class="form-control" name="sale_date" id="sale_date" required>
                            </div>

                            <!-- Due Date -->
                            <div class="col-md-6 form-group">
                                <label for="due_date">Due Date</label>
                                <input type="date" class="form-control" name="due_date" id="due_date" required>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="completed">Draft</option>
                                    <option value="failed">Final</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Product/Service details</p>
                <div class="row">
                    <!-- Product ID -->
                    <label for="product_id">Product/Service</label>
                    <input
                        class="form-control"
                        id="product"
                        name="product"
                        v-model="productSearch" // This could be the selected product ID
                        @input="searchProduct"
                        @change="onProductChange" // Trigger on change
                        placeholder="Search product"
                    >

                    <div class="table-responsive">
                        <table class="table mt-3 table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th style="max-width: 10em; width: 10em;">Product</th>
                                    <th style="max-width: 50px; width: 50px;">Price</th>
                                    <th style="max-width: 60px; width: 60px;">Quantity</th>
                                    <th style="max-width: 100px; width: 100px;">Total</th>
                                    <th style="max-width: 100px; width: 15px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="product-details">
                                <tr v-for="(product, index) in selectedProducts" :key="index">
                                    <td>
                                        <strong>@{{ product.name }}</strong>
                                        <p>@{{ product.description }}</p>
                                    </td>
                                    <td>@{{ formatCurrency(product.price) }}</td>
                                    <td>
                                        <x-adminlte-input
                                            type="number"
                                            name="quantities[]"
                                            v-model="quantities[index]"
                                            min="1"
                                            class="form-control"
                                            @input="handleQuantityChange(index)"
                                        />
                                    </td>
                                    <td>
                                        @{{ formatCurrency(product.price * quantities[index] || 0) }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" @click="removeProduct(index)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="text-right">
                            <strong>Total Sales: @{{ formatCurrency(totalSales) }}</strong>
                        </div>
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
            <button type="submit" class="btn btn-primary">Add Sale</button>
        </div>
    </form>
</div>
@stop
@push('js')
<script>
    const addSale = createApp({
        setup() {
            // Reactive references
            const selectedProducts = ref([]); // Array to hold selected products
            const quantities = ref([]); // Array to hold quantities for each selected product
            const products = ref([]); // This should be populated with your products array from the API
            const client = ref('');
            const clientData = ref('');
            const clientId = '{{ $client->id ?? null }}'; // Use null if client ID is not set
            const searchQuery = ref('');
            const productSearch = ref('');
            // Reactive state to hold product details
            const productDetails = ref([]);

            onMounted(() => {

                // Conditionally fetch client data if the client ID exists
                if (clientId) {
                    fetchClient(clientId);
                }
            });

            const totalSales = computed(() => {
                return selectedProducts.value.reduce((acc, product, index) => {
                    const total = (product.price || 0) * (quantities.value[index] || 0);
                    return acc + total;
                }, 0);
            });

            // Function to handle adding a new product row
            const addProduct = () => {
                quantities.value.push(1); // Add a default quantity of 1
            };

            function onProductChange(event) {
                addProduct(); // Adds a new product
            }

            // Method to initialize product search with typeahead
            const searchProduct = () => {
                const path = "{{ route('search-product') }}";

                // Initialize typeahead on the #product input
                $('#product').typeahead({
                    minLength: 2, // Start searching after typing 2 characters
                    highlight: true, // Highlight matching results

                    // Fetch the data from the server when a user types in the input
                    source: function (query, process) {
                        // Use debounce to limit how frequently search requests are sent
                        clearTimeout(this.searchTimeout);
                        this.searchTimeout = setTimeout(() => {
                            $.get(path, { query: query }, function (data) {
                                process(data); // Pass data to the typeahead process
                            }).fail(function () {
                                console.error('Error fetching products'); // Handle server errors
                            });
                        }, 300); // Delay of 300ms before making the request
                    },

                    // Define how to display the suggestions in the dropdown
                    displayText: function (item) {
                        return item.name; // Display product name in the dropdown
                    },

                    // Handle the event when a suggestion is selected
                    afterSelect: async function (item) {
                        // Check if the product is already in the list
                        const existingProduct = selectedProducts.value.find(product => product.id === item.id);
                        console.log(selectedProducts);

                        if (existingProduct) {
                            // If the product already exists, increase its quantity by 1
                            existingProduct.quantity += 1;

                            // Update the quantities array to match the updated quantity in selectedProducts
                            const index = selectedProducts.value.findIndex(product => product.id === item.id);
                            quantities.value[index] = existingProduct.quantity;
                        } else {
                            // If the product doesn't exist, add it to the selectedProducts array with a default quantity of 1
                            selectedProducts.value.push({ ...item, quantity: 1 });
                            quantities.value.push(1); // Add the default quantity to the quantities array
                        }

                        // Clear the search input after adding the product
                        productSearch.value = '';
                    }.bind(this),
                });
            };


            const searchClient = () => {
                const path = "{{ route('search-client') }}";

                // Initialize typeahead on the #client input
                $('#client').typeahead({
                    minLength: 2, // Start searching after typing 2 characters
                    highlight: true, // Highlight matching results

                    // Fetch the data from the server when a user types in the input
                    source: function (query, process) {
                        return $.get(path, { query: query }, function (data) {
                            return process(data);
                        });
                    },
                    // Define how to display the suggestions in the dropdown
                    displayText: function (item) {
                        return item.client_name; // Display client name as the suggestion
                    },
                    // Handle the event when a suggestion is selected
                    afterSelect: function (item) {
                        // Update the Vue component data with the selected client's information
                        this.client = item; // Set the client data to the selected item
                        fetchClient(item.id); // Fetch additional client details if needed
                    }.bind(this), // Ensure proper context within Vue.js
                });
            };

            const formatCurrency = (value) => {
                return `K ${Number(value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            };

            const validateQuantity = (index) => {
                if (quantities.value[index] < 1) {
                    quantities.value[index] = 1; // Reset to minimum allowed value
                }
            };

            const handleQuantityChange = (index) => {
                // Validate the quantity to ensure it's not less than the minimum allowed value
                validateQuantity(index);

                // Retrieve the product from the selectedProducts array using the index
                const product = selectedProducts.value[index];
                if (product) {
                    // Update the total based on the new quantity
                    product.total = product.price * product.quantity; // Calculate the new total
                }

                // Optionally, you can update any computed properties that rely on these quantities
            };



            const removeProduct = (index) => {
                // Remove the product ID and quantity at the specified index
                selectedProducts.value.splice(index, 1);
                quantities.value.splice(index, 1);
            };


            const notification = ($text, $icon) =>{
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    html: $text,
                    showConfirmButton: false,
                    timer: 5500,
                    timerProgressBar: true,
                    icon: $icon,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                      }
                  });
            }

            // Function to fetch client data
            const fetchClient = (clientId) => {
                axios.post(`/fetch-client`, { clientId: clientId })
                    .then(response => {
                        clientData.value = response.data.data;
                        client.value = clientData.value.client_name;
                    })
                    .catch(error => {

                    });
            };

            function onClientChange(event){

            }

            return {
                selectedProducts,
                quantities,
                addProduct,
                productDetails,
                totalSales,
                products,
                formatCurrency,
                client,
                searchClient,
                searchProduct,
                clientId,
                onClientChange,
                clientData,
                onProductChange,
                searchQuery,
                removeProduct,
                productSearch,
                validateQuantity,
                handleQuantityChange
            };
        }
    });

    addSale.mount('#addSale');
</script>
@endpush
