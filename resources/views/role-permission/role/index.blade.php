<x-admin.layout title="Roles List">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Card -->
                    <div class="card">
                        <section class="content-header">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="col-sm-7 col-auto">
                                        <h3 class="page-title">Roles List</h3>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/portal">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Users List</li>
                                        </ul>
                                    </div>
                                    @can('role.create')
                                    <div class="col-sm-5 col">
                                        <a href="{{url ('/portal/roles/create') }}" class="btn btn-primary float-right mt-2"><i class="fas fa-plus"></i> Add</a>
                                    </div>
                                    @endcan
                                </div>
                            </div>
                        </section>
                        @if (session('status'))

                        <div class="alert alert-success">{{ session('status') }}</div>
                            
                        @endif
                        <div class="card-body">
                            <table class="datatable table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#SN</th>
                                        <th>Name</th>
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <ul>
                                                @if($role->permissions->isEmpty())
                                                    <li>No permissions assigned</li>
                                                @else
                                                    @foreach($role->permissions as $permission)
                                                        <li>{{ $permission->name }}</li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </td>
                                        <td align="center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    Action <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @can('role.view')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ url('/portal/roles/'.$role->id.'/give-permissions') }}">
                                                            <span class="fa fa-plus text-primary"></span> permission
                                                        </a>
                                                    </li>
                                                    @endcan
                                                    @can('role.edit')
                                                    <li><div class="dropdown-divider"></div></li>      
                                                    <li>
                                                        <a class="dropdown-item" href="{{ url('/portal/roles/'.$role->id.'/edit') }}">
                                                            <span class="fa fa-edit text-primary"></span> Edit
                                                        </a>
                                                    </li>
                                                   @endcan
                                                   
                                                    <li><div class="dropdown-divider"></div></li>
                                                    @can('role.delete')
                                                    <li>
                                                        <form action="{{ route('role.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">
                                                                <span class="fa fa-trash" style="color:red;"></span> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                    @endcan                                                    
                                                </ul>
                                            </div>
                                        </td>                               
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-admin.layout>
