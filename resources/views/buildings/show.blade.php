<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $building->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Building Details</h3>

                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $building->name }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">City</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $building->city }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if ($building->status == 'Completed') bg-green-100 text-green-800
                                            @elseif($building->status == 'Under Construction') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $building->status }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Completion Year</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $building->completion_year ?: 'To be determined' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Specifications</h3>

                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Height</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $building->height }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Number of Floors</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $building->floors }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Material</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $building->material }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Function</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $building->function }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                Created: {{ $building->created_at->format('M d, Y') }}
                                @if ($building->updated_at != $building->created_at)
                                    • Updated: {{ $building->updated_at->format('M d, Y') }}
                                @endif
                            </div>

                            <div class="flex space-x-3">
                                <a href="{{ route('buildings.index') }}" class="text-gray-600 hover:text-gray-900">
                                    ← Back to Buildings
                                </a>
                                <a href="{{ route('buildings.edit', $building) }}"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('buildings.destroy', $building) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('Are you sure you want to delete this building?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
