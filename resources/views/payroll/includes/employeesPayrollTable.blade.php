<div v-if="data.employees" class="table-responsive">
      <table id="employeesPayrollTable" class="table table-bordered table-striped table-vcenter display nowrap">
          <thead>
              <tr>
                  <th>#</th>
                  <th style="min-width: 250px;">Name</th>
                  <th style="min-width: 150px;">Gross</th>
                  <th style="min-width: 150px;">Paye</th>
                  <th style="min-width: 150px;">Net</th>
                  <th style="min-width: 150px;">Earnings</th>
                  <th style="min-width: 150px;">Deductions</th>
                  <th style="min-width: 150px;">Total paid</th>
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
                    @{{ formatCurrency(employee.pivot.salary) }}
                </td>
                <td class="font-w600">
                    @{{ formatCurrency(employee.pivot.payee) }}
                </td>
                <td class="font-w600">
                    @{{ formatCurrency(employee.pivot.net_salary) }}
                </td>
                <td class="font-w600">
                    @{{ formatCurrency(employee.pivot.earning_amount) }}
                </td>
                <td class="font-w600">
                    @{{ formatCurrency(employee.pivot.deduction_amount) }}
                </td>
                <td class="font-w600">
                    @{{ formatCurrency(employee.pivot.total_paid) }}
                </td>
                <td class="font-w600">
                    <button type="button" @click="employeePayDetails(employee.id, '{{ $payroll->id }}')"
                            class="btn btn-success d-flex align-items-center justify-content-center mb-4 float-end"
                            data-bs-toggle="modal">
                        <i class="fa fa-eye me-2"></i>
                        <span class="ml-1">View</span>
                    </button>
                </td>
            </tr>
          </tbody>
      </table>
</div>
<div v-else>
    <p class="p-5">No employees in this payroll!</p>
</div>
