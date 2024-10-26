<form action="/save-payroll" method="post">
    @csrf
    <div class="card mb-3 p-4">
        <div class="box-body">
            <h3>For Client: <strong>{{ $client->client_name }}</strong></h3>
            <div class="row">
                <x-adminlte-input type="text"
                    name="payrollMonthYear"
                    label="Payroll month year"
                    placeholder="Payroll Month/Year"
                    value=""
                    fgroup-class="col-md-4"
                    class="{{ $errors->has('payroll_group_name') ? 'is-invalid' : '' }}"
                    id="payroll_month_year"
                    autocomplete="off"/>

                <x-adminlte-input name="client" value="{{ $client->id }}" hidden />

                <x-adminlte-select
                    name="payrollStatus"
                    label="Status"
                    data-placeholder="Select an option..."
                    fgroup-class="col-md-4"
                    class="{{ $errors->has('status') ? 'is-invalid' : '' }}"
                    autocomplete="off"
                    required
                >
                    <option value="Draft">Draft</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="pending_approval">Pending Approval</option>
                    <option value="Final">Final</option>
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
                    Gross
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
                    Net Salary
                </th>
            </thead>
            <tbody>
                {{--  @foreach($payrolls as $key => $payroll)
                    <tr>
                        <td>
                            <input name="payroll[{{ $key}}][employee]" value="{{ $payroll['employee']->id }}" hidden>
                            {{ $payroll['employee']->fname }} {{ $payroll['employee']->mname }} {{ $payroll['employee']->sname }}
                        </td>
                        <td>
                            <x-adminlte-input
                                type="text"
                                name="payroll[{{ $key}}][salary]"
                                value="{{ $payroll['salary'] }}"
                                autocomplete="off"
                            />
                            <p>
                                <x-adminlte-select2
                                    name="payroll[{{ $key }}][pay_period]" label="Pay Period:">
                                    <option>{{ $payroll['pay_period'] }}</option>
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
                                                <!-- Description Input -->
                                                <x-adminlte-input
                                                    type="text"
                                                    name="payroll[{{ $key }}][earning_description]"
                                                    v-model="row.description"
                                                    placeholder="Earning Description"
                                                    autocomplete="off"
                                                />
                                            </td>
                                            <td>
                                                <!-- Amount Input -->
                                                <x-adminlte-input
                                                    type="text"
                                                    name="payroll[{{ $key }}][earning_amount]"
                                                    v-model="row.amount"
                                                    placeholder="Earnings Amount"
                                                    autocomplete="off"
                                                />
                                            </td>
                                            <td>
                                                <!-- Remove Button or Add Button for First Row -->
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
                                                <!-- Description Input -->
                                                <x-adminlte-input
                                                    type="text"
                                                    name="payroll[{{ $key }}][deduction_description]"
                                                    v-model="row.description"
                                                    placeholder="Deduction Description"
                                                    autocomplete="off"
                                                />
                                            </td>
                                            <td>
                                                <!-- Amount Input -->
                                                <x-adminlte-input
                                                    type="text"
                                                    name="payroll[{{ $key }}][deduction_amount]"
                                                    v-model="row.amount"
                                                    placeholder="Deduction Amount"
                                                    autocomplete="off"
                                                />
                                            </td>
                                            <td>
                                                <!-- Remove Button or Add Button for First Row -->
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
                            <input name="payroll[{{ $key}}][paye]" value="{{ $payroll['paye'] }}" hidden>
                            K{{ $payroll['paye'] }}
                        </td>
                        <td>
                            <input name="payroll[{{ $key}}][net_salary]" value="{{ $payroll['net_salary'] }}" hidden>
                            K{{ number_format($payroll['net_salary'], 2) }}
                        </td>
                    </tr>
                @endforeach  --}}
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary btn-lg" @click="handleSubmit">
            Add
        </button>
    </div>
</form>
