<div>
    <!-- Modal Background Overlay -->
    <div v-if="showAddPaymentModal" class="modal-backdrop fade" :class="{ show: showAddPaymentModal }"></div>

    <!-- Modal Dialog -->
    <div class="modal fade" :class="{ show: showAddPaymentModal }" v-if="showAddPaymentModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="display: block;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Add payment</h4><br>
                </div>
                <div class="modal-body" style="overflow-y: auto;">
                    Invoice number: @{{ billData.invoice_number }}
                    <form @submit.prevent="savePayment(billData.id)" class="p-3">
                        <div class="row">
                            <!-- Paid Amount -->
                            <div class="col-md-12">
                                <x-adminlte-input
                                    name="amountToPay"
                                    id="amountToPay"
                                    v-model="state.amountToPay"
                                    type="number"
                                    step="1"
                                    autocomplete="off"
                                    class="{{ $errors->has('amountToPay') ? 'is-invalid' : '' }}"
                                    label="Amount:"
                                />
                                <div class="small text-muted pb-3">
                                    <span :class="{ 'text-danger': state.amountToPay > totalPayable || state.amountToPay < 0 }">
                                        Maximum payable is @{{ formatCurrency(totalPayable) }}
                                    </span> |
                                    <span :class="{'text-danger': balance - state.amountToPay != 0}">
                                        Balance: @{{ formatCurrency(balance - state.amountToPay) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Payment Date -->
                            <x-adminlte-input
                                name="payment_date"
                                id="payment_date"
                                type="date"
                                fgroup-class="col-md-12"
                                autocomplete="off"
                                class="{{ $errors->has('payment_date') ? 'is-invalid' : '' }}"
                                v-model="state.payment_date"
                                label="Payment date:"
                            />

                            <!-- Payment Method -->
                            <x-adminlte-select
                                name="payment_method"
                                v-model="state.payment_method"
                                fgroup-class="col-md-12"
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
                            <div class="col-md-12" v-if="state.payment_method === 'cheque' || state.payment_method === 'bank_transfer'">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="savePayment(billData.id)">Save</button>
                </form>
                <button type="button" class="btn btn-default" @click="closeForm">Cancel</button>
                </div>
            </div>
        </div>
    </div>

</div>
