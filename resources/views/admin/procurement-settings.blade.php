<x-admin.layout title="Procurement Team Setup & Role Management">

<div class="container-fluid px-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-cogs text-primary"></i> Team Setup & Role Management
            </h2>
            <p class="text-muted mb-0">
                Select a project to manage team roles and permissions
            </p>
        </div>
        <a href="{{ route('procurement.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            {{ session('success') }}
            <button type="button" class="btn-close" data-dismiss="alert"></button>
        </div>
    @endif

    {{-- Project Cards --}}
    <div class="row g-4">
        @forelse($projects as $project)
            <div class="col-md-2">
                <div class="card h-100 shadow-sm project-card">
                    <div class="card-body d-flex flex-column justify-content-between">

                        <div>
                            <div class="icon-box mb-3">
                                <i class="fas fa-project-diagram"></i>
                            </div>

                            <h5 class="fw-semibold mb-1">
                                {{ $project->project_name }}
                            </h5>

                            <p class="text-muted small mb-3">
                                Project ID: <span class="fw-medium">{{ $project->project_id }}</span>
                            </p>
                        </div>

                        <a href="{{ route('admin.project-roles.index', $project->project_id) }}"
                           class="btn btn-primary w-100">
                            <i class="fas fa-users-cog"></i> Manage
                        </a>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center shadow-sm">
                    <i class="fas fa-info-circle"></i>
                    No projects found. Please create a project first.
                </div>
            </div>
        @endforelse
    </div>

    {{-- Quick Guide --}}
    @if($projects->count() > 0)
    <div class="card mt-5 shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-lightbulb text-warning"></i> Quick Guide
            </h5>

            <div class="row">

                {{-- Roles --}}
                <div class="col-md-6 mb-3">
                    <h6 class="fw-semibold mb-3">Available Roles</h6>
                    <ul class="small text-muted ps-3">
                        <li><strong>Procurement Personnel</strong> – Upload, view & comment on TOR</li>
                        <li><strong>IT Personnel</strong> – Review ICT-related TORs</li>
                        <li><strong>Approver</strong> – Approve/reject TOR and change status</li>
                        <li><strong>TOR Reviewer</strong> – Provide review comments</li>
                    </ul>
                </div>

                {{-- Steps --}}
                <div class="col-md-6 mb-3">
                    <h6 class="fw-semibold mb-3">How to Use</h6>
                    <ol class="small text-muted ps-3">
                        <li>Select a project</li>
                        <li>Review assigned roles</li>
                        <li>Add or update roles</li>
                        <li>Remove roles if necessary</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>

{{-- Styles --}}
<style>
    .project-card {
        border: none;
        border-radius: 12px;
        transition: all 0.25s ease;
    }

    .project-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .icon-box {
        width: 48px;
        height: 48px;
        background: rgba(0, 123, 255, 0.1);
        color: #007bff;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 20px;
    }

    .btn-primary {
        border-radius: 8px;
        font-weight: 500;
    }

    .card {
        border-radius: 12px;
    }
</style>

</x-admin.layout>