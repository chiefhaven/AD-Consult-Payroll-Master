<div id="designations" v-show="showDesignations">
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
                            0
                        </td>
                        <td class="text-center">
                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn btn-default" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="d-sm-inline-block">Action</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end p-0">
                                    <div class="p-2">
                                        <!-- View Payroll Link -->
                                        <button class="dropdown-item nav-main-link" @click="fetchProductDetails(designation.id)">
                                            <i class="nav-main-link-icon fas fa-eye"></i>
                                            <span class="btn">View</span>
                                        </button>

                                        <!-- Edit designation -->
                                        <a class="dropdown-item nav-main-link btn" href="#">
                                            <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                                            <span class="btn">Edit</span>
                                        </a>

                                        <!-- Delete Designation Form -->
                                        <form class="dropdown-item nav-main-link" method="POST" :action="'/delete-designation/' + designation.id">
                                            @csrf
                                            @method('DELETE')
                                            <i class="nav-main-link-icon fas fa-trash-alt"></i>
                                            <button class="btn delete-designation-confirm" type="submit">Delete</button>
                                        </form>
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
