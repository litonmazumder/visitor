<x-admin.layout title="Users List">
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
                                        <h3 class="page-title">Permissions List</h3>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/portal">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Users List</li>
                                        </ul>
                                    </div>
                                    @can('permission.create')
                                    <div class="col-sm-5 col">
                                        <a href="{{url ('/portal/permissions/create') }}" class="btn btn-primary float-right mt-2"><i class="fas fa-plus"></i> Add</a>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td align="center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    Action <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @can('permission.edit')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ url('/portal/permissions/'.$permission->id.'/edit') }}">
                                                            <span class="fa fa-edit text-primary"></span> Edit
                                                        </a>
                                                    </li>
                                                    @endcan
                                                    @can('permission.delete')
                                                    <li><div class="dropdown-divider"></div></li>
                                                    
                                                    <li>
                                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permission?');">
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
