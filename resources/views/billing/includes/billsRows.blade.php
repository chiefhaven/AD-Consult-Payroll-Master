<tr>
    <td class="text-center">
        <div class="dropdown d-inline-block">
            <button type="button" class="btn btn-default" id="action-dropdown-{{ $bill->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="d-sm-inline-block">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-end p-0">
                <div class="p-2">
                    <a class="dropdown-item nav-main-link" href="{{ url('/view-bill', $bill) }}">
                        <i class="nav-main-link-icon fas fa-eye"></i>
                        <div class="btn">View</div>
                    </a>
                    <form method="POST" class="dropdown-item nav-main-link" action="{{ url('/edit-bill', $bill) }}">
                        @csrf
                        <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                        <button class="btn p-0" type="submit">
                            <div class="btn">Edit</div>
                        </button>
                    </form>
                    <a class="dropdown-item nav-main-link" href="{{ url('/add-payment', $bill) }}">
                        <i class="nav-main-link-icon fas fa-dollar-sign"></i>
                        <div class="btn">Add payment</div>
                    </a>
                    <a class="dropdown-item nav-main-link" href="{{ url('/print-bill', $bill) }}">
                        <i class="nav-main-link-icon fas fa-print"></i>
                        <div class="btn">Print bill</div>
                    </a>
                    <a class="dropdown-item nav-main-link" href="{{ url('/send-notification', $bill) }}">
                        <i class="nav-main-link-icon fas fa-envelope"></i>
                        <div class="btn">Send new sale notification</div>
                    </a>
                    <form class="dropdown-item nav-main-link" method="POST" action="{{ url('delete-bill', $bill->id) }}" onsubmit="return confirm('Are you sure you want to delete this bill?');">
                        @csrf
                        @method('DELETE')
                        <i class="nav-main-link-icon fas fa-trash"></i>
                        <button class="btn p-0 delete-employee-confirm" type="submit">
                            <div class="btn">Delete</div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </td>
    <td>
        {{ $bill->created_at->format('Y-m-d') }}
    </td>
    <td>
        {{ $bill->invoice_number }}
    </td>
    <td>
        {{ $bill->client->client_name }}
    </td>
    <td class="text-end">
        {{ $bill->products->sum('pivot.quantity') }}
    </td>
    <td class="text-end">
        K{{ number_format($bill->products->map(function($product) {
            return $product->pivot->price * $product->pivot->quantity;
        })->sum(), 2) }}
    </td>
    <td class="text-end">
        K{{ number_format($bill->products->sum('pivot.item_discount'), 2) }}
    </td>
    <td class="text-end">
        K{{ number_format($bill->products->sum('pivot.tax'), 2) }}
    </td>
    <td class="text-end">
        K{{ number_format($bill->products->sum('pivot.total'), 2) }}
    </td>
    <td class="text-end">
        K{{ number_format($bill->total_paid, 2) }}
    </td>
    <td>
        K{{ number_format($bill->products->sum('pivot.total') - $bill->total_paid), 2 }}
    </td>
    <td>
        @php
            $remainingAmount = $bill->products->sum('pivot.total') - $bill->total_paid;
        @endphp

        <button class="btn btn-sm
            @if ($remainingAmount == 0)
                btn-success
            @elseif ($remainingAmount < $bill->products->sum('pivot.total'))
                btn-warning
            @else
                btn-danger
            @endif">
            @if ($remainingAmount == 0)
                Paid
            @elseif ($remainingAmount < $bill->products->sum('pivot.total'))
                Partial Payment
            @else
                Due
            @endif
        </button>

    </td>
</tr>
