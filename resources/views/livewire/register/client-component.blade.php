<div>
    <h3 class="text-3xl pb-3 mb-2 font-bold text-center bg-gradient-to-r from-pink-600 to-orange-500 bg-clip-text text-transparent">Client Details</h3>

    <div class="mb-4">
        <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
        <input type="text" wire:model="company_name" id="company_name" class="w-full px-4 py-2 border rounded-lg">
        @error('company_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
        <input type="text" wire:model="industry" id="industry" class="w-full px-4 py-2 border rounded-lg">
        @error('industry') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
        <textarea wire:model="address" id="address" class="w-full px-4 py-2 border rounded-lg"></textarea>
        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
        <input type="text" wire:model="contact_number" id="contact_number" class="w-full px-4 py-2 border rounded-lg">
        @error('contact_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
        <input type="url" wire:model="website" id="website" class="w-full px-4 py-2 border rounded-lg" placeholder="https://example.com">
        @error('website') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
</div>
