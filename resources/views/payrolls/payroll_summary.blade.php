@extends('adminlte::page')

@section('title', 'Payrolls')

@section('content_header')
    <h1>&nbsp; All Payrolls</h1>
@stop

@section('content')
<div id="appp">
  <div class="col">
    <!-- Payroll Table -->
    <div>
      <table id="myTable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Total </th>
            <th>Date</th>
            <th>Total Employees</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
           <tr
                v-for="payroll in payrollData"
                :key="payroll.period"
                @click="goToPayrollDetails(payroll.period)"
                style="cursor: pointer;"
            >
                <td>@{{ formatMonthYear(payroll.period) }}</td>
                <td>@{{ formatCurrency(payroll.totalNetPay) }}</td>
                <td>@{{ payroll.date }}</td>
                <td>@{{ payroll.recordCount}}</td>
                <td>@{{ payroll.status }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@stop

@include('components.layouts.footer_bottom')

@push('js')
<!-- Vue App Script -->
<script type="module" src="{{ asset('js/payroll.js') }}"></script>
@endpush
