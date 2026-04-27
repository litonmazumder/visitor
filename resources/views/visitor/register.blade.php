<x-layout>
    <x-slot name="title">{{ $title }}</x-slot>
        <!-- Form Section -->
        <div class="w-full bg-blue-900 text-white p-8">
            <h3 class="text-2xl font-semibold mb-6">Visitor Registration</h3>
            <form id="visitorForm" action="{{ route('visitor.store') }}" method="POST">
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
                        class="w-full p-3 border rounded border-gray-300 text-black" required autocomplete="off">
                          <option value="">Select</option>
                          @foreach($visitorCompany as $company)
                          <option value="{{ $company->name }}">{{ $company->name }}</option>
                          @endforeach
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
                              <option value="Official" {{ old('purpose') == 'official' ? 'selected' : '' }}>Official Visit</option>
                              <option value="Personal" {{ old('purpose') == 'personal' ? 'selected' : '' }}>Personal Visit</option>
                              <option value="Interview" {{ old('purpose') == 'interview' ? 'selected' : '' }}>Interview</option>
                          </select>
                      </div>
                      <div class="w-full md:w-1/2 px-2 relative">
                        <label for="toWhom" class="block mb-2">To Whom: *</label>
                        <input type="text" id="toWhom" 
                               class="w-full p-3 border rounded border-gray-300 text-black pr-10" 
                               placeholder="Enter name" required autocomplete="off">
                        <input type="hidden" id="empId" name="employee_id" class="w-full p-3 border rounded border-gray-300 text-black" readonly>
                        <div id="staffSuggestions" class="absolute left-2 right-0 w-full bg-white max-h-48 overflow-y-auto z-50 cursor-pointer text-black">
                            <!-- Suggestions will be appended here -->
                        </div>
                        <button type="button" id="clearStaff" class="absolute inset-y-2 right-2 flex items-center text-gray-500 hover:text-gray-700 hidden">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>                           
                  </div>
                  
                  <div class="flex flex-wrap -mx-2 mt-4">
                    <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                        <label for="card_no" class="block mb-2">Card Number: *</label>
                        <select id="card_no" name="cardno" class="w-full p-2.5 border rounded border-gray-300 text-black text-lg" autocomplete="off" required>
                          <option value="">Select</option>
                          @foreach($visitorCards as $card)
                          <option value="{{ $card->card_no }}">{{ $card->card_no }}</option>
                          @endforeach
                        </select>
                    </div>
                      <div class="w-full md:w-1/2 px-2">
                          <label for="accompanied" class="block mb-2">No of Accompanied:</label>
                          <input type="number" id="accompanied" name="accompanied" class="w-full p-3 border rounded border-gray-300 text-black" placeholder="How many people are with you?" autocomplete="off">
                      </div>
                  </div>
              </div>
          
              <div class="flex justify-between items-center">
                  <button id="submitBtn" type="submit" class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600 focus:outline-none focus:ring">
                    <span id="spinnerIcon" class="spinner-border spinner-border-sm hidden" role="status" aria-hidden="true"></span>
                    <span id="buttonText">Submit</span>
                  </button>
                  <a href="search" class="text-white-500 hover:underline">Already Registered?</a>
                </div>
          </form>
          
          </div>
            
</x-layout>



   