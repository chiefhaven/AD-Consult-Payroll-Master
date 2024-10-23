<div class="table-responsive">
    @if( !$payrolls->isEmpty())
      <table id="allPayrollsTable" class="table table-bordered table-striped table-vcenter display nowrap">
          <thead>
              <tr>
                  <th style="min-width: 150px;">Company/Organisation</th>
                  <th style="min-width: 150px;">Payroll Period</th>
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
            @foreach ($payrolls as $payroll)
              <tr>
                <td class="font-w600">
                   {{ $payroll->client->client_name }}
                </td>
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

        {{--  @include('../payroll/includes/viewPayrollModal')  --}}

    @else
        <p class="p-5">
            No payrolls yet!
        </p>
    @endif
</div>

