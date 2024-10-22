<div>
    <!-- Modal Background Overlay -->
    <div v-if="showPayrollModal" class="modal-backdrop fade" :class="{ show: showPayrollModal }"></div>

    <!-- Modal Dialog -->
    <div class="modal fade" :class="{ show: showPayrollModal }" v-if="showPayrollModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="display: block;">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Payroll Details</h3>
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
                            <div class="row" v-if="data && data.client">
                            <p>
                                <strong>For client:</strong> @{{ data.client.client_name }}
                                <strong>Month/Year:</strong> @{{ data.group }}
                                <strong>Status:</strong> @{{ data.status }}
                            </p>
                                <div class="row">
                                    <!-- Employees Count -->
                                    <div class="col-md-3">
                                        <div class="small-box bg-light">
                                        <div class="inner">
                                            <h4>@{{ data.employees.length }}</h4>
                                            <p>Employees</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Total Gross -->
                                    <div class="col-md-3">
                                        <div class="small-box bg-light">
                                        <div class="inner">
                                            <h4>@{{ totalGross }}</h4>
                                            <p>Total Gross</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Total Net -->
                                    <div class="col-md-3">
                                        <div class="small-box bg-light">
                                        <div class="inner">
                                            <h4>@{{ totalNet }}</h4>
                                            <p>Total Net</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Total Paye -->
                                    <div class="col-md-3">
                                        <div class="small-box bg-light">
                                        <div class="inner">
                                            <h4>@{{ totalPaye }}</h4>
                                            <p>Total Paye</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Total Deductions -->
                                    <div class="col-md-3">
                                        <div class="small-box bg-light">
                                        <div class="inner">
                                            <h4>@{{ totalDeductions }}</h4>
                                            <p>Total Deductions</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-minus-circle"></i>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Total Earnings -->
                                    <div class="col-md-3">
                                        <div class="small-box bg-light">
                                        <div class="inner">
                                            <h4>@{{ totalEarnings }}</h4>
                                            <p>Total Earnings</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-plus-circle"></i>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Total Paid -->
                                    <div class="col-md-3">
                                        <div class="small-box bg-light">
                                        <div class="inner">
                                            <h4>@{{ totalPaid }}</h4>
                                            <p>Total Paid</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    @include('../payroll/includes/employeesPayrollTable')
                                </div>
                            </div>
                        </div>
                        <p v-if="error">@{{ error }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" @click="changeStatus('Approved', data.id)">Approve</button>
            <button type="button" class="btn btn-default" @click="closeModal">Close</button>
            </div>
        </div>
        </div>
    </div>
</div>

<div>
    <!-- Modal Background Overlay -->
    <div v-if="showEmployeePayModal" class="modal-backdrop fade" :class="{ show: showEmployeePayModal }"></div>

    <!-- Modal Dialog -->
    <div class="modal fade" :class="{ show: showEmployeePayModal }" v-if="showEmployeePayModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="display: block;">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div v-if="!loading && data">
                        @{{ employeeData.employees[0].fname }}
                        @{{ employeeData.employees[0].mname }}
                        @{{ employeeData.employees[0].sname }} Payroll Details
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
                        <div v-if="!loading && employeeData">
                            <div class="row" v-if="employeeData && employeeData.employees[0]">
                                <table class="table">
                                    <tr>
                                        <th>Employee</th>
                                        <td>@{{ employeeData.employees[0].fname }} @{{ employeeData.employees[0].mname }} @{{ employeeData.employees[0].sname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Month/Year</th>
                                        <td>@{{ employeeData.group }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>@{{ employeeData.status }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gross Salary</th>
                                        <td>@{{ formatCurrency(employeeData.employees[0].pivot.salary) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Paye</th>
                                        <td>@{{ formatCurrency(employeeData.employees[0].pivot.payee) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Net Salary</th>
                                        <td>@{{ formatCurrency(employeeData.employees[0].pivot.net_salary) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Earnings</th>
                                        <td>@{{ employeeData.employees[0].pivot.earning_description }} - @{{ formatCurrency(employeeData.employees[0].pivot.earning_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Deductions</th>
                                        <td>@{{ employeeData.employees[0].pivot.deduction_description || 'N/A' }} - @{{ formatCurrency(employeeData.employees[0].pivot.deduction_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Paid</th>
                                        <td>@{{ formatCurrency(employeeData.employees[0].pivot.total_paid) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Paid on</th>
                                        <td>@{{ employeeData.payroll_date || '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method</th>
                                        <td>@{{ employeeData.payment_method || '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <p v-if="error">@{{ error }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" @click="employeePayslip(employeeData.employees[0].id, employeeData.employees[0].pivot.payroll_id, 1)">Dowload Payslip</button>
            <button type="button" class="btn btn-default" @click="closeEmployeePayModal">Close</button>
            </div>
        </div>
        </div>
    </div>
</div>
