<x-admin.layout title="Visitor List">
    <section class="content">
        <div class="container-fluid">

            <!-- Filter Card -->
            <div class="card card-outline card-primary mb-4">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-filter mr-2"></i> Filter Visitors
                    </h3>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('visitor_list.search') }}">
                        <div class="row">

                            <!-- Start Date -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_datetime">Start Date & Time</label>
                                    <input type="datetime-local"
                                           id="start_datetime"
                                           name="start_datetime"
                                           class="form-control"
                                           value="{{ request('start_datetime') }}">
                                </div>
                            </div>

                            <!-- End Date -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_datetime">End Date & Time</label>
                                    <input type="datetime-local"
                                           id="end_datetime"
                                           name="end_datetime"
                                           class="form-control"
                                           value="{{ request('end_datetime') }}">
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="w-100 d-flex justify-content-end">
                                    
                                    <a href="{{ route('dashboard') }}" class="btn btn-secondary mr-2">
                                        <i class="fas fa-undo"></i> Reset
                                    </a>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Apply Filter
                                    </button>

                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- Visitor Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-users mr-2"></i> All Visitor List
                    </h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#SN</th>
                                    <th>Visitor Name</th>
                                    <th>Organization</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Visit To</th>
                                    <th>Entry Time</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($ShowVisitors as $visitor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            <a href="{{ route('visitor.details', $visitor->id) }}" class="font-weight-bold text-primary">
                                                {{ $visitor->name ?? 'N/A' }}
                                            </a>
                                        </td>

                                        <td>{{ $visitor->company->name ?? 'N/A' }}</td>
                                        <td>{{ $visitor->mobile ?? 'N/A' }}</td>
                                        <td>{{ $visitor->email ?? 'N/A' }}</td>
                                        <td>{{ $visitor->latest_visit->employee->name ?? 'N/A' }}</td>

                                        <td>
                                            {{ $visitor->latest_visit && $visitor->latest_visit->entry_time 
                                                ? $visitor->latest_visit->entry_time->format('d-M-y h:i A') 
                                                : 'N/A' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            No visitors found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</x-admin.layout>