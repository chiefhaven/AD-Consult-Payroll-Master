@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Add Payroll')

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
    <livewire:common.page-header pageTitle="Add payroll" buttonName="Go back" link="/client/{{ $client->id }}" buttonClass="btn btn-warning"/>
    <div class="col-lg-12">
        @include('includes/error')
        @section('plugins.Select2', true)
        <form @submit.prevent="submitPayroll"> <!-- Prevent default submission -->
            @csrf
            <div class="card mb-3 p-4">
                <div class="box-body">
                    <h3>For Client: <strong>@{{ client.client_name }}</strong></h3>
                    <div class="row">
                        <x-adminlte-input
                            type="text"
                            name="payrollMonthYear"
                            label="Payroll month year"
                            placeholder="Payroll Month/Year"
                            v-model="payrollMonthYear"
                            fgroup-class="col-md-4"
                            id="payroll_month_year"
                            autocomplete="off"
                        />
                        <x-adminlte-input
                            name="client"
                            v-model="clientId"
                            value=""
                            hidden
                        />
                        <x-adminlte-select
                            name="payrollStatus"
                            label="Status"
                            data-placeholder="Select an option..."
                            fgroup-class="col-md-4"
                            class="{{ $errors->has('status') ? 'is-invalid' : '' }}"
                            autocomplete="off"
                            required
                            v-model="payrollStatus"
                        >
                            <option value="Draft">Draft</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="pending_approval">Pending Approval</option>
                            <option value="Final">Final</option>
                        </x-adminlte-select>
                    </div>
                </div>
            </div>
            <div class="card mb-3 p-4">
                <table class="table table-responsive" id="payroll_table">
                    <thead>
                        <tr>
                            <th class="text-nowrap" style="width: auto;">Employee</th>
                            <th class="text-nowrap" style="width: auto; min-width: 70px;">Gross (K)</th>
                            <th class="text-nowrap" style="width: auto;">Earnings (K)</th>
                            <th class="text-nowrap" style="min-width: 150px;">Deductions (K)</th>
                            <th class="text-nowrap" style="min-width: 150px;">Paye (K)</th>
                            <th class="text-nowrap" style="min-width: 150px;">Net Salary(K)</th>
                            <th class="text-nowrap" style="min-width: 150px;">Total Pay(K)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(payroll, index) in payrollStates" :key="payroll.employeeId">
                            <td>
                                <input v-model="payroll.employeeId" hidden>
                                @{{ payroll.employeeName }}
                            </td>
                            <td style="min-width: 70px !important">
                                <x-adminlte-input
                                    type="text"
                                    name="gross_salary"
                                    v-model="payrollStates[index].salary"
                                    autocomplete="off"
                                />
                                 {{--  K@{{ payroll.salary }}  --}}
                                <p>
                                    <x-adminlte-select2
                                        name="pay_period"
                                        v-model="payrollStates[index].payPeriod"
                                        data-placeholder="Select Pay Period"
                                    >
                                        <option value="Hourly">Hourly</option>
                                        <option value="Daily">Daily</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="Bi weekly">Bi weekly</option>
                                        <option value="Monthly">Monthly</option>
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
                                            <tr v-for="(row, rowIndex) in earningsRows[index]" :key="rowIndex">
                                                <td>
                                                    <x-adminlte-input
                                                        type="text"
                                                        name="earning_description"
                                                        v-model="row.description"
                                                        placeholder="Earning Description"
                                                        autocomplete="off"
                                                    />
                                                </td>
                                                <td>
                                                    <x-adminlte-input
                                                        type="text"
                                                        name="earning_amount"
                                                        v-model="row.amount"
                                                        placeholder="Earnings Amount"
                                                        autocomplete="off"
                                                    />
                                                </td>
                                                <td>
                                                    <div>
                                                        <button v-if="rowIndex > 0" type="button" class="btn btn-danger" @click="removeEarningRow(index, rowIndex)">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <button v-else type="button" class="btn btn-primary" @click="addEarningRow(index)">
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
                                                    <strong>K @{{ calculateEarningsTotal(index) }}</strong>
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
                                            <tr v-for="(row, rowIndex) in deductionsRows[index]" :key="rowIndex">
                                                <td>
                                                    <x-adminlte-input
                                                        type="text"
                                                        name="deduction_description"
                                                        v-model="row.description"
                                                        placeholder="Deduction Description"
                                                        autocomplete="off"
                                                    />
                                                </td>
                                                <td>
                                                    <x-adminlte-input
                                                        type="text"
                                                        name="deduction_amount"
                                                        v-model="row.amount"
                                                        placeholder="Deduction Amount"
                                                        autocomplete="off"
                                                    />
                                                </td>
                                                <td>
                                                    <div>
                                                        <button v-if="rowIndex > 0" type="button" class="btn btn-danger" @click="removeDeductionRow(index, rowIndex)">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <button v-else type="button" class="btn btn-primary" @click="addDeductionRow(index)">
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
                                                    <strong>K @{{ calculateDeductionsTotal(index) }}</strong>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </td>
                            <td>
                                <input name="totalPaye" v-model="payrollStates[index].totalPaye" hidden>
                                @{{ formatCurrency(payroll.totalPaye) }}
                            </td>
                            <td>
                                <input name="net_salary" v-model="payrollStates[index].net_salary" hidden>
                                @{{ formatCurrency(payroll.net_salary) }}
                            </td>
                            <td>
                                @{{ formatCurrency(payroll.totalPay) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    Add
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
        $("#payroll_month_year").datepicker({
            format: "MM yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
    });

</script>
<script setup>
    const app = createApp({
      setup() {

        const payrolls = ref([]);

        payrolls.value = @json($payrolls);
        payrolls.value = Object.values(payrolls.value);


        const client = ref('');
        const clientId = ref('');
        const action = ref('');
        const payrollStatus = ref('Draft');
        const earningsRows = ref({});
        const deductionsRows = ref({});
        const payrollStates = ref([]);
        const payrollMonthYear = ref('');

        onMounted(() => {
            clientId.value = "{{ $client->id }}"
            payrollMonthYear.value = "{{ $payroll_month_year }}"
            payrolls.value.forEach((payroll) => {
                // Initialize state for each payroll
                const state = {
                    salary: payroll.employee.salary || 0, // Ensure basic_pay is set correctly
                    totalPaye: payroll.totalPaye || 0, // Default to 0 if paye is not defined
                    deductions: payroll.deductions || 0,
                    net_salary: payroll.net_salary || 0,
                    totalPay: payroll.totalPay || 0,
                    employeeId: payroll.employee.id,
                    employeeName: `${payroll.employee.fname || ''} ${payroll.employee.mname || ''} ${payroll.employee.sname || ''}`.trim(), // Combine names
                    payPeriod: payroll.employee.pay_period || '' // Default to empty string if pay_period is not defined
                };

                payrollStates.value.push(state); // Push the initialized state to payrollStates
            });
        });



        const state = ref(
            {
                salary: 0,
                totalPaye: 0,
                deductions: 0,
                net_salary: 0,
                employeeId:'',
                basic_pay: 0,
                payPeriod:'',
                totalPay: 0,
            }
        )

        // Initialize earnings and deductions for each payroll
        @foreach($payrolls as $payroll)
            earningsRows.value[{{ $loop->index }}] = [{ description: 'Bonus', amount: {{ $payroll['bonus']}} }];
            deductionsRows.value[{{ $loop->index }}] = [{ description: '', amount: '' }];
            state.value.salary[{{ $loop->index }}] = [{{{ $payroll['salary'] }}}];
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
        };

        const formatCurrency = (value) => {
            return `K ${Number(value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        };

        const submitPayroll = async () => {
            NProgress.start();
            try {
            console.log(payrollMonthYear.value);
                console.log(payrollStates.value);
                const response = await axios.post('/save-payroll', {
                    payrolls: payrollStates.value,
                    clientId: clientId.value,
                    payrollStatus: payrollStatus.value,
                    payrollMonthYear: payrollMonthYear.value,
                });
                console.log(response.status)

                if (response.status == 200) {
                    window.location.href = `/client/${clientId.value}`;
                }

                // Handle success response
            } catch (error) {
                console.error('Error saving payroll:', error);
                // Handle error response
            } finally{
                NProgress.done();
            }
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
            client,
            payrolls,
            payrollMonthYear,
            action,
            clientId,
            payrollStatus,
            formatCurrency,
            payrollStates,
            state,
            submitPayroll

        };
    }})
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
