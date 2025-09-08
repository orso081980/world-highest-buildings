<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Skyscraper') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('buildings.update', $building) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Building Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Building Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $building->name) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" id="city" value="{{ old('city', $building->city) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Status</option>
                                    <option value="Planned" {{ old('status', $building->status) == 'Planned' ? 'selected' : '' }}>Planned</option>
                                    <option value="Under Construction" {{ old('status', $building->status) == 'Under Construction' ? 'selected' : '' }}>Under Construction</option>
                                    <option value="Completed" {{ old('status', $building->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Completion Year -->
                            <div>
                                <label for="completion_year" class="block text-sm font-medium text-gray-700">Completion Year</label>
                                <input type="number" name="completion_year" id="completion_year" value="{{ old('completion_year', $building->completion_year) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    min="1900" max="2100">
                                @error('completion_year')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Height -->
                            <div>
                                <label for="height" class="block text-sm font-medium text-gray-700">Height</label>
                                <input type="text" name="height" id="height" value="{{ old('height', $building->height) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('height')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Floors -->
                            <div>
                                <label for="floors" class="block text-sm font-medium text-gray-700">Number of Floors</label>
                                <input type="number" name="floors" id="floors" value="{{ old('floors', $building->floors) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    min="1">
                                @error('floors')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Material -->
                            <div>
                                <label for="material" class="block text-sm font-medium text-gray-700">Material</label>
                                <input type="text" name="material" id="material" value="{{ old('material', $building->material) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('material')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Function -->
                            <div>
                                <label for="function" class="block text-sm font-medium text-gray-700">Function</label>
                                <input type="text" name="function" id="function" value="{{ old('function', $building->function) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('function')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('buildings.index') }}" class="text-gray-600 hover:text-gray-900">
                                ← Back to Buildings
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Building
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
