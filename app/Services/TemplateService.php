<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Page;
use App\Models\PageTemplate;
use Illuminate\Support\Collection;

/**
 * Servicio para listar, cargar y aplicar templates precargados a páginas.
 *
 * Los templates se almacenan en la tabla `page_templates` y contienen
 * la estructura GrapesJS completa (HTML, CSS, componentes, estilos)
 * junto con configuración de fuentes y colores.
 */
class TemplateService
{
    /**
     * Lista todos los templates disponibles.
     *
     * @return Collection<int, PageTemplate>
     */
    public function list(): Collection
    {
        return PageTemplate::all();
    }

    /**
     * Carga un template por su slug.
     *
     * @param  string  $slug  Slug del template (e.g. 'landing-startup')
     * @return PageTemplate|null  null si no se encuentra
     */
    public function load(string $slug): ?PageTemplate
    {
        return PageTemplate::where('slug', $slug)->first();
    }

    /**
     * Aplica un template a una página.
     *
     * Copia el contenido GrapesJS (html, components, styles), los estilos CSS,
     * y registra el slug del template en la página.
     *
     * @param  Page          $page      Página destino
     * @param  PageTemplate  $template  Template a aplicar
     * @return Page  La página con el template aplicado (ya guardada)
     */
    public function applyToPage(Page $page, PageTemplate $template): Page
    {
        $templateContent = $template->content ?? [];

        $page->content = [
            'html' => $templateContent['html'] ?? '',
            'components' => $templateContent['components'] ?? [],
            'styles' => $templateContent['styles'] ?? [],
        ];

        $page->css = $templateContent['css'] ?? '';
        $page->template = $template->slug;

        $page->save();

        return $page;
    }
}
