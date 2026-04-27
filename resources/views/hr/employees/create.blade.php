<x-admin.layout title="Create Employee">

    <section class="content">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title">Create Employee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/portal">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('employee.index') }}">Employees</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('employee.store') }}" method="POST">
                        @csrf

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Name</label>
                                <input type="text" name="emp_name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="emp_email" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Designation</label>
                                <input type="text" name="emp_designation" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Department</label>
                                <input type="text" name="emp_department" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="emp_status" class="form-control">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-3">
                            <button class="btn btn-success">Save</button>
                            <a href="{{ route('employee.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </section>

</x-admin.layout>