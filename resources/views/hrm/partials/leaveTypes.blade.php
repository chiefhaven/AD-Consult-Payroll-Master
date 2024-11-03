<div id="leavetypes" v-if="showLeaveTypes" :class="{ show: showLeaveTypes }">

    <div v-if="!loading && leaveTypes.length > 0">
        <div class="table-responsive container-fluid">
            <table id="leaveTypesTable" class="table table-bordered table-striped table-vcenter w-100 display nowrap">
            <thead>
                <tr>
                <th style="min-width: 150px;">Name</th>
                <th style="min-width: 50px;">Description</th>
                <th class="text-center" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="leaveType in leaveTypes" :key="leaveType.id">
                <td class="font-w600">
                    @{{ leaveType.name }}
                </td>
                <td>
                    @{{ leaveType.description }}
                </td>
                <td class="text-center">
                    <div class="dropdown d-inline-block">
                    <button
                        type="button"
                        class="btn btn-default"
                        :id="'dropdown-' + leaveType.id"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <span class="d-sm-inline-block">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-0">
                        <div class="p-2">
                        <!-- View Leave Type -->
                        <button class="dropdown-item nav-main-link" @click="leavetypeDetails(leaveType.id)">
                            <i class="nav-main-link-icon fas fa-eye"></i>
                            <span class="btn">View</span>
                        </button>

                        <!-- Edit Leave Type -->
                        <button class="dropdown-item nav-main-link btn" @click="editLeaveType(leaveType)">
                            <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                            <span class="btn">Edit</span>
                        </button>

                        <!-- Delete Leave Type -->
                        <button class="dropdown-item nav-main-link btn delete-leaveType-confirm" type="button" @click="confirmLeaveTypeDelete(leaveType.id)">
                            <i class="nav-main-link-icon fas fa-trash-alt"></i>
                            <span class="btn">Delete</span>
                        </button>
                        </div>
                    </div>
                    </div>
                </td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
    <div v-if="!loading && leaveTypes.length <= 0">
        <p class="text-center">No leave types available</p>
    </div>

    <div v-if="error">
        <p class="p-5">
            @{{ error }}
        </p>
    </div>

</div>

<div>
    <!-- Modal Background Overlay -->
    <div v-if="showAddLeaveTypeModal" class="modal-backdrop fade" :class="{ show: showAddLeaveTypeModal }"></div>

    <!-- Modal Dialog -->
    <div class="modal fade" :class="{ show: showAddLeaveTypeModal }" v-if="showAddLeaveTypeModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="display: block;">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>@{{ state.modalTitle }}</h3>
            </div>
            <div class="modal-body">
                <div class="mb-3 p-4">
                    <div class="box-body">
                        <x-adminlte-input
                            type="text"
                            name="name"
                            v-model="state.name"
                            label="Name"
                            placeholder="Name"
                            fgroup-class="col-md-12"
                            class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                            id="name"
                            autocomplete="off"
                        />

                        <x-adminlte-textarea
                            type="text"
                            name="description"
                            v-model="state.description"
                            label="Description"
                            placeholder="Description"
                            fgroup-class="col-md-12"
                            class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                            autocomplete="off"
                        ></x-adminlte-textarea>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" @click="addLeaveType(state.leaveTypeId)">@{{ state.buttonName }}</button>
            <button type="button" class="btn btn-default" @click="closeForm">Cancel</button>
            </div>
        </div>
        </div>
    </div>
</div>

