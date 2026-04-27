<x-admin.layout title="Edit Employee">

    <section class="content">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title">Edit Employee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('employee.index') }}">Employees</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('employee.update', $employee->employee_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name', $employee->name) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email', $employee->email) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Designation</label>
                                <input type="text" name="designation" class="form-control"
                                       value="{{ old('designation', $employee->designation) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Department</label>
                                <input type="text" name="department" class="form-control"
                                       value="{{ old('department', $employee->department) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="Active" {{ $employee->status == 'Active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="Inactive" {{ $employee->status == 'Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-3">
                            <button class="btn btn-success">Update</button>
                            <a href="{{ route('employee.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </section>

</x-admin.layout>