<x-admin.layout title="Access Denied">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle"></i> Access Denied
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-1">403</h1>
                    <h4>Forbidden</h4>
                    <p class="lead">You don't have permission to access this page.</p>
                    <p>You may not have the required permissions, or your permissions may have been recently changed.</p>

                    <div class="mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Go Back
                        </a>
                        <a href="#" class="btn btn-primary ml-2">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </div>

                    @if(auth()->check())
                        <div class="mt-4">
                            <small class="text-muted">
                                Logged in as: {{ auth()->user()->name ?? auth()->user()->emp_name ?? 'Unknown' }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</x-admin.layout>