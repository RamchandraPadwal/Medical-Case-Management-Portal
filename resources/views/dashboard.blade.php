<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Overview</h1>
                <p class="text-sm text-slate-500 mt-0.5">Welcome back, {{ Auth::user()->name }} &bull; Role: <span class="capitalize font-medium text-slate-700">{{ Auth::user()->role }}</span></p>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('cases.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-slate-700 border border-slate-200 rounded-lg text-sm font-semibold hover:bg-slate-50 transition shadow-sm">
                    View All Cases
                </a>
                @can('create', App\Models\MedicalCase::class)
                    <a href="{{ route('cases.create') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-600 text-white rounded-lg text-sm font-semibold hover:bg-teal-700 active:bg-teal-800 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Case
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 5 Metric Tiles -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @php
                    $cards = [
                        'Total cases' => [
                            'count' => $counts['Total cases'] ?? 0,
                            'route' => route('cases.index'),
                            'border' => 'hover:border-slate-400',
                            'badge' => 'bg-slate-100 text-slate-700',
                            'dot' => 'bg-slate-700',
                        ],
                        'Planning' => [
                            'count' => $counts['Planning'] ?? 0,
                            'route' => route('cases.index', ['status' => 'Planning']),
                            'border' => 'hover:border-sky-300',
                            'badge' => 'bg-sky-50 text-sky-700 ring-1 ring-sky-600/20',
                            'dot' => 'bg-sky-500',
                        ],
                        'In Review' => [
                            'count' => $counts['In Review'] ?? 0,
                            'route' => route('cases.index', ['status' => 'In Review']),
                            'border' => 'hover:border-amber-300',
                            'badge' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20',
                            'dot' => 'bg-amber-500',
                        ],
                        'Approved' => [
                            'count' => $counts['Approved'] ?? 0,
                            'route' => route('cases.index', ['status' => 'Approved']),
                            'border' => 'hover:border-emerald-300',
                            'badge' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20',
                            'dot' => 'bg-emerald-500',
                        ],
                        'Completed' => [
                            'count' => $counts['Completed'] ?? 0,
                            'route' => route('cases.index', ['status' => 'Completed']),
                            'border' => 'hover:border-teal-300',
                            'badge' => 'bg-teal-50 text-teal-700 ring-1 ring-teal-600/20',
                            'dot' => 'bg-teal-500',
                        ],
                    ];
                @endphp

                @foreach ($cards as $label => $c)
                    <a href="{{ $c['route'] }}"
                       class="group bg-white border border-slate-200 rounded-xl p-5 shadow-sm transition hover:shadow-md {{ $c['border'] }} flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ $label }}</span>
                            <span class="w-2 h-2 rounded-full {{ $c['dot'] }}"></span>
                        </div>
                        <div class="mt-4 flex items-baseline justify-between">
                            <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $c['count'] }}</span>
                            <span class="text-xs font-medium text-slate-400 group-hover:text-teal-600 transition">View &rarr;</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Clean Quick-Action Banner -->
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Manage Implant Procedures</h2>
                    <p class="text-sm text-slate-500 mt-1 max-w-xl">
                        Search cases by case number, surgeon, or clinical priority. View full details, update workflow status, or create new implant records.
                    </p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('cases.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white rounded-lg text-sm font-semibold hover:bg-slate-800 transition shadow-sm">
                        Browse All {{ $counts['Total cases'] ?? 0 }} Cases &rarr;
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
