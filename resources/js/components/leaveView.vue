<template>
    <div class="container-fluid">
        <div class="row p-4">
            <h1>{{ monthName }} {{ year }}</h1>
        </div>

        <!-- Status Cards -->
        <div class="row p-4">
            <div class="col-md-4" v-for="(count, status) in statusCounts" :key="status">
                <div class="card text-white bg-secondary mb-1">
                    <div class="card-body">
                        <h5 class="card-title">{{ status }}</h5>
                        <p class="card-text">{{ count }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mass Approve/Disapprove Buttons -->
        <div class="row p-4">
            <div class="col-md-12 mb-3">
                <button @click="massApprove" class="btn btn-success">Mass Approve</button>
                <button @click="massDisapprove" class="btn btn-danger">Mass Disapprove</button>
            </div>
        </div>

        <!-- Leaves Table -->
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
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    props: ['initialYear', 'initialMonth'],
    setup(props) {
        const year = ref(props.initialYear);
        const month = ref(props.initialMonth);
        const leaves = ref([]);
        const statusCounts = ref({
            Approved: 0,
            Disapproved: 0,
            Pending: 0
        });

        const monthName = computed(() => {
            return new Date(year.value, month.value - 1).toLocaleString('default', { month: 'long' });
        });

        const fetchLeaveData = () => {
            axios.get(`/leave/${year.value}/${month.value}`)
                .then(response => {
                    leaves.value = response.data.leaves;
                    statusCounts.value = {
                        Approved: response.data.approvedRequests,
                        Disapproved: response.data.disapprovedRequests,
                        Pending: response.data.pendingRequests
                    };

                    // Initialize DataTable after fetching data
                    nextTick(() => {
                        $('#leaveTable').DataTable({
                            destroy: true,
                            autoWidth: false,
                            responsive: true
                        });
                    });
                })
                .catch(error => console.error('Error fetching leave data:', error));
        };

        const massApprove = async () => {
            try {
                const response = await axios.post(`/leave/${uuid.value}/mass-approve`);
                updateCounts(response.data);
                alert('Mass approval successful!');
            } catch (error) {
                console.error('Error approving leaves:', error);
            }
        };

        const massDisapprove = async () => {
            try {
                const response = await axios.post(`/leave/${uuid.value}/mass-disapprove`);
                updateCounts(response.data);
                alert('Mass disapproval successful!');
            } catch (error) {
                console.error('Error disapproving leaves:', error);
            }
        };

        const updateCounts = (data) => {
            statusCounts.value.Approved = data.approvedRequests;
            statusCounts.value.Disapproved = data.disapprovedRequests;
            statusCounts.value.Pending = data.totalRequests;
        };

        onMounted(() => {
            fetchLeaveData();
        });

        return {
            leaves,
            statusCounts,
            monthName,
            massApprove,
            massDisapprove
        };
    }
};
</script>
