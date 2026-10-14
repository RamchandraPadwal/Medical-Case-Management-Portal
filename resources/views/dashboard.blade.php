<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach ($counts as $label => $count)
                    <div class="bg-white shadow-sm sm:rounded-lg p-4">
                        <div class="text-sm text-gray-500">{{ $label }}</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $count }}</div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                <a href="{{ route('cases.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold hover:bg-gray-700">
                    View all cases
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
