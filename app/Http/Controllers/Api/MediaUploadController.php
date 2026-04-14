<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaUploadController extends Controller
{
    public function __construct(
        private readonly MediaService $mediaService,
    ) {}

    /**
     * Subir un archivo de medios desde el editor.
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,gif,webp,svg,mp4,pdf'],
        ]);

        $fileData = $this->mediaService->upload($request->file('file'));

        return response()->json($fileData, 201);
    }

    /**
     * Listar todos los archivos en el directorio media del storage público.
     */
    public function index(): JsonResponse
    {
        $files = Storage::disk('public')->files('media');

        $result = array_map(function (string $file) {
            return [
                'url' => Storage::disk('public')->url($file),
                'name' => basename($file),
                'size' => Storage::disk('public')->size($file),
            ];
        }, $files);

        return response()->json(array_values($result));
    }

    /**
     * Eliminar un archivo de medios.
     */
    public function destroy(string $path): JsonResponse
    {
        // Prevent path traversal
        $path = ltrim($path, '/');
        if (str_contains($path, '..') || str_starts_with($path, '/') || !str_starts_with($path, 'uploads/')) {
            return response()->json(['error' => 'Ruta no permitida.'], 403);
        }

        $success = $this->mediaService->delete($path);

        if ($success) {
            return response()->json(['message' => 'Archivo eliminado.']);
        }

        return response()->json(['error' => 'No se pudo eliminar el archivo.'], 404);
    }
}
