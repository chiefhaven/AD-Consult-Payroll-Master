<div class="table-responsive" id="viewClient">
    @if( !$billing->isEmpty())
      <table id="invoicesSalesTable" class="table table-bordered table-striped table-vcenter display nowrap">
          <thead>
            <tr>
                <th class="text-center" style="width: 100px;">Actions</th>
                <th style="min-width: 150px;">Date</th>
                <th style="min-width: 150px;">Due Date</th>
                <th style="min-width: 150px;">Invoice No.</th>
                <th style="min-width: 150px;">Client</th>
                <th class="text-end" style="min-width: 150px;">Items Qty</th>
                <th class="text-end" style="min-width: 150px;">Sub total</th>
                <th class="text-end" style="min-width: 150px;">Discount</th>
                <th class="text-end" style="min-width: 150px;">Tax</th>
                <th class="text-end" style="min-width: 150px;">Total</th>
                <th class="text-end" style="min-width: 150px;">Total Paid</th>
                <th class="text-end" style="min-width: 150px;">Balance</th>
                <th style="min-width: 150px;">Payment Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($billing as $bill)
                @if ($bill->billing_type == 'invoice')
                    @include('billing.includes.billsRows')
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
