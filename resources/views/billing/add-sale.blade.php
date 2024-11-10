@extends('adminlte::page')

@section('title', 'Add Sale')

@section('content_header')
    <h1>Add Sale</h1>
@stop

@section('content')
<div id="addSale" v-cloak>
    <form @submit.prevent="postOrder">
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

                            <x-adminlte-input
                                type="date"
                                name="saleDate"
                                v-model="state.saleDate"
                                label="Sale date:"
                                placeholder="Sale date"
                                fgroup-class="col-md-6"
                                class="{ 'is-invalid': errors.has('sale_date') }"
                                autocomplete="off"
                            />

                            <x-adminlte-input
                                type="date"
                                name="due_date"
                                v-model="state.dueDate"
                                label="Due date:"
                                placeholder="Due date"
                                fgroup-class="col-md-6"
                                class="{ 'is-invalid': errors.has('due_date') }"
                                autocomplete="off"
                            />

                            <x-adminlte-select2
                                name="state.status"
                                v-model="state.status"
                                label="Status:"
                                fgroup-class="col-md-6"
                                class="{ 'is-invalid': $errors->has('status') }"
                                data-placeholder="Select an option..."
                                autocomplete="off">
                                <option value="" disabled>Please select an option...</option>
                                <option>Draft</option>
                                <option>Final</option>
                            </x-adminlte-select2>

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
                    <div class="col-md-12 block block-content">
                        <div class="table-responsive">
                            <table class="table mt-3 table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th style="max-width: 15em; width: 15em;">Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Item Discount</th>
                                        <th>Tax</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="product-details">
                                    <tr v-for="(product, index) in selectedProducts" :key="index">
                                        <td>
                                            <strong>@{{ product.name }}</strong>
                                            <p>@{{ product.description }}</p>
                                        </td>
                                        <td>
                                            <x-adminlte-input
                                                type="number"
                                                name="quantities[]"
                                                v-model="quantities[index]"
                                                min="1"
                                                class="form-control"
                                                @input="handleRowChanges(index)"
                                            />
                                        </td>
                                        <td>@{{ formatCurrency(product.price) }}</td>
                                        <td>
                                            <x-adminlte-input
                                                type="number"
                                                name="itemDiscounts[]"
                                                v-model="itemDiscounts[index]"
                                                min="0"
                                                class="form-control"
                                                @input="handleRowChanges(index)"
                                            />
                                        </td>
                                        <td>
                                            <x-adminlte-select2
                                                name="taxes"
                                                v-model="taxes[index]"
                                                class="form-control"
                                                autocomplete="off"
                                                @change="handleRowChanges(index)"
                                            >
                                                <option value="None">None</option>
                                                <option value="VAT">VAT</option>
                                            </x-adminlte-select2>
                                        </td>
                                        <td>
                                            @{{ formatCurrency(product.total || 0 ) }}
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
        </div>

        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Payment details</p>
                <div class="row">
                    <!-- Paid Amount -->
                    <x-adminlte-input
                        name="paid_amount"
                        id="paid_amount"
                        v-model="state.paid_amount"
                        type="number"
                        step="0.01"
                        fgroup-class="col-md-4"
                        autocomplete="off"
                        class="{{ $errors->has('paid_amount') ? 'is-invalid' : '' }}"
                        label="Paid amount:"
                    />

                    <!-- Payment Date -->
                    <x-adminlte-input
                        name="payment_date"
                        id="payment_date"
                        type="date"
                        fgroup-class="col-md-4"
                        autocomplete="off"
                        class="{{ $errors->has('payment_date') ? 'is-invalid' : '' }}"
                        v-model="state.payment_date"
                        label="Payment date:"
                    />

                    <!-- Payment Method -->
                    <x-adminlte-select
                        name="payment_method"
                        v-model="state.payment_method"
                        fgroup-class="col-md-4"
                        class="{{ $errors->has('payment_method') ? 'is-invalid' : '' }}"
                        label="Payment method:"
                    >
                        <option value="" disabled selected>Select Payment Method</option>
                        <option value="cash">Cash</option>
                        <option value="cheque">Cheque</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="online">Online</option>
                    </x-adminlte-select>

                    <!-- Cheque Number (conditionally shown) -->
                    <div class="col-md-4" v-if="state.payment_method === 'cheque' || state.payment_method === 'bank_transfer'">
                        <x-adminlte-input
                            v-model="state.chequeAccountNumber"
                            name="chequeAccountNumber"
                            id="chequeAccountNumber"
                            type="text"
                            autocomplete="off"
                            class="{{ $errors->has('chequeAccountNumber') ? 'is-invalid' : '' }}"
                            label="Cheque/Account Number:"
                        />
                    </div>

                    <!-- Notes -->
                    <x-adminlte-textarea
                        name="notes"
                        id="notes"
                        fgroup-class="col-md-12"
                        autocomplete="off"
                        class="{{ $errors->has('notes') ? 'is-invalid' : '' }}"
                        v-model="state.notes"
                        rows="3"
                        label="Notes:"
                    />
                </div>
            </div>
            <div class="col-md-12" :class="{ 'text-danger': totalSales - state.paid_amount > 0 }">
                Balance: @{{ formatCurrency(totalSales - state.paid_amount) }}
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
            const itemDiscounts = ref([]); // Array to hold quantities for each selected product
            const taxes = ref([]); // Array to hold quantities for each selected product
            const taxAmounts = ref([]);
            const products = ref([]); // This should be populated with your products array from the API
            const client = ref('');
            const clientData = ref('');
            const clientId = '{{ $client->id ?? null }}'; // Use null if client ID is not set
            const searchQuery = ref('');
            const productSearch = ref('');
            const productDetails = ref([]);
            const balance = ref(0);

            const state = ref({
                saleDate: '',
                dueDate: '',
                status:'Draft',
                notes:'',
                paid_amount: 0,
                payment_method: '',
                chequeAccountNumber: '',
            })

            onMounted(() => {

                // Conditionally fetch client data if the client ID exists
                if (clientId) {
                    fetchClient(clientId);
                }
            });


            const totalSales = computed(() => {
                return selectedProducts.value.reduce((total, product, index) => {
                    const taxRate = product.tax === "VAT" ? 0.165 : 0; // Assuming VAT is 16.5%
                    const quantity = quantities.value[index] || 0;
                    const discount = itemDiscounts.value[index] || 0;
                    const price = product.price || 0;

                    // Calculate subtotal with quantity and discount
                    const baseTotal = (price * quantity) - discount;

                    // Apply tax to the baseTotal
                    const lineTotal = baseTotal * (1 + taxRate);

                    return total + lineTotal;
                }, 0);
            });

            // Function to handle adding a new product row
            const addProduct = () => {
                quantities.value.push(1); // Add a default quantity of 1
                itemDiscounts.value.push(0);
                taxes.value.push('None');
            };

            function onProductChange(event) {
                addProduct(); // Adds a new product
            }

            // Method to initialize product search with typeahead
            const searchProduct = () => {

                NProgress.start();
                const path = "{{ route('search-product') }}";

                // Initialize typeahead on the #product input
                $('#product').typeahead({
                    minLength: 2, // Start searching after typing 2 characters
                    highlight: true, // Highlight matching results

                    // Fetch the data from the server when a user types in the input
                    source: function (query, process) {
                        clearTimeout(this.searchTimeout);
                        this.searchTimeout = setTimeout(() => {
                            $.get(path, { query: query }, function (data) {
                                if (!data || data.length === 0) {
                                    notification('No products found, add', 'erro');
                                }

                                process(data);  // Pass data to the typeahead process
                                NProgress.done();
                            }).fail(function () {
                                console.error('Error fetching products');
                                notification("There was an issue fetching the products. Please try again later.", 'error');
                            });
                        }, 300); // Delay of 300ms before making the request
                    },

                    // Define how to display the suggestions in the dropdown
                    displayText: function (item) {
                        return item.name; // Display product name in the dropdown
                    },

                    // Handle the event when a suggestion is selected
                    afterSelect: function (item) {
                        const existingProduct = selectedProducts.value.find(product => product.id === item.id);

                        if (existingProduct) {
                            // If the product already exists, increase its quantity by 1
                            existingProduct.quantity += 1;
                            const index = selectedProducts.value.findIndex(product => product.id === item.id);
                            quantities.value[index] = existingProduct.quantity;
                        } else {
                            // If the product doesn't exist, add it to the selectedProducts array with a default quantity of 1
                            selectedProducts.value.push({ ...item, quantity: 1, discount: 0, tax: 'None', taxAmount: 0 });
                            quantities.value.push(1); // Add the default quantity to the quantities array
                            taxes.value.push('None');
                            taxAmounts.value.push(0);
                        }

                        // Clear the search input after adding the product
                        productSearch.value = '';
                    },
                });

            };

            const searchClient = () => {
                NProgress.start()
                const path = "{{ route('search-client') }}";

                // Initialize typeahead on the #client input
                $('#client').typeahead({
                    minLength: 2, // Start searching after typing 2 characters
                    highlight: true, // Highlight matching results

                    // Fetch the data from the server when a user types in the input
                    source: function (query, process) {
                        return $.get(path, { query: query }, function (data) {


                            if (!data || data.length === 0) {
                                notification('No client found', 'error');
                            }

                            NProgress.done();
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
                return new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'MMK'
                }).format(value);
            };

            const validateQuantity = (index) => {
                if (quantities.value[index] < 1) {
                    quantities.value[index] = 1; // Reset to minimum allowed value
                }
            };

            const validateTax = (index) => {
                if (taxes.value[index] !== "None" && taxes.value[index] !== "Withholding" && taxes.value[index] !== "VAT") {
                    taxes.value[index] = "None"; // Reset to a default allowed value, e.g., "None"
                }
            };

            const validateItemDiscounts = (index) => {
                if (itemDiscounts.value[index] < 1) {
                    itemDiscounts.value[index] = 0; // Reset to minimum allowed value
                }
            };

            const handleRowChanges = (index) => {
                // Validate the quantity to ensure it's not less than the minimum allowed value
                validateQuantity(index);
                validateItemDiscounts(index);

                // Retrieve the product from the selectedProducts array using the index
                const product = selectedProducts.value[index];
                if (product) {
                    // Update the product's quantity, discount, and tax first
                    product.quantity = quantities.value[index];
                    product.discount = itemDiscounts.value[index];
                    product.tax = taxes.value[index];

                    // Define tax rate based on the tax type
                    const taxRate = product.tax === "VAT" ? 0.165 : 0; // Assuming VAT is 16.5%; adjust as necessary

                    // Calculate the total, applying discount and tax
                    const baseTotal = product.price * product.quantity - product.discount;
                    product.total = baseTotal * (1 + taxRate); // Apply tax if applicable
                    product.taxAmount = baseTotal * (taxRate)
                }
            };



            const removeProduct = (index) => {
                // Remove the product ID and quantity at the specified index
                selectedProducts.value.splice(index, 1);
                quantities.value.splice(index, 1);
                itemDiscounts.value.splice(index, 1);
                taxes.value.splice(index, 1);
            };

            const postOrder = async () => {
                NProgress.start();
                try {
                    const response = await axios.put('/store-sale', {
                        client: clientData.value.id,
                        products: selectedProducts.value,
                        state: state.value,
                    });

                    // Handle success
                    if (response.status === 200) {
                        notification('Bill created successfully', 'success');

                        // Optional: Reset form fields here if needed, e.g., form.reset();

                        // Redirect to /all-sales and prevent further actions
                        window.location.href = '/all-sales';
                        return;
                    }
                } catch (error) {
                    // Handle error
                    if (error.response) {
                        notification('Server responded with:', 'error');
                        // Optionally, display error feedback to the user
                    } else {
                        notification('Network error or request was not sent', 'error');
                    }
                } finally{
                    NProgress.done();
                }
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
                        clientId.value = clientData.value.id;
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
                handleRowChanges,
                postOrder,
                state,
                itemDiscounts,
                taxes,
                balance,
            };
        }
    });

    addSale.mount('#addSale');
</script>
@endpush
