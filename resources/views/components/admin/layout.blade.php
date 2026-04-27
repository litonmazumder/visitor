<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SCBD Portal' }}</title>

    {{-- Fonts & Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    {{-- AdminLTE --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">

    {{-- Plugins --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">

<div class="wrapper">

    <x-admin.navbar />
    <x-admin.sidebar />

    <div class="content-wrapper">
        <section class="content pt-3">
            <div class="container-fluid">
                {{ $slot }}
            </div>
        </section>
    </div>

    <footer class="main-footer text-center text-muted">
        <strong>© {{ date('Y') }} SCBD Portal</strong> — IT Team
    </footer>

</div>
@vite(['resources/js/app.js'])

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>


<script>
    $(function () {
        $('.select2-vendors').select2({
            placeholder: 'Select vendors',
            allowClear: true,
            width: 'resolve'
        });
    });
</script>

<!-- <script>
tinymce.init({
    selector: '#email_body',
    height: 300,
    menubar: false,
    plugins: [
        'lists link image table code'
    ],
    toolbar: `
        undo redo |
        bold italic underline |
        alignleft aligncenter alignright |
        bullist numlist |
        link table |
        code
    `
});
</script> -->

<script>
var quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Write email to vendors...',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['link'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['clean']
        ]
    }
});
</script>

<script>
$(document).ready(function () {

    // ✅ Toastr config (IMPORTANT)
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: "3000"
    };

    // ✅ Toast messages
    @if(session('success'))
        toastr.success(@json(session('success')));
    @endif

    @if(session('error'))
        toastr.error(@json(session('error')));
    @endif

    // ✅ DataTable init
    if ($('.datatable').length) {
        $('.datatable').DataTable({
            pageLength: 25,
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search..."
            }
        });
    }

});
</script>

@stack('scripts')

</body>
</html>
