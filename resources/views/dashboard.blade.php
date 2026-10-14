<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Clinical Case Dashboard</h1>
                <p class="text-sm text-slate-500 mt-0.5">Real-time overview of medical implant cases and surgical pipeline.</p>
            </div>
            <div class="flex items-center gap-3">
                @can('create', App\Models\MedicalCase::class)
                    <a href="{{ route('cases.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded-lg text-sm font-semibold hover:bg-teal-700 active:bg-teal-800 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Case
                    </a>
                @endcan
                <a href="{{ route('cases.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white text-slate-700 border border-slate-200 rounded-lg text-sm font-semibold hover:bg-slate-50 transition shadow-sm">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    View All Cases
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- KPI Metric Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @php
                    $cardStyles = [
                        'Total cases' => [
                            'bg' => 'bg-slate-900',
                            'text' => 'text-white',
                            'label' => 'text-slate-300',
                            'badge' => 'bg-slate-800 text-slate-200 border-slate-700',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                        ],
                        'Planning' => [
                            'bg' => 'bg-white',
                            'text' => 'text-sky-700',
                            'label' => 'text-slate-600',
                            'badge' => 'bg-sky-50 text-sky-700 border-sky-200',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                        ],
                        'In Review' => [
                            'bg' => 'bg-white',
                            'text' => 'text-amber-700',
                            'label' => 'text-slate-600',
                            'badge' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>',
                        ],
                        'Approved' => [
                            'bg' => 'bg-white',
                            'text' => 'text-emerald-700',
                            'label' => 'text-slate-600',
                            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        ],
                        'Completed' => [
                            'bg' => 'bg-white',
                            'text' => 'text-teal-700',
                            'label' => 'text-slate-600',
                            'badge' => 'bg-teal-50 text-teal-700 border-teal-200',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
                        ],
                    ];
                @endphp

                @foreach ($counts as $label => $count)
                    @php
                        $style = $cardStyles[$label] ?? [
                            'bg' => 'bg-white',
                            'text' => 'text-slate-900',
                            'label' => 'text-slate-600',
                            'badge' => 'bg-slate-50 text-slate-700 border-slate-200',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        ];
                    @endphp
                    <div class="{{ $style['bg'] }} border border-slate-200 rounded-xl p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold uppercase tracking-wider {{ $style['label'] }}">{{ $label }}</span>
                            <span class="w-8 h-8 rounded-lg {{ $style['badge'] }} border flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $style['icon'] !!}
                                </svg>
                            </span>
                        </div>
                        <div class="mt-3">
                            <span class="text-3xl font-extrabold tracking-tight {{ $style['text'] }}">{{ $count }}</span>
                        </div>
                        <div class="mt-2 text-xs text-slate-400">
                            @if ($label === 'Total cases')
                                Registered in database
                            @else
                                <a href="{{ route('cases.index', ['status' => $label]) }}" class="text-teal-600 hover:text-teal-700 font-medium inline-flex items-center gap-1">
                                    Filter cases &rarr;
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Workflow Stage Guide Card -->
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-800">Implant Case Lifecycle</h2>
                <p class="text-xs text-slate-500 mt-0.5">Sequential stages followed for each surgical implant case:</p>

                <div class="mt-5 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3 text-center">
                    <div class="p-3 rounded-lg bg-slate-50 border border-slate-200">
                        <span class="inline-block w-2 h-2 rounded-full bg-slate-400 mb-1"></span>
                        <div class="text-xs font-semibold text-slate-700">1. Draft</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Initial setup</div>
                    </div>
                    <div class="p-3 rounded-lg bg-sky-50/70 border border-sky-200">
                        <span class="inline-block w-2 h-2 rounded-full bg-sky-500 mb-1"></span>
                        <div class="text-xs font-semibold text-sky-800">2. Planning</div>
                        <div class="text-[11px] text-sky-600 mt-0.5">Spec & anatomy</div>
                    </div>
                    <div class="p-3 rounded-lg bg-amber-50/70 border border-amber-200">
                        <span class="inline-block w-2 h-2 rounded-full bg-amber-500 mb-1"></span>
                        <div class="text-xs font-semibold text-amber-800">3. In Review</div>
                        <div class="text-[11px] text-amber-600 mt-0.5">Surgical audit</div>
                    </div>
                    <div class="p-3 rounded-lg bg-emerald-50/70 border border-emerald-200">
                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 mb-1"></span>
                        <div class="text-xs font-semibold text-emerald-800">4. Approved</div>
                        <div class="text-[11px] text-emerald-600 mt-0.5">Cleared for OR</div>
                    </div>
                    <div class="p-3 rounded-lg bg-teal-50/70 border border-teal-200">
                        <span class="inline-block w-2 h-2 rounded-full bg-teal-500 mb-1"></span>
                        <div class="text-xs font-semibold text-teal-800">5. Completed</div>
                        <div class="text-[11px] text-teal-600 mt-0.5">Procedure done</div>
                    </div>
                    <div class="p-3 rounded-lg bg-rose-50/70 border border-rose-200">
                        <span class="inline-block w-2 h-2 rounded-full bg-rose-400 mb-1"></span>
                        <div class="text-xs font-semibold text-rose-800">Cancelled</div>
                        <div class="text-[11px] text-rose-600 mt-0.5">Terminated</div>
                    </div>
                </div>
            </div>

            <!-- Quick Action Card -->
            <div class="bg-gradient-to-r from-teal-800 to-slate-900 rounded-xl p-6 text-white shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold">Implant Case Management Portal</h3>
                    <p class="text-sm text-teal-100 mt-1">Search cases by patient reference, surgeon, or filter by clinical priority.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('cases.index') }}"
                       class="px-4 py-2.5 rounded-lg bg-white text-slate-900 font-semibold text-sm hover:bg-slate-100 transition shadow">
                        Browse Cases &rarr;
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
