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
            @{{ period }}
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

<script type="module" src="{{ asset('js/payroll.js') }}"></script>
@endpush
