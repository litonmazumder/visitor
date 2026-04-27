<x-admin.layout title="Project Role Management - {{ $project->project_name }}">

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">
                <i class="fas fa-users-cog"></i> Project Role Management
            </h1>
            <p class="text-muted">{{ $project->project_name }}</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.procurement.settings') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Current Role Assignments -->
            @foreach($roleDictionary as $roleType => $roleLabel)
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user-check"></i> {{ $roleLabel }}
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($roleAssignments->has($roleType) && $roleAssignments[$roleType]->count() > 0)
                            <div class="list-group">
                                @foreach($roleAssignments[$roleType] as $role)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            @if($role->staff)
                                                <h6 class="mb-0">{{ $role->staff->emp_name }}</h6>
                                                <small class="text-muted">ID: {{ $role->staff->staff_id }}</small>
                                            @else
                                                <h6 class="mb-0 text-danger"><em>Staff Not Found</em></h6>
                                                <small class="text-muted">ID: {{ $role->user_id }}</small>
                                            @endif
                                        </div>
                                        <form action="{{ route('admin.project-roles.remove', [$project->project_id, $role->id]) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('Are you sure you want to remove this role?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">
                                <em>No staff assigned to this role yet.</em>
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-lg-4">
            <!-- Assign New Role -->
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle"></i> Assign New Role
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.project-roles.assign', $project->project_id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="role_type" class="font-weight-bold">Role</label>
                            <select name="role_type" id="role_type" class="form-control @error('role_type') is-invalid @enderror" required>
                                <option value="">-- Select Role --</option>
                                @foreach($roleDictionary as $roleType => $roleLabel)
                                    <option value="{{ $roleType }}" @if(old('role_type') === $roleType) selected @endif>
                                        {{ $roleLabel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="user_id" class="font-weight-bold">Staff Member</label>
                            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                <option value="">-- Select Staff Member --</option>
                                @foreach($availableStaff as $staff)
                                    <option value="{{ $staff->staff_id }}" @if(old('user_id') == $staff->staff_id) selected @endif>
                                        {{ $staff->emp_name }} ({{ $staff->staff_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-check"></i> Assign Role
                        </button>
                    </form>

                    @if($availableStaff->isEmpty())
                        <div class="alert alert-info mt-3 mb-0">
                            <small>All active staff have been assigned at least one role in this project.</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Help Section -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Role Descriptions
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="small">
                        <dt><strong>Procurement Personnel</strong></dt>
                        <dd>Can view TOR documents, add comments, and manage procurement workflow.</dd>

                        <dt><strong>IT Personnel</strong></dt>
                        <dd>Can view and comment on ICT service TORs only. Manual assignment required for ICT projects.</dd>

                        <dt><strong>Approver</strong></dt>
                        <dd>Can view all TORs, add comments, and approve/reject TOR documents.</dd>

                        <dt><strong>TOR Reviewer</strong></dt>
                        <dd>Can view TOR documents and add comments for review purposes.</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .sticky-top {
        position: sticky;
    }
</style>
</x-admin.layout>
