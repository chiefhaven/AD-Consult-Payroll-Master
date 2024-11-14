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
                @include('billing.includes.billDetails')
            <div class="modal-footer">
            <button type="button" class="btn btn-default" @click="printBill()">Print</button>
            <button type="button" class="btn btn-default" @click="closeForm">Cancel</button>
            </div>
        </div>
        </div>
    </div>
</div>
