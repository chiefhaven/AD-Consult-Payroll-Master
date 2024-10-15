<div class="table-responsive" id="viewClient">
    @if( !$client->billing->isEmpty())
      <table id="payrollTable" class="table table-bordered table-striped table-vcenter display nowrap">
          <thead>
            <tr>
                <th class="text-center" style="width: 100px;">Actions</th>
                <th style="min-width: 150px;">Date</th>
                <th style="min-width: 50px;">Type</th>
                <th style="min-width: 150px;">No.</th>
                <th class="text-end" style="min-width: 150px;">Qty</th>
                <th class="text-end" style="min-width: 150px;">Total Amount</th>
                <th class="text-end" style="min-width: 150px;">Total Paid</th>
                <th class="text-end" style="min-width: 150px;">Balance</th>
                <th class="text-end" style="min-width: 150px;">Discount</th>
                <th class="text-end" style="min-width: 150px;">Tax</th>
                <th style="min-width: 150px;">Payment Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($client->billing as $item)
                <tr>
                    <td class="text-center">
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn btn-primary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-sm-inline-block">Action</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end p-0">
                                <div class="p-2">
                                    <a class="dropdown-item nav-main-link" href="{{ url('/view-bill', $item) }}">
                                        <i class="nav-main-link-icon fa fa-eye"></i><div class="btn">View</div>
                                    </a>
                                    <form method="POST" class="dropdown-item nav-main-link" action="{{ url('/edit-bill', $item) }}">
                                        {{ csrf_field() }}
                                        <i class="nav-main-link-icon fa fa-pencil-alt"></i>
                                        <button class="btn" type="submit">Edit</button>
                                    </form>
                                    <a class="dropdown-item nav-main-link" href="{{ url('/view-bill', $item) }}">
                                        <i class="nav-main-link-icon fa fa-dollar-sign"></i><div class="btn">Add payment</div>
                                    </a>
                                    <a class="dropdown-item nav-main-link" href="{{ url('/view-bill', $item) }}">
                                        <i class="nav-main-link-icon fa fa-print"></i><div class="btn">Print bill</div>
                                    </a>
                                    <a class="dropdown-item nav-main-link" href="{{ url('/view-bill', $item) }}">
                                        <i class="nav-main-link-icon fa fa-envelope"></i><div class="btn">Send new sale notification</div>
                                    </a>
                                    <form class="dropdown-item nav-main-link" method="POST" action="{{ url('delete-bill', $item->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <i class="nav-main-link-icon fa fa-trash"></i>
                                        <button class="btn delete-employee-confirm" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        @if($item->is_invoice == 1)
                            Invoice
                        @elseif ($item->is_quotation)
                            Quotation
                        @endif
                    </td>
                    <td>{{ $item->is_quotation }}</td>
                    <td class="text-end">{{ $item->quantity }}</td>
                    <td class="text-end">{{ number_format($item->total_amount, 2) }}</td>
                    <td class="text-end">{{ number_format($item->total_paid, 2) }}</td>
                    <td class="text-end">{{ number_format($item->balance, 2) }}</td>
                    <td class="text-end">{{ number_format($item->discount, 2) }}</td>
                    <td class="text-end">{{ number_format($item->tax, 2) }}</td>
                    <td>{{ $item->payment_status }}</td>
                </tr>
            @endforeach
        </tbody>
      </table>
    @else
        <p class="p-5">
            No billing transactions yet!
        </p>
    @endif
</div>
