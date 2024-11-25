<!-- Modal Background Overlay -->
<div v-if="showEditModal" class="modal-backdrop fade" :class="{ show: showEditModal }"></div>

<!-- Modal Dialog -->
<div class="modal fade pt-5 mt-5" :class="{ show: showEditModal }" v-if="showEditModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="display: block;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Role</h5>
                <button type="button" class="btn-close" @click="showEditModal = false"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Role Name</label>
                        <input type="text" id="roleName" v-model="roleName" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h5>Permissions</h5>
                        <div class="row">
                            <div class="col-md-4" v-for="permission in role.permissions" :key="permission.id">
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        :id="'permission-' + permission.id"
                                        :value="permission.id"
                                        v-model="selectedPermissions"
                                    />
                                    <label class="form-check-label" :for="'permission-' + permission.id">
                                        @{{ permission.name }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" @click="showEditModal = false">Close</button>
                <button type="button" class="btn btn-default" @click="saveRole">Save changes</button>
            </div>
        </div>
    </div>
</div>
