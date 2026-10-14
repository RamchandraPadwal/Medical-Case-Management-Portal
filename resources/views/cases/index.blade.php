<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Implant Cases</h1>
                <p class="text-sm text-slate-500 mt-0.5">Registry of medical implant cases, patient references, and surgeon assignments.</p>
            </div>
            @can('create', App\Models\MedicalCase::class)
                <a href="{{ route('cases.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-teal-600 text-white rounded-lg text-sm font-semibold hover:bg-teal-700 active:bg-teal-800 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Case
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Search & Filters Card -->
            <form method="GET" action="{{ route('cases.index') }}"
                  class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm grid grid-cols-1 md:grid-cols-5 gap-3">
                <div class="md:col-span-2 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search case number or surgeon..."
                           class="w-full pl-9 border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm text-sm">
                </div>

                <div>
                    <select name="status" class="w-full border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm text-sm">
                        <option value="">All statuses</option>
                        @foreach (App\Models\MedicalCase::STATUSES as $s)
                            <option value="{{ $s }}" @selected($status === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="priority" class="w-full border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm text-sm">
                        <option value="">All priorities</option>
                        @foreach (App\Models\MedicalCase::PRIORITIES as $p)
                            <option value="{{ $p }}" @selected($priority === $p)>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-teal-600 text-white rounded-lg text-sm font-semibold hover:bg-teal-700 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('cases.index') }}" class="px-3.5 py-2 border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 rounded-lg text-sm font-medium transition">
                        Reset
                    </a>
                </div>
            </form>

            <!-- Table Card -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm text-left">
                        <thead class="bg-slate-50 text-slate-600 uppercase tracking-wider text-[11px] font-bold">
                            <tr>
                                <th class="px-5 py-3.5">Case no.</th>
                                <th class="px-5 py-3.5">Patient ref</th>
                                <th class="px-5 py-3.5">Surgeon</th>
                                <th class="px-5 py-3.5">Implant type</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5">Priority</th>
                                <th class="px-5 py-3.5">Surgery date</th>
                                <th class="px-5 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($cases as $case)
                                <tr class="hover:bg-slate-50/75 transition-colors">
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
                                    <td class="px-5 py-3.5 whitespace-nowrap text-slate-700">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>{{ $case->surgeon_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-slate-600 font-medium">
                                        {{ $case->implant_type }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'Draft' => 'bg-slate-100 text-slate-700 border-slate-200',
                                                'Planning' => 'bg-sky-50 text-sky-700 border-sky-200',
                                                'In Review' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'Approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'Completed' => 'bg-teal-50 text-teal-700 border-teal-200',
                                                'Cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
                                            ];
                                            $badgeColor = $statusColors[$case->status] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $badgeColor }}">
                                            {{ $case->status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        @php
                                            $priorityColors = [
                                                'High' => 'bg-rose-50 text-rose-700 border-rose-200 font-semibold',
                                                'Medium' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'Low' => 'bg-slate-100 text-slate-600 border-slate-200',
                                            ];
                                            $pColor = $priorityColors[$case->priority] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs border {{ $pColor }}">
                                            {{ $case->priority }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-slate-500 text-xs">
                                        @if ($case->surgery_date)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span>{{ $case->surgery_date->format('d M Y') }}</span>
                                            </div>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-right font-medium">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('cases.show', $case) }}" class="text-teal-600 hover:text-teal-800 hover:underline">
                                                View
                                            </a>

                                            @can('update', $case)
                                                <span class="text-slate-300">|</span>
                                                <a href="{{ route('cases.edit', $case) }}" class="text-indigo-600 hover:text-indigo-800 hover:underline">
                                                    Edit
                                                </a>
                                            @endcan

                                            @can('delete', $case)
                                                <span class="text-slate-300">|</span>
                                                <form method="POST" action="{{ route('cases.destroy', $case) }}" class="inline"
                                                      onsubmit="return confirm('Delete case {{ $case->case_number }}?')">
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
                                    <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                                        <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="font-medium text-slate-600">No implant cases found.</p>
                                        <p class="text-xs text-slate-400 mt-1">Try adjusting your search or filter settings.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">{{ $cases->links() }}</div>
        </div>
    </div>
</x-app-layout>
