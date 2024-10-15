<div class="table-responsive">
    @if( !$clients->isEmpty())
      <table id="clientsTable" class="table table-bordered table-striped table-vcenter">
        <thead>
            <tr>
                <th scope="col" style="min-width: 150px;">Name</th>
                <th scope="col">Employees</th>
                <th scope="col" style="min-width: 150px;">Phone</th>
                <th scope="col" style="min-width: 150px;">Email Address</th>
                <th scope="col" style="min-width: 150px;">Contract Started</th>
                <th scope="col" style="min-width: 150px;">Contract End Date</th>
                <th scope="col">Industry</th>
                <th scope="col" style="min-width: 150px;">Street Address</th>
                <th scope="col">City</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-center" style="width: 100px;">Actions</th>
            </tr>
        </thead>
        <tbody class="hovabletbody">
            @foreach ($clients as $client)
                <tr onclick="location.href='{{ url('/client', $client) }}'" style="cursor: pointer;">
                    <td class="font-w600">
                        {{$client->client_name}}
                    </td>
                    <td class="font-w600">
                        {{ $client->employees->count() }}
                    </td>
                    <td class="font-w600">
                        {{$client->phone}} <br>
                        {{$client->phone2}}
                    </td>
                    <td>
                        @if(isset($client->user->email))
                            {{$client->user->email}}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        {{$client->contract_start_date}}
                    </td>
                    <td>
                        {{$client->contract_end_date}}
                    </td>
                    <td>
                        {{$client->industry->name ?? 'N/A'}}
                    </td>
                    <td>
                        {{$client->street_address ?? 'N/A'}}
                    </td>
                    <td>
                        {{$client->city ?? 'N/A'}}
                    </td>
                    <td>
                        {{$client->status}}
                    </td>
                    <td class="text-center">
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn btn-primary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Actions for {{ $client->fname }}">
                                <span class="d-sm-inline-block">Action</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end p-0">
                                <div class="p-2">
                                    <a class="dropdown-item nav-main-link" href="{{ url('/client', $client) }}">
                                        <i class="nav-main-link-icon fa fa-eye"></i>
                                        <button class="btn">View</button>
                                    </a>
                                    <form method="POST" class="dropdown-item nav-main-link" action="{{ url('/edit-clinent', $client) }}">
                                        {{ csrf_field() }}
                                        <i class="nav-main-link-icon fa fa-pencil-alt"></i>
                                        <button class="btn" type="submit">Edit</button>
                                    </form>
                                    <form class="dropdown-item nav-main-link" method="POST" action="{{ url('delete-client', $client->id) }}" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <i class="nav-main-link-icon fa fa-trash"></i>
                                        <button class="btn delete-confirm" type="submit">Delete</button>
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
        <p class="p-5">No clients yet registered</p>
    @endif
</div>
