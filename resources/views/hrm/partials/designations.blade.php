<div id="designations" v-if="showDesignations" :class="{ show: showDesignations }">
    <div class="d-flex justify-content-center align-items-center flex-column" style="min-height: 200px;" v-if="loading">
        <p class="spinner"></p>
        <p>
            Loading data, please wait...
        </p>
    </div>
    <div v-if="!loading && designations.length > 0">
        <div class="table-responsive container-fluid">
            <table id="designationsTable" class="table table-bordered table-striped table-vcenter w-100 display nowrap">
                <thead>
                    <tr>
                        <th style="min-width: 150px;">Name</th>
                        <th style="min-width: 50px;">Description</th>
                        <th style="min-width: 50px;">Employees</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="designation in designations" :key="designation.id">
                        <td class="font-w600">
                            @{{ designation.name }}
                        </td>
                        <td>
                            @{{ designation.description }}
                        </td>
                        <td>
                            @{{ designation.employees.length }}
                        </td>
                        <td class="text-center">
                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn btn-default" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="d-sm-inline-block">Action</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end p-0">
                                    <div class="p-2">
                                        <!-- View Payroll Link -->
                                        <button class="dropdown-item nav-main-link" @click="designationDetails(designation.id)">
                                            <i class="nav-main-link-icon fas fa-eye"></i>
                                            <span class="btn">View</span>
                                        </button>

                                        <!-- Edit designation -->
                                        <button class="dropdown-item nav-main-link btn" @click="editDesignation(designation)">
                                            <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                                            <span class="btn">Edit</span>
                                        </button>

                                        <button class="dropdown-item nav-main-link btn delete-designation-confirm" type="button" @click="confirmDelete(designation.id)">
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
    <div v-if="error">
        <p class="p-5">
            @{{ error }}
        </p>
    </div>

</div>

<div>
    <!-- Modal Background Overlay -->
    <div v-if="showAddDesignationModal" class="modal-backdrop fade" :class="{ show: showAddDesignationModal }"></div>

    <!-- Modal Dialog -->
    <div class="modal fade" :class="{ show: showAddDesignationModal }" v-if="showAddDesignationModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="display: block;">
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
            <button type="button" class="btn btn-default" @click="addDesignation(state.designationId)">@{{ state.buttonName }}</button>
            <button type="button" class="btn btn-default" @click="closeForm">Cancel</button>
            </div>
        </div>
        </div>
    </div>
</div>

