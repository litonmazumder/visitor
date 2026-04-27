<x-admin.layout title="Role Create">
    <section class="content">
    <div class="container-fluid">
    <div class="col-md-11">
    <h5 class="card-header">Add new Role</h5>
    <div class="card-body">
    
      <form class="form-row" id="register_form" action="{{ url('/portal/roles') }}" method="post">
      @csrf
        <div class="form-group col-md-6">
      <label for="name">Name<span class="text-danger">*</span></label>
      <input type=text value="" placeholder="Enter role name" id="name"
      class="form-control " name="name" required>
      <small class="help-text text-muted">Please enter role name.</small>
      </div>
    
      <div class="col-12">
      <div class="float-right">
      <button type="submit" name="" class="create-button btn btn-primary"> Create</button>
      <a href="{{url ('/portal/roles') }}" type="submit" name="data" class="btn btn-secondary"></i> Cancel</a>
      </div>
      </div>
      </form>
    </div>
    </div>
    </div>
    </section>
</x-admin.layout>  