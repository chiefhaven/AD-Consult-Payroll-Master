@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'View Client')

{{-- Extend and customize the page content header --}}

@section('plugins.Select2', true)

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title', 'adminlte')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
<div class="row" id="payroll" v-cloak>
    <livewire:common.page-header pageTitle="Add payroll" buttonName="Go back" link="/client/{{ $payroll->client->id }}" buttonClass="btn btn-warning"/>
    <div class="col-lg-12">
        @include('includes/error')
        @section('plugins.Select2', true)
        <form action="/update-payroll/{{ $payroll->id }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card mb-3 p-4">
                <div class="box-body">
                    <h3>For Client: <strong>{{ $payroll->client->client_name }}</strong></h3>
                    <div class="row">
                        <x-adminlte-input type="text" name="payrollMonthYear" label="Month/Year:*" placeholder="Month/Year"  value="{{ $payroll->group }}" fgroup-class="col-md-4" class="{{ $errors->has('payroll_month_year') ? 'is-invalid' : '' }}" id="payrollMonthYear" required autocomplete="off"/>

                        <x-adminlte-input name="client" value="{{ $payroll->client->id }}" hidden />

                        <x-adminlte-select
                            name="payrollStatus"
                            label="Status"
                            data-placeholder="Select an option..."
                            fgroup-class="col-md-4"
                            class="{{ $errors->has('status') ? 'is-invalid' : '' }}"
                            autocomplete="off"
                            required
                        >
                            <option value="" disabled>Please select an option...</option>
                            <option value="draft" {{ $payroll->status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="cancelled" {{ $payroll->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="pending_approval" {{ $payroll->status === 'pending_approval' ? 'selected' : '' }}>Pending Approval</option>
                            <option value="final" {{ $payroll->status === 'final' ? 'selected' : '' }}>Final</option>
                        </x-adminlte-select>
                    </div>
                </div>
            </div>
            <div class="card">
                <table class="table" id="payroll_table">
                    <thead>
                        <th>
                            Employee
                        </th>
                        <th>
                            Salary
                        </th>
                        <th>
                            Earnings
                        </th>
                        <th>
                            Deductions
                        </th>
                        <th>
                            Paye
                        </th>
                        <th>
                            Net amount
                        </th>
                    </thead>
                    <tbody>
                        @foreach($payroll->employees as $key => $employee)
                            <tr>
                                <td>
                                    <input name="payroll[{{ $key }}][employee]" value="{{ $employee->id }}" hidden>
                                    {{ $employee->fname }} {{ $employee->mname }} {{ $employee->sname }}
                                </td>
                                <td>
                                    <x-adminlte-input
                                        type="text"
                                        name="payroll[{{ $key }}][salary]"
                                        value="{{ $employee->salary ?? '' }}"
                                        autocomplete="off"
                                    />
                                    <p>
                                        <x-adminlte-select2
                                            name="payroll[{{ $key }}][pay_period]" label="Pay Period:">
                                            <option>{{ $employee->pay_period ?? 'Select Pay Period' }}</option>
                                        </x-adminlte-select2>
                                    </p>
                                </td>

                                <!-- Earnings Section -->
                                <td>
                                    <div class="p-2 mb-3 shadow-sm border-primary">
                                        <table class="table" style="border: none;">
                                            <thead style="border-bottom: none;">
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(row, index) in earningsRows[{{ $loop->index }}]" :key="index">
                                                    <td>
                                                        <x-adminlte-input
                                                            type="text"
                                                            name="payroll[{{ $key }}][earning_description]"
                                                            v-model="row.description"
                                                            placeholder="Earning Description"
                                                            autocomplete="off"
                                                        />
                                                    </td>
                                                    <td>
                                                        <x-adminlte-input
                                                            type="text"
                                                            name="payroll[{{ $key }}][earning_amount]"
                                                            v-model="row.amount"
                                                            placeholder="Earnings Amount"
                                                            autocomplete="off"
                                                        />
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <button v-if="index > 0" type="button" class="btn btn-danger" @click="removeEarningRow({{ $loop->index }}, index)">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                            <button v-else type="button" class="btn btn-primary" @click="addEarningRow({{ $loop->index }})">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>Total Earnings:</td>
                                                    <td>
                                                        <!-- <strong>K @{{ calculateEarningsTotal({{ $loop->index }}) }}</strong> -->
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </td>

                                <!-- Deductions Section -->
                                <td>
                                    <div class="p-2 mb-3 shadow-sm border-danger">
                                        <table class="table" style="border: none;">
                                            <thead style="border-bottom: none;">
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(row, index) in deductionsRows[{{ $loop->index }}]" :key="index">
                                                    <td>
                                                        <x-adminlte-input
                                                            type="text"
                                                            name="payroll[{{ $key }}][deduction_description]"
                                                            v-model="row.description"
                                                            placeholder="Deduction Description"
                                                            autocomplete="off"
                                                        />
                                                    </td>
                                                    <td>
                                                        <x-adminlte-input
                                                            type="text"
                                                            name="payroll[{{ $key }}][deduction_amount]"
                                                            v-model="row.amount"
                                                            placeholder="Deduction Amount"
                                                            autocomplete="off"
                                                        />
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <button v-if="index > 0" type="button" class="btn btn-danger" @click="removeDeductionRow({{ $loop->index }}, index)">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                            <button v-else type="button" class="btn btn-primary" @click="addDeductionRow({{ $loop->index }})">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>Total Deductions:</td>
                                                    <td>
                                                        <!-- <strong>K @{{ calculateDeductionsTotal({{ $loop->index }}) }}</strong> -->
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </td>

                                <td>
                                    <input name="payroll[{{ $key }}][payee]" value="{{ $employee->payee ?? '' }}" hidden>
                                    K{{ $employee->payee ?? '0.00' }}
                                </td>
                                <td>
                                    <input name="payroll[{{ $key }}][net_salary]" value="{{ number_format(($employee->salary ?? 0) + ($employee->bonus ?? 0) - ($employee->payee ?? 0), 2) }}" hidden>
                                    K{{ number_format(($employee->salary ?? 0) + ($employee->bonus ?? 0) - ($employee->payee ?? 0), 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary btn-lg" @click="handleSubmit">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@stop

@include('/components/layouts/footer_bottom')

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script>

    $(document).ready(function() {
        $("#payrollMonthYear").datepicker({
            format: "MM yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

    });
</script>
<script setup>
    const { createApp, ref, reactive } = Vue


    const app = createApp({
      setup() {

        // Define reactive data for earnings and deductions
        const earningsRows = ref({});
        const deductionsRows = ref({});
        const state = ref(
            {
                salary: 0,
                paye: 0,
                deductions: 0,
            }
        )

        // Initialize earnings and deductions for each payroll
        @foreach($payroll->employees as $index => $payroll)
            earningsRows.value[{{ $index }}] = [{ description: 'Bonus', amount: {{ $payroll['bonus'] ?? 0 }} }];
            deductionsRows.value[{{ $index }}] = [{ description: '', amount: '' }];
            state.value.salary[{{ $index }}] = {{ $payroll['salary'] ?? 0 }};
        @endforeach

        // Add a new earnings row for a specific payroll
        const addEarningRow = (payrollIndex) => {
            earningsRows.value[payrollIndex].push({ description: '', amount: '' });
        };

        // Remove an earnings row for a specific payroll
        const removeEarningRow = (payrollIndex, rowIndex) => {
            if (earningsRows.value[payrollIndex].length > 1) {
                earningsRows.value[payrollIndex].splice(rowIndex, 1);
            }
        };

        // Add a new deduction row for a specific payroll
        const addDeductionRow = (payrollIndex) => {
            deductionsRows.value[payrollIndex].push({ description: '', amount: '' });
        };

        // Remove a deduction row for a specific payroll
        const removeDeductionRow = (payrollIndex, rowIndex) => {
            if (deductionsRows.value[payrollIndex].length > 1) {
                deductionsRows.value[payrollIndex].splice(rowIndex, 1);
            }
        };

        // Compute total earnings for a specific payroll
        const calculateEarningsTotal = (payrollIndex) => {
            return earningsRows.value[payrollIndex].reduce((sum, row) => {
                return sum + parseFloat(row.amount || 0);
            }, 0).toFixed(2);
        };

        // Compute total deductions for a specific payroll
        const calculateDeductionsTotal = (payrollIndex) => {
            return deductionsRows.value[payrollIndex].reduce((sum, row) => {
                return sum + parseFloat(row.amount || 0);
            }, 0).toFixed(2);
        };

        // Handle form submission
        const handleSubmit = () => {
            // Log form data to the console
            console.log('Form submitted:', {
                earningsRows: earningsRows.value,
                deductionsRows: deductionsRows.value
            });

            // Here, you can perform form validation or submit data to the server via API call
            // For example:
            // axios.post('/api/submit-payroll', { earnings: earningsRows.value, deductions: deductionsRows.value })
            // .then(response => {
            //     // handle success
            // })
            // .catch(error => {
            //     // handle error
            // });
        };

        return {
            earningsRows,
            deductionsRows,
            addEarningRow,
            removeEarningRow,
            addDeductionRow,
            removeDeductionRow,
            calculateDeductionsTotal,
            calculateEarningsTotal,
            handleSubmit,
            state
        };
    }
    })
    app.mount('#payroll')
</script>
@endpush

{{-- Add common CSS customizations --}}

@push('css')
<style type="text/css">

    {{-- You can add AdminLTE customizations here --}}

    .card {
        border-radius: none;
    }
    .card-title {
        font-weight: 600;
    }


</style>
@endpush
