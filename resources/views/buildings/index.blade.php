<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Skyscrapers') }}
            </h2>
            <a href="{{ route('buildings.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Building
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Search and Filter Form -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <form method="GET" action="{{ route('buildings.index') }}"
                            class="flex flex-wrap gap-4 items-end">
                            <div class="flex-1 min-w-64">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search
                                    Buildings</label>
                                <input type="text" name="search" id="search" value="{{ $search }}"
                                    placeholder="Search by name, city, or function..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div class="min-w-48">
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Filter by
                                    Country</label>
                                <select name="country" id="country"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All Countries</option>
                                    @foreach ($countries as $countryOption)
                                        <option value="{{ $countryOption }}"
                                            {{ $country == $countryOption ? 'selected' : '' }}>
                                            {{ $countryOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Search
                                </button>
                                <a href="{{ route('buildings.index') }}"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Clear
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Results Summary -->
                    @if ($buildings->total() > 0)
                        <div class="mb-4 text-sm text-gray-600">
                            Showing {{ $buildings->firstItem() }} to {{ $buildings->lastItem() }} of
                            {{ $buildings->total() }} buildings
                            @if ($search || $country)
                                <span class="ml-2 font-medium">
                                    (filtered
                                    @if ($search)
                                        for "{{ $search }}"
                                    @endif
                                    @if ($country)
                                        with country "{{ $country }}"
                                    @endif
                                    )
                                </span>
                            @endif
                        </div>
                    @endif

                    @if ($buildings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Building Name</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            City</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Country</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Completion</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Height</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Floors</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Material</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Function</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($buildings as $index => $building)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $building->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $building->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $building->city }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $building->country }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if ($building->status == 'Completed') bg-green-100 text-green-800
                                                    @elseif($building->status == 'Under Construction') bg-yellow-100 text-yellow-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ $building->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $building->completion_year ?: 'TBD' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $building->height }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $building->floors }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $building->material }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $building->function }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('buildings.show', $building) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                                <a href="{{ route('buildings.edit', $building) }}"
                                                    class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                                <form action="{{ route('buildings.destroy', $building) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $buildings->appends(request()->query())->links() }}
                        </div>
                    @else
                        @if ($search || $country)
                            <div class="text-center py-12">
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No buildings found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                                <div class="mt-6">
                                    <a href="{{ route('buildings.index') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Show All Buildings
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No buildings</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating your first skyscraper.</p>
                                <div class="mt-6">
                                    <a href="{{ route('buildings.create') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Add New Building
                                    </a>
                                </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
