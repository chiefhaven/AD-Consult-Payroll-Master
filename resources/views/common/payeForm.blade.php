<!-- Modal -->
<div class="modal fade" id="payBlacket_modal" tabindex="-1" aria-labelledby="payBlacketLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payBlacketLabel">PAYE Brackets</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="updateBrackets">
                    <x-adminlte-card title="Edit PAYE Tax Brackets" theme="light" icon="fas fa-edit" collapsible>
                        <div v-for="(bracket, index) in brackets" :key="index">
                            <!-- Limit Input Field -->
                            <label :for="'limit-' + index">
                                @{{ getLabel(index) }}
                            </label>
                            <input
                                id="'limit-' + index"
                                name="'limit-' + index"
                                v-model="bracket.limit"
                                class="form-control"
                                required
                            />

                            <!-- Tax Rate Input Field -->
                            <x-adminlte-input
                                name="'rate-' + index"
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
        const payeBracket = createApp({
            setup() {
                const brackets = ref([]);

                const fetchBrackets = async () => {
                    try {
                        const response = await axios.get('/paye-brackets');
                        brackets.value = response.data; // Assign the data to brackets
                    } catch (error) {
                        console.error('Error fetching PAYE brackets:', error);
                    }
                };

                // Update PAYE brackets
                const updateBrackets = async () => {
                    try {
                        // Validate brackets before making the request
                        if (!Array.isArray(brackets.value) || brackets.value.length === 0) {
                            alert('No brackets available to update.');
                            return;
                        }

                        // Show a loading indicator (assuming you're using a reactive state for this)
                        //loadingIndicator.value = true; // Update this according to your state management

                        // Make the PUT request to update PAYE brackets
                        const response = await axios.put('/update-paye-brackets', { brackets: brackets.value });

                        if (response.status === 200 ) { // Check for any successful status code
                            notification('PAYE brackets updated successfully', 'success');
                            closeModal(); // Close modal after update
                            // Optionally refresh or update the PAYE brackets list to reflect changes in the UI
                        } else {
                            notification('Unexpected response from the server', 'error');
                        }
                    } catch (error) {
                        console.error('Error updating PAYE brackets:', error);

                        // Check for validation errors from the server response
                        if (error.response && error.response.data && error.response.data.errors) {
                            notification(error.response.data.errors.message || 'Failed to update PAYE brackets.', 'error');
                        } else {
                            notification('An unexpected error occurred while updating PAYE brackets.', 'error');
                        }
                    } finally {
                        // Hide the loading indicator
                        //loadingIndicator.value = false; // Reset loading indicator state
                    }
                };

                function notification($text, $icon){
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

                const getLabel = (index) => {
                    if (index === 0) {
                      return 'The first';
                    }
                    else if (index === brackets.value.length - 1) {
                      return 'In excess of';
                    }
                    else {
                      return 'The next';
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

                onMounted(fetchBrackets);

                return {
                    brackets,
                    updateBrackets,
                    openModal,
                    closeModal,
                    getLabel
                };
            },
        });

        payeBracket.mount('#payBlacket_modal');
    </script>
@endpush

