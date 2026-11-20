<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private function superUser(): User
    {
        return User::factory()->superUser()->create();
    }

    public function test_super_user_can_list_accounts(): void
    {
        User::factory()->admin()->create(['name' => 'Budi Admin']);

        $this->actingAs($this->superUser())->get('/superuser/akun')->assertOk()->assertSee('Budi Admin');
    }

    public function test_super_user_can_create_account_for_every_role(): void
    {
        $actor = $this->superUser();

        foreach (Role::cases() as $role) {
            $this->actingAs($actor)->post('/superuser/akun', [
                'name' => 'Akun '.$role->label(),
                'email' => $role->value.'@baru.test',
                'role' => $role->value,
                'password' => 'rahasia123',
                'is_active' => 1,
            ])->assertRedirect('/superuser/akun');

            $this->assertDatabaseHas('users', ['email' => $role->value.'@baru.test', 'role' => $role->value]);
        }
    }

    public function test_super_user_can_update_account_and_reset_password(): void
    {
        $target = User::factory()->guru()->create();

        $this->actingAs($this->superUser())->put("/superuser/akun/{$target->id}", [
            'name' => 'Nama Baru',
            'email' => $target->email,
            'role' => Role::Admin->value,
            'password' => 'passwordbaru1',
            'is_active' => 1,
        ])->assertRedirect('/superuser/akun');

        $target->refresh();
        $this->assertSame('Nama Baru', $target->name);
        $this->assertSame(Role::Admin, $target->role);
        $this->assertTrue(\Hash::check('passwordbaru1', $target->password));
    }

    public function test_super_user_can_toggle_and_delete_account(): void
    {
        $actor = $this->superUser();
        $target = User::factory()->guru()->create();

        $this->actingAs($actor)->patch("/superuser/akun/{$target->id}/status")->assertSessionHasNoErrors();
        $this->assertFalse($target->fresh()->is_active);

        $this->actingAs($actor)->delete("/superuser/akun/{$target->id}")->assertRedirect('/superuser/akun');
        $this->assertDatabaseMissing('users', ['id' => $target->id]);
    }

    public function test_super_user_cannot_delete_or_deactivate_self(): void
    {
        $actor = $this->superUser();

        $this->actingAs($actor)->delete("/superuser/akun/{$actor->id}")->assertSessionHasErrors('user');
        $this->actingAs($actor)->patch("/superuser/akun/{$actor->id}/status")->assertSessionHasErrors('user');
        $this->assertDatabaseHas('users', ['id' => $actor->id, 'is_active' => true]);
    }

    public function test_email_must_be_unique(): void
    {
        $existing = User::factory()->create();

        $this->actingAs($this->superUser())->post('/superuser/akun', [
            'name' => 'X', 'email' => $existing->email, 'role' => 'guru', 'password' => 'rahasia123',
        ])->assertSessionHasErrors('email');
    }

    public function test_other_roles_cannot_manage_accounts(): void
    {
        $target = User::factory()->guru()->create();

        foreach (['admin', 'kepalaSekolah', 'guru'] as $state) {
            $actor = User::factory()->{$state}()->create();
            $this->actingAs($actor)->get('/superuser/akun')->assertForbidden();
            $this->actingAs($actor)->post('/superuser/akun', [])->assertForbidden();
            $this->actingAs($actor)->delete("/superuser/akun/{$target->id}")->assertForbidden();
        }
    }
}
