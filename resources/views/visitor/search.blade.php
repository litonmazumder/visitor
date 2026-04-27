<x-layout>
  <x-slot name="title">{{ $title }}</x-slot>  
<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="relative w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden flex">
    <!-- Form Section -->
    <div class="w-full bg-blue-900 text-white p-8">
      <h3 class="text-2xl font-semibold mb-6">Search Visitor</h3>
      <form action="/visitor/search/result" method="get">
        <div class="mb-4">
          {{-- <label for="visitorMobile" class="block text-gray-700 font-medium mb-2">Visitor Mobile:</label> --}}
          <input type="tel" id="visitorMobile" name="visitorMobile" pattern="[0-9]{11}" placeholder="Enter your mobile number" required autocomplete="off"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-150 ease-in-out text-black">
        </div>
        <div class="flex items-center justify-between mt-6">
          <button type="submit" class="bg-blue-600 text-white font-medium px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition duration-150 ease-in-out">
            Search
          </button>
          <a href="/visitor/register" class="text-white-500 hover:underline">New Visitor?</a>
        </div>
      </form>
    
    </div>

</x-layout>
