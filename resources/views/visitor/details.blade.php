<!-- resources/views/admin/visitor-details.blade.php -->

<x-admin.layout title="Visitor Details">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Card -->
                    <div class="card">
                      <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">Visit Details</h3>

                            <a href="{{ route('visitor.index') }}" class="btn btn-primary ml-auto">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            <h4>Visitor Information</h4>
                            <strong><p>Name: {{ $visitor->name }}</p></strong>
                            <strong><p>Organization: {{ $visitor->company->name ?? 'N/A' }}</p></strong>
                            <strong><p>Mobile: {{ $visitor->mobile }}</p></strong>
                            @if(!empty($visitor->email))
                                <strong><p>Email: {{ $visitor->email }}</p></strong>
                            @endif

                            {{-- <h4>Visits</h4> --}}
                            <table class="datatable table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#SN</th>
                                        <th>Visit To</th>
                                        <th>Purpose</th>
                                        <th>Entry Time</th>
                                        <th>Exit Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitor->visits as $visit)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $visit->employee->name }}</td>
                                        <td>{{ $visit->purpose }}</td>
                                        <td>{{ $visit->entry_time ? $visit->entry_time->format('d-M-y H:i a') : 'N/A' }}</td>
                                        <td>{{ $visit->exit_time ? $visit->exit_time->format('d-M-y H:i a') : 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</x-admin.layout>
