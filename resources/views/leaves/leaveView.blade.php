@extends('adminlte::page')

@section('title', 'Leave')

@section('content_header')
    <h1 class="text-muted">
        Leave Management
    </h1>
    @push('css')
        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.min.css"> --}}
        <!-- Bootstrap CSS -->
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

        <!-- Bootstrap JavaScript -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}

        <style>
        #leaveDatail.modal {
            position: fixed !important;
        }
        </style>


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
    {{-- <div class="row pt-4">
        <div class="col-md-12 mb-3">
            <button @click="massApprove" type="button" class="btn btn-success">Mass Approve</button>
            <button @click="massDisapprove" type="button" class="btn btn-danger">Mass Disapprove</button>
        </div>
    </div> --}}

    <!-- Data table -->

    <div class="row mt-1">
            <table id="leavesTable" class="display">
                <thead>
                    <tr>
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
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="#"
                                            data-toggle="modal"
                                            data-target="#leaveDatail"
                                            @click.prevent="viewLeaveDetails(leave)"
                                            {{-- data-url="{{ route('leaveDetail', ['id' => $leave->id]) }}" --}}
                                        >
                                            View
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

    
    </div>

    {{-- modal code here --}}
    <div
    class="modal fade text-left"
    id="leaveDatail"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    v-if="selectedLeave"

    >

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _('Leave Details') }}</h4>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                    @click="closeModal"
                    >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <div class="row p-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col md-6">
                                                <div class="card p-2">
                                                   <h5>Employee ID</h5>
                                                    <p>  @{{ selectedLeave.employee_no }}</p>
                                                </div>
                                            </div>

                                            <div class="col md-6">
                                                <div class="card p-2">
                                                    <h5>Name</h5>
                                                    <p>@{{ selectedLeave.Name }}  @{{ selectedLeave.Surname }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h6>Leave Type</h6>
                                                <p class="card p-2">@{{ selectedLeave.Type }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <h6>Status</h6>
                                                <p class="card p-2">@{{ selectedLeave.Status }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <h6>Application Date</h6>
                                                <p class="card p-2"> @{{ selectedLeave.start_date }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6>Reason here</h6>
                                                <p class="card p-2">@{{ selectedLeave.Reason }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6>Leave Records</h6>
                                                <p>records here</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>



</div>
{{-- @include('leaves.leaveDetail') --}}
@endsection

@include('/components/layouts/footer_bottom')

{{-- @push('js')
    <script>
        $(document).ready(function() {
            $('#LeaveTable').DataTable({
                autoWidth: false,
                responsive: true
                // paging: true,
                // search: true,
                // ordering: true,
                // info: true,
                // lengthChange: true,
                // pageLength: 10,
            });
        });
    </script>
@endpush --}}

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
                const selectedLeave = ref(null);
                const statusCounts = ref({
                    Approved: 0,
                    Disapproved: 0,
                    Pending: 0,
                });

                const fetchLeaveData = () => {
                    NProgress.start();
                    return axios.get(`/leaves/leavesData`)
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

                // const initializeDataTable = () => {
                // $('#leaveTable').DataTable().clear().destroy();  // Destroy the previous instance
                // $('#leaveTable').DataTable();  // Reinitialize the table with the updated data
                //     }


                // const fetchLeaveData = () => {
                //     // Fetch all leave data
                // };

                const viewLeaveDetails = (leave) => {
                selectedLeave.value = leave; // Update the selected leave
                // $('#leaveDatail').modal('show'); // Show the modal

                };

                // $('#leaveDatail').on('hide.bs.modal', () => {
                const closeModal = () => {
                selectedLeave.value = null; // Clear the data when the modal is closed
                };


                // const viewLeaveDetails = (leave) => {
                // selectedLeave.value = leave; // Set the selected leave details
                // };

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

                // const massApprove = () => processLeaves('mass-approve');
                // const massDisapprove = () => processLeaves('mass-disapprove');

               

            //     const approveLeave = (id) => {
            //         NProgress.start();
            //         axios.post(`{{ route('leaves.approve', '') }}/${id}`)
            //         .then(response => {
            //             updateCounts(response.data);
            //             notification(`Approval successful!`, 'success');
            //             fetchLeaveData().then(() => {
            //             initializeDataTable(); // Reinitialize only after content is updated
            //             });
            //         })
            //         .catch(error => {
            //             console.error('Error approving leave:', error);
            //         });
            // };

             const approveLeave = (id) => { 
                axios.post(`{{ route('leaves.approve', '') }}/${id}`)
                .then(response => {
                    // Update the counts based on the server response
                    updateCounts(response.data);
                    
                    // Show a notification that the disapproval was successful
                    notification(`Approval successful!`, 'success');
                    
                    // Fetch updated leave data and reinitialize the DataTable
                    fetchLeaveData().then(() => {
                        initializeDataTable(); // Reinitialize the DataTable with the updated data
                    });
                })
                .catch(error => {
                    console.error('Error disapproving leave:', error);
                });
            };


            const disapproveLeave = (id) => {
            
                return axios.post(`{{ route('leaves.disapprove', '') }}/${id}`)
                .then(response => {
                    // Update the counts based on the server response
                    updateCounts(response.data);
                    
                    // Show a notification that the disapproval was successful
                    notification(`Disapproval successful!`, 'success');
                    
                    // Fetch updated leave data and reinitialize the DataTable
                    fetchLeaveData().then(() => {
                initializeDataTable(); // Reinitialize the DataTable with the updated data
            });

                })
                .catch(error => {
                    console.error('Error disapproving leave:', error);
                });
                
            };


            const updateCounts = (data) => {
                                statusCounts.value = {
                                    Approved: data.approvedRequests,
                                    Disapproved: data.disapprovedRequests,
                                    Pending: data.pendingRequests,
                                };
                            };
            // This function updates the counts in the component's state
// const updateCounts = (counts) => {
//     // Update the status counts (approved, disapproved, pending)
//     this.statusCounts = counts;  // Ensure that 'this.statusCounts' is the right variable storing the counts
// };


            
const initializeDataTable = () => {
    try {
        // Destroy existing DataTable instance if it exists
        if ($.fn.DataTable.isDataTable('#leavesTable')) {
            $('#leavesTable').DataTable().clear().destroy();
        }

        // Use Vue's $nextTick to ensure DOM updates are complete
        Vue.nextTick(() => {
            $('#leavesTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print'],
                scrollX: true,
                scrollY: true,
                paging: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                ordering: true,
                autoWidth: false,
            });
        });
    } catch (error) {
        console.error('Error initializing DataTable:', error);
    }
};


                onMounted(() => {
                        fetchLeaveData();
                        initializeDataTable();
                            });


                return {
                    leaves,
                    selectAll,
                    statusCounts,
                    fetchLeaveData,
                    toggleSelectAll,
                    toggleDropdown,
                    getSelectedIds,
                    // massApprove,
                    // massDisapprove,
                    approveLeave,
                    disapproveLeave,
                    selectedLeave,
                    viewLeaveDetails,
                    closeModal,
                    initializeDataTable
                };
            },
        });

        app.mount('#app');
    </script>
@endpush

