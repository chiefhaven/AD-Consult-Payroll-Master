<!-- Modal -->
<div class="modal fade" id="payBlacket_modal" tabindex="-1" aria-labelledby="payBlacketLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payBlacketLabel">Edit PAYE Brackets</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="updateBrackets">
                    <x-adminlte-card title="Edit PAYE Tax Brackets" theme="light" icon="fas fa-edit" collapsible>
                        <div v-for="(bracket, index) in brackets" :key="index">
                            <!-- Limit Input Field -->
                            <x-adminlte-input
                                :name="'limit_' + index"
                                label="Income Limit"
                                v-model="bracket.limit"
                                igroup-size="sm"
                                required
                            >
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-light">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            <!-- Tax Rate Input Field -->
                            <x-adminlte-input
                                :name="'rate_' + index"
                                label="Tax Rate (%)"
                                v-model="bracket.rate"
                                igroup-size="sm"
                                required
                            >
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-light">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        <x-slot name="footerSlot">
                            <x-adminlte-button label="Update PAYE Brackets" theme="primary" icon="fas fa-save" type="submit" />
                        </x-slot>
                    </x-adminlte-card>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">Close</button>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    const { createApp, ref, computed, onMounted } = Vue;

    const payeBracket = createApp({
        setup() {
            const brackets = ref([]);

            // Fetch PAYE brackets from the API
            const fetchBrackets = async () => {
                try {
                    const response = await axios.get('/paye-brackets');
                    brackets.value = response.data;
                } catch (error) {
                    console.error('Error fetching PAYE brackets:', error);
                }
            };

            // Update PAYE brackets
            const updateBrackets = async () => {
                try {
                    await axios.put('/update-paye-brackets', { brackets: brackets.value });
                    alert('PAYE brackets updated successfully!');
                    closeModal(); // Optional: Close modal after update
                } catch (error) {
                    console.error('Error updating PAYE brackets:', error);
                    alert('Failed to update PAYE brackets.');
                }
            };

            // Open modal and fetch brackets
            const openModal = () => {
                fetchBrackets(); // Fetch brackets when opening the modal
                $('#payBlacket_modal').modal('show'); // Show the Bootstrap modal
            };

            // Close modal
            const closeModal = () => {
                $('#payBlacket_modal').modal('hide'); // Hide the Bootstrap modal
            };

            // Fetch data when the component is mounted (optional for initial load)
            onMounted(fetchBrackets); // Optional: You can call this if you want to fetch data immediately

            return {
                brackets,
                updateBrackets,
                openModal,
                closeModal
            };
        },
    });

    payeBracket.mount('#payBlacket_modal');

    //Add Sale App
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

