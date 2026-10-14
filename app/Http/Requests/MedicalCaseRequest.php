<?php

namespace App\Http\Requests;

use App\Models\MedicalCase;
use App\Support\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * Used for both create (POST) and update (PUT/PATCH), web and API.
 */
class MedicalCaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if (! $user) {
            return false;
        }

        return $this->isMethod('POST')
            ? $user->can('create', MedicalCase::class)
            : $user->can('update', MedicalCase::class);
    }

    public function rules(): array
    {
        // Web route param is {case} (a model); API route param is {id}.
        $routeCase = $this->route('case') ?? $this->route('id');
        $ignoreId = $routeCase instanceof MedicalCase ? $routeCase->id : $routeCase;

        return [
            'case_number' => [
                'required', 'string', 'max:50',
                Rule::unique('cases', 'case_number')->ignore($ignoreId), // on edit, ignore this case itself
            ],
            'patient_reference' => ['required', 'string', 'max:100'],
            'surgeon_name' => ['required', 'string', 'max:100'],
            'implant_type' => ['required', 'string', 'max:100'],
            'status' => ['required', Rule::in(MedicalCase::STATUSES)],
            'priority' => ['required', Rule::in(MedicalCase::PRIORITIES)],
            'surgery_date' => ['nullable', 'date'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        if ($this->is('api/*')) {
            throw new HttpResponseException(
                ApiResponse::error('Validation failed.', 422, $validator->errors()->toArray())
            );
        }

        parent::failedValidation($validator);
    }

    protected function failedAuthorization(): void
    {
        if ($this->is('api/*')) {
            throw new HttpResponseException(ApiResponse::error('You are not allowed to do this.', 403));
        }

        parent::failedAuthorization();
    }
}
