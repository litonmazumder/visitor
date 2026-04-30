<x-admin.layout title="Active Visitor Information">

<section class="content">
    <div class="container-fluid">

        <!-- Header -->
        <div class="row mb-3 items-center">
            <div class="col-sm-6">
                <h3 class="page-title">Active Visitor Information</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Active Visitor
                    </li>
                </ul>
            </div>
        </div>

        <!-- Card -->
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <strong>
                    Total Active Visitors:
                    <span id="total-count" class="bg-primary text-white px-2 py-1 rounded">
                        0
                    </span>
                </strong>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="datatable table table-bordered table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>To Whom</th>
                                <th>Mobile</th>
                                <th>Purpose</th>
                                <th>From</th>
                                <th>Card No</th>
                                <th>Entry Time</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody id="live-data-body">
                            <tr>
                                <td colspan="9" class="text-center py-3">
                                    Loading...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function () {

    function fetchActiveVisitors(searchTerm = '') {
        $.ajax({
            url: '{{ route('api.visitor.active') }}',
            method: 'GET',
            data: { searchTerm: searchTerm },

            success: function(data) {

                let tbody = $('#live-data-body');
                tbody.empty();

                $('#total-count').text(data.length);

                if (data.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="9" class="text-center py-3">
                                No active visitors found
                            </td>
                        </tr>
                    `);
                    return;
                }

                data.forEach((visit, index) => {

                    let visitor = visit.visitor ?? {};
                    let company = visitor.company ?? {};
                    let staff = visit.staff ?? {};

                    let row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${visitor.name ?? 'N/A'}</td>
                            <td>${staff.emp_name ?? 'N/A'}</td>
                            <td>${visitor.mobile ?? 'N/A'}</td>
                            <td>${visit.purpose ?? 'N/A'}</td>
                            <td>${company.name ?? 'N/A'}</td>
                            <td>${visit.cardno ?? 'N/A'}</td>
                            <td>${visit.entry_time ? new Date(visit.entry_time).toLocaleString() : 'N/A'}</td>
                            <td class="text-center">
                                <button 
                                    class="btn btn-danger btn-sm exit-button"
                                    data-id="${visit.id}">
                                    Exit
                                </button>
                            </td>
                        </tr>
                    `;

                    tbody.append(row);
                });
            },

            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }


    function exitVisitor(id) {
        $.ajax({
            url: '{{ route('api.visitor.exit') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                visit_id: id
            },

            success: function(res) {
                if (res.success) {
                    fetchActiveVisitors($('#searchCard').val());
                } else {
                    alert('Exit failed');
                }
            },

            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    }


    // Exit click
    $(document).on('click', '.exit-button', function () {
        let id = $(this).data('id');

        if (confirm('Confirm exit?')) {
            exitVisitor(id);
        }
    });


    // Search
    $('#searchCard').on('input', function () {
        fetchActiveVisitors($(this).val());
    });


    // Auto refresh
    setInterval(() => {
        fetchActiveVisitors($('#searchCard').val());
    }, 5000);


    // Initial load
    fetchActiveVisitors();

});
</script>

</x-admin.layout>