<x-admin.layout title="Active Visitor Information">

<section class="content">
    <div class="container-fluid">

        <!-- Header -->
        <div class="row mb-3">
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

            <!-- Header with Search -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>
                    Total Active Visitors:
                    <span id="total-count" class="badge badge-primary">
                        0
                    </span>
                </strong>

                <input type="text"
                       id="searchCard"
                       class="form-control w-25"
                       placeholder="Search by name / card...">
            </div>

            <!-- Table -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="thead-light">
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
                                <td colspan="9" class="text-center py-3 text-muted">
                                    Loading visitors...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</section>


<script>
$(document).ready(function () {

    console.log("Active Visitor Script Loaded");

    let debounceTimer;

    function fetchActiveVisitors(searchTerm = '') {

        $.ajax({
            url: "{{ url('dashboard/visitor/fetch') }}",
            method: 'GET',
            data: { searchTerm: searchTerm },

            beforeSend: function () {
                $('#live-data-body').html(`
                    <tr>
                        <td colspan="9" class="text-center py-3 text-muted">
                            Loading...
                        </td>
                    </tr>
                `);
            },

            success: function(data) {

                console.log("DATA:", data);

                let tbody = $('#live-data-body');
                tbody.empty();

                $('#total-count').text(data.length);

                if (!data || data.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="9" class="text-center py-3 text-muted">
                                No active visitors found
                            </td>
                        </tr>
                    `);
                    return;
                }

                data.forEach((visit, index) => {

                    let visitor = visit.visitor || {};
                    let company = visitor.company || {};
                    let staff = visit.employee || {};

                    let entryTime = visit.entry_time
                        ? new Date(visit.entry_time).toLocaleString()
                        : 'N/A';

                    let row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${visitor.name || 'N/A'}</td>
                            <td>${staff.name || 'N/A'}</td>
                            <td>${visitor.mobile || 'N/A'}</td>
                            <td>${visit.purpose || 'N/A'}</td>
                            <td>${company.name || 'N/A'}</td>
                            <td>${visit.cardno || 'N/A'}</td>
                            <td>${entryTime}</td>
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
                console.error("ERROR:", xhr.responseText);

                $('#live-data-body').html(`
                    <tr>
                        <td colspan="9" class="text-center text-danger py-3">
                            Failed to load data
                        </td>
                    </tr>
                `);
            }
        });
    }


    function exitVisitor(id) {

        $.ajax({
            url: "{{ route('api.visitor.exit') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
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


    // Exit button
    $(document).on('click', '.exit-button', function () {
        let id = $(this).data('id');

        if (confirm('Confirm exit?')) {
            exitVisitor(id);
        }
    });


    // Search with debounce
    $('#searchCard').on('input', function () {
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            fetchActiveVisitors($(this).val());
        }, 400);
    });


    // Auto refresh every 5 sec
    setInterval(() => {
        fetchActiveVisitors($('#searchCard').val());
    }, 5000);


    // Initial load
    fetchActiveVisitors();

});
</script>

</x-admin.layout>