<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Controlador para mantener viva la sesión del editor y refrescar el token CSRF.
 *
 * El editor GrapesJS envía un heartbeat cada 5 minutos a este endpoint.
 * Al responder exitosamente, la sesión se renueva automáticamente y se devuelve
 * un token CSRF fresco para que las peticiones de guardado no fallen por expiración.
 *
 * @example POST /api/heartbeat
 * Response: { "alive": true, "csrf": "new-csrf-token-here" }
 */
class SessionController extends Controller
{
    /**
     * Heartbeat endpoint: toca la sesión para mantenerla activa y devuelve un CSRF token fresco.
     */
    public function heartbeat(): JsonResponse
    {
        // Al procesar esta request, Laravel ya toca la sesión automáticamente
        return response()->json([
            'alive' => true,
            'csrf' => csrf_token(),
        ]);
    }
}
