<x-admin.layout title="Role Create">
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-11">
                <h5 class="card-header">Add Permissions to Role: <strong>{{ $role->name }}</strong></h5>
                <div class="card-body">
                    @error('permission')
                        <span>{{$message}}</span>
                    @enderror

                    <form class="form-row" id="register_form" action="{{ route('roles.give-permissions.store', $role->id) }}" method="post">
                        @csrf

                        {{-- Dynamic Permission Groups --}}
                        @php
                            // Grouping permissions by their prefix (before the dot)
                            $groupedPermissions = $permissions->groupBy(function($permission) {
                                return explode('.', $permission->name)[0]; // Extract the group from permission name
                            });
                        @endphp

                        {{-- Display Permission Groups --}}
                        @foreach($groupedPermissions as $group => $permissionsInGroup)
                            <div class="form-group col-md-6">
                                <h6 class="mb-3">
                                    <strong>{{ ucfirst($group) }} Permissions</strong>
                                    <input type="checkbox" id="check-all-{{ $group }}" class="ml-2"> Check All
                                </h6>
                                <div class="form-check">
                                    @foreach($permissionsInGroup as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   value="{{ $permission->id }}"                               
                                                   class="form-check-input {{ $group }}-permission" 
                                                   name="permission[]"
                                                   {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ ucfirst(str_replace('.', ' ', $permission->name)) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        {{-- Submit and Cancel --}}
                        <div class="col-12">
                            <div class="float-right">
                                <button type="submit" class="create-button btn btn-primary">Update</button>
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- JavaScript to handle "Check All" functionality --}}
    <script>
        @foreach($groupedPermissions as $group => $permissionsInGroup)
            // Handle "Check All" for each group
            document.getElementById('check-all-{{ $group }}').addEventListener('change', function () {
                const permissions = document.querySelectorAll('.{{ $group }}-permission');
                permissions.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        @endforeach
    </script>
</x-admin.layout>
