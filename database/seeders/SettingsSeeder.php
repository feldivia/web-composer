<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'Mi Sitio Web',
            'site_description' => 'Sitio web creado con WebComposer',
            'site_logo' => null,
            'site_favicon' => null,
            'font_heading' => 'Montserrat',
            'font_body' => 'Inter',
            'color_primary' => '#6366F1',
            'color_secondary' => '#0EA5E9',
            'color_accent' => '#F59E0B',
            'color_background' => '#FFFFFF',
            'color_text' => '#1E293B',
            'analytics_id' => null,
            'meta_pixel_id' => null,
            'whatsapp_number' => null,
            'whatsapp_message' => 'Hola, necesito información',
            'footer_text' => '© ' . date('Y') . ' Mi Sitio Web',
            'social_facebook' => null,
            'social_instagram' => null,
            'social_twitter' => null,
            'social_linkedin' => null,
            'social_youtube' => null,
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
