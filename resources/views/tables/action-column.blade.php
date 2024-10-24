<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Action
    </button>
    <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton">
        @isset($resource)
            <a href="{{ route('view-client', $resource->id) }}" class="dropdown-item mb-1">
                <i class="fa fa-solid fa-eye me-2"></i> View
            </a>
        @endisset

        @isset ( $resource )
            <form wire:submit="editItem({{ $resource->id }})">
                <button type="submit" class="dropdown-item mb-1">
                        <i class="fa fa-solid fa-pen me-2"></i> Edit
                </button>
            </form>
        @endisset

        @isset ( $resource )
            <form wire:submit="deleteItem({{ $resource->id }})" class="bg-danger">
                <button type="submit" class="dropdown-item bg-danger mb-1">
                    <i class="fa fa-solid fa-trash"></i> Delete
                </button>
            </form>
        @endisset
    </div>
  </div>
