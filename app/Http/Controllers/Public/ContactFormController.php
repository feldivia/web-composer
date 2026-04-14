<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactFormMail;
use App\Models\FormSubmission;
use App\Services\SettingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    /**
     * Almacena una nueva submission del formulario de contacto.
     * Si hay configuración SMTP, envía email de notificación.
     */
    public function store(ContactFormRequest $request): JsonResponse
    {
        /** @var array<string, mixed> $validated */
        $validated = $request->validated();

        unset($validated['website']);

        $submission = FormSubmission::create([
            'page_id' => $validated['page_id'] ?? null,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
        ]);

        // Enviar email si hay configuración SMTP
        $this->sendEmailNotification($submission);

        return response()->json([
            'success' => true,
            'message' => 'Mensaje enviado correctamente',
        ]);
    }

    /**
     * Configura SMTP dinámicamente desde Settings y envía el email.
     */
    private function sendEmailNotification(FormSubmission $submission): void
    {
        $mailTo = SettingsService::get('mail_to');
        $mailHost = SettingsService::get('mail_host');

        if (empty($mailTo) || empty($mailHost)) {
            return;
        }

        try {
            // Configurar SMTP dinámicamente desde Settings
            config([
                'mail.mailers.smtp.host' => $mailHost,
                'mail.mailers.smtp.port' => (int) (SettingsService::get('mail_port') ?: 587),
                'mail.mailers.smtp.username' => SettingsService::get('mail_username') ?: null,
                'mail.mailers.smtp.password' => SettingsService::get('mail_password') ?: null,
                'mail.mailers.smtp.encryption' => SettingsService::get('mail_encryption') ?: 'tls',
                'mail.default' => 'smtp',
                'mail.from.address' => SettingsService::get('mail_from_address') ?: $mailTo,
                'mail.from.name' => SettingsService::get('mail_from_name') ?: SettingsService::get('site_name') ?: 'WebComposer',
            ]);

            Mail::to($mailTo)->send(new ContactFormMail($submission));
        } catch (\Exception $e) {
            Log::warning('Error al enviar email de contacto', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage(),
            ]);
            // No lanzar excepción — el mensaje se guardó en BD, el email es secundario
        }
    }
}
