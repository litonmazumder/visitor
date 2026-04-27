<x-layout>
    <!-- Form Section -->
    <div class="w-full bg-blue-900 text-white p-8">
        <h3 class="text-2xl font-semibold mb-6">Visitor Search Result</h3>
        <form id="visitorForm" action="{{route('record.visit')}}" method="POST">
          @csrf
          <div id="formOverlay" class="fixed inset-0 bg-black opacity-50 z-50 hidden"></div>
          
          <!-- Visitor Details -->
          <div class="mb-6">
              <div class="flex flex-wrap -mx-2">
                  <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                      <label for="visitorName" class="block mb-2">Visitor Name: *</label>
                      <input type="hidden" name="visitor_id" value="{{$visitor->id}}" class="text-black">
                      <input type="text" id="visitorName" name="name" 
                      class="w-full p-3 border rounded border-gray-300 text-black" 
                      placeholder="Write your name" required autocomplete="off" value="{{$visitor->name}}" readonly>
                  </div>
                  <div class="w-full md:w-1/2 px-2">
                      <label for="visitorMobile" class="block mb-2">Mobile: *</label>
                      <input type="number" id="visitorMobile" name="mobile" 
                      class="w-full p-3 border rounded border-gray-300 text-black" 
                      placeholder="e.g., 0172394444" required autocomplete="off" value="{{ $visitor->mobile ?? '' }}" readonly>
                  </div>
              </div>
              <div class="flex flex-wrap -mx-2 mt-4">
                  <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                      <label for="visitorEmail" class="block mb-2">Email:</label>
                      <input type="email" id="visitorEmail" name="email" 
                      class="w-full p-3 border rounded border-gray-300 text-black" 
                      placeholder="Write your email" autocomplete="off" value="{{ $visitor->email ?? '' }}" readonly>
                  </div>
                  <div class="w-full md:w-1/2 px-2">
                    <label for="company" class="block mb-2">From (Company/Organization/Location): *</label>
                    <select id="company" name="company" 
                    class="w-full p-3 border rounded border-gray-300 text-black" required autocomplete="off">
                      <option value="{{$visitor->company->name}}">{{$visitor->company->name}}</option>
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
                  <div class="w-full md:w-1/2 px-2 relative mb-4 md:mb-0">
                    <label for="toWhom" class="block mb-2">To Whom: *</label>
                    <input type="text" id="toWhom" 
                           class="w-full p-3 border rounded border-gray-300 text-black" 
                           placeholder="Enter name" required autocomplete="off">
                           <input type="hidden" id="empId" name="employee_id" class="w-full p-3 border rounded border-gray-300 text-black" readonly>
                           <div id="staffSuggestions" class="absolute start-0 w-full bg-white max-h-48 overflow-y-auto z-50 text-black">
                            <!-- Suggestions will be appended here -->
                        </div>                        
                </div>
              </div>
              <div class="flex flex-wrap -mx-2 mt-4">
                <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                    <label for="card_no" class="block mb-2">Card Number: *</label>
                    <select id="card_no" name="cardno" class="w-full p-2.5 border rounded border-gray-300 text-black text-base leading-tight" autocomplete="off" required>
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
              <a href="/visitor/register" class="text-white-500 hover:underline">Start Over?</a>
            </div>
      </form>
      
      </div>
      
</x-layout>