<div v-if="data.employees" class="table-responsive">
      <table id="employeePayrollTable" class="table table-bordered table-striped table-vcenter display nowrap">
          <thead>
              <tr>
                  <th>#</th>
                  <th style="min-width: 250px;">Name</th>
                  <th style="min-width: 150px;">Gross (K)</th>
                  <th style="min-width: 150px;">Paye (K)</th>
                  <th style="min-width: 150px;">Net (K)</th>
                  <th style="min-width: 150px;">Earnings (K)</th>
                  <th style="min-width: 150px;">Deductions (K)</th>
                  <th style="min-width: 150px;">Total paid (K)</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
            <tr v-for="(employee, index) in data.employees" :key="index">
                <td class="font-w600">
                    @{{ index+1 }}
                </td>
                <td class="font-w600">
                   @{{ employee.fname }}
                   @{{ employee.mname }}
                   @{{ employee.sname }}
                </td>
                <td class="font-w600">
                    @{{ employee.pivot.salary }}
                </td>
                <td class="font-w600">
                    @{{ employee.pivot.payee }}
                </td>
                <td class="font-w600">
                    @{{ employee.pivot.net_salary }}
                </td>
                <td class="font-w600">
                    @{{ employee.pivot.earning_amount }}
                </td>
                <td class="font-w600">
                    @{{ employee.pivot.deduction_amount }}
                </td>
                <td class="font-w600">
                    @{{ employee.pivot.total_paid }}
                </td>
                <td class="font-w600">
                    <button class="btn btn-success">Payslip</button>
                </td>
            </tr>
          </tbody>
      </table>
</div>
<div v-else>
    <p class="p-5">No employees in this payroll!</p>
</div>
@push('js')
<script>
    $('#employeePayrollTable').DataTable({
        scrollX: true,
        scrollY: true,
    });
</script>
@endpush
