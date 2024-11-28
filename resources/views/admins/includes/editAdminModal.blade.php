<div>
    <!-- Modal Background Overlay -->
    <div v-if="showEditAdminModal" class="modal-backdrop fade" :class="{ show: showEditAdminModal }"></div>

    <!-- Modal Dialog -->
    <div class="modal fade" :class="{ show: showEditAdminModal }" v-if="showEditAdminModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="display: block;">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content mt-5" style="box-shadow:none !important">
            <div class="modal-header">
                <h3>Edit admin @{{ form.first_name }}</h3>
            </div>
            <div class="mb-3 p-4">
                <div class="box-body">
                    @include('admins/includes/adminForm')
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" @click="closeModal">Close</button>
            </div>
        </div>
        </div>
    </div>
</div>
