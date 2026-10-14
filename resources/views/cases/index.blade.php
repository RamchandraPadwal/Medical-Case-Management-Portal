<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Implant Cases</h1>
                <p class="text-sm text-slate-500 mt-0.5">Showing all registered cases and surgical workflow statuses.</p>
            </div>
            @can('create', App\Models\MedicalCase::class)
                <a href="{{ route('cases.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded-lg text-sm font-semibold hover:bg-teal-700 active:bg-teal-800 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Case
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="p-3.5 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Clean Filter Bar -->
            <form method="GET" action="{{ route('cases.index') }}"
                  class="bg-white border border-slate-200 rounded-xl p-3.5 shadow-sm grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-center">
                <div class="lg:col-span-2 relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search case number or surgeon..."
                           class="w-full border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg text-sm">
                </div>

                <div>
                    <select name="status" class="w-full border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg text-sm">
                        <option value="">All Statuses</option>
                        @foreach (App\Models\MedicalCase::STATUSES as $s)
                            <option value="{{ $s }}" @selected($status === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="priority" class="w-full border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg text-sm">
                        <option value="">All Priorities</option>
                        @foreach (App\Models\MedicalCase::PRIORITIES as $p)
                            <option value="{{ $p }}" @selected($priority === $p)>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-slate-900 text-white rounded-lg text-sm font-semibold hover:bg-slate-800 transition">
                        Filter
                    </button>
                    @if ($search !== '' || $status || $priority)
                        <a href="{{ route('cases.index') }}" class="px-3 py-2 text-sm text-slate-500 hover:text-slate-800 border border-slate-200 rounded-lg hover:bg-slate-50 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Cases Table Card -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm text-left">
                        <thead class="bg-slate-50/80 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                            <tr>
                                <th class="px-5 py-3.5">Case no.</th>
                                <th class="px-5 py-3.5">Patient ref</th>
                                <th class="px-5 py-3.5">Surgeon</th>
                                <th class="px-5 py-3.5">Implant</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5">Priority</th>
                                <th class="px-5 py-3.5">Surgery date</th>
                                <th class="px-5 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($cases as $case)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <a href="{{ route('cases.show', $case) }}" class="font-bold text-teal-700 hover:text-teal-900 hover:underline">
                                            {{ $case->case_number }}
                                        </a>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <span class="font-mono text-xs px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $case->patient_reference }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-slate-800 font-medium">
                                        {{ $case->surgeon_name }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-slate-600">
                                        {{ $case->implant_type }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'Draft' => 'bg-slate-100 text-slate-700',
                                                'Planning' => 'bg-sky-50 text-sky-700 ring-1 ring-sky-600/20',
                                                'In Review' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20',
                                                'Approved' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20',
                                                'Completed' => 'bg-teal-50 text-teal-700 ring-1 ring-teal-600/20',
                                                'Cancelled' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-600/20',
                                            ];
                                            $badgeColor = $statusColors[$case->status] ?? 'bg-slate-100 text-slate-700';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }}">
                                            {{ $case->status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        @php
                                            $priorityColors = [
                                                'High' => 'bg-rose-50 text-rose-700 font-semibold ring-1 ring-rose-600/20',
                                                'Medium' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/20',
                                                'Low' => 'bg-slate-100 text-slate-600',
                                            ];
                                            $pColor = $priorityColors[$case->priority] ?? 'bg-slate-100 text-slate-600';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs {{ $pColor }}">
                                            {{ $case->priority }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-slate-500 text-xs">
                                        {{ $case->surgery_date?->format('d M Y') ?? '-' }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-right font-medium">
                                        <div class="inline-flex items-center gap-2.5 text-xs">
                                            <a href="{{ route('cases.show', $case) }}" class="text-teal-600 hover:text-teal-800 hover:underline">
                                                View
                                            </a>

                                            @can('update', $case)
                                                <a href="{{ route('cases.edit', $case) }}" class="text-indigo-600 hover:text-indigo-800 hover:underline">
                                                    Edit
                                                </a>
                                            @endcan

                                            @can('delete', $case)
                                                <form method="POST" action="{{ route('cases.destroy', $case) }}" class="inline"
                                                      onsubmit="return confirm('Delete {{ $case->case_number }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-600 hover:text-rose-800 hover:underline">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center text-slate-500">
                                        No cases found matching your filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pt-2">{{ $cases->links() }}</div>
        </div>
    </div>
</x-app-layout>
