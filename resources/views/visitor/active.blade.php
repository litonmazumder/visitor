<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Visitors</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Active Visitor Information</h2>

    <!-- Search Field Positioned to the Right -->
    <div class="flex justify-end mb-4">
        <div class="w-full max-w-xs">
            <input type="text" class="form-input w-full p-2 border border-gray-300 rounded-lg shadow-sm" id="searchCard" placeholder="Search by Card Number">
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">To Whom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobile</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. of Accomp.</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Card No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entry Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody id="live-data-body" class="bg-white divide-y divide-gray-200">
                <!-- Data will be inserted here by JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function fetchActiveVisitors(searchTerm = '') {
        $.ajax({
    url: '{{ route('api.visitor.active') }}',
    method: 'GET',
    data: { searchTerm: searchTerm },
    success: function(data) {
        var tbody = $('#live-data-body');
        tbody.empty();
        data.forEach(function(visit, index) {
            console.log(visit); // Debug data
            var row = '<tr>' +
                '<td class="px-6 py-4 whitespace-nowrap">' + (index + 1) + '</td>' +
                '<td class="px-6 py-4 whitespace-nowrap">' + (visit.visitor ? visit.visitor.name : 'N/A') + '</td>' +
                '<td class="px-6 py-4 whitespace-nowrap">' + (visit.staff ? visit.staff.emp_name : 'N/A') + '</td>' +
                '<td class="px-6 py-4 whitespace-nowrap">' + (visit.visitor ? visit.visitor.mobile : 'N/A') + '</td>' +
                '<td class="px-6 py-4 whitespace-nowrap">' + visit.purpose + '</td>' +
                '<td class="px-6 py-4 whitespace-nowrap">' + (visit.visitor ? visit.visitor.company.name : 'N/A') + '</td>' +
                '<td class="px-6 py-4 whitespace-nowrap">' + (visit.visitor ? visit.accompanied : 'N/A') + '</td>' +
                '<td class="px-6 py-4 whitespace-nowrap">' + visit.cardno + '</td>' +
                '<td class="px-6 py-4 whitespace-nowrap">' + (visit.entry_time ? new Date(visit.entry_time).toLocaleString() : 'N/A') + '</td>' +
                '<td class="px-6 py-4 whitespace-nowrap">' +
                    '<button class="bg-red-500 text-white px-4 py-2 rounded exit-button" data-visit-id="' + visit.id + '">' +
                        'Exit' +
                    '</button>' +
                '</td>' +
            '</tr>';
            tbody.append(row);
        });
    },
    error: function(xhr, status, error) {
        console.log("Error fetching active visitors: " + error);
    }
});

    }

    function exitVisitor(visitId) {
        $.ajax({
            url: '{{ route('api.visitor.exit') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                visit_id: visitId
            },
            success: function(response) {
                if (response.success) {
                    alert('Visitor exited successfully');
                    fetchActiveVisitors($('#searchCard').val()); // Refresh data
                } else {
                    alert('Failed to mark visitor as exited.');
                }
            },
            error: function(xhr, status, error) {
                console.log("Error exiting visitor: " + error);
                alert('Failed to exit visitor: ' + xhr.responseText);
            }
        });
    }

    $(document).on('click', '.exit-button', function() {
        var visitId = $(this).data('visit-id');
        if (confirm('Are you sure you want to exit this visitor?')) {
            exitVisitor(visitId);
        }
    });

    // Initial fetch
    fetchActiveVisitors();

    // Search functionality
    $('#searchCard').on('input', function() {
        var searchTerm = $(this).val();
        fetchActiveVisitors(searchTerm);
    });

    // Fetch data every 5 seconds
    setInterval(function() {
        fetchActiveVisitors($('#searchCard').val());
    }, 5000);
});

</script>

</body>
</html>
