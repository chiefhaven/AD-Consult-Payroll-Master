<div>
    <!-- Modal Background Overlay -->
    <div v-if="showBillModal" class="modal-backdrop fade" :class="{ show: showBillModal }"></div>

    <!-- Modal Dialog -->
    <div class="modal fade" :class="{ show: showBillModal }" v-if="showBillModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="display: block;">
        <div class="modal-dialog  modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Sell details: Invoice number( @{{ billData.invoice_number }})
            </div>
            <div class="modal-body">
                <div class="mb-3 p-4">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <th>Invoice No.:</th>
                                        <td>@{{ billData.invoice_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td class="capitalize">@{{ billData.bill_status }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status:</th>
                                        <td>
                                            <div v-if="balance === 0">
                                                Paid
                                            </div>
                                            <div v-if="totalPayments > 0 && totalPayments < totalPayable">
                                                Partially paid
                                            </div>
                                            <div v-if="totalPayments === 0 && totalPayable > 0">
                                                Not paid
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-5">
                                <table>
                                    <tr>
                                        <th>Client Name:</th>
                                        <td>@{{ billData.client.client_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td>@{{ billData.client.address }}</td>
                                    </tr>
                                    <tr>
                                        <th>City:</th>
                                        <td>@{{ billData.client.city }}</td>
                                    </tr>
                                    <tr>
                                        <th>Country:</th>
                                        <td>@{{ billData.client.country }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>@{{ billData.client.phone }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table>
                                    <tr>
                                        <th>Created:</th>
                                        <td>@{{ formatDate(billData.billing_date) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Due:</th>
                                        <td>@{{ calculateDueDate(billData.billing_date, billData.paymentTerms, billData.termsUnits) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-12 pt-5 pb-3">
                                <h5>Products/services:</h5>
                                <table id="invoicesSalesTable" class="table table-striped table-vcenter display nowrap">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Discount</th>
                                            <th>Tax</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="product in billData.products" :key="product.id">
                                            <td>
                                                <strong>@{{ product.name }}</strong><br>
                                                @{{ product.description }}
                                            </td>
                                            <td>@{{ product.pivot.quantity }}</td>
                                            <td>@{{ formatCurrency(product.pivot.price) }}</td>
                                            <td>@{{ formatCurrency(product.pivot.item_discount) }}</td>
                                            <td>@{{ formatCurrency(product.pivot.tax) }}</td>
                                            <td>@{{ formatCurrency(product.pivot.total) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-8">
                                <div v-if="billData.payments.length > 0">
                                    <strong>Payment information</strong>
                                    <table class="table table-responsive table-striped">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Payment Method</th>
                                                <th>Reference</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="payment in billData.payments" :key="payment.id">
                                                <td>@{{ payment.payment_date }}</td>
                                                <td>@{{ formatCurrency(payment.payment_amount) }}</td>
                                                <td>@{{ payment.payment_method }}</td>
                                                <td>@{{ payment.payment_reference }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td><strong>Total:</strong></td>
                                            <td>@{{ formatCurrency(totalAmount) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tax:</strong></td>
                                            <td>@{{ formatCurrency(totalTax) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Discount:</strong></td>
                                            <td>@{{ formatCurrency(totalDiscount) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Payable:</strong></td>
                                            <td>@{{ formatCurrency(totalPayable) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Paid:</strong></td>
                                            <td>@{{ formatCurrency(totalPayments) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Balance:</strong></td>
                                            <td>@{{ formatCurrency(balance) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" @click="printBill()">Print</button>
            <button type="button" class="btn btn-default" @click="closeForm">Cancel</button>
            </div>
        </div>
        </div>
    </div>
</div>
