@php
    $balance = $bill->products->sum('pivot.total') - $bill->payments->sum('payment_amount');
    $paidAmount = $bill->payments->sum('payment_amount');
@endphp
<tr>
    <td class="text-center">
        <div class="dropdown d-inline-block">
            <button type="button" class="btn btn-default" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="d-sm-inline-block">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-end p-0">
                <div class="p-2">
                    <button class="dropdown-item nav-main-link" type="button" @click="viewBill('{{ $bill->id }}')">
                        <i class="nav-main-link-icon fas fa-eye"></i>
                        <span class="btn">View</span>
                    </button>
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
                    <button class="dropdown-item nav-main-link btn delete-bill-confirm" type="button" @click="confirmBillDelete('{{ $bill->id }}')">
                        <i class="nav-main-link-icon fas fa-trash-alt"></i>
                        <span class="btn">Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </td>
    <td>
        {{ \Carbon\Carbon::parse($bill->billing_date)->format('d F, Y') }}
    </td>
    <td>
        coming soon
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
        K{{ number_format($bill->payments->sum('payment_amount'), 2) }}
    </td>
    <td>
        K{{ number_format($bill->products->sum('pivot.total') - $paidAmount), 2 }}
    </td>
    <td>
        <button class="btn btn-sm
            @if ($balance == 0)
                btn-success
            @elseif ($balance > 0 && $paidAmount > 0))
                btn-primary
            @else
                btn-warning
            @endif">
            @if ($balance == 0)
                Paid
            @elseif ($balance > 0 && $paidAmount > 0)
                Partial Payment
            @else
                Due
            @endif
        </button>

    </td>
</tr>
