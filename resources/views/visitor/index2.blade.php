<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visitor Registration</title>
  <!-- Include Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="relative w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden flex">
    <!-- Form Section -->
    <div class="w-full bg-blue-900 text-white p-8">
      <h3 class="text-2xl font-semibold mb-6">Visitor Registration</h3>
      
      <!-- Search Form Inside the Visitor Registration -->
      <form action="/register" method="POST" class="mb-6">
        @csrf
        <div class="flex items-center bg-white text-black rounded-lg overflow-hidden shadow-md">
          <input type="text" name="search" class="w-full p-3 outline-none" placeholder="Search visitor..." required autocomplete="off">
          <button type="submit" class="bg-blue-500 text-white p-3 hover:bg-blue-600">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </form>

      <form id="visitorForm" action="/register" method="POST">
        @csrf
        <div id="formOverlay" class="fixed inset-0 bg-black opacity-50 z-50 hidden"></div>
        
        <!-- Visitor Details -->
        <div class="mb-6">
            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                    <label for="visitorName" class="block mb-2">Visitor Name: *</label>
                    <input type="text" id="visitorName" name="name" 
                    class="w-full p-3 border rounded border-gray-300 text-black" 
                    placeholder="Write your name" required autocomplete="off" value="{{ old('name') }}">
                </div>
                <div class="w-full md:w-1/2 px-2">
                    <label for="visitorMobile" class="block mb-2">Mobile: *</label>
                    <input type="number" id="visitorMobile" name="mobile" 
                    class="w-full p-3 border rounded border-gray-300 text-black" 
                    placeholder="e.g., 0172394444" required autocomplete="off" value="{{ old('mobile') }}">
                </div>
            </div>
            <div class="flex flex-wrap -mx-2 mt-4">
                <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                    <label for="visitorEmail" class="block mb-2">Email:</label>
                    <input type="email" id="visitorEmail" name="email" 
                    class="w-full p-3 border rounded border-gray-300 text-black" 
                    placeholder="Write your email" autocomplete="off" value="{{ old('email') }}">
                </div>
                <div class="w-full md:w-1/2 px-2">
                    <label for="company" class="block mb-2">From (Company/Organization/Location): *</label>
                    <select id="company" name="company" 
                    class="w-full p-3 border rounded border-gray-300 text-black" required autocomplete="off" value="{{ old('company') }}">
                        <option value="Company 1">Company 1</option>
                    </select>
                    <small class="block mt-2">Not listed? click & write down here.</small>
                </div>
            </div>
        </div>
    
        <!-- Visit Details -->
        <div class="mb-6">
            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                    <label for="purpose" class="block mb-2">Purpose of Visit: *</label>
                    <select id="purpose" name="purpose" class="w-full p-3 border rounded border-gray-300 text-black" required>
                        <option value="">Select</option>
                        <option value="official" {{ old('purpose') == 'official' ? 'selected' : '' }}>Official Visit</option>
                        <option value="personal" {{ old('purpose') == 'personal' ? 'selected' : '' }}>Personal Visit</option>
                    </select>
                </div>
                <div class="w-full md:w-1/2 px-2 relative mb-4 md:mb-0">
                    <label for="toWhom" class="block mb-2">To Whom: *</label>
                    <input type="text" id="toWhom" name="towhom" 
                    class="w-full p-3 border rounded border-gray-300 text-black" 
                    placeholder="Enter name" required autocomplete="off" value="{{ old('towhom') }}">
                    <input type="hidden" id="staffId" name="staffId">
                </div>
            </div>
            <div class="flex flex-wrap -mx-2 mt-4">
                <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                    <label for="card_no" class="block mb-2">Card Number: *</label>
                    <select id="card_no" name="cardno" class="w-full p-3 border rounded border-gray-300 text-black" autocomplete="off" required>
                        <option value="">Select</option>
                        @for($i = 901; $i <= 915; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="w-full md:w-1/2 px-2">
                    <label for="accompanied" class="block mb-2">No of Accompanied:</label>
                    <input type="number" id="accompanied" name="accompanied" class="w-full p-3 border rounded border-gray-300 text-black" placeholder="How many people are with you?" autocomplete="off">
                </div>
            </div>
        </div>
    
        <div class="flex justify-end items-center mt-6">
            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600 focus:outline-none focus:ring">
                Submit
            </button>
        </div>
    </form>
    
    </div>

    <!-- Logo Section -->
    <div class="absolute top-0 right-0 p-2">
      <img src="http://192.168.1.212/public/resource/images/Swisscontact_logo_negative_rgb.png" alt="logo" class="w-48">
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

</body>
</html>
