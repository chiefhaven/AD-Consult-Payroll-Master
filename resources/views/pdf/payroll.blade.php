<!DOCTYPE html>
<html>
<head>
    @include('pdf.css')
</head>
<body>
<div class="container" style="padding: 60px">
    <div class="row">
        <div class="container">
            <div class="col-lg-12">
                <h3 class="text-center">Payroll</h3>
                <p><i class="fas fa-building"></i> <strong>Company/Organisation:</strong> {{ $payroll->client->client_name ?? 'N/A' }}</p>
                <p><i class="fas fa-calendar-alt"></i> <strong>Period:</strong> {{ $payroll->group ?? 'N/A' }}</p>
                <p><i class="fas fa-check-circle"></i> <strong>Status:</strong> {{ $payroll->status ?? 'N/A' }}</p>
            </div>
            <table class="table table-striped table-responsive" style="font-size:12px; background-color: #ffffff">
                    <thead style="color: #ffffff !important; background-color:#0665d0;">
                        <th class="invoice-td">Name</th>
                        <th class="invoice-td">Position</th>
                        <th class="invoice-td">Gross</th>
                        <th class="invoice-td">Paye</th>
                        <th class="invoice-td">Net</th>
                        <th class="invoice-td">Earnings</th>
                        <th class="invoice-td">Deductions</th>
                        <th class="invoice-td">Total Paid</th>
                    </thead>
                    <tbody>
                    @foreach ($payroll->employees as $employee)
                        <tr class="py-1" style="padding-top: 0px; padding-bottom: 0px;">
                            <td class="invoice-td">
                                {{ $employee->fname }} {{ $employee->mname }} {{ $employee->sname }}
                            </td>
                            <td class="invoice-td">
                                {{ $employee->designation->name }}
                            </td>
                            <td class="invoice-td">
                                {{ number_format($employee->pivot->salary, 2) }}
                            </td>
                            <td class="invoice-td">
                                {{ number_format($employee->pivot->payee ?? 0, 2) }}
                            </td>
                            <td class="invoice-td">
                                {{ number_format($employee->pivot->net_salary ?? 0, 2) }}
                            </td>
                            <td class="invoice-td">
                                {{ $employee->pivot->earning_description }}: {{ number_format($employee->pivot->earning_amount ?? 0, 2) }}
                            </td>
                            <td class="invoice-td">
                                {{ $employee->pivot->deduction_description }}: {{ number_format($employee->pivot->deduction_amount ?? 0, 2) }}
                            </td>
                            <td class="invoice-td">
                                {{ number_format($employee->pivot->total_paid ?? 0, 2) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>
</div>

</body>
</html>
