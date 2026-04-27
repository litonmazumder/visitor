<x-admin.layout title="User Create">
        <section class="content">
        <div class="container-fluid">
        <div class="col-md-11">
        <h5 class="card-header">New User Information</h5>
        <div class="card-body">
        
          <form class="form-row" id="register_form" action="{{ url('/portal/users') }}" method="post">
          @csrf
          <div class="form-group col-md-6">
          <label for="name">User Name<span class="text-danger">*</span></label>
          <input type=text value="" placeholder="Enter employee name" id="name"
          class="form-control " name="name" min="0" max="" required>
          <small class="help-text text-muted">Please enter employee name.</small>
          </div>

          <div class="form-group col-md-6">
            <label for="name">Email<span class="text-danger">*</span></label>
            <input type=Email value=""
            placeholder="Enter email" id="email"
            class="form-control " name="email" min="0" max="" step="0.01" required>
            <small class="help-text text-muted">Please enter email.</small>
          </div>

          <div class="form-group col-md-6">
            <label for="password">Temporary Password<span class="text-danger">*</span></label>
            <input type="password" class="form-control" placeholder="Password" name="password" required>
            <small class="help-text text-muted">Please enter email.</small>
          </div>
        
          <div class="form-group col-md-6">
          <label for="roles">Roles<span class="text-danger">*</span></label>
          <select class="roles form-control" id="roles" name="roles[]" required>
            <option value="">Select</option>
            @foreach($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
          @endforeach
          </select>
          <small class="help-text text-muted">Please select roles.</small>
        </div>
        
          {{-- <div class="form-group col-md-6">
          <label for="project">Status<span class="text-danger">*</span></label>
          <select class="project form-control" id="project" name="emp_status" required>
            <option value="">Select</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
          <small class="help-text text-muted">Please choose a status.</small>
          </div> --}}
        
        
          <div class="col-12">
          <div class="float-right">
          <button type="submit" name="emp_info" class="create-button btn btn-primary"> Create</button>
          <a href="/portal/users" type="submit" name="data" class="btn btn-secondary"></i> Cancel</a>
          </div>
          </div>
          </form>
        </div>
        </div>
        </div>
        </section>
</x-admin.layout>  