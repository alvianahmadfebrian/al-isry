<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{0: string, 1: string}> [factory state, URL prefix]
     */
    public static function areas(): array
    {
        return [
            'superuser' => ['superUser', '/superuser'],
            'admin' => ['admin', '/admin'],
            'kepsek' => ['kepalaSekolah', '/kepsek'],
            'guru' => ['guru', '/guru'],
        ];
    }

    public function test_guest_is_redirected_to_login_for_every_area(): void
    {
        foreach (self::areas() as [, $url]) {
            $this->get($url)->assertRedirect('/login');
        }
    }

    public function test_each_role_can_access_own_area_and_is_forbidden_from_others(): void
    {
        foreach (self::areas() as [$state, $ownUrl]) {
            $user = User::factory()->{$state}()->create();

            foreach (self::areas() as [$otherState, $url]) {
                $response = $this->actingAs($user)->get($url);

                if ($url === $ownUrl || $state === 'superUser') {
                    $response->assertOk();
                } else {
                    $response->assertForbidden();
                }
            }
        }
    }

    public function test_dashboard_redirects_to_role_dashboard(): void
    {
        $this->actingAs(User::factory()->admin()->create())->get('/dashboard')->assertRedirect(route('admin.dashboard'));
        $this->actingAs(User::factory()->kepalaSekolah()->create())->get('/dashboard')->assertRedirect(route('kepsek.dashboard'));
        $this->actingAs(User::factory()->guru()->create())->get('/dashboard')->assertRedirect(route('guru.dashboard'));
        $this->actingAs(User::factory()->superUser()->create())->get('/dashboard')->assertRedirect(route('superuser.dashboard'));
    }

    public function test_admin_cannot_manage_super_user_accounts(): void
    {
        $admin = User::factory()->admin()->create();

        $this->assertFalse($admin->can('update', User::factory()->superUser()->create()));
        $this->assertFalse($admin->can('delete', User::factory()->kepalaSekolah()->create()));
        $this->assertTrue($admin->can('update', User::factory()->guru()->create()));
    }

    public function test_super_user_can_manage_any_account(): void
    {
        $superUser = User::factory()->superUser()->create();

        $this->assertTrue($superUser->can('update', User::factory()->admin()->create()));
        $this->assertTrue($superUser->can('delete', User::factory()->kepalaSekolah()->create()));
    }

    public function test_guru_cannot_manage_other_accounts(): void
    {
        $guru = User::factory()->guru()->create();

        $this->assertFalse($guru->can('update', User::factory()->guru()->create()));
        $this->assertTrue($guru->can('update', $guru));
    }
}
