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
                            <x-adminlte-input
                                name="fdf"
                                label="dfdfg"
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
                            <x-adminlte-input
                                name="fdgf"
                                label="'Tax Rate'"
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
</script>
@endpush

