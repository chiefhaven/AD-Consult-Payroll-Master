<div class="table-responsive">
    @if( !$employee->payrolls->isEmpty())
      <table id="payrollsTable" class="table table-bordered table-striped table-vcenter display nowrap">
          <thead>
              <tr>
                  <th style="min-width: 250px;">Group</th>
                  <th style="min-width: 150px;">Gross (K)</th>
                  <th style="min-width: 150px;">Paye (K)</th>
                  <th style="min-width: 150px;">Net (K)</th>
                  <th style="min-width: 150px;">Earnings (K)</th>
                  <th style="min-width: 150px;">Deductions (K)</th>
                  <th style="min-width: 150px;">Total paid (K)</th>
                  <th>Status</th>
                  <th class="text-center" style="width: 100px;">Actions</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($employee->payrolls as $payroll)
              <tr>
                <td class="font-w600">
                   {{ $payroll->group }}
                </td>
                <td class="font-w600">
                    @if(isset($payroll))
                        {{ number_format($payroll->pivot->salary, 2) }}
                    @endif
                </td>
                <td class="font-w600">
                    @if(isset($payroll))
                        {{ number_format($payroll->pivot->payee, 2) }}
                    @endif
                </td>
                <td class="font-w600">
                    @if(isset($payroll))
                        {{ number_format($payroll->pivot->net_salary, 2) }}
                    @endif
                </td>
                <td class="font-w600">
                    @if(isset($payroll))
                        {{ number_format($payroll->pivot->earning_amount, 2) }}
                    @endif
                </td>
                <td class="font-w600">
                    @if(isset($payroll))
                        {{ number_format($payroll->pivot->deduction_amount, 2) }}
                    @endif
                </td>
                <td class="font-w600">
                    @if(isset($payroll))
                        {{ number_format($payroll->pivot->total_paid, 2) }}
                    @endif
                </td>
                <td class="font-w600">
                    @if(isset($payroll))
                        {{ $payroll->status }}
                    @endif
                </td>
                <td class="text-center">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-primary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-sm-inline-block">Action</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-0">
                            <div class="p-2">
                                <!-- View Payroll Link -->
                                <a class="dropdown-item nav-main-link" href="{{ url('/view-payroll', $payroll->id) }}">
                                    <i class="nav-main-link-icon fas fa-eye"></i>
                                    <span class="btn">View</span>
                                </a>

                                <!-- Download Payroll Payslip -->
                                <a class="dropdown-item nav-main-link" href="{{ url('/#') }}">
                                    <i class="nav-main-link-icon fas fa-download"></i>
                                    <span class="btn">Download payslip</span>
                                </a>

                                <!-- Edit Payroll Form -->
                                <form method="POST" class="dropdown-item nav-main-link" action="{{ url('/edit-payroll', $payroll->id) }}">
                                    @csrf
                                    <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                                    <button class="btn" type="submit">Edit</button>
                                </form>

                                <!-- Delete Payroll Form -->
                                <form class="dropdown-item nav-main-link" method="POST" action="{{ url('delete-payroll', $payroll->id) }}" onsubmit="return confirm('Are you sure you want to delete this payroll?');">
                                    @csrf
                                    @method('DELETE')
                                    <i class="nav-main-link-icon fas fa-trash-alt"></i>
                                    <button class="btn delete-confirm" type="submit">Delete</button>
                                </form>

                                <!-- View Payroll Link -->
                                <a class="dropdown-item nav-main-link" href="{{ url('/#') }}">
                                    <i class="nav-main-link-icon fas fa-envelope"></i>
                                    <span class="btn">Send new pay notification</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
              </tr>
              @endforeach
          </tbody>
      </table>

    @else
        <p class="p-5">No payrolls yet for this employee!</p>
    @endif
    </div>

