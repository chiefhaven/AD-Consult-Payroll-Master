<div class="table-responsive" id="viewClient">
    @if( !$billing->isEmpty())
      <table id="quotationsSalesTable" class="table table-bordered table-striped table-vcenter display nowrap">
          <thead>
            <tr>
                <th class="text-center" style="width: 100px;">Actions</th>
                <th style="min-width: 150px;">Date</th>
                <th style="min-width: 150px;">Quotation No.</th>
                <th style="min-width: 150px;">Client</th>
                <th class="text-end" style="min-width: 150px;">Items Qty</th>
                <th class="text-end" style="min-width: 150px;">Total Amount</th>
                <th class="text-end" style="min-width: 150px;">Total Paid</th>
                <th class="text-end" style="min-width: 150px;">Balance</th>
                <th class="text-end" style="min-width: 150px;">Discount</th>
                <th class="text-end" style="min-width: 150px;">Tax</th>
                <th style="min-width: 150px;">Quotation Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($billing as $item)
                @if ($item->is_quotation == 1)
                    <tr>
                        <td class="text-center">
                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn btn-primary" id="action-dropdown-{{ $item->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="d-sm-inline-block">Action</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end p-0">
                                    <div class="p-2">
                                        <a class="dropdown-item nav-main-link" href="{{ url('/view-bill', $item) }}">
                                            <i class="nav-main-link-icon fas fa-eye"></i> View
                                        </a>
                                        <form method="POST" class="dropdown-item nav-main-link" action="{{ url('/edit-bill', $item) }}">
                                            @csrf
                                            <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                                            <button class="btn btn-link p-0" type="submit">Edit</button>
                                        </form>
                                        <a class="dropdown-item nav-main-link" href="{{ url('/add-payment', $item) }}">
                                            <i class="nav-main-link-icon fas fa-dollar-sign"></i> Add payment
                                        </a>
                                        <a class="dropdown-item nav-main-link" href="{{ url('/print-bill', $item) }}">
                                            <i class="nav-main-link-icon fas fa-print"></i> Print bill
                                        </a>
                                        <a class="dropdown-item nav-main-link" href="{{ url('/send-notification', $item) }}">
                                            <i class="nav-main-link-icon fas fa-envelope"></i> Send new sale notification
                                        </a>
                                        <form class="dropdown-item nav-main-link" method="POST" action="{{ url('delete-bill', $item->id) }}" onsubmit="return confirm('Are you sure you want to delete this bill?');">
                                            @csrf
                                            @method('DELETE')
                                            <i class="nav-main-link-icon fas fa-trash"></i>
                                            <button class="btn btn-link p-0 delete-employee-confirm" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                        <td>{{ $item->number }}</td>
                        <td>{{ $item->client->client_name }}</td>
                        <td class="text-end">{{ $item->quantity }}</td>
                        <td class="text-end">{{ number_format($item->total_amount, 2) }}</td>
                        <td class="text-end">{{ number_format($item->total_paid, 2) }}</td>
                        <td class="text-end">{{ number_format($item->balance, 2) }}</td>
                        <td class="text-end">{{ number_format($item->discount, 2) }}</td>
                        <td class="text-end">{{ number_format($item->tax, 2) }}</td>
                        <td>{{ $item->payment_status }}</td>
                    </tr>
                @endif
            @endforeach

        </tbody>
      </table>
    @else
        <p class="p-5">
            No billing transactions yet!
        </p>
    @endif
</div>
