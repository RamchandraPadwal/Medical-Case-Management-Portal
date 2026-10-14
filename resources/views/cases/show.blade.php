<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold text-teal-700 uppercase tracking-wider mb-1">
                    <a href="{{ route('cases.index') }}" class="hover:underline">Cases</a>
                    <span>&rsaquo;</span>
                    <span>Case Details</span>
                </div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">{{ $case->case_number }}</h1>
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
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-bold border {{ $badgeColor }}">
                        {{ $case->status }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('cases.index') }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-slate-200 bg-white text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition shadow-sm">
                    &larr; Back to list
                </a>

                @can('update', $case)
                    <a href="{{ route('cases.edit', $case) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-600 text-white text-sm font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Case
                    </a>
                @endcan

                @can('delete', $case)
                    <form method="POST" action="{{ route('cases.destroy', $case) }}"
                          onsubmit="return confirm('Permanently delete case {{ $case->case_number }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-rose-50 border border-rose-200 text-rose-700 text-sm font-semibold rounded-lg hover:bg-rose-100 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Case Summary Header Card -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Section 1 -->
                    <div class="space-y-4 border-b md:border-b-0 md:border-r border-slate-100 pb-4 md:pb-0 md:pr-6">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-teal-700">Patient & Identification</h2>
                        <div>
                            <div class="text-xs text-slate-400">Database ID</div>
                            <div class="font-medium text-slate-800 text-sm">#{{ $case->id }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">Case Number</div>
                            <div class="font-bold text-slate-900 text-base">{{ $case->case_number }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">Patient Reference</div>
                            <div class="mt-0.5">
                                <span class="font-mono text-xs px-2.5 py-1 rounded-md bg-slate-100 text-slate-800 border border-slate-200 font-semibold">
                                    {{ $case->patient_reference }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2 -->
                    <div class="space-y-4 border-b md:border-b-0 md:border-r border-slate-100 pb-4 md:pb-0 md:pr-6">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-teal-700">Clinical Specification</h2>
                        <div>
                            <div class="text-xs text-slate-400">Surgeon</div>
                            <div class="font-semibold text-slate-800 text-sm flex items-center gap-1.5 mt-0.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $case->surgeon_name }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">Implant Type</div>
                            <div class="font-medium text-slate-800 text-sm mt-0.5">{{ $case->implant_type }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">Surgery Date</div>
                            <div class="font-medium text-slate-800 text-sm mt-0.5 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $case->surgery_date?->format('d F Y') ?? 'Not scheduled' }}
                            </div>
                        </div>
                    </div>

                    <!-- Section 3 -->
                    <div class="space-y-4">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-teal-700">Status & Audit</h2>
                        <div>
                            <div class="text-xs text-slate-400">Workflow Status</div>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeColor }}">
                                    {{ $case->status }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">Clinical Priority</div>
                            @php
                                $priorityColors = [
                                    'High' => 'bg-rose-50 text-rose-700 border-rose-200 font-semibold',
                                    'Medium' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'Low' => 'bg-slate-100 text-slate-600 border-slate-200',
                                ];
                                $pColor = $priorityColors[$case->priority] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                            @endphp
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs border {{ $pColor }}">
                                    {{ $case->priority }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">Created By</div>
                            <div class="font-medium text-slate-800 text-sm mt-0.5">{{ $case->creator->name }} ({{ $case->creator->email }})</div>
                        </div>
                    </div>

                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between text-xs text-slate-400 gap-2">
                    <div>Created on {{ $case->created_at->format('d M Y \a\t H:i') }}</div>
                    <div>Last modified {{ $case->updated_at->format('d M Y \a\t H:i') }}</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
