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
        <tr v-for="leave in leaves" :key="leave.id">
            <td><input type="checkbox" v-model="leave.selected"></td>
            <td>{{ leave.employee_no }}</td>
            <td>{{ leave.Name }}</td>
            <td>{{ leave.Surname }}</td>
            <td>{{ leave.start_date }}</td>
            <td>{{ leave.Type }}</td>
            <td>{{ leave.Status }}</td>
            <td>{{ leave.Reason }}</td>
            <td>
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
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.min.js"></script>
    <script>
       new Vue({
    el: '#app',
    data: {
    leaves: [],
    selectAll: false,
    statusCounts: {
        Approved: 0,
        Disapproved: 0,
        Pending: 0
    }
},
methods: {
    fetchLeaveData() {
        axios.get('/leave')  // Ensure the API call is returning a proper response
            .then(response => {
                // Check if response contains 'leaves' data
                console.log(response.data);  // Debugging response
                this.leaves = response.data.leaves.map(leave => ({
                    ...leave,
                    selected: false, // Add a 'selected' property to each leave for checkbox logic
                    showDropdown: false // Make sure this is initialized if you're using it in the template
                }));
                this.statusCounts = {
                    Approved: response.data.approvedRequests,
                    Disapproved: response.data.disapprovedRequests,
                    Pending: response.data.pendingRequests
                };
            })
            .catch(error => console.error('Error fetching leave data:', error));
    }
,
        toggleSelectAll() {
            this.selectAll = !this.selectAll;
            this.leaves.forEach(leave => {
                leave.selected = this.selectAll; // Make sure 'selected' is being properly updated
            });
        },
        // Toggle the dropdown visibility for a specific leave entry
        toggleDropdown(leaveId) {
        this.leaves = this.leaves.map(leave => ({...leave,
            showDropdown: leave.id === leaveId ? !leave.showDropdown : false
        }));
    },
        getSelectedIds() {
            // Make sure the 'selected' property is being used to filter selected leaves
            return this.leaves.filter(leave => leave.selected).map(leave => leave.id);
        },
        massApprove() {
            const selectedIds = this.getSelectedIds();
            if (selectedIds.length === 0) {
                alert('Please select at least one leave request.');
                return;
            }
            axios.post(`/leave/mass-approve`, { ids: selectedIds })
                .then(response => {
                    this.updateCounts(response.data);
                    alert('Mass approval successful!');
                    this.fetchLeaveData();
                })
                .catch(error => console.error('Error approving leaves:', error));
        },

        massDisapprove() {
            const selectedIds = this.getSelectedIds();
            if (selectedIds.length === 0) {
                alert('Please select at least one leave request.');
                return;
            }
            axios.post(`/leave/mass-disapprove`, { ids: selectedIds })
                .then(response => {
                    this.updateCounts(response.data);
                    alert('Mass disapproval successful!');
                    this.fetchLeaveData(); // Refresh leave data to reflect changes
                })
                .catch(error => console.error('Error disapproving leaves:', error));
        },

        updateCounts(data) {
            this.statusCounts.Approved = data.approvedRequests;
            this.statusCounts.Disapproved = data.disapprovedRequests;
            this.statusCounts.Pending = data.pendingRequests;
        },

        approveLeave(leaveId) {
            axios.post(`/leave/approve/${leaveId}`)
                .then(response => {
                    alert('Leave approved');
                    this.fetchLeaveData(); // Refresh leave data to reflect changes
                })
                .catch(error => console.error('Error approving leave:', error));
        },

        disapproveLeave(leaveId) {
            axios.post(`/leave/disapprove/${leaveId}`)
                .then(response => {
                    alert('Leave disapproved');
                    this.fetchLeaveData(); // Refresh leave data to reflect changes
                })
                .catch(error => console.error('Error disapproving leave:', error));
        },

    }
    mounted() {
    this.fetchLeaveData();
}

});

    </script>
@endpush
