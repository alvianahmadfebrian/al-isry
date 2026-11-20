<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Satu akun default untuk setiap role. Kata sandi semua: "password".
     */
    public function run(): void
    {
        $accounts = [
            ['Super User', 'superuser@sekolah.test', Role::SuperUser],
            ['Admin Sekolah', 'admin@sekolah.test', Role::Admin],
            ['Kepala Sekolah', 'kepsek@sekolah.test', Role::KepalaSekolah],
            ['Guru Contoh', 'guru@sekolah.test', Role::Guru],
        ];

        foreach ($accounts as [$name, $email, $role]) {
            User::updateOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => 'password', 'role' => $role, 'is_active' => true],
            );
        }
    }
}
