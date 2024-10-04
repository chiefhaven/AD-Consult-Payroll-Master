<div>
    <!-- Modal Background Overlay -->
    <div v-if="showPayrollModal" class="modal-backdrop fade" :class="{ show: showPayrollModal }"></div>

    <!-- Modal Dialog -->
    <div class="modal fade" :class="{ show: showPayrollModal }" v-if="showPayrollModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="display: block;">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Payroll Details</h3>
            </div>
            <div class="modal-body">
                <div class="mb-3 p-4">
                    <div class="box-body">
                    <p v-if="loading">
                        Loading data, please wait...
                    </p>
                    <div v-if="!loading && data">
                        <div class="row" v-if="data && data.client">
                        <p>
                            For client:@{{ data.client.client_name }}
                            Month/Year:@{{ data.group }}
                            Status:@{{ data.status }}
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
                                        <i class="fas fa-info-circle"></i>
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
                                        <i class="fas fa-info-circle"></i>
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
                                        <i class="fas fa-info-circle"></i>
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
                                        <i class="fas fa-info-circle"></i>
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
                                        <i class="fas fa-info-circle"></i>
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
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @include('../payroll/includes/employeesPayrollTable')

                                </div>
                            </div>
                        </div>
                    </div>
                    <p v-if="error">@{{ error }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="proceed">Edit</button>
            <button type="button" class="btn btn-default" @click="closeModal">Close</button>
            </div>
        </div>
        </div>
    </div>
  </div>
