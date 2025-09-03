<form action="{{ route('tags.store') }}" method="POST" class="space-y-4">
    @csrf
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="color" class="block text-sm font-medium text-gray-700">Color (optional)</label>
            <input type="color" name="color" id="color" value="{{ old('color', '#e5e7eb') }}"
                   class="mt-1 block w-full h-10 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('color')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    
    <div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create Tag
        </button>
    </div>
</form>