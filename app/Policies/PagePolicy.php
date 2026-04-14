<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

/**
 * Policy para páginas: solo Admin y Editor pueden gestionar páginas.
 */
class PagePolicy
{
    /**
     * Determina si el usuario puede ver el listado de páginas.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole([User::ROLE_ADMIN, User::ROLE_EDITOR]);
    }

    /**
     * Determina si el usuario puede ver una página específica.
     */
    public function view(User $user, Page $page): bool
    {
        return $user->hasRole([User::ROLE_ADMIN, User::ROLE_EDITOR]);
    }

    /**
     * Determina si el usuario puede crear páginas.
     */
    public function create(User $user): bool
    {
        return $user->hasRole([User::ROLE_ADMIN, User::ROLE_EDITOR]);
    }

    /**
     * Determina si el usuario puede editar una página.
     */
    public function update(User $user, Page $page): bool
    {
        return $user->hasRole([User::ROLE_ADMIN, User::ROLE_EDITOR]);
    }

    /**
     * Determina si el usuario puede eliminar una página.
     */
    public function delete(User $user, Page $page): bool
    {
        return $user->hasRole([User::ROLE_ADMIN, User::ROLE_EDITOR]);
    }

    /**
     * Determina si el usuario puede eliminar páginas en masa.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasRole([User::ROLE_ADMIN, User::ROLE_EDITOR]);
    }
}
