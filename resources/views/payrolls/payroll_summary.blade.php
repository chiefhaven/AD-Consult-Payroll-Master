@extends('adminlte::page')

@section('title', 'Payrolls')

@section('content_header')
    <h1>&nbsp; All Payrolls</h1>
@stop

@section('content')
<div id="appp">
  <div class="col">
    <!-- Period Tabs -->
    <div class="row mb-2">
      <ul class="nav nav-tabs">
        <li v-for="period in periods" :key="period" class="nav-item">
          <button
            class="nav-link"
            :class="{ active: selectedPeriod === period }"
            @click="setPeriod(period)"
          >
            @{{ period }}
          </button>
        </li>
      </ul>
    </div>

    <!-- Payroll Table -->
    <div v-if="filteredPayrolls.length > 0">
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
            :key="payroll.period"
            @click="goToPayrollDetail(payroll.period)"
            style="cursor: pointer;"
          >
            <td>@{{ formatMonthYear(payroll.period) }}</td>
            <td>@{{ formatCurrency(payroll.totalNetPay) }}</td>
            <td>@{{ payroll.date }}</td>
            <td>@{{ payroll.records.length }}</td>
            <td>@{{ payroll.status }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- No Data Message -->
    <div v-else>
      <p>No payroll data available for the selected period.</p>
    </div>
  </div>
</div>
@stop

@include('components.layouts.footer_bottom')

@push('js')
<!-- Vue App Script -->
<script type="module" src="{{ asset('js/payroll.js') }}"></script>

{{-- <script>
    console.log('Raw PHP Grouped Payrolls:', @json($groupedPayrolls));
    // Pass grouped payroll data from controller to Vue
    window.groupedPayrolls = @json($groupedPayrolls); --}}
</script>
@endpush
