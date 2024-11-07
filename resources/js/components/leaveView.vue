<template>
    <div class="container-fluid">
        <div class="row p-4">
            <h1>{{ monthName }} {{ year }}</h1>
        </div>

        <div class="row p-4">
            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-1">
                    <div class="card-body">
                        <h5 class="card-title">Total</h5>
                        <p class="card-text">{{ totalRequests }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-1">
                    <div class="card-body">
                        <h5 class="card-title">Approved</h5>
                        <p class="card-text">{{ approvedRequests }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-1">
                    <div class="card-body">
                        <h5 class="card-title">Disapproved</h5>
                        <p class="card-text">{{ disapprovedRequests }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row p-4">
            <div class="col-md-12 mb-3">
                <button @click="massApprove" class="btn btn-success">Mass Approve</button>
                <button @click="massDisapprove" class="btn btn-danger">Mass Disapprove</button>
            </div>
        </div>

        <div class="row p-4 mt-1">
            <table id="leaveTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>First Name</th>
                        <th>Surname</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="leave in leaves" :key="leave.id">
                        <td>{{ leave.employee_no }}</td>
                        <td>{{ leave.Name }}</td>
                        <td>{{ leave.Surname }}</td>
                        <td>{{ leave.start_date }}</td>
                        <td>{{ leave.end_date }}</td>
                        <td>{{ leave.Type }}</td>
                        <td>{{ leave.status }}</td>
                        <td>{{ leave.Reason }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: ['initialYear', 'initialMonth'],
    data() {
        return {
            year: this.initialYear,
            month: this.initialMonth,
            leaves: [],
            totalRequests: 0,
            approvedRequests: 0,
            disapprovedRequests: 0,
            pendingRequests: 0
        };
    },
    computed: {
        monthName() {
            return new Date(this.year, this.month - 1).toLocaleString('default', { month: 'long' });
        }
    },

    methods: {
        fetchLeaveData() {
            axios.get(`/leave/${this.year}/${this.month}`)
                .then(response => {
                    this.leaves = response.data.leaves;
                    this.totalRequests = this.leaves.length;
                    this.approvedRequests = response.data.approvedRequests;
                    this.disapprovedRequests = response.data.disapprovedRequests;
                    this.pendingRequests = response.data.pendingRequests;

                    // Initialize or reinitialize DataTables
                    this.$nextTick(() => {
                        $('#leaveTable').DataTable({
                            destroy: true,  // Reinitialize table
                            autoWidth: false,
                            responsive: true
                        });
                    });
                })
                .catch(error => {
                    console.error("There was an error fetching the leave data:", error);
                });
        },

        // Mass approve method
        async massApprove() {
            try {
                const response = await axios.post(`/leave/${this.year}/${this.month}/mass-approve`);
                this.updateCounts(response.data);  // Update counts from response
                alert('Mass approval successful!');
            } catch (error) {
                console.error('Error approving leaves:', error);
            }
        },

        // Mass disapprove method
        async massDisapprove() {
            try {
                const response = await axios.post(`/leave/${this.year}/${this.month}/mass-disapprove`);
                this.updateCounts(response.data);  // Update counts from response
                alert('Mass disapproval successful!');
            } catch (error) {
                console.error('Error disapproving leaves:', error);
            }
        },

        // Update the counts after mass approval/disapproval
        updateCounts(data) {
            this.approvedRequests = data.approvedRequests;
            this.disapprovedRequests = data.disapprovedRequests;
            this.totalRequests = data.totalRequests;
        }
    },

    mounted() {
        this.fetchLeaveData();
    }
};
</script>

<style scoped>
/* Add any custom styles here */
</style>
