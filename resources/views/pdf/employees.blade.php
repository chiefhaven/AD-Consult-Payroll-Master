<!DOCTYPE html>
<html>
<head>
    @include('pdf.css')
</head>
<body>
<div class="container" style="padding: 60px">
    <div class="row">
        <div class="container">
            <div class="col-lg-12" style="text-align:center">
                <h3>Employees List</h3>
                {{ $client->client_name }}
            </div>
            <table class="table table-striped table-responsive" style="font-size:12px; background-color: #ffffff">
                    <thead style="color: #ffffff !important; background-color:#0665d0;">
                        <th class="invoice-td">Name</th>
                        <th class="invoice-td">Position</th>
                        <th class="invoice-td">Salary</th>
                        <th class="invoice-td">Pay period</th>
                        <th class="invoice-td">Contract end</th>
                        <th class="invoice-td">Contract end</th>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr class="py-1" style="padding-top: 0px; padding-bottom: 0px; ">
                                <td class="invoice-td">
                                    {{$employee->fname}} {{$employee->mname}} {{$employee->sname}}
                                </td>
                                <td class="invoice-td">
                                    {{$employee->designation->name}}
                                </td>
                                <td class="invoice-td">
                                    {{$employee->salary}}
                                </td>
                                <td class="invoice-td">
                                    {{$employee->pay_period}}
                                </td>
                                <td class="invoice-td">
                                    {{$employee->contract_start_date}}
                                </td>
                                <td class="invoice-td">
                                    {{$employee->contract_end_date}}
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
