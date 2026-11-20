<?php

namespace App\Enums;

enum Role: string
{
    case SuperUser = 'super_user';
    case Admin = 'admin';
    case KepalaSekolah = 'kepala_sekolah';
    case Guru = 'guru';

    public function label(): string
    {
        return match ($this) {
            self::SuperUser => 'Super User',
            self::Admin => 'Admin',
            self::KepalaSekolah => 'Kepala Sekolah',
            self::Guru => 'Guru',
        };
    }

    public function dashboardRoute(): string
    {
        return match ($this) {
            self::SuperUser => 'superuser.dashboard',
            self::Admin => 'admin.dashboard',
            self::KepalaSekolah => 'kepsek.dashboard',
            self::Guru => 'guru.dashboard',
        };
    }
}
