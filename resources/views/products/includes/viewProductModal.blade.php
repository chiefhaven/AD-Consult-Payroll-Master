<div>
    <!-- Modal Background Overlay -->
    <div v-if="showProductModal" class="modal-backdrop fade" :class="{ show: showProductModal }"></div>

    <!-- Modal Dialog -->
    <div class="modal fade" :class="{ show: showProductModal }" v-if="showProductModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="display: block;">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div v-if="!loading && data">
                        @{{ data.name }} Details
                </div>
            </div>
            <div class="modal-body">
                <div class="mb-3 p-4">
                    <div class="box-body">
                        <div class="d-flex justify-content-center align-items-center flex-column" style="min-height: 200px;" v-if="loading">
                            <p class="spinner"></p>
                            <p>
                                Loading data, please wait...
                            </p>
                        </div>
                        <div v-if="!loading && data">
                            <div class="row" v-if="data">
                                <div>
                                    <h3>@{{ data.name }}</h3>
                                    <p>@{{ data.description }}</p>
                                    <p>Price: @{{ formatCurrency(data.price) }}</p>
                                    <p>VAT applicable: @{{ data.vat }}</p>
                                </div>
                            </div>
                        </div>
                        <p v-if="error">@{{ error }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" @click="closeProductModal">Close</button>
            </div>
        </div>
        </div>
    </div>
</div>
