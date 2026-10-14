<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Case {{ $case->case_number }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800 text-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <div><dt class="text-gray-500">ID</dt><dd class="font-medium">{{ $case->id }}</dd></div>
                    <div><dt class="text-gray-500">Case number</dt><dd class="font-medium">{{ $case->case_number }}</dd></div>
                    <div><dt class="text-gray-500">Patient reference</dt><dd class="font-medium">{{ $case->patient_reference }}</dd></div>
                    <div><dt class="text-gray-500">Surgeon</dt><dd class="font-medium">{{ $case->surgeon_name }}</dd></div>
                    <div><dt class="text-gray-500">Implant type</dt><dd class="font-medium">{{ $case->implant_type }}</dd></div>
                    <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ $case->status }}</dd></div>
                    <div><dt class="text-gray-500">Priority</dt><dd class="font-medium">{{ $case->priority }}</dd></div>
                    <div><dt class="text-gray-500">Surgery date</dt><dd class="font-medium">{{ $case->surgery_date?->format('d M Y') ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Created by</dt><dd class="font-medium">{{ $case->creator->name }}</dd></div>
                    <div><dt class="text-gray-500">Created at</dt><dd class="font-medium">{{ $case->created_at->format('d M Y, H:i') }}</dd></div>
                    <div><dt class="text-gray-500">Last updated</dt><dd class="font-medium">{{ $case->updated_at->format('d M Y, H:i') }}</dd></div>
                </dl>

                <div class="mt-6 flex items-center gap-4 text-sm">
                    <a href="{{ route('cases.index') }}" class="text-gray-600 hover:underline">Back to list</a>

                    @can('update', $case)
                        <a href="{{ route('cases.edit', $case) }}" class="text-indigo-600 hover:underline">Edit</a>
                    @endcan

                    @can('delete', $case)
                        <form method="POST" action="{{ route('cases.destroy', $case) }}"
                              onsubmit="return confirm('Delete {{ $case->case_number }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
