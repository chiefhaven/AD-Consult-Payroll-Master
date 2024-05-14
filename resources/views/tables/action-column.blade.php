<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Action
    </button>
    <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton">
        @isset ( $employee )
            <a class="dropdown-item bnt" href="{{ route('view-employee', $employee) }}"><i class="fa fa-solid fa-eye me-2"></i> View</a>
        @endif

        @isset ( $employee )
            <a class="dropdown-item btn" href="#">
                <div>
                    <i class="fa fa-solid fa-pen me-2"></i> Edit
                </div>
            </a>
        @endif

        @isset ( $employee )
            {{--  <form
                action="#"
                class="d-inline dropdown-item "
                method="POST"
                x-data
                @submit.prevent="if (confirm('Are you sure you want to delete this user?')) $el.submit()"
            >
                @method('DELETE')
                @csrf
                <button type="submit" class="btn bg-danger">
                    <i class="fa fa-solid fa-trash"></i> Delete
                </button>
            </form>  --}}

            <form wire:submit="deleteItem" value="{{ $employee }}">
                <button type="submit" class="btn bg-danger">
                    <i class="fa fa-solid fa-trash"></i> Delete
                </button>
            </form>
        @endif
    </div>
  </div>
