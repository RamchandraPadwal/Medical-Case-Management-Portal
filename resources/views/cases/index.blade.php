<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cases</h2>
            @can('create', App\Models\MedicalCase::class)
                <a href="{{ route('cases.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold hover:bg-gray-700">
                    New case
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800 text-sm">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('cases.index') }}"
                  class="bg-white shadow-sm sm:rounded-lg p-4 mb-4 grid grid-cols-1 md:grid-cols-5 gap-3">
                <input type="text" name="search" value="{{ $search }}" placeholder="Case number or surgeon"
                       class="md:col-span-2 border-gray-300 rounded-md shadow-sm text-sm">

                <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All statuses</option>
                    @foreach (App\Models\MedicalCase::STATUSES as $s)
                        <option value="{{ $s }}" @selected($status === $s)>{{ $s }}</option>
                    @endforeach
                </select>

                <select name="priority" class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All priorities</option>
                    @foreach (App\Models\MedicalCase::PRIORITIES as $p)
                        <option value="{{ $p }}" @selected($priority === $p)>{{ $p }}</option>
                    @endforeach
                </select>

                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold">Filter</button>
                    <a href="{{ route('cases.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm">Reset</a>
                </div>
            </form>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Case no.</th>
                            <th class="px-4 py-3">Patient ref</th>
                            <th class="px-4 py-3">Surgeon</th>
                            <th class="px-4 py-3">Implant</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Priority</th>
                            <th class="px-4 py-3">Surgery date</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($cases as $case)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $case->case_number }}</td>
                                <td class="px-4 py-3">{{ $case->patient_reference }}</td>
                                <td class="px-4 py-3">{{ $case->surgeon_name }}</td>
                                <td class="px-4 py-3">{{ $case->implant_type }}</td>
                                <td class="px-4 py-3">{{ $case->status }}</td>
                                <td class="px-4 py-3">{{ $case->priority }}</td>
                                <td class="px-4 py-3">{{ $case->surgery_date?->format('d M Y') ?? '-' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a href="{{ route('cases.show', $case) }}" class="text-indigo-600 hover:underline">View</a>

                                    @can('update', $case)
                                        <a href="{{ route('cases.edit', $case) }}" class="ml-2 text-indigo-600 hover:underline">Edit</a>
                                    @endcan

                                    @can('delete', $case)
                                        <form method="POST" action="{{ route('cases.destroy', $case) }}" class="inline"
                                              onsubmit="return confirm('Delete {{ $case->case_number }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ml-2 text-red-600 hover:underline">Delete</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="px-4 py-6 text-center text-gray-500">No cases found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $cases->links() }}</div>
        </div>
    </div>
</x-app-layout>
