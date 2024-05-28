<div class="table-responsive">
    @if( !$client->employee->isEmpty())
      <table class="table table-bordered table-striped table-vcenter">
          <thead>
              <tr>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th style="min-width: 150px;">Other names</th>
                  <th style="min-width: 150px;">Phone</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th class="text-center" style="width: 100px;">Actions</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($client->employee as $employee)
              <tr>
                <td class="font-w600">
                    {{$employee->fname}}
                </td>
                <td class="font-w600">
                    {{$employee->sname}}
                </td>
                <td class="font-w600">
                    {{$employee->mname}}
                </td>
                <td>
                    {{$employee->phone}}
                </td>
                <td>
                    @if(isset($employee->user->email))

                        {{$employee->user->email}}

                    @else

                    @endif
                </td>
                <td>
                    {{$employee->status}}
                </td>
                <td class="text-center">
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn btn-primary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-sm-inline-block">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-0">
                    <div class="p-2">
                        <a class="dropdown-item nav-main-link" href="{{ url('/viewstudent', $employee->id) }}">
                        <i class="nav-main-link-icon fa fa-user"></i><div class="btn">Profile</div>
                        </a>
                        <form method="POST" class="dropdown-item nav-main-link" action="{{ url('/edit-student', $employee->id) }}">
                            {{ csrf_field() }}
                            <i class="nav-main-link-icon fa fa-pencil"></i>
                            <button class="btn" type="submit">Edit</button>
                        </form>
                        <form class="dropdown-item nav-main-link" method="POST" action="{{ url('student-delete', $employee->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <i class="nav-main-link-icon fa fa-trash"></i>
                            <button class="btn delete-confirm" type="submit">Delete</button>
                        </form>
                        <form method="POST" class="dropdown-item nav-main-link" action="{{ url('send-notification', $employee->id) }}">
                            {{ csrf_field() }}
                            <i class="nav-main-link-icon fa fa-paper-plane"></i>
                            <button class="btn" type="submit">Send balance reminder</button>
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
        <p class="p-5">No employees yet for this client!</p>
    @endif
    </div>
