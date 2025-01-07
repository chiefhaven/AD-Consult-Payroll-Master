@extends('adminlte::page')

@section('title', 'Payrolls')

@section('content_header')
    <h1>&nbsp; All Payrolls</h1>
@stop

@section('content')
<div id="app">
    <div class="col">
        <div class="row mb-2">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="#" @click.prevent="setPeriod('Monthly')" :class="{'active': period === 'Monthly'}">Monthly</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" @click.prevent="setPeriod('Bi-Weekly')" :class="{'active': period === 'Bi-Weekly'}">Bi-Weekly</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" @click.prevent="setPeriod('Weekly')" :class="{'active': period === 'Weekly'}">Weekly</a>
                </li>
            </ul>
        </div>

        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Total (MWK)</th>
                    <th>Date</th>
                    <th>Total Employees</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(data, monthYear) in filteredPayrolls" :key="monthYear" @click="goToPayrollDetail(monthYear)">
                    <td>@{{ formatMonthYear(monthYear) }}</td>
                    <td>@{{ formatCurrency(data.total_net_pay) }}</td>
                    <td>@{{ formatDate(monthYear) }}</td>
                    <td>@{{ data.employee_count }}</td>
                    <td>@{{ data.status }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@stop

@include('/components/layouts/footer_bottom')

@push('js')
{{-- <script src="https://cdn.jsdelivr.net/npm/vue@3.0.0/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script> --}}
<script>
   const app = Vue.createApp({
    data() {
        return {
            period: 'Monthly', // Default period
            payrollData: @json($groupedPayrolls), // Laravel data
        };
    },
    computed: {
        filteredPayrolls() {
            console.log(this.payrollData); // Log the entire payroll data
            return this.payrollData[this.period] || {};
        }
    },
    methods: {
        setPeriod(newPeriod) {
            this.period = newPeriod; // Set the selected period
            console.log(this.payrollData[this.period]); // Inspect the filtered data
        },
        goToPayrollDetail(monthYear) {
            window.location.href = '{{ route('payrolls.group', ['monthYear' => ':monthYear']) }}'.replace(':monthYear', monthYear);
        },
        formatMonthYear(monthYear) {
            return moment(monthYear, 'Y-M').format('MMMM YYYY');
        },
        formatCurrency(amount) {
            return new Intl.NumberFormat('en-MW', { style: 'currency', currency: 'MWK' }).format(amount);
        },
        formatDate(monthYear) {
            return moment(monthYear, 'Y-M').format('YYYY-MM-DD');
        }
    },
    mounted() {
        // Check if payrollData is populated correctly
        console.log(this.payrollData); // Log the payroll data when the component is mounted
    }
});

app.mount('#app');

</script>
@endpush
