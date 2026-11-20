<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'registration_number',
    'child_name',
    'nickname',
    'gender',
    'birth_place',
    'birth_date',
    'nik',
    'religion',
    'group_choice',
    'father_name',
    'father_occupation',
    'mother_name',
    'mother_occupation',
    'parent_phone',
    'parent_email',
    'address',
    'health_notes',
    'status',
    'admin_notes',
    'reviewed_by',
    'reviewed_at',
])]
class PpdbRegistration extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public static function generateNumber(): string
    {
        $year = date('Y');
        $next = (static::query()->max('id') ?? 0) + 1;

        return sprintf('PPDB-%s-%04d', $year, $next);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'diverifikasi' => 'Berkas Diverifikasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Belum Diterima',
            default => 'Menunggu Verifikasi',
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'diverifikasi' => 'bg-blue-100 text-blue-800',
            'diterima' => 'bg-lime-100 text-lime-800',
            'ditolak' => 'bg-red-100 text-red-800',
            default => 'bg-amber-100 text-amber-800',
        };
    }
}
