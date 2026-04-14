<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

/**
 * Servicio para subir, validar y eliminar archivos multimedia.
 *
 * Utiliza la configuración de `config/webcomposer.php` → `media` para
 * determinar el disco de almacenamiento, tamaño máximo y tipos permitidos.
 */
class MediaService
{
    /**
     * Sube un archivo al disco configurado.
     *
     * Valida el archivo antes de subirlo. Almacena en la carpeta `uploads`
     * del disco público con un nombre único generado automáticamente.
     *
     * @param  UploadedFile  $file  Archivo subido desde el formulario o editor
     * @return array{path: string, url: string, name: string, size: int, mime: string}
     *
     * @throws InvalidArgumentException Si el archivo no pasa la validación
     *
     * Ejemplo de respuesta:
     * ```json
     * {
     *   "path": "uploads/abc123.jpg",
     *   "url": "/storage/uploads/abc123.jpg",
     *   "name": "foto-producto.jpg",
     *   "size": 204800,
     *   "mime": "image/jpeg"
     * }
     * ```
     */
    public function upload(UploadedFile $file): array
    {
        if (! $this->validate($file)) {
            throw new InvalidArgumentException(
                'El archivo no cumple con los requisitos de tipo o tamaño permitidos.'
            );
        }

        $disk = config('webcomposer.media.disk', 'public');
        $path = $file->store('uploads', $disk);

        return [
            'path' => $path,
            'url' => '/storage/' . $path,
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
        ];
    }

    /**
     * Valida que el archivo cumpla con los requisitos de tipo y tamaño.
     *
     * @param  UploadedFile  $file  Archivo a validar
     * @return bool  true si el archivo es válido
     */
    public function validate(UploadedFile $file): bool
    {
        $allowedTypes = config('webcomposer.media.allowed_types', []);
        $maxSize = (int) config('webcomposer.media.max_file_size', 10240);

        $extension = strtolower($file->getClientOriginalExtension());

        // Block SVG uploads (potential XSS vector)
        if ($extension === 'svg') {
            return false;
        }

        if (! in_array($extension, $allowedTypes, true)) {
            return false;
        }

        // Block dangerous MIME types
        $mimeType = $file->getMimeType();
        $dangerousMimes = ['text/html', 'application/javascript', 'text/javascript', 'application/x-httpd-php'];
        if (in_array($mimeType, $dangerousMimes, true)) {
            return false;
        }

        // max_file_size está en KB, getSize() retorna bytes
        if ($file->getSize() > $maxSize * 1024) {
            return false;
        }

        return true;
    }

    /**
     * Elimina un archivo del disco de almacenamiento.
     *
     * @param  string  $path  Ruta relativa del archivo (e.g. 'uploads/abc123.jpg')
     * @return bool  true si se eliminó correctamente
     */
    public function delete(string $path): bool
    {
        $disk = config('webcomposer.media.disk', 'public');

        return Storage::disk($disk)->delete($path);
    }
}
