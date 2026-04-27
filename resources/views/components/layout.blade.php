<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'SCBD PORTAL' }}</title>

  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <!-- Include Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2/dist/css/tom-select.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="relative w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden flex">

    {{ $slot }}

     <!-- Logo Section -->
     <div class="absolute top-0 right-0 p-3">
      <img src="{{ asset('images/logos/logo.svg') }}" alt="logo" class="w-48">
    </div>
  </div>

@if(session('success'))
<script>
      toastr.success("{{ session('success') }}");
</script>
@endif

@if($errors->any())
  <script>
      @foreach ($errors->all() as $error)
          toastr.error("{{ $error }}");
      @endforeach
  </script>
@endif


<script src="https://cdn.jsdelivr.net/npm/tom-select@2/dist/js/tom-select.complete.min.js"></script>

<script>
new TomSelect("#card_no", {
    create: false,
    sortField: {
        field: "text",
        direction: "asc"
    }
});

new TomSelect("#company", {
    create: true,  // Allows users to create new tags
    sortField: {
        field: "text",
        direction: "asc"
    }
});
</script>

<script>
  $(document).ready(function() {
      function toggleClearButton(show) {
          if (show) {
              $('#clearStaff').removeClass('hidden');
          } else {
              $('#clearStaff').addClass('hidden');
          }
      }
  
      $('#toWhom').on('input', function() {
          var searchTerm = $(this).val();
  
          if (searchTerm.length >= 3) {
              $.ajax({
                  url: '/api/visitor/staff-suggestions',
                  method: 'GET',
                  data: { searchTerm: searchTerm },
                  dataType: 'json',
                  success: function(data) {
                      $('#staffSuggestions').empty();
                      if (data.length > 0) {
                          data.forEach(function(employee) {
                              var suggestionItem = $('<div class="px-4 p-2 cursor-pointer hover:bg-blue-200 suggestion-item" data-id="' + employee.employee_id + '">' + employee.name + '</div>');
                              suggestionItem.click(function() {
                                  $('#toWhom').val(employee.name);
                                  $('#empId').val(employee.employee_id);
                                  $('#staffSuggestions').empty();
                                  toggleClearButton(true); // Show the clear button
                              });
                              $('#staffSuggestions').append(suggestionItem);
                          });
                      } else {
                          $('#staffSuggestions').append('<div class="px-4 text-gray-500">No suggestions found</div>');
                      }
                  },
                  error: function(xhr, status, error) {
                      console.log("Error fetching suggestions: " + error);
                  }
              });
          } else {
              $('#staffSuggestions').empty();
          }
      });
  
      $('#clearStaff').on('click', function() {
          $('#toWhom').val('');
          $('#empId').val('');
          $('#staffSuggestions').empty();
          toggleClearButton(false); // Hide the clear button
      });
  
      // Initial check to hide clear button if no staff is selected
      toggleClearButton($('#toWhom').val().trim() !== '');
  });
  </script>
  
  
</body>
</html>
