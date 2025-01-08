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
          <li v-for="period in periods" :key="period" class="nav-item">
            <button
              class="nav-link"
              :class="{ active: selectedPeriod === period }"
              @click="setPeriod(period)"
            >
              {{ period }}
            </button>
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
          <tr
            v-for="payroll in filteredPayrolls"
            :key="payroll.monthYear"
            @click="goToPayrollDetail(payroll.monthYear)"
            style="cursor: pointer;"
          >
            <td>@{{ formatMonthYear(payroll.monthYear) }}</td>
            <td>@{{ formatCurrency(payroll.totalNetPay) }}</td>
            <td>@{{ payroll.date }}</td>
            <td>@{{ payroll.employeeCount }}</td>
            <td>@{{ payroll.status }}</td>
          </tr>
        </tbody>
      </table>
    </div>
</div>
@stop

@include('components.layouts.footer_bottom')

@push('js')
<script src="https://cdn.jsdelivr.net/npm/vue@3.0.0/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

<script>
const { createApp, ref, computed } = Vue;

const Payrolls = {
  setup() {
    const periods = ["Monthly", "Bi-Weekly", "Weekly"]; // Make sure these match the backend keys
    const selectedPeriod = ref("Monthly");
    const payrollData = ref(@json($groupedPayrolls)); // Pass validated JSON data from Laravel

    const filteredPayrolls = computed(() => {
      const data = payrollData.value[selectedPeriod.value];
      if (!data) return [];
      return Object.entries(data).map(([monthYear, records]) => ({
        monthYear,
        totalNetPay: records.reduce((sum, record) => sum + record.net_pay, 0),
        employeeCount: records.length,
        status: records.every((record) => record.status === "Draft") ? "Draft" : "Paid",
        date: moment(monthYear, "Y-M").format("YYYY-MM-DD"),
      }));
    });

    const setPeriod = (period) => {
      selectedPeriod.value = period;
    };

    const goToPayrollDetail = (monthYear) => {
      const url = `{{ route('payrolls.group', ['monthYear' => ':monthYear']) }}`.replace(
        ":monthYear",
        monthYear
      );
      window.location.href = url;
    };

    const formatMonthYear = (monthYear) => moment(monthYear, "Y-M").format("MMMM YYYY");

    const formatCurrency = (amount) =>
      new Intl.NumberFormat("en-MW", {
        style: "currency",
        currency: "MWK",
      }).format(amount);

    return {
      periods,
      selectedPeriod,
      payrollData,
      filteredPayrolls,
      setPeriod,
      goToPayrollDetail,
      formatMonthYear,
      formatCurrency,
    };
  },
};

createApp(Payrolls).mount("#app");
</script>


