<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalCase extends Model
{
    use HasFactory;

    // "Case" is a reserved word in PHP, so the model is MedicalCase and the table is "cases".
    protected $table = 'cases';

    public const STATUSES = ['Draft', 'Planning', 'In Review', 'Approved', 'Completed', 'Cancelled'];
    public const PRIORITIES = ['Low', 'Medium', 'High'];

    // created_by is NOT fillable: the controller sets it from the logged-in user.
    protected $fillable = [
        'case_number',
        'patient_reference',
        'surgeon_name',
        'implant_type',
        'status',
        'priority',
        'surgery_date',
    ];

    protected function casts(): array
    {
        return ['surgery_date' => 'date'];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
