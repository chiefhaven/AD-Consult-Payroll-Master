@extends('adminlte::page')

@section('title', 'Leave')

@section('content_header')
    <h1 class="text-muted">
        Leave Management
    </h1>
    @push('css')
        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.min.css"> --}}
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap JavaScript -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}

    @endpush
@stop

@section('content')

<!-- Vue app container for Leave View component -->
<div id="app">
    <div class="row">
        <div class="col-md-4">
            <!-- Total Requests Card -->
            <div class="card text-white bg-secondary mb-1">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <p class="card-text">
                        @{{ leaves.filter(leave => leave.Status === 'Pending').length }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Approved Requests Card -->
            <div class="card text-white bg-secondary mb-1">
                <div class="card-body">
                    <h5 class="card-title">Approved</h5>
                    <p class="card-text">
                        @{{ leaves.filter(leave => leave.Status === 'Approved').length }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Disapproved Requests Card -->
            <div class="card text-white bg-secondary mb-1">
                <div class="card-body">
                    <h5 class="card-title">Disapproved</h5>
                    <p class="card-text">
                        @{{ leaves.filter(leave => leave.Status === 'Disapproved').length }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mass Approve and Disapprove Buttons -->
    <div class="row pt-4">
        <div class="col-md-12 mb-3">
            <button @click="massApprove" type="button" class="btn btn-success">Mass Approve</button>
            <button @click="massDisapprove" type="button" class="btn btn-danger">Mass Disapprove</button>
        </div>
    </div>

    <!-- Data table -->
    <div class="row mt-1">
        <div class="box card p-3">
            <table id="leavesTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        {{-- <th><input type="checkbox" @click="toggleSelectAll" :checked="selectAll"></th> --}}
                        <th><input type="checkbox" v-model="selectAll" @change="toggleSelectAll"></th>
                        <th style="min-width: 5em; width: 5em">ID #</th>
                        <th style="min-width: 10em; width: 10em">First Name</th>
                        <th>Surname</th>
                        <th style="min-width: 5em; width: 5em">Start Date</th>
                        <th style="min-width: 10em; width: 10em">Type</th>
                        <th>Status</th>
                        <th style="min-width: 10em; width: 10em">Reason</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="leave in leaves" >
                        <td><input type="checkbox" v-model="leave.selected"></td>
                        <td>@{{ leave.employee_no }}</td>  <!-- Use Vue data properties, not Blade variables -->
                        <td>@{{ leave.Name }}</td>
                        <td>@{{ leave.Surname }}</td>
                        <td>@{{ leave.start_date }}</td>
                        <td>@{{ leave.Type }}</td>
                        <td>@{{ leave.Status }}</td>
                        <td>@{{ leave.Reason }}</td>
                        <td>
                            <div class="dropdown">
    <!-- Bootstrap Dropdown Toggle -->
    <button
        class="btn btn-secondary dropdown-toggle"
        type="button"
        id="dropdownMenuButton"
        data-bs-toggle="dropdown"
        aria-expanded="false"
    >
        Actions
    </button>

    <!-- Bootstrap Dropdown Menu -->
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li>
            <a
                class="dropdown-item"
                href="#"
                @click.prevent="approveLeave(leave.id)"
            >
                Approve
            </a>
        </li>
        <li>
            <a
                class="dropdown-item"
                href="#"
                @click.prevent="disapproveLeave(leave.id)"
            >
                Disapprove
            </a>
        </li>
    </ul>
</div>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@include('/components/layouts/footer_bottom')

@push('js')
    <script>

        const app = createApp({
            setup() {
                    // Axios CSRF token setup
                    axios.defaults.headers.common['X-CSRF-TOKEN'] = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content');

                const leaves = ref([]);
                const selectAll = ref(false);
                const statusCounts = ref({
                    Approved: 0,
                    Disapproved: 0,
                    Pending: 0,
                });

                const fetchLeaveData = () => {
                    NProgress.start();
                    axios.get(`/leaves/leavesData`)
                        .then(response => {
                            leaves.value = response.data;
                            initializeDataTable();
                        })
                        .catch(error => {
                            console.error('Error fetching leave data:', error);
                        })
                        .finally(() => {
                            NProgress.done();
                        });
                };

                const toggleSelectAll = () => {
                    selectAll.value = !selectAll.value;
                    leaves.value.forEach(leave => {
                        leave.selected = selectAll.value;
                    });
                };

                const toggleDropdown = (leave) => {
                    leave.showDropdown = !leave.showDropdown;
                    leaves.value.forEach((l) => {
                        if (l.id !== leave.id) l.showDropdown = false;
                    });
                };


                const getSelectedIds = () => {
                    return leaves.value.filter(leave => leave.selected).map(leave => leave.id);
                };

                const processLeaves = (action) => {
                    const selectedIds = getSelectedIds();
                    if (selectedIds.length === 0) {
                        notification('Please select at least one leave request.', 'error');
                        return;
                    }
                    axios.post(`/leaves/${action}`, { ids: selectedIds })
                        .then(response => {
                            updateCounts(response.data);
                            notification(`Mass ${action} successful!`, 'success');
                            fetchLeaveData();
                        })
                        .catch(error => console.error(`Error in ${action}:`, error));
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

                const massApprove = () => processLeaves('mass-approve');
                const massDisapprove = () => processLeaves('mass-disapprove');

                const updateCounts = (data) => {
                    statusCounts.value = {
                        Approved: data.approvedRequests,
                        Disapproved: data.disapprovedRequests,
                        Pending: data.pendingRequests,
                    };
                };

                const approveLeave = (leaveId) => {
                    axios.post(`{{ route('leaves.approve', '') }}/${leaveId}`)
                    .then(response => {
                        updateCounts(response.data);
                        notification(`Approval successful!`, 'success');
                        fetchLeaveData();
                    })
                    .catch(error => {
                        console.error('Error approving leave:', error);
                    });
            };
               const disapproveLeave = (leaveId) => {
                    axios.post(`{{ route('leaves.disapprove', '') }}/${leaveId}`)
                    .then(response => {
                        updateCounts(response.data);
                        notification(`Disapproval successful!`, 'success');
                        fetchLeaveData();
                    })
                    .catch(error => {
                        console.error('Error disapproving leave:', error);
                    });
            };

            onMounted(() => {
                fetchLeaveData();
            });

            // Function to initialize DataTable after Vue has rendered the table
            // const initializeDataTable = () => {
            //     setTimeout(() => {
            //         $('#leavesTable').DataTable({
            //             dom: 'Bfrtip',
            //             buttons: ['copy', 'excel', 'pdf', 'print'],
            //             scrollX: true,
            //             scrollY: true,
            //         });
            //     }, 0); // Timeout ensures the DOM is ready
            // };

            const initializeDataTable = () => {
    setTimeout(() => {
        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#leavesTable')) {
            $('#leavesTable').DataTable()
        }

        // Reinitialize DataTable
        $('#leavesTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'excel', 'pdf', 'print'],
            scrollX: true,
            scrollY: true,
        });
    }, 0); // Timeout ensures the DOM is ready
};


                return {
                    leaves,
                    selectAll,
                    statusCounts,
                    fetchLeaveData,
                    toggleSelectAll,
                    toggleDropdown,
                    getSelectedIds,
                    massApprove,
                    massDisapprove,
                    approveLeave,
                    disapproveLeave,
                };
            },
        });

        app.mount('#app');
    </script>
@endpush

