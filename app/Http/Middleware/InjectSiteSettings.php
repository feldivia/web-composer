<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\SettingsService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware que inyecta la configuración global del sitio en todas las vistas.
 *
 * Lee las settings principales (nombre, logo, fuentes, colores, redes sociales, etc.)
 * via SettingsService y las comparte como variable `$siteSettings` disponible
 * en todas las vistas Blade.
 */
class InjectSiteSettings
{
    /**
     * Claves de configuración que se inyectan en las vistas.
     *
     * @var list<string>
     */
    private const SETTING_KEYS = [
        'site_name',
        'site_description',
        'site_logo',
        'site_favicon',
        'font_heading',
        'font_body',
        'color_primary',
        'color_secondary',
        'color_accent',
        'color_background',
        'color_text',
        'social_facebook',
        'social_instagram',
        'social_twitter',
        'social_linkedin',
        'social_youtube',
        'whatsapp_number',
        'whatsapp_message',
        'footer_text',
    ];

    /**
     * Procesa la request inyectando las settings del sitio en las vistas.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $settings = SettingsService::getMany(self::SETTING_KEYS);

        View::share('siteSettings', $settings);

        return $next($request);
    }
}
