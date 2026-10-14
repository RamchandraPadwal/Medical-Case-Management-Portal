<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $case->case_number }}</h1>
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
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badgeColor }}">
                    {{ $case->status }}
                </span>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('cases.index') }}"
                   class="px-3.5 py-2 border border-slate-200 bg-white text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition shadow-sm">
                    &larr; Back
                </a>

                @can('update', $case)
                    <a href="{{ route('cases.edit', $case) }}"
                       class="px-4 py-2 bg-teal-600 text-white text-sm font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm">
                        Edit
                    </a>
                @endcan

                @can('delete', $case)
                    <form method="POST" action="{{ route('cases.destroy', $case) }}"
                          onsubmit="return confirm('Delete case {{ $case->case_number }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3.5 py-2 text-rose-600 hover:text-rose-800 text-sm font-medium hover:bg-rose-50 rounded-lg transition">
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="p-3.5 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-200 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Case Details</span>
                    <span class="text-xs text-slate-400">ID: #{{ $case->id }}</span>
                </div>

                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5 text-sm">
                        <div>
                            <dt class="text-xs font-medium text-slate-400 uppercase tracking-wider">Case Number</dt>
                            <dd class="mt-1 font-bold text-slate-900 text-base">{{ $case->case_number }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium text-slate-400 uppercase tracking-wider">Patient Reference</dt>
                            <dd class="mt-1 font-mono text-sm bg-slate-100 text-slate-800 px-2 py-0.5 rounded inline-block">
                                {{ $case->patient_reference }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium text-slate-400 uppercase tracking-wider">Surgeon</dt>
                            <dd class="mt-1 font-medium text-slate-800">{{ $case->surgeon_name }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium text-slate-400 uppercase tracking-wider">Implant Type</dt>
                            <dd class="mt-1 font-medium text-slate-800">{{ $case->implant_type }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium text-slate-400 uppercase tracking-wider">Status</dt>
                            <dd class="mt-1 font-medium text-slate-800">{{ $case->status }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium text-slate-400 uppercase tracking-wider">Priority</dt>
                            <dd class="mt-1 font-medium text-slate-800">{{ $case->priority }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium text-slate-400 uppercase tracking-wider">Surgery Date</dt>
                            <dd class="mt-1 font-medium text-slate-800">{{ $case->surgery_date?->format('d F Y') ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium text-slate-400 uppercase tracking-wider">Created By</dt>
                            <dd class="mt-1 font-medium text-slate-800">{{ $case->creator->name }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="px-6 py-3.5 bg-slate-50/60 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between text-xs text-slate-400 gap-1">
                    <span>Created: {{ $case->created_at->format('d M Y, H:i') }}</span>
                    <span>Last updated: {{ $case->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
