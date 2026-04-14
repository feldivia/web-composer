<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Models\FormSubmission;
use Illuminate\Http\JsonResponse;

class ContactFormController extends Controller
{
    /**
     * Almacena una nueva submission del formulario de contacto.
     *
     * Rate limit: max 5 submissions por IP por hora (aplicado via middleware en la ruta).
     *
     * @param ContactFormRequest $request
     * @return JsonResponse
     *
     * @example Request:
     *   POST /contact
     *   {
     *     "name": "Juan Pérez",
     *     "email": "juan@example.com",
     *     "phone": "+56912345678",
     *     "subject": "Consulta",
     *     "message": "Me gustaría saber más sobre sus servicios.",
     *     "page_id": 1
     *   }
     *
     * @example Response (200):
     *   { "success": true, "message": "Mensaje enviado correctamente" }
     *
     * @example Response (422):
     *   { "success": false, "message": "Error de validación", "errors": {...} }
     *
     * @example Response (429):
     *   { "message": "Too Many Attempts." }
     */
    public function store(ContactFormRequest $request): JsonResponse
    {
        /** @var array<string, mixed> $validated */
        $validated = $request->validated();

        // Eliminar el campo honeypot antes de guardar
        unset($validated['website']);

        FormSubmission::create([
            'page_id' => $validated['page_id'] ?? null,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mensaje enviado correctamente',
        ]);
    }
}
