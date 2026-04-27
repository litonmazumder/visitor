<x-admin.layout title="User Create">
    <section class="content">
    <div class="container-fluid">
    <div class="col-md-11">
    <h5 class="card-header">New User Information</h5>
    <div class="card-body">
    
      <form class="form-row" action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
      <div class="form-group col-md-6">
      <label for="name">User Name<span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
      <small class="help-text text-muted">Please enter employee name.</small>
      </div>

      <div class="form-group col-md-6">
        <label for="name">Email<span class="text-danger">*</span></label>
        <input type=Email placeholder="Enter email" id="email" class="form-control " name="email" value="{{ $user->email }}">
        <small class="help-text text-muted">Please enter email.</small>
      </div>

      <div class="form-group col-md-6">
        <label for="password">Temporary Password<span class="text-danger"></span></label>
        <input type="password" class="form-control" placeholder="Password" name="password">
        <small class="help-text text-muted">Please enter email.</small>
      </div>
    
      <div class="form-group col-md-6">
      <label for="roles">Roles<span class="text-danger">*</span></label>
      <select class="roles form-control" id="roles" name="roles[]" required>
        @foreach($roles as $role)
            <option value="{{ $role->id }}" 
                {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
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
      <button type="submit" name="emp_info" class="create-button btn btn-primary"> Update</button>
      <a href="/portal/users" type="submit" name="data" class="btn btn-secondary"></i> Cancel</a>
      </div>
      </div>
      </form>
    </div>
    </div>
    </div>
    </section>
</x-admin.layout>  