@extends('adminlte::page')

{{-- Extend and customize the browser title --}}
@section('title', 'View Client')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

{{-- Extend and customize the page content header --}}
@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title', 'adminlte')
            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card p-5 mt-3">
            <div class="row">
                <div class="col-md-3">
                    @if (isset($client->client_logo))
                        <img src="/img/{{ $client->client_logo }}" height="auto" width="100%">
                    @else
                        <img src="/img/logo-placeholder.png" height="auto" width="100%">
                    @endif
                </div>
                <div class="col-md-1"><p>&nbsp;</p></div>
                <div class="col-md-8">
                    <h2 class="fw-bold">{{ $client->client_name }}</h2>
                    <div class="text-bold">Slogan</div>
                    <p class="">
                        <div class="">Address: {{ $client->address }}</div>
                        <div class="">Phone: {{ $client->phone }}</div>
                        <div class="">Email:
                            @if(isset($client->user->email))
                                {{ $client->user->email }}
                            @else
                                No email set!
                            @endif
                        </div>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <x-adminlte-small-box title="{{ $client->employees->count() }}" text="Employees" icon="fas fa-users" theme="light"/>
            </div>
            <div class="col-md-4">
                <x-adminlte-small-box title="K0.00" text="Unpaid Invoices" icon="fas fa-file-invoice" theme="light"/>
            </div>
            <div class="col-md-4">
                <x-adminlte-small-box title="0" text="Tickets" icon="fa-regular fas fa-file-invoice" theme="light"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 pl-3">
                <div class="row">
                    <div class="col-md-12 mb-4 card p-3">
                        <div class="row pb-4">
                            <div class="col-md-6 d-flex justify-content-start">
                                <div class="h4"><strong>Employees</strong></div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="dropdown d-inline-block">
                                    <button type="button" class="btn btn-primary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="d-sm-inline-block">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end p-0">
                                        <div class="p-2">
                                            <a class="dropdown-item nav-main-link btn" href="{{ route('add-employee', $client) }}">
                                                <i class="fa fa-plus me-2"></i>
                                                <span class="btn">Add Employee</span>
                                            </a>

                                            <a class="dropdown-item nav-main-link btn" href="{{ route('export-employees', [$client, 'csv']) }}">
                                                <i class="nav-main-link-icon fas fa-download"></i>
                                                <span class="btn">Export CSV</span>
                                            </a>

                                            <a class="dropdown-item nav-main-link btn" href="{{ route('export-employees', [$client, 'pdf']) }}">
                                                <i class="nav-main-link-icon fas fa-download"></i>
                                                <span class="btn">Export PDF</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('/employees/includes/employeeTable')
                    </div>
                    <div class="col-md-12 card p-3">
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start">
                                <div class="h4"><strong>Payrolls</strong></div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary pull-right mb-4" data-toggle="modal" data-target="#payroll_modal">
                                        <i class="fa fa-plus"></i>
                                        Add Payroll
                                    </button>
                            </div>
                        </div>
                        @include('../payroll/includes/payrollTable')
                    </div>

                    <div class="col-md-12 card p-3">
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start">
                                <div class="h4"><strong>Billing</strong></div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <a class="btn btn-primary pull-right mb-4" href="/add-sale?client={{ $client->id }}">
                                    <i class="fa fa-plus"></i>
                                    Add Sale
                                </a>
                            </div>
                        </div>
                        @include('../billing/includes/clientBillingTable')
                    </div>
                </div>
            </div>
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-3 card p-5">
                Upcoming Events
            </div>
        </div>
    </div>
</div>
@stop

@include('/components/layouts/footer_bottom')

{{-- Add common Javascript/Jquery code --}}
@push('js')
<script>
    $(document).ready(function() {
        $('.delete-payroll-confirm').on('click', function (e) {
            e.preventDefault(); // Prevent default button behavior
            var form = $(this).closest('form'); // Get the closest form element
            Swal.fire({
                title: 'Delete Payroll',
                text: 'Do you want to delete this payroll? This action cannot be undone!',
                icon: 'warning', // Use warning icon
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });

        $('.delete-employee-confirm').on('click', function (e) {
            e.preventDefault(); // Prevent default button behavior
            var form = $(this).closest('form'); // Get the closest form element
            Swal.fire({
                title: 'Delete Employee',
                text: 'Do you want to delete this employee? This action cannot be undone!',
                icon: 'warning', // Use warning icon
                showCancelButton: true,
                confirmButtonText: 'Yes, delet!',
                cancelButtonText: 'No, keep'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });

        $('#employeeTable').DataTable({
            scrollX: true,
            scrollY: true,
        });

        $('#payrollTable').DataTable({
            dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
            scrollX: true,
            scrollY: true,
        });

        $("#payroll_month_year").datepicker({
            format: "MM yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

        document.querySelector('.select-all').addEventListener('click', function() {
            let select = document.getElementById('employees');
            for (let option of select.options) {
                option.selected = true;
            }
            $(select).trigger('change'); // Trigger change event to update the Select2 component
        });

        document.querySelector('.deselect-all').addEventListener('click', function() {
            let select = document.getElementById('employees');
            for (let option of select.options) {
                option.selected = false;
            }
            $(select).trigger('change'); // Trigger change event to update the Select2 component
        });
    });
</script>
<script>

    const app = createApp({
      setup() {
        const showPayrollModal = ref(false);  // Modal hidden by default
        const showEmployeePayModal = ref(false);  // Modal hidden by default
        const data = ref(null);        // Store payroll data
        const employeeData = ref(null);        // Store employee payroll data
        const loading = ref(false);    // Manage loading state
        const error = ref(null);       // Store error messages

        // Open the payroll details modal and fetch payroll data
        const fetchPayrollDetails = (payroll) => {
          showPayrollModal.value = true;
          fetchData(payroll);  // Fetch data when the modal opens
        };

        // Close the modal
        const closeModal = () => {
            data.value = null
            showPayrollModal.value = false;
        };

        // Fetch Payroll details
        const fetchData = async (payroll) => {
            loading.value = true;
            error.value = null;
            try {
                const response = await axios.get(`/view-payroll/${payroll}`);
                if (response.data && response.data.length > 0) {
                    data.value = response.data[0];  // Access the first object in the response array

                    console.log(response.data)
                } else {
                    error.value = "No data found for the provided payroll ID.";
                }
            } catch (err) {
                error.value = "Failed to fetch payroll data";
            } finally {
                loading.value = false;
            }
        };

        // Open the payroll details modal and fetch payroll data
        const employeePayDetails = (employee, payroll) => {
            showEmployeePayModal.value = true;
            showPayrollModal.value = false;
            fetchEmployeePayDetails(employee, payroll);  // Fetch data when the modal opens
        };

        // Fetch Employee Payroll details
        const fetchEmployeePayDetails = async (employee, payroll) => {
            loading.value = true;
            error.value = null;
            try {
                const response = await axios.get(`/view-employee-payroll/${employee}/${payroll}`);
                if (response.data && response.data.length > 0) {
                    employeeData.value = response.data[0];  // Access the first object in the response array
                    console.log(response.data);
                } else {
                    error.value = "No data found for the provided payroll ID.";
                }
            } catch (err) {
                error.value = "Failed to fetch payroll data";
            } finally {
                loading.value = false;
            }
        };

        // Close the modal
        const closeEmployeePayModal = () => {
            showEmployeePayModal.value = false;
            showPayrollModal.value = true;
        };

        const changeStatus = (status, payrollId) => {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to change the status to ${status}. This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an API call to change the status
                    axios.post('/change-payroll-status', { status, payroll: payrollId })
                        .then(response => {
                            notification('Payroll status updated successfully, page', 'success');
                                    // Refresh the page
                            location.reload(); // Reloads the current page
                        })
                        .catch(error => {
                            // Handle error response
                            console.error('Error updating payroll status:', error);
                            notification('Failed to update payroll status.', 'error');
                        });
                }
            });
        };

        const openStatusDialog = (payrollId, currentStatus) => {
            Swal.fire({
                title: 'Change Payroll Status',
                text: `Current status: ${currentStatus}`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Paid',
                showDenyButton: true,
                denyButtonText: 'Ask Approval',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    changeStatus('Paid', payrollId);
                } else if (result.isDenied) {
                    changeStatus('Pending Approval', payrollId);
                }
            });
        };

        // Computed properties for different totals
        const totalGross = computed(() => {
            const total = data.value?.employees?.reduce((sum, emp) => sum + parseFloat(emp.pivot.salary || 0), 0) || 0;

            return formatCurrency(total);
        });

        const totalNet = computed(() => {
            const total = data.value?.employees?.reduce((sum, emp) => sum + parseFloat(emp.pivot.net_salary || 0), 0) || 0;

            return formatCurrency(total);
        });

        const totalPaye = computed(() => {
            const total = data.value?.employees?.reduce((sum, emp) => sum + parseFloat(emp.pivot.payee || 0), 0) || 0;

            return formatCurrency(total);
        });

        const totalPaid = computed(() => {
            const total = data.value?.employees?.reduce((sum, emp) => sum + parseFloat(emp.pivot.total_paid || 0), 0) || 0;

            return formatCurrency(total);
        });

        const totalDeductions = computed(() => {
            const total = data.value?.employees?.reduce((sum, emp) => sum + parseFloat(emp.pivot.deduction_amount || 0), 0) || 0;

            return formatCurrency(total);
        });

        const formatCurrency = (value) => {
            return `K ${Number(value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        };

        const totalEarnings = computed(() => {
            const total = data.value?.employees?.reduce((sum, emp) => sum + parseFloat(emp.pivot.earning_amount || 0), 0) || 0;

            return formatCurrency(total);
        });

        const proceed = () => {
            // Add your logic to proceed here
            console.log("Proceed button clicked");
        };

        const notification = ($text, $icon) =>{
            Swal.fire({
                toast: true,
                position: "top-end",
                html: $text,
                showConfirmButton: false,
                timer: 5500,
                timerProgressBar: true,
                icon: $icon,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                  }
              });
        }

        return {
            showPayrollModal,
            data,
            employeeData,
            loading,
            error,
            totalGross,
            totalNet,
            totalPaye,
            totalPaid,
            totalDeductions,
            totalEarnings,
            closeModal,
            proceed,
            fetchPayrollDetails,
            closeEmployeePayModal,
            showEmployeePayModal,
            employeePayDetails,
            formatCurrency,
            changeStatus,
            openStatusDialog
        };
      },
    });

    app.mount('#viewClient');
</script>
@endpush

{{-- Add common CSS customizations --}}
@push('css')
<style type="text/css">
    .card {
        border-radius: none;
    }
    .card-title {
        font-weight: 600;
    }
</style>
@endpush
