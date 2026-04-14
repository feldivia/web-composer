<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

/**
 * Policy para posts: Admin y Editor pueden gestionar todos los posts.
 * Writer solo puede crear y editar sus propios posts.
 */
class PostPolicy
{
    /**
     * Determina si el usuario puede ver el listado de posts.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determina si el usuario puede ver un post específico.
     */
    public function view(User $user, Post $post): bool
    {
        if ($user->hasRole([User::ROLE_ADMIN, User::ROLE_EDITOR])) {
            return true;
        }

        return $user->id === $post->user_id;
    }

    /**
     * Determina si el usuario puede crear posts.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determina si el usuario puede editar un post.
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->hasRole([User::ROLE_ADMIN, User::ROLE_EDITOR])) {
            return true;
        }

        return $user->id === $post->user_id;
    }

    /**
     * Determina si el usuario puede eliminar un post.
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user->hasRole([User::ROLE_ADMIN, User::ROLE_EDITOR])) {
            return true;
        }

        return $user->id === $post->user_id;
    }

    /**
     * Determina si el usuario puede eliminar posts en masa.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasRole([User::ROLE_ADMIN, User::ROLE_EDITOR]);
    }
}
