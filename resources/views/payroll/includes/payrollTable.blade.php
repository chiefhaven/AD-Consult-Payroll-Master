<div class="table-responsive" id="viewClient">
    @if( !$client->payrolls->isEmpty())
      <table id="payrollTable" class="table table-bordered table-striped table-vcenter display nowrap">
          <thead>
              <tr>
                  <th style="min-width: 150px;">Group</th>
                  <th style="min-width: 50px;">Employees</th>
                  <th style="min-width: 150px;">Total gross</th>
                  <th style="min-width: 150px;">Total Paye</th>
                  <th style="min-width: 150px;">Total net</th>
                  <th style="min-width: 150px;">Total earnings</th>
                  <th style="min-width: 150px;">Total deductions</th>
                  <th style="min-width: 150px;">Total paid</th>
                  <th>Status</th>
                  <th class="text-center" style="width: 100px;">Actions</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($client->payrolls as $payroll)
              <tr>
                <td class="font-w600">
                   {{ $payroll->group }}
                </td>
                <td class="font-w600">
                    @if(isset($payroll->employees))
                        {{ $payroll->employees()->count() }}
                    @endif
                </td>
                <td class="font-w600">
                    K{{ number_format($payroll->employees()->sum('payroll_employee.salary')) }}
                </td>
                <td>
                    K{{ number_format($payroll->employees()->sum('payroll_employee.payee')) }}
                </td>
                <td class="font-w600">
                    K{{ number_format($payroll->employees()->sum('payroll_employee.net_salary')) }}
                </td>
                <td>
                    K{{ $payroll->employees()->sum('payroll_employee.earning_amount') }}
                </td>
                <td class="font-w600">
                    K{{ number_format($payroll->employees()->sum('payroll_employee.deduction_amount')) }}
                </td>
                <td>
                    K{{ number_format($payroll->employees()->sum('payroll_employee.total_paid')) }}
                </td>
                <td>
                    @if ($payroll->status === 'Paid' || $payroll->status === 'Cancelled')
                        {{ $payroll->status }}
                    @else
                        <button class="btn btn-sm btn-warning" @click="openStatusDialog('{{ $payroll->id }}', '{{ $payroll->status }}')">
                            {{ $payroll->status }}
                        </button>
                    @endif
                </td>
                <td class="text-center">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-default" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-sm-inline-block">Action</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-0">
                            <div class="p-2">
                                <!-- View Payroll Link -->
                                <button class="dropdown-item nav-main-link" @click="fetchPayrollDetails('{{ $payroll->id }}')">
                                    <i class="nav-main-link-icon fas fa-eye"></i>
                                    <span class="btn">View</span>
                                </button>

                                <!-- Edit Payroll -->
                                <a class="dropdown-item nav-main-link btn" href="{{ route('edit-payroll', $payroll) }}">
                                    <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                                    <span class="btn">Edit</span>
                                </a>

                                <!-- Export Payroll -->
                                <a class="dropdown-item nav-main-link btn" href="{{ route('export-payroll', [$payroll->id, 'pdf']) }}">
                                    <i class="nav-main-link-icon fas fa-print"></i>
                                    <span class="btn">Export PDF</span>
                                </a>

                                <!-- Export Payroll -->
                                <a class="dropdown-item nav-main-link btn" href="{{ route('export-payroll', [$payroll->id, 'csv']) }}">
                                    <i class="nav-main-link-icon fas fa-print"></i>
                                    <span class="btn">Export CSV</span>
                                </a>

                                <!-- Delete Payroll Form -->
                                <form class="dropdown-item nav-main-link" method="POST" action="{{ url('delete-payroll', $payroll) }}">
                                    @csrf
                                    @method('DELETE')
                                    <i class="nav-main-link-icon fas fa-trash-alt"></i>
                                    <button class="btn delete-payroll-confirm" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
              </tr>
            @endforeach
          </tbody>
      </table>

        @include('../payroll/includes/viewPayrollModal')

    @else
        <p class="p-5">
            No payrolls yet for this client!
        </p>
    @endif
</div>
<div class="modal fade" id="payroll_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @if($client->employees->count()>0)
                <form action="/add-payroll/{{ $client->id }}" method="GET" autocomplete="off">
                <div class="modal-body">
                    <x-adminlte-input type="text"
                        name="client"
                        id="client"
                        autocomplete="false"
                        value="{{ $client->id }}"
                        v-model="client"
                        required hidden/>
                    <div class="mb-3 p-4">
                        <div class="box-body">
                            <div class="row">
                                <x-adminlte-input
                                    type="text"
                                    name="payroll_month_year"
                                    label="Month/Year:*"
                                    placeholder="Month/Year"
                                    fgroup-class="col-12"
                                    class="{{ $errors->has('payroll_month_year') ? 'is-invalid' : '' }}"
                                    id="payroll_month_year"
                                    v-model="payroll_month_year"
                                    required
                                    autocomplete="off"/>

                                <div class="form-group col-12">
                                    <label for="employees" class="form-label">Select employees:*</label>

                                    <!-- Button group to place next to label -->
                                    <div class="button-group" style="display: inline-block; margin-left: 10px;">
                                        <button type="button" class="btn btn-primary btn-xs select-all">
                                            Select all
                                        </button>
                                        <button type="button" class="btn btn-primary btn-xs deselect-all">
                                            Deselect all
                                        </button>
                                    </div>

                                    <!-- Select2 component -->
                                    <x-adminlte-select2
                                        multiple="multiple"
                                        name="employees[]"
                                        fgroup-class="col-12"
                                        class="{{ $errors->has('employees') ? 'is-invalid' : '' }} no-rounded-corners"
                                        id="employees"
                                        required
                                        v-model="employees[]"
                                        autocomplete="off"
                                    >

                                        @if(isset($client->employees) && count($client->employees) > 0)
                                            @foreach($client->employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->fname }} {{ $employee->mname }} {{ $employee->sname }}</option>
                                            @endforeach
                                        @endif
                                    </x-adminlte-select2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" @click="openAddPayrollModal">Proceed</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>
            @else
                <div class="modal-body">
                    You must add employees to this client to add a payroll
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            @endif
        </div>
    </div>
</div>

