@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

      <div class="row">
        <div class="col-md-12">
          <form action="">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                <input type="text" name="search" autofocus placeholder="Search by phone or email or name.." class="form-control" value="{{request()->search}}">
                </div>
              </div>
              <div class="col-md-2">
                <select class="form-control"  name="role_id" style="display:inline-block">
                  <option selected disabled>Filter By Role</option>
                  <option></option>
                  @foreach ($roles as $role)
                  <option value="{{$role->id}}" {{ request()->role_id == $role->id ? 'selected' : ''}}>{{$role->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-control"  name="country_id" style="display:inline-block">
                  <option selected disabled>Filter By country</option>
                  <option></option>
                  @foreach ($countries as $country)
                  <option value="{{$country->id}}" {{ request()->country_id == $country->id ? 'selected' : ''}}>{{$country->name_en}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>Search</button>
                @if (auth()->user()->hasPermission('users-create'))
                <a href="{{route('users.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">Create user</button></a>
                @else
                <a href="#" disabled> <button type="button" class="btn btn-primary">Create user</button></a>
                @endif
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">Users</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($users->count() > 0)
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          #id
                      </th>
                      <th>
                          User Name
                      </th>
                      <th>
                          User Profile
                      </th>
                      <th>
                          user Type
                      </th>
                      <th>
                        user country
                    </th>
                      <th>
                        user Roles
                    </th>
                    <th>
                        Orders
                    </th>
                      <th>
                        Created At
                    </th>
                    <th>
                      Updated At
                  </th>
                  <?php if($users !== Null){$user = $users[0];} ?>
                  @if ($user->trashed())
                  <th>
                    Deleted At
                  </th>
                  @endif
                      <th style="" class="text-center">
                          Status
                      </th>
                      <th style="" class="">
                        Actions
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr>

                      @foreach ($users as $user)
                    <td>
                        {{ $user->id }}
                    </td>
                    <td>
                        <small>
                            {{ $user->name }}
                        </small>
                    </td>
                    <td>

                                <img alt="Avatar" class="table-avatar" src="{{ asset('storage/images/users/' . $user->profile) }}">

                    </td>
                    <td>
                        <small>
                            {{ $user->type }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $user->country->name_en }}
                      </small>
                  </td>
                    <td>
                      <small>
                          {{-- {{ implode(', ' , $user->roles->pluck('name')->toArray()) }} --}}
                          @foreach ($user->roles as $role)
                      <h5 style="display: inline-block"><span class="badge badge-primary">{{$role->name}}</span></h5>

                          @endforeach
                      </small>
                  </td>
                  <td>
                    <small>
                        @if (auth()->user()->hasPermission('orders-read'))
                        <a href="{{route('orders.create' , ['lang' => app()->getLocale() , 'user' => $user->id])}}" class="btn btn-sm btn-primary">add order</a>
                        @else
                        <a href="#" class="btn btn-sm btn-primary disabled">add order</a>

                        @endif
                    </small>
                    <small>
                        @if (auth()->user()->hasPermission('addresses-read'))
                        <a href="{{route('addresses.index' , ['lang' => app()->getLocale() , 'user' => $user->id])}}" class="btn btn-sm btn-primary">add address</a>
                        @else
                        <a href="#" class="btn btn-sm btn-primary disabled">add address</a>

                        @endif
                    </small>
                </td>
                    <td>
                        <small>
                            {{ $user->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $user->updated_at }}
                      </small>
                  </td>
                  @if ($user->trashed())
                  <td>
                    <small>
                        {{ $user->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-state">
                        <span class="badge badge-success">Active</span>
                    </td>
                    <td class="project-actions">

                        @if (!$user->trashed())
                        @if (auth()->user()->hasPermission('users-read'))
                        <a class="btn btn-primary btn-sm" href="{{route('users.show' , [app()->getLocale() , $user->id])}}">
                            <i class="fas fa-folder">
                            </i>
                            View
                        </a>
                        @else
                        <a class="btn btn-primary btn-sm" href="#" aria-disabled="true">
                          <i class="fas fa-folder">
                          </i>
                          View
                        </a>
                        @endif
                        @if (auth()->user()->hasPermission('users-update'))
                        <a class="btn btn-info btn-sm" href="{{route('users.edit' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>
                        @else
                        <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Edit
                        </a>
                        @endif
                        @else
                        @if (auth()->user()->hasPermission('users-restore'))
                        <a class="btn btn-info btn-sm" href="{{route('users.restore' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Restore
                        </a>
                        @else
                        <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Restore
                        </a>
                        @endif
                                @endif

                                @if ((auth()->user()->hasPermission('users-delete'))| (auth()->user()->hasPermission('users-trash')))
                                    <form method="POST" action="{{route('users.destroy' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($user->trashed())
                                                    {{ __('Delete') }}
                                                    @else
                                                    {{ __('Trash') }}
                                                    @endif
                                                </button>
                                    </form>
                                    @else
                                    <button class="btn btn-danger btn-sm">
                                      <i class="fas fa-trash">
                                      </i>
                                      @if ($user->trashed())
                                      {{ __('Delete') }}
                                      @else
                                      {{ __('Trash') }}
                                      @endif
                                  </button>
                                  @endif



                    </td>
                </tr>
                      @endforeach


              </tbody>
          </table>

          <div class="row mt-3"> {{ $users->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">No Users To Show</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection

