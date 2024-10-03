<div v-if="" class="table-responsive">
      <table id="payrollTable" class="table table-bordered table-striped table-vcenter display nowrap">
          <thead>
              <tr>
                  <th style="min-width: 250px;">Name</th>
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
            <tr v-for="(employee, index) in data.employees" :key="index">
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
            </tr>
          </tbody>
      </table>
</div>
<div v-else>
    <p class="p-5">No employees in this payroll!</p>
</div>
