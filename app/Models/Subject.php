<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['code', 'name', 'description', 'weight_tugas', 'weight_uh', 'weight_uts', 'weight_uas'])]
class Subject extends Model
{
    public function calculateFinalScore(float $tugas, float $uh, float $uts, float $uas): float
    {
        $totalWeight = ($this->weight_tugas + $this->weight_uh + $this->weight_uts + $this->weight_uas) ?: 100;

        $score = (
            ($tugas * $this->weight_tugas) +
            ($uh * $this->weight_uh) +
            ($uts * $this->weight_uts) +
            ($uas * $this->weight_uas)
        ) / $totalWeight;

        return round($score, 2);
    }

    public static function predicateFor(float $score): string
    {
        return match (true) {
            $score >= 88 => 'A',
            $score >= 78 => 'B',
            $score >= 68 => 'C',
            default => 'D',
        };
    }
}
