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
                    <li class="breadcrumb-item active">Active Visitor</li>
                </ul>
            </div>
        </div>

        <!-- Alpine App -->
        <div x-data="visitorApp()" x-init="init()">

            <!-- Card -->
            <div class="card">

                <!-- Header -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>
                        Total Active Visitors:
                        <span class="badge badge-primary" x-text="visitors.length"></span>
                    </strong>

                    <input type="text"
                           x-model="search"
                           @input.debounce.400ms="fetchData()"
                           class="form-control w-25"
                           placeholder="Search visitor...">
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

                            <tbody>

                                <!-- Loading -->
                                <template x-if="loading">
                                    <tr>
                                        <td colspan="9" class="text-center py-3 text-muted">
                                            Loading visitors...
                                        </td>
                                    </tr>
                                </template>

                                <!-- No Data -->
                                <template x-if="!loading && visitors.length === 0">
                                    <tr>
                                        <td colspan="9" class="text-center py-3 text-muted">
                                            No active visitors found
                                        </td>
                                    </tr>
                                </template>

                                <!-- Data -->
                                <template x-for="(visit, index) in visitors" :key="visit.id">
                                    <tr>
                                        <td x-text="index + 1"></td>
                                        <td x-text="visit.visitor?.name || 'N/A'"></td>
                                        <td x-text="visit.employee?.name || 'N/A'"></td>
                                        <td x-text="visit.visitor?.mobile || 'N/A'"></td>
                                        <td x-text="visit.purpose || 'N/A'"></td>
                                        <td x-text="visit.visitor?.company?.name || 'N/A'"></td>
                                        <td x-text="visit.cardno || 'N/A'"></td>
                                        <td x-text="formatTime(visit.entry_time)"></td>
                                        <td class="text-center">
                                            <button 
                                                @click="exitVisitor(visit.id)"
                                                class="btn btn-danger btn-sm">
                                                Exit
                                            </button>
                                        </td>
                                    </tr>
                                </template>

                            </tbody>

                        </table>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<!-- Alpine.js -->
<script src="https://unpkg.com/alpinejs" defer></script>

<script>
function visitorApp() {
    return {
        visitors: [],
        search: '',
        loading: true,

        init() {
            this.fetchData();

            // Auto refresh every 5 seconds
            setInterval(() => {
                this.fetchData();
            }, 5000);
        },

        fetchData() {
            this.loading = true;

            fetch("{{ url('dashboard/visitor/fetch') }}?searchTerm=" + this.search)
                .then(res => res.json())
                .then(data => {
                    this.visitors = data;
                    this.loading = false;
                })
                .catch(err => {
                    console.error("Fetch error:", err);
                    this.loading = false;
                });
        },

        exitVisitor(id) {
            if (!confirm("Confirm exit?")) return;

            fetch("{{ route('api.visitor.exit') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ visit_id: id })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    this.fetchData();
                } else {
                    alert("Exit failed");
                }
            })
            .catch(err => alert("Error: " + err));
        },

        formatTime(time) {
            return time ? new Date(time).toLocaleString() : 'N/A';
        }
    }
}
</script>

</x-admin.layout>