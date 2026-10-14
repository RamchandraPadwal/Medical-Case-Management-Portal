<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-teal-700 uppercase tracking-wider mb-1">
                <a href="{{ route('cases.index') }}" class="hover:underline">Cases</a>
                <span>&rsaquo;</span>
                <a href="{{ route('cases.show', $case) }}" class="hover:underline">{{ $case->case_number }}</a>
                <span>&rsaquo;</span>
                <span>Edit</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Case {{ $case->case_number }}</h1>
            <p class="text-sm text-slate-500 mt-0.5">Update workflow status, priority, or clinical details.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 sm:p-8">
                @include('cases._form', ['action' => route('cases.update', $case), 'method' => 'PUT'])
            </div>
        </div>
    </div>
</x-app-layout>
