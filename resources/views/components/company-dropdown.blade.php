<div class="w-full md:w-1/2 px-2">
    <label for="company" class="block mb-2">From (Company/Organization/Location): *</label>
    <select id="company" name="company" 
    class="w-full p-3 border rounded border-gray-300 text-black" required autocomplete="off">
      <option value="">Select</option>
      @foreach($visitorCompanies as $company)
      <option value="{{ $company->company_name }}">{{ $company->company_name }}</option>
      @endforeach
    </select>
    <small class="block mt-2">Not listed? click & write down here.</small>
</div>
