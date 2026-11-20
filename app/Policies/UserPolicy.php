<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class UserPolicy
{
    /**
     * Super User boleh segalanya.
     */
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === Role::SuperUser ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->role === Role::Admin;
    }

    public function view(User $user, User $target): bool
    {
        return $this->manageable($user, $target);
    }

    public function create(User $user): bool
    {
        return $user->role === Role::Admin;
    }

    public function update(User $user, User $target): bool
    {
        return $user->id === $target->id || $this->manageable($user, $target);
    }

    public function delete(User $user, User $target): bool
    {
        return $user->id !== $target->id && $this->manageable($user, $target);
    }

    /**
     * Admin hanya boleh mengelola akun Guru.
     */
    private function manageable(User $user, User $target): bool
    {
        return $user->role === Role::Admin && $target->role === Role::Guru;
    }
}
