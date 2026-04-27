<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Operations Management | Sign in</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- AdminLTE -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">

  <!-- Toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
</head>

<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <b>OPERATIONS MANAGEMENT</b>
  </div>

  <div class="card">
    {{ $slot }}
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

<script>
$(document).ready(function () {

    // Toastr config
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: "3000"
    };

    // Success message
    @if(session('success'))
        toastr.success(@json(session('success')));
    @endif

    // Error message
    @if(session('error'))
        toastr.error(@json(session('error')));
    @endif

    // Refresh CSRF right before POST submits to avoid 419 on long-open pages.
    $('form[method="POST"], form[method="post"]').on('submit', async function (e) {
      const form = this;

      if (form.dataset.csrfRefreshed === '1') {
        return;
      }

      e.preventDefault();

      try {
        const response = await fetch(@json(route('csrf.token')), {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          credentials: 'same-origin'
        });

        if (response.ok) {
          const data = await response.json();
          const tokenInput = form.querySelector('input[name="_token"]');

          if (tokenInput && data.token) {
            tokenInput.value = data.token;
          }
        }
      } catch (error) {
        // Submit anyway; server-side validation will handle unexpected failures.
      }

      form.dataset.csrfRefreshed = '1';
      form.submit();
    });

});
</script>

</body>
</html>