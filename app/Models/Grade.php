<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['teacher_assignment_id', 'student_id', 'tugas', 'uh', 'uts', 'uas', 'final_score', 'predicate', 'notes'])]
class Grade extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tugas' => 'float',
            'uh' => 'float',
            'uts' => 'float',
            'uas' => 'float',
            'final_score' => 'float',
        ];
    }

    public function teacherAssignment(): BelongsTo
    {
        return $this->belongsTo(TeacherAssignment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
