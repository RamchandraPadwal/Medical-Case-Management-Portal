{{-- Shared by create and edit. Expects: $case, $action, $method ('POST' or 'PUT') --}}
@php
    $field = 'mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm';
@endphp

<form method="POST" action="{{ $action }}" class="space-y-4">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <x-input-label for="case_number" value="Case number" />
        <input id="case_number" name="case_number" type="text" class="{{ $field }}"
               value="{{ old('case_number', $case->case_number) }}" placeholder="CASE-0001">
        <x-input-error :messages="$errors->get('case_number')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="patient_reference" value="Patient reference (dummy code)" />
        <input id="patient_reference" name="patient_reference" type="text" class="{{ $field }}"
               value="{{ old('patient_reference', $case->patient_reference) }}">
        <x-input-error :messages="$errors->get('patient_reference')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="surgeon_name" value="Surgeon name" />
        <input id="surgeon_name" name="surgeon_name" type="text" class="{{ $field }}"
               value="{{ old('surgeon_name', $case->surgeon_name) }}">
        <x-input-error :messages="$errors->get('surgeon_name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="implant_type" value="Implant type" />
        <input id="implant_type" name="implant_type" type="text" class="{{ $field }}"
               value="{{ old('implant_type', $case->implant_type) }}">
        <x-input-error :messages="$errors->get('implant_type')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status" class="{{ $field }}">
                @foreach (App\Models\MedicalCase::STATUSES as $s)
                    <option value="{{ $s }}" @selected(old('status', $case->status) === $s)>{{ $s }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="priority" value="Priority" />
            <select id="priority" name="priority" class="{{ $field }}">
                @foreach (App\Models\MedicalCase::PRIORITIES as $p)
                    <option value="{{ $p }}" @selected(old('priority', $case->priority) === $p)>{{ $p }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('priority')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="surgery_date" value="Surgery date (optional)" />
        <input id="surgery_date" name="surgery_date" type="date" class="{{ $field }}"
               value="{{ old('surgery_date', $case->surgery_date?->format('Y-m-d')) }}">
        <x-input-error :messages="$errors->get('surgery_date')" class="mt-2" />
    </div>

    <div class="flex items-center gap-3">
        <x-primary-button>Save</x-primary-button>
        <a href="{{ route('cases.index') }}" class="text-sm text-gray-600 hover:underline">Cancel</a>
    </div>
</form>
