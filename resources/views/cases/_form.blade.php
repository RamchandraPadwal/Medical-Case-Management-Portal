{{-- Shared by create and edit. Expects: $case, $action, $method ('POST' or 'PUT') --}}
@php
    $field = 'mt-1 block w-full border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm text-sm';
@endphp

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100 pb-2">
            1. Case & Patient Identification
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="case_number" value="Case number *" />
                <input id="case_number" name="case_number" type="text" class="{{ $field }}"
                       value="{{ old('case_number', $case->case_number) }}" placeholder="e.g. CASE-0001">
                <p class="text-[11px] text-slate-400 mt-1">Unique tracking identifier.</p>
                <x-input-error :messages="$errors->get('case_number')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="patient_reference" value="Patient reference (dummy code) *" />
                <input id="patient_reference" name="patient_reference" type="text" class="{{ $field }}"
                       value="{{ old('patient_reference', $case->patient_reference) }}" placeholder="e.g. PT-001234">
                <p class="text-[11px] text-slate-400 mt-1">Anonymized patient reference.</p>
                <x-input-error :messages="$errors->get('patient_reference')" class="mt-1.5" />
            </div>
        </div>
    </div>

    <div class="space-y-4 pt-2">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100 pb-2">
            2. Clinical & Implant Specification
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="surgeon_name" value="Surgeon name *" />
                <input id="surgeon_name" name="surgeon_name" type="text" class="{{ $field }}"
                       value="{{ old('surgeon_name', $case->surgeon_name) }}" placeholder="e.g. Dr. Jane Smith">
                <x-input-error :messages="$errors->get('surgeon_name')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="implant_type" value="Implant type *" />
                <input id="implant_type" name="implant_type" type="text" class="{{ $field }}"
                       value="{{ old('implant_type', $case->implant_type) }}" placeholder="e.g. Knee implant, Hip stem">
                <x-input-error :messages="$errors->get('implant_type')" class="mt-1.5" />
            </div>
        </div>
    </div>

    <div class="space-y-4 pt-2">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100 pb-2">
            3. Workflow Status & Scheduling
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <x-input-label for="status" value="Workflow Status *" />
                <select id="status" name="status" class="{{ $field }}">
                    @foreach (App\Models\MedicalCase::STATUSES as $s)
                        <option value="{{ $s }}" @selected(old('status', $case->status) === $s)>{{ $s }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="priority" value="Clinical Priority *" />
                <select id="priority" name="priority" class="{{ $field }}">
                    @foreach (App\Models\MedicalCase::PRIORITIES as $p)
                        <option value="{{ $p }}" @selected(old('priority', $case->priority) === $p)>{{ $p }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('priority')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="surgery_date" value="Surgery date (optional)" />
                <input id="surgery_date" name="surgery_date" type="date" class="{{ $field }}"
                       value="{{ old('surgery_date', $case->surgery_date?->format('Y-m-d')) }}">
                <x-input-error :messages="$errors->get('surgery_date')" class="mt-1.5" />
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 text-white rounded-lg text-sm font-semibold hover:bg-teal-700 active:bg-teal-800 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Save Case
        </button>
        <a href="{{ route('cases.index') }}" class="px-4 py-2.5 border border-slate-200 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50 transition">
            Cancel
        </a>
    </div>
</form>
