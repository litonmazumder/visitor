<x-admin.layout title="Visitor List">
    <section class="content">
        <div class="container-fluid">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('dashboard') }}">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="start_datetime">Start Date & Time:</label>
                        <input type="datetime-local" id="start_datetime" name="start_datetime" class="form-control" value="{{ request('start_datetime') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_datetime">End Date & Time:</label>
                        <input type="datetime-local" id="end_datetime" name="end_datetime" class="form-control" value="{{ request('end_datetime') }}">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>

            </form>

            <div class="row">
                <div class="col-12">
                    <!-- Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Visitor List</h3>
                        </div>
                        <div class="card-body">
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
                                    @foreach ($ShowVisitors as $visitor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ route('visitor.details', $visitor->id) }}">{{ $visitor->name ?? 'N/A' }}</a></td>
                                        <td>{{ $visitor->company->name ?? 'N/A' }}</td>
                                        <td>{{ $visitor->mobile ?? 'N/A' }}</td>
                                        <td>{{ $visitor->email ?? 'N/A' }}</td>
                                        <td>{{ $visitor->latest_visit->staff->name ?? 'N/A' }}</td>
                                        <td>{{ $visitor->latest_visit ? $visitor->latest_visit->entry_time->format('d-M-y H:i a') : 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-admin.layout>
