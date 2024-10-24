<div class="table-responsive">
    @if( !$products->isEmpty())
      <table id="allPayrollsTable" class="table table-bordered table-striped table-vcenter w-100 display nowrap">
          <thead>
              <tr>
                  <th style="min-width: 150px;">Name</th>
                  <th style="min-width: 50px;">Unit price</th>
                  <th style="min-width: 150px;">VAT</th>
                  <th style="min-width: 150px;">Category</th>
                  <th class="text-center" style="width: 100px;">Actions</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($products as $product)
              <tr>
                <td class="font-w600">
                   {{ $product->name }}
                </td>
                <td>
                    K{{ number_format($product->price, 2) }}
                </td>
                <td>
                    {{ $product->vat }}
                </td>
                <td>
                    {{ $product->category }}
                </td>
                <td class="text-center">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-default" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-sm-inline-block">Action</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-0">
                            <div class="p-2">
                                <!-- View Payroll Link -->
                                <button class="dropdown-item nav-main-link" @click="fetchProductDetails('{{ $product->id }}')">
                                    <i class="nav-main-link-icon fas fa-eye"></i>
                                    <span class="btn">View</span>
                                </button>

                                <!-- Edit Product -->
                                <a class="dropdown-item nav-main-link btn" href="{{ route('edit-product', $product) }}">
                                    <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                                    <span class="btn">Edit</span>
                                </a>

                                <!-- Delete Payroll Form -->
                                <form class="dropdown-item nav-main-link" method="POST" action="{{ url('delete-product', $product) }}">
                                    @csrf
                                    @method('DELETE')
                                    <i class="nav-main-link-icon fas fa-trash-alt"></i>
                                    <button class="btn delete-product-confirm" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
              </tr>
            @endforeach
          </tbody>
      </table>
    @else
        <p class="p-5">
            No products yet!
        </p>
    @endif
</div>

