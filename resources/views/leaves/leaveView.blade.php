@extends('adminlte::page')

@section('title', 'Leave')

@section('content_header')
    <h1 class="text-muted">
        Leave Management
    </h1>
    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.min.css">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap JavaScript -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}

    @endpush
@stop

@section('content')

<!-- Vue app container for Leave View component -->
<div id="app">
    <div class="row p-4">
        <div class="col-md-4">
            <!-- Total Requests Card -->
            <div class="card text-white bg-secondary mb-1">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <p class="card-text">{{ $pendingRequests }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Approved Requests Card -->
            <div class="card text-white bg-secondary mb-1">
                <div class="card-body">
                    <h5 class="card-title">Approved</h5>
                    <p class="card-text">{{ $approvedRequests }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Disapproved Requests Card -->
            <div class="card text-white bg-secondary mb-1">
                <div class="card-body">
                    <h5 class="card-title">Disapproved</h5>
                    <p class="card-text">{{ $disapprovedRequests }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mass Approve and Disapprove Buttons -->
    <div class="row p-4">
        <div class="col-md-12 mb-3">
            <button @click="massApprove" type="button" class="btn btn-success">Mass Approve</button>
            <button @click="massDisapprove" type="button" class="btn btn-danger">Mass Disapprove</button>
        </div>
    </div>

    <!-- Data table -->
    <div class="row p-4 mt-1">
        <table id="leaveTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th><input type="checkbox" @click="toggleSelectAll" :checked="selectAll"></th>
            <th>Employee ID</th>
            <th>First Name</th>
            <th>Surname</th>
            <th>Start Date</th>
            <th>Type</th>
            <th>Status</th>
            <th>Reason</th>
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
            <td> </td>
        </tr>
<div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" @click="toggleDropdown(leave.id)">
                        Actions
                    </button>
                    <div v-if="leave.showDropdown">
                        <ul>
                            <li><a href="#" @click="approveLeave(leave.id)">Approve</a></li>
                            <li><a href="#" @click="disapproveLeave(leave.id)">Disapprove</a></li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>

    </div>
</div>

@endsection

@include('/components/layouts/footer_bottom')


@push('js')

    <script>

    const { ref, onMounted, createApp } = Vue;

    const app = createApp({
        setup() {
            const leaves = ref([]);
            const selectAll = ref(false);
            const statusCounts = ref({
                Approved: 0,
                Disapproved: 0,
                Pending: 0,
            });

            // Fetch leave data from the API
            const fetchLeaveData = () => {
                axios.get('leaves/leaveView')
                    .then(response => {
                        console.log(response.data); // Debugging response
                        leaves.value = response.data.leaves.map(leave => ({
                            ...leave,
                            selected: false, // Add a 'selected' property for checkbox logic
                            showDropdown: false, // Initialize dropdown visibility
                        }));
                        statusCounts.value = {
                            Approved: response.data.approvedRequests,
                            Disapproved: response.data.disapprovedRequests,
                            Pending: response.data.pendingRequests,
                        };
                    })
                    .catch(error => console.error('Error fetching leave data:', error));
            };

            // Toggle all checkboxes
            const toggleSelectAll = () => {
                selectAll.value = !selectAll.value;
                leaves.value.forEach(leave => {
                    leave.selected = selectAll.value;
                });
            };

            // Toggle the dropdown visibility for a specific leave entry
            const toggleDropdown = (leaveId) => {
                leaves.value = leaves.value.map(leave => ({
                    ...leave,
                    showDropdown: leave.id === leaveId ? !leave.showDropdown : false,
                }));
            };

            // Get the IDs of all selected leaves
            const getSelectedIds = () => {
                return leaves.value.filter(leave => leave.selected).map(leave => leave.id);
            };

            // Mass approve selected leave requests
            const massApprove = () => {
                const selectedIds = getSelectedIds();
                if (selectedIds.length === 0) {
                    alert('Please select at least one leave request.');
                    return;
                }
                axios.post(`/leave/mass-approve`, { ids: selectedIds })
                    .then(response => {
                        updateCounts(response.data);
                        alert('Mass approval successful!');
                        fetchLeaveData();
                    })
                    .catch(error => console.error('Error approving leaves:', error));
            };

            // Mass disapprove selected leave requests
            const massDisapprove = () => {
                const selectedIds = getSelectedIds();
                if (selectedIds.length === 0) {
                    alert('Please select at least one leave request.');
                    return;
                }
                axios.post(`/leave/mass-disapprove`, { ids: selectedIds })
                    .then(response => {
                        updateCounts(response.data);
                        alert('Mass disapproval successful!');
                        fetchLeaveData();
                    })
                    .catch(error => console.error('Error disapproving leaves:', error));
            };

            // Update the leave status counts
            const updateCounts = (data) => {
                statusCounts.value = {
                    Approved: data.approvedRequests,
                    Disapproved: data.disapprovedRequests,
                    Pending: data.pendingRequests,
                };
            };

            // Approve a single leave request
            const approveLeave = (leaveId) => {
                axios.post(`/leave/approve/${leaveId}`)
                    .then(response => {
                        alert('Leave approved');
                        fetchLeaveData();
                    })
                    .catch(error => console.error('Error approving leave:', error));
            };

            // Disapprove a single leave request
            const disapproveLeave = (leaveId) => {
                axios.post(`/leave/disapprove/${leaveId}`)
                    .then(response => {
                        alert('Leave disapproved');
                        fetchLeaveData();
                    })
                    .catch(error => console.error('Error disapproving leave:', error));
            };

            // Fetch leave data when the component is mounted
            onMounted(() => {
                console.log('onMounted');
                fetchLeaveData();
            });

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

    // Mount the app to the DOM
    app.mount('#app');

    </script>
@endpush
