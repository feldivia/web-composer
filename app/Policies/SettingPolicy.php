<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

/**
 * Policy para configuración del sitio: solo Admin puede cambiar settings.
 */
class SettingPolicy
{
    /**
     * Determina si el usuario puede ver la configuración.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede modificar la configuración.
     */
    public function update(User $user): bool
    {
        return $user->isAdmin();
    }
}
