<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

/**
 * Policy para usuarios: solo Admin puede gestionar usuarios.
 */
class UserPolicy
{
    /**
     * Determina si el usuario puede ver el listado de usuarios.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede ver un usuario específico.
     */
    public function view(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede crear usuarios.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede editar un usuario.
     */
    public function update(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar un usuario.
     * Admin no puede eliminarse a sí mismo.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }

        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar usuarios en masa.
     */
    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
