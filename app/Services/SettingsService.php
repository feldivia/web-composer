<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Servicio para lectura/escritura de configuración del sitio.
 *
 * Usa la tabla `settings` como almacenamiento key-value con caché de 1 hora.
 */
class SettingsService
{
    /**
     * Prefijo para las claves de caché.
     */
    private const CACHE_PREFIX = 'setting_';

    /**
     * TTL de caché en segundos (1 hora).
     */
    private const CACHE_TTL = 3600;

    /**
     * Obtiene el valor de una configuración por su clave.
     *
     * Lee primero de caché; si no existe, consulta la BD y cachea el resultado.
     *
     * @param  string  $key      Clave de la configuración (e.g. 'site_name')
     * @param  mixed   $default  Valor por defecto si la clave no existe
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember(
            self::CACHE_PREFIX . $key,
            self::CACHE_TTL,
            function () use ($key, $default): mixed {
                $setting = Setting::where('key', $key)->first();

                return $setting ? $setting->value : $default;
            }
        );
    }

    /**
     * Establece el valor de una configuración.
     *
     * Crea o actualiza el registro en BD y limpia la caché para esa clave.
     *
     * @param  string  $key    Clave de la configuración
     * @param  mixed   $value  Valor a almacenar (se guarda como JSON en BD)
     */
    public static function set(string $key, mixed $value): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget(self::CACHE_PREFIX . $key);
    }

    /**
     * Obtiene múltiples configuraciones de forma eficiente.
     *
     * Para cada clave, intenta leer de caché primero. Las claves no encontradas
     * en caché se consultan en una sola query a la BD.
     *
     * @param  list<string>  $keys  Lista de claves a obtener
     * @return array<string, mixed>  Mapa clave => valor
     */
    public static function getMany(array $keys): array
    {
        $result = [];
        $missingKeys = [];

        // Intentar leer de caché primero
        foreach ($keys as $key) {
            $cached = Cache::get(self::CACHE_PREFIX . $key);

            if ($cached !== null) {
                $result[$key] = $cached;
            } else {
                $missingKeys[] = $key;
            }
        }

        // Consultar las claves faltantes en una sola query
        if ($missingKeys !== []) {
            $settings = Setting::whereIn('key', $missingKeys)->get();

            foreach ($settings as $setting) {
                $result[$setting->key] = $setting->value;

                Cache::put(
                    self::CACHE_PREFIX . $setting->key,
                    $setting->value,
                    self::CACHE_TTL
                );
            }

            // Asegurar que todas las claves solicitadas estén en el resultado
            foreach ($missingKeys as $key) {
                if (! array_key_exists($key, $result)) {
                    $result[$key] = null;
                }
            }
        }

        return $result;
    }
}
