<!DOCTYPE html>
<html>
<head>
    @include('pdf.css')
</head>
<body>
<div class="container" style="padding: 60px">
    <div class="row">
        <div class="container">
            <div class="col-md-5">
                <table class="table" style="width: 100%; font-size: 12px;">
                    <tr>
                        <td colspan="2">
                            <h2>Payslip for {{ $employeePayroll->employees[0]->fname }}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Fullname:</strong>
                            {{ $employeePayroll->employees[0]->fname }}
                            {{ $employeePayroll->employees[0]->mname }}
                            {{ $employeePayroll->employees[0]->sname }}<br>
                            <strong>Position:</strong> {{ $employeePayroll->employees[0]->position }}<br>
                            <strong>Period:</strong> {{ $employeePayroll->group ?? 'N/A' }}<br>
                            <strong>Status:</strong> {{ $employeePayroll->status ?? 'N/A' }}
                        </td>
                        <td class="amount">
                            <strong>Company/Organisation</strong><br>
                            {{ $employeePayroll->client->client_name ?? 'N/A' }}<br>
                            {{ $employeePayroll->client->street_address ?? 'N/A' }}<br>
                            {{ $employeePayroll->client->city ?? 'N/A' }}<br>
                            {{ $employeePayroll->client->country_id ?? 'N/A' }}<br>
                            {{ $employeePayroll->client->phone ?? 'N/A' }}<br>
                            {{ $employeePayroll->client->user->email ?? 'N/A' }}
                        </td>
                    </tr>
                </table>
            </div>
            <table class="table table-striped table-responsive" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th class="text">Item</th>
                        <th class="amount">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text">Gross</th>
                        <td class="amount">K{{ number_format($employeePayroll->employees[0]->pivot->salary, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text">Paye</th>
                        <td class="amount">K{{ number_format($employeePayroll->employees[0]->pivot->payee, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text">Net Pay</th>
                        <td class="amount">K{{ number_format($employeePayroll->employees[0]->pivot->net_salary, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text">Deductions</th>
                        <td class="amount">K{{ number_format($employeePayroll->employees[0]->pivot->deductions_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text">Earnings</th>
                        <td class="amount">K{{ number_format($employeePayroll->employees[0]->pivot->earning_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <p>&nbsp;</p>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr>
                        <td></td>
                        <td class="amount">
                            <strong>Total Paid: </strong>
                            K{{ number_format($employeePayroll->employees[0]->pivot->total_paid, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

</body>
</html>
