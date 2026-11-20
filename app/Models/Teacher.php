<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'nip', 'name', 'position', 'specialization', 'education', 'photo_url', 'bio', 'show_on_landing'])]
class Teacher extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'show_on_landing' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TeacherAssignment::class);
    }
}
