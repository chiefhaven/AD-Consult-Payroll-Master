<div class="table-responsive">
    @if( !$client->payrolls->isEmpty())
      <table id="payrollTable" class="table table-bordered table-striped table-vcenter display nowrap">
          <thead>
              <tr>
                  <th style="min-width: 150px;">Group</th>
                  <th style="min-width: 150px;">Total employees</th>
                  <th style="min-width: 150px;">Total amount</th>
                  <th style="min-width: 150px;">Total deductions</th>
                  <th style="min-width: 150px;">Payee</th>
                  <th style="min-width: 150px;">Bonuses</th>
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
                    @if(isset($payroll->employee))
                        {{ $payroll->employee->count() }}
                    @endif
                </td>
                <td class="font-w600">
                    K{{ number_format($payroll->total_amount) }}
                </td>
                <td class="font-w600">
                    K{{ number_format($payroll->total_deductions) }}
                </td>
                <td>
                    K{{ number_format($payroll->total_payee) }}
                </td>
                <td>
                    K{{ number_format($payroll->bonuses) }}
                </td>
                <td>
                    {{ $payroll->status }}
                </td>
                <td class="text-center">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-primary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-sm-inline-block">Action</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-0">
                        <div class="p-2">
                            <a class="dropdown-item nav-main-link" href="{{ url('/viewpayroll', $payroll->id) }}">
                            <i class="nav-main-link-icon fa fa-user"></i><div class="btn">Profile</div>
                            </a>
                            <form method="POST" class="dropdown-item nav-main-link" action="{{ url('/edit-student', $payroll->id) }}">
                                {{ csrf_field() }}
                                <i class="nav-main-link-icon fa fa-pencil"></i>
                                <button class="btn" type="submit">Edit</button>
                            </form>
                            <form class="dropdown-item nav-main-link" method="POST" action="{{ url('student-delete', $payroll->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <i class="nav-main-link-icon fa fa-trash"></i>
                                <button class="btn delete-confirm" type="submit">Delete</button>
                            </form>
                        </div>
                        </div>
                    </div>
                </td>
              </tr>
              @endforeach
          </tbody>
      </table>

    @else
        <p class="p-5">No payrolls yet for this client!</p>
    @endif
    </div>
    <div class="modal fade" id="payroll_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form action="/add-payroll/{{ $client->id }}" method="GET" autocomplete="off">
                <div class="modal-body">
                    <x-adminlte-input type="text" name="client" id="client" autocomplete="false" value="{{ $client->id }}" required hidden/>
                    <div class="mb-3 p-4">
                        <div class="box-body">
                            <div class="row">
                                <x-adminlte-input type="text" name="payroll_month_year" label="Month/Year:*" placeholder="Month/Year" fgroup-class="col-12" class="{{ $errors->has('payroll_month_year') ? 'is-invalid' : '' }}" id="payroll_month_year" required autocomplete="off"/>

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
                                    <x-adminlte-select2 multiple="multiple" name="employees" placeholder="Employees" fgroup-class="col-12" class="{{ $errors->has('employees') ? 'is-invalid' : '' }}" id="employees" required autocomplete="off">
                                        @foreach($client->employee as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->fname }} {{ $employee->mname }} {{ $employee->sname }}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Proceed</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
            </div>
        </div>
    </div>

