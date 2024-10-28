<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quote #{{ $billing->id }}</title>
</head>
<body>

      <div class="row p-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body ">
                    <div class="row">
                        <p>AD Consult </p>
                        <P>Private Bag 23, </P>
                        <p>Limbe Blantyre</p>
                        <p>info@adconsult.com</p>
                    </div>
                    <div class="row">
                        <div class="col md-6">
                            <div>
                                <h4>Quote To</h4>
                                <p>{{ $billing->client_name }}</p>
                                <p>{{ $billing->client->address }}</p>
                                <p>{{ $billing->client->phone }}</p>
                            </div>
                        </div>

                        <div class="col md-6">
                            <div>
                                <h4>Logo Here</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                            <p>Quote No:QT00{{ $billing->id }} </p>
                            <p>Date:{{ $billing->issue_date }} </p>
                            <p>Due Date: {{ $billing->due_date }} </p>
                        </div>
                    </div>
                    <div class="row">
                        <table>
                            <head>
                                <th>Product/Service</th>
                                <th>Discription</th>
                                <th>Quantity/Hours</th>
                                <th>Rate</th>
                                <th>Total</th>
                            </head>
                            <tbody>
                                <tr>
                                    <td>{{ $billing->product }} </td>
                                    <td>{{ $billing->discription }}</td>
                                    <td>{{ $billing->quantity }} </td>
                                    <td>MWK {{ $billing->rate }} /(Qty/Service) </td>
                                    <td>{{number_format($billing->quantity * $billing->rate, 2)  }}  </td>
                                </tr>
                            </tbody>

                        </table>
                        <div class="row">
                            <div class="col-md-4">
                                <h4>Transaction Terms</h4>
                                <p>{{ $billing->transaction_terms }}</p>
                            </div>
                        <div class="col-md-4">

                        </div>

                            <div class="col-md-4">
                                <p>Subtotal:{{ $billing->total_amount }} </p>
                                <p>Discount:{{ $billing->discount }} </p>
                                <p>Tax Amount:{{ $billing->tax_amount }}</p>
                                <div class="card">TOTAL: {{number_format($billing->total_amount-$billing->discount-$billing->tax_amount, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
