<?php

namespace Database\Factories;

use App\Models\MedicalCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MedicalCase>
 */
class MedicalCaseFactory extends Factory
{
    protected $model = MedicalCase::class;

    public function definition(): array
    {
        return [
            'case_number' => 'CASE-'.str_pad((string) fake()->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT),
            'patient_reference' => 'PT-'.fake()->unique()->numerify('######'), // dummy code, not a real name
            'surgeon_name' => 'Dr. '.fake()->lastName(),
            'implant_type' => fake()->randomElement(['Knee implant', 'Hip implant', 'Spinal rod', 'Shoulder implant', 'Dental implant']),
            'status' => fake()->randomElement(MedicalCase::STATUSES),
            'priority' => fake()->randomElement(MedicalCase::PRIORITIES),
            'surgery_date' => fake()->optional(0.7)->dateTimeBetween('now', '+6 months'),
            'created_by' => User::factory(),
        ];
    }
}
