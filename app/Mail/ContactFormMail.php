<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\FormSubmission;
use App\Services\SettingsService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public FormSubmission $submission,
    ) {}

    public function envelope(): Envelope
    {
        $siteName = SettingsService::get('site_name') ?? 'WebComposer';
        $subject = $this->submission->subject
            ? "[{$siteName}] {$this->submission->subject}"
            : "[{$siteName}] Nuevo mensaje de contacto";

        return new Envelope(
            subject: $subject,
            replyTo: [$this->submission->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: $this->buildHtml(),
        );
    }

    private function buildHtml(): string
    {
        $name = e($this->submission->name);
        $email = e($this->submission->email);
        $phone = $this->submission->phone ? e($this->submission->phone) : '—';
        $subject = $this->submission->subject ? e($this->submission->subject) : '—';
        $message = nl2br(e($this->submission->message));
        $date = $this->submission->created_at->format('d/m/Y H:i');
        $siteName = e(SettingsService::get('site_name') ?? 'WebComposer');

        return <<<HTML
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
            <div style="background: #6366f1; color: #fff; padding: 20px; border-radius: 12px 12px 0 0;">
                <h2 style="margin: 0; font-size: 18px;">Nuevo mensaje de contacto</h2>
                <p style="margin: 4px 0 0; opacity: 0.8; font-size: 13px;">{$siteName} — {$date}</p>
            </div>
            <div style="background: #fff; border: 1px solid #e2e8f0; border-top: none; padding: 24px; border-radius: 0 0 12px 12px;">
                <table style="width: 100%; font-size: 14px; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; width: 100px; vertical-align: top;">Nombre:</td>
                        <td style="padding: 8px 0; color: #1e293b; font-weight: 600;">{$name}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; vertical-align: top;">Email:</td>
                        <td style="padding: 8px 0;"><a href="mailto:{$email}" style="color: #6366f1;">{$email}</a></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; vertical-align: top;">Teléfono:</td>
                        <td style="padding: 8px 0; color: #1e293b;">{$phone}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; vertical-align: top;">Asunto:</td>
                        <td style="padding: 8px 0; color: #1e293b;">{$subject}</td>
                    </tr>
                </table>
                <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 16px 0;">
                <div style="font-size: 14px; color: #1e293b; line-height: 1.7;">
                    <strong style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Mensaje:</strong><br><br>
                    {$message}
                </div>
            </div>
            <p style="text-align: center; font-size: 11px; color: #94a3b8; margin-top: 16px;">
                Este email fue enviado automáticamente desde el formulario de contacto de {$siteName}.
            </p>
        </div>
        HTML;
    }
}
