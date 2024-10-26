<div><!-- Modal Background Overlay -->
    <div class="modal-backdrop fade"></div>

    <!-- Modal Dialog -->
    <div class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="display: block;">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Payroll Details</h3>
            </div>
            <div class="modal-body">
                <div class="mb-3 p-4">
                    <div class="box-body">
                        <div class="d-flex justify-content-center align-items-center flex-column" style="min-height: 200px;">
                            <p class="spinner"></p>
                            <p>
                                Loading data, please wait...
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" @click="">Add payroll</button>
            <button type="button" class="btn btn-default" @click="closeAddPayrollModal">Cancel</button>
            </div>
        </div>
        </div>
    </div>
