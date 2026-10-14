<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Case: {{ $case->case_number }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">Modify workflow status or procedure details.</p>
            </div>
            <a href="{{ route('cases.show', $case) }}" class="text-sm text-slate-500 hover:text-slate-800 transition">
                &larr; Back to Case
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 sm:p-7">
                @include('cases._form', ['action' => route('cases.update', $case), 'method' => 'PUT'])
            </div>
        </div>
    </div>
</x-app-layout>
