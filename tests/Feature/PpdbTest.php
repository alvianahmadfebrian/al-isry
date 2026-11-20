<?php

namespace Tests\Feature;

use App\Models\PpdbRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PpdbTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_submit_ppdb_registration_and_view_proof(): void
    {
        $this->get('/ppdb/daftar')
            ->assertOk()
            ->assertSee('Formulir Pendaftaran Peserta Didik Baru');

        $response = $this->post('/ppdb/daftar', [
            'child_name' => 'Aisyah Humaira',
            'nickname' => 'Aisyah',
            'gender' => 'P',
            'birth_place' => 'Bogor',
            'birth_date' => '2021-04-12',
            'nik' => '3271015204210001',
            'group_choice' => 'Kelompok A (4-5 Tahun)',
            'father_name' => 'Ahmad Fauzi',
            'father_occupation' => 'Karyawan Swasta',
            'mother_name' => 'Siti Maryam',
            'mother_occupation' => 'Ibu Rumah Tangga',
            'parent_phone' => '081299887766',
            'parent_email' => 'fauzi@contoh.test',
            'address' => 'Jl. Seroja Raya Blok C No. 12, Taman Yasmin, Bogor',
        ]);

        $registration = PpdbRegistration::firstOrFail();
        $response->assertRedirect(route('ppdb.show', $registration->registration_number));

        $this->get(route('ppdb.show', $registration->registration_number))
            ->assertOk()
            ->assertSee($registration->registration_number)
            ->assertSee('Aisyah Humaira')
            ->assertSee('Menunggu Verifikasi');

        $this->get(route('ppdb.check', ['nomor' => $registration->registration_number]))
            ->assertOk()
            ->assertSee('Aisyah Humaira');
    }

    public function test_admin_can_verify_and_accept_ppdb_registration(): void
    {
        $admin = User::factory()->admin()->create();
        $registration = PpdbRegistration::create([
            'registration_number' => 'PPDB-2026-0001',
            'child_name' => 'Muhammad Zaidan',
            'gender' => 'L',
            'birth_place' => 'Bogor',
            'birth_date' => '2020-08-10',
            'group_choice' => 'Kelompok B (5-6 Tahun)',
            'father_name' => 'Budi Santoso',
            'mother_name' => 'Rina Wati',
            'parent_phone' => '081233445566',
            'address' => 'Taman Yasmin Sektor 3 Bogor',
            'status' => 'menunggu',
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.ppdb.status', $registration), [
                'status' => 'diterima',
                'admin_notes' => 'Selamat, ananda diterima di Kelompok B.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('ppdb_registrations', [
            'id' => $registration->id,
            'status' => 'diterima',
            'reviewed_by' => $admin->id,
        ]);

        $this->get(route('ppdb.check', ['nomor' => 'PPDB-2026-0001']))
            ->assertOk()
            ->assertSee('Diterima')
            ->assertSee('Selamat, ananda diterima di Kelompok B.');
    }

    public function test_guru_cannot_access_admin_ppdb_management(): void
    {
        $guru = User::factory()->guru()->create();

        $this->actingAs($guru)->get('/admin/ppdb')->assertForbidden();
    }
}
