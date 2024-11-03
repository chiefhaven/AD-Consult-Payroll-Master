<div id="attendances" v-if="showAttendances" :class="{ show: showAttendances }">
    <div v-if="!loading && attendances.length > 0">
        <div class="table-responsive">
            <table id="attendancesTable" class="table table-bordered table-striped table-vcenter display nowrap">
                <thead>
                    <tr>
                        <th style="min-width: 150px;">Employee</th>
                        <th>Employee ID</th>
                        <th>Attendance Date</th>
                        <th>Status</th>
                        <th>Check-In Time</th>
                        <th>Check-Out Time</th>
                        <th>Working Hours</th>
                        <th>Remarks</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="attendance in attendances" :key="attendance.id">
                        <td class="font-w600">
                            @{{ attendance.employee.fname }} @{{ attendance.employee.mname }} @{{ attendance.employee.sname }}
                        </td>
                        <td>
                            @{{ attendance.employee.employee_no }}
                        </td>
                        <td>
                            @{{ attendance.attendance_date }}
                        </td>
                        <td>
                            @{{ attendance.status }}
                        </td>
                        <td>
                            @{{ attendance.check_in_time || 'N/A' }}
                        </td>
                        <td>
                            @{{ attendance.check_out_time || 'N/A' }}
                        </td>
                        <td>
                            @{{ attendance.working_hours || 'N/A' }} hours
                        </td>
                        <td>
                            @{{ attendance.remarks || 'N/A' }}
                        </td>
                        <td class="text-center">
                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn btn-default" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="d-sm-inline-block">Action</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end p-0">
                                    <div class="p-2">
                                        <!-- View Payroll Link -->
                                        <button class="dropdown-item nav-main-link" @click="fetchProductDetails(attendance.id)">
                                            <i class="nav-main-link-icon fas fa-eye"></i>
                                            <span class="btn">View</span>
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
