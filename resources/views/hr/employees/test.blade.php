<x-admin.layout title="Employee List">

    <section class="content">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title">Employee List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/portal">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employees</li>
                    </ul>
                </div>

                @can('employee.create')
                <div class="col-sm-5 col">
                    <a href="{{ route('hr.employees.create') }}" class="btn btn-primary float-right mt-2">
                        <i class="fas fa-plus"></i> Create
                    </a>
                </div>
                @endcan
            </div>

            <div class="card">
                <div class="card-header">
                    <strong>Total Employees:</strong>
                    <span class="bg-primary text-white px-2 py-1 rounded">
                        {{ $employees->count() }}
                    </span>
                </div>

                <div class="card-body">
                    <table class="datatable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#SN</th>
                                <th>Staff ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Designation</th>
                                <th>Project</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $employee->staff_id }}</td>
                                <td>{{ $employee->emp_name }}</td>
                                <td>{{ $employee->emp_email }}</td>
                                <td>{{ $employee->emp_designation }}</td>
                                <td>{{ $employee->project_name }}</td>
                                <td>{{ $employee->emp_location }}</td>
                                <td>
                                    @if($employee->emp_status == 'Active')
                                        <span class="px-2 py-1 rounded-pill bg-success text-white">Active</span>
                                    @else
                                        <span class="px-2 py-1 rounded-pill bg-secondary text-white">Inactive</span>
                                    @endif
                                </td>

                                <td align="center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-bs-toggle="dropdown">
                                            Action
                                        </button>

                                        <ul class="dropdown-menu">

                                            @can('employee.edit')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('hr.employees.edit', $employee->id) }}">
                                                    <span class="fa fa-edit text-primary"></span> Edit
                                                </a>
                                            </li>
                                            @endcan

                                            @can('employee.delete')
                                            <li><div class="dropdown-divider"></div></li>
                                            <li>
                                                <form action="{{ route('hr.employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Delete this employee?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <span class="fa fa-trash text-danger"></span> Delete
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
    </section>

</x-admin.layout>