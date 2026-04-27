<x-admin.layout title="Edit Roles">
    <section class="content">
    <div class="container-fluid">
    <div class="col-md-11">
    <h5 class="card-header">Edit Role</h5>
    <div class="card-body">
    
      <form class="form-row" id="register_form" action="{{ url('/portal/roles/'.$role->id) }}" method="post">
      @csrf
      @method('PUT')
        <div class="form-group col-md-6">
      <label for="name">Name<span class="text-danger">*</span></label>
      <input type=text placeholder="Enter permission name" id="name"
      class="form-control " name="name" value="{{ $role->name }}">
      <small class="help-text text-muted">Please enter permission name.</small>
      </div>
    
      <div class="col-12">
      <div class="float-right">
      <button type="submit" name="emp_info" class="create-button btn btn-primary"> Update</button>
      <a href="{{url ('/portal/roles') }}" type="submit" name="data" class="btn btn-secondary"></i> Cancel</a>
      </div>
      </div>
      </form>
    </div>
    </div>
    </div>
    </section>
</x-admin.layout>  