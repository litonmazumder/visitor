<x-admin.layout title="Visitor List">
  <section class="content">
      <div class="container-fluid">
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
                                      <th>Accompanied</th>
                                      <th>Purpose</th>
                                      <th>Entry Time</th>
                                      <th>Exit Time</th>
                                      {{-- <th>Action</th> --}}
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($ShowVisitors as $visitor)
                                  <tr>
                                      <td>{{ $loop->iteration }}</td>
                                      <td><a href="{{ $visitor->visitor ? route('visitor.details', $visitor->visitor->id) : '#' }}">{{ $visitor->visitor->name ?? 'N/A' }}</a></td>
                                      <td>{{ $visitor->visitor->company->name ?? 'N/A' }}</td>
                                      <td>{{ $visitor->visitor->mobile ?? 'N/A' }}</td>
                                      <td>{{ $visitor->visitor->email ?? 'N/A' }}</td>
                                      <td>{{ $visitor->staff->emp_name ?? 'N/A' }}</td>
                                      <td>{{ $visitor->accompanied ?? 'N/A' }}</td>
                                      <td>{{ $visitor->purpose ?? 'N/A' }}</td>
                                      <td>{{ $visitor->entry_time ? $visitor->entry_time->format('d-M-y H:i a') : 'N/A' }}</td>
                                      <td>{{ $visitor->exit_time ? $visitor->exit_time->format('d-M-y H:i a') : 'N/A' }}</td>
                                      {{-- <td>
                                          <a href="#" class="btn btn-info btn-sm">View</a>
                                          <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                          <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                      </td> --}}
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


  <!-- Initialize DataTables -->

</x-admin.layout>
