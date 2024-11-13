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

                        <div class="col-md-6">
                            <div class="row groupHaven">
                                <x-adminlte-input
                                    type="text"
                                    name="paymentTerms"
                                    v-model="state.paymentTerms"
                                    label="Payment terms:"
                                    placeholder="Payment terms"
                                    fgroup-class="col-md-7 pr-0"
                                    class="{ 'is-invalid': errors.has('paymentTerms') } left-field"
                                    autocomplete="off"
                                />
                                <x-adminlte-select2
                                    name="state.termsUnits"
                                    v-model="state.termsUnits"
                                    label="-"
                                    fgroup-class="col-md-5 pl-0"
                                    class="{ 'is-invalid': $errors->has('termsUnits') } right-field"
                                    data-placeholder="Select an option..."
                                    autocomplete="off">
                                    <option value="" disabled>Please select...</option>
                                    <option>Days</option>
                                    <option>Months</option>
                                </x-adminlte-select2>
                            </div>
                        </div>

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
                                    <th style="max-width: 7em; width: 7em;">Tax</th>
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
                                        <x-adminlte-select
                                            name="taxes"
                                            v-model="taxes[index]"
                                            class="form-control"
                                            autocomplete="off"
                                            @input="handleRowChanges(index)"
                                        >
                                            <option value="None">None</option>
                                            <option value="VAT">VAT</option>
                                        </x-adminlte-select>
                                    </td>
                                    <td>
                                        @{{ formatCurrency( product.total ) }}
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
            <p>Add payment</p>
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
                    name="amountToPay"
                    v-model="state.amountToPay"
                    fgroup-class="col-md-4"
                    class="{{ $errors->has('amountToPay') ? 'is-invalid' : '' }}"
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
                <div class="col-md-4" v-if="state.amountToPay === 'cheque' || state.amountToPay === 'bank_transfer'">
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
        <div class="col-md-12" :class="{ 'text-danger': balance > 0 }">
            Balance: @{{ formatCurrency( balance ) }}
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Add Sale</button>
    </div>
</form>
