@extends('adminlte::page')

@section('title', 'Edit bill')

@section('content_header')
    <h1>Edit bill</h1>
@stop

@section('content')
<div id="editSale" v-cloak>
    @include('billing.includes.form')
</div>
@stop
@push('js')
<script>
    const editSale = createApp({
        setup() {
            // Reactive references
            const selectedProducts = ref([]); // Array to hold selected products
            const quantities = ref([]); // Array to hold quantities for each selected product
            const itemDiscounts = ref([]); // Array to hold discounts for each selected product
            const taxes = ref([]); // Array to hold tax names for each selected product
            const taxAmounts = ref([]);
            const products = ref([]); // This should be populated with your products array from the API
            const client = ref('');
            const clientData = ref('');
            const clientId = ref('{{ $client->id ?? null }}'); // Use ref to make clientId reactive
            const searchQuery = ref('');
            const productSearch = ref('');
            const productDetails = ref([]);
            const balance = ref(0);
            const bill = ref({});
            const paidAoumt = ref(0);

            const state = ref({
                saleDate: '',
                paymentTerms: 0,
                termsUnits: '',
                status: 'Draft',
                notes: '',
                payment_method: '',
                amountToPay: 0,
                chequeAccountNumber: '',
            });

            onMounted(() => {
                // Conditionally fetch client data if the client ID exists
                if (clientId.value) {
                    fetchClient(clientId.value);
                }

                if ('{{ $billing->id }}') {
                    clientId.value = {!! json_encode($billing->client_id) !!};

                    fetchClient(clientId.value);

                    paidAoumt.value = {!! json_encode($billing->payments->sum('payment_amount')) !!};

                    balance.value = totalSales.value - paidAoumt.value;

                    selectedProducts.value = {!! json_encode($billing->products) !!};

                    state.value.saleDate = {!! json_encode($billing->billing_date) !!};
                    state.value.paymentTerms = {!! json_encode($billing->paymentTerms) !!};
                    state.value.termsUnits = {!! json_encode($billing->termsUnits) !!};
                    state.value.status = {!! json_encode($billing->bill_status) !!};

                    quantities.value = {!! json_encode($billing->products->map(function($product) {
                        return $product->pivot->quantity;
                    })) !!};

                    product.total = {!! json_encode($billing->products->map(function($product) {
                        return $product->pivot->total;
                    })) !!};

                    taxes.value = {!! json_encode($billing->products->map(function($product) {
                        // Check if taxType exists and is not 'None'
                        return $product->pivot->taxType && $product->pivot->taxType !== 'None'
                            ? \App\Models\TaxRate::find($product->pivot->taxType)->tax_name ?? 'None'
                            : 'None';
                    })) !!};

                    itemDiscounts.value = {!! json_encode($billing->products->map(function($product) {
                        return $product->pivot->item_discount;  // Extract the item_discount value from pivot
                    })) !!};

                    // If you want to update product totals, you might loop through selectedProducts
                    selectedProducts.value.forEach((product, index) => {
                        // Assuming you want to update product total for each product
                        // Update each product's total here
                        product.total = product.pivot.total;  // or any other logic you need
                    });
                }
            });

            const taxRates = {
                VAT: 0.165, // Define VAT as 16.5%
                None: 0,    // Define None as 0%
            };

            const totalSales = computed(() => {
                return selectedProducts.value.reduce((total, product, index) => {
                    // Get the tax rate based on the product's tax type
                    const taxType = taxes.value[index] || "None";
                    const taxRate = taxRates[taxType] || 0;

                    // Safely retrieve quantity, discount, and price values, defaulting to 0 if they are missing
                    const quantity = parseFloat(quantities.value[index]) || 0;
                    const discount = parseFloat(itemDiscounts.value[index]) || 0;
                    const price = parseFloat(product.price) || 0;

                    // Calculate the base total for each product, taking quantity and discount into account
                    const baseTotal = (price * quantity) - discount;

                    // Calculate the total including tax
                    const lineTotal = baseTotal * (1 + taxRate);

                    // Accumulate the lineTotal for each product into the overall total
                    return total + lineTotal;
                }, 0);
            });

            // Function to handle adding a new product row
            const addProduct = () => {
                if (products.value.length > 0) {
                    selectedProducts.value.push({ ...products.value[0], quantity: 1, discount: 0, tax: 'None' });
                    quantities.value.push(1);
                    itemDiscounts.value.push(0);
                    taxes.value.push('None');
                }
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
                    balance.value = totalSales.value - amountToPay.value - paidAoumt.value;

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

    editSale.mount('#editSale');
</script>
@endpush
