<div id="leaves" v-if="showLeaves" :class="{ show: showLeaves }">

    <div v-if="!loading && leaves.length > 0">
        <div class="table-responsive">
            <table id="leavesTable" class="table table-bordered table-striped table-vcenter display nowrap">
            <thead>
                <tr>
                <th style="min-width: 150px;">Employee Name</th>
                <th style="min-width: 150px;">Applied on</th>
                <th style="min-width: 150px;">Start date</th>
                <th style="min-width: 150px;">End date</th>
                <th style="min-width: 50px;">Reason</th>
                <th style="min-width: 50px;">Status</th>
                <th style="min-width: 50px;">Approval date</th>
                <th style="min-width: 50px;">Approval by</th>
                <th class="text-center" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="leave in leaves" :key="leave.id">
                <td class="font-w600">
                    @{{ leave.employee.fname }}
                    @{{ leave.employee.mname }}
                    @{{ leave.employee.sname }}
                </td>
                <td>
                    @{{ leave.created_at }}
                </td>
                <td>
                    @{{ leave.start_date }}
                </td>
                <td>
                    @{{ leave.end_date }}
                </td>
                <td>
                    @{{ leave.reason }}
                </td>
                <td>
                    @{{ leave.status }}
                </td>
                <td>
                    @{{ leave.approval_date }}
                </td>
                <td>
                    @{{ leave.approved_by_user.username }}<br>
                    <div class="small text-muted">
                        @{{ leave.approved_by_user.email }}
                    </div>
                </td>
                <td class="text-center">
                    <div class="dropdown d-inline-block">
                    <button
                        type="button"
                        class="btn btn-default"
                        :id="'dropdown-' + leave.id"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <span class="d-sm-inline-block">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-0">
                        <div class="p-2">
                        <!-- View Leave Details -->
                        <button class="dropdown-item nav-main-link" @click="leaveDetails(leave.id)">
                            <i class="nav-main-link-icon fas fa-eye"></i>
                            <span class="btn">View</span>
                        </button>

                        <button class="dropdown-item nav-main-link" @click="leaveApproval(leave.id)">
                            <i class="nav-main-link-icon fas fa-check-circle"></i>
                            <span class="btn">Approval Status</span>
                        </button>

                        {{--  <!-- Edit Leave -->
                        <button class="dropdown-item nav-main-link btn" @click="editLeave(leave)">
                            <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                            <span class="btn">Edit</span>
                        </button>

                        <!-- Delete Leave -->
                        <button class="dropdown-item nav-main-link btn delete-leave-confirm" type="button" @click="confirmLeaveDelete(leave.id)">
                            <i class="nav-main-link-icon fas fa-trash-alt"></i>
                            <span class="btn">Delete</span>
                        </button>  --}}
                        </div>
                    </div>
                    </div>
                </td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
    <div v-if="!loading && leaves.length <= 0">
        <p class="text-center">No leaves available</p>
    </div>
    <div v-if="error">
        <p class="p-5">
            @{{ error }}
        </p>
    </div>

</div>
