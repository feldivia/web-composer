<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Servicio de sanitización de HTML usando HTMLPurifier.
 *
 * Permite HTML seguro (tags de layout, estilos inline, imágenes, videos)
 * pero elimina scripts, event handlers y contenido malicioso.
 */
class HtmlSanitizerService
{
    private static ?\HTMLPurifier $purifier = null;

    /**
     * Sanitiza HTML permitiendo tags seguros para el page builder.
     */
    public static function sanitize(string $html): string
    {
        if (trim($html) === '') {
            return '';
        }

        return self::getPurifier()->purify($html);
    }

    /**
     * Sanitiza CSS eliminando expresiones, imports y URLs peligrosas.
     */
    public static function sanitizeCss(string $css): string
    {
        if (trim($css) === '') {
            return '';
        }

        // Bloquear todas las variantes de @import (url(), string, etc.)
        $css = preg_replace('/@import\s+/i', '/* blocked @import */ ', $css);
        // Bloquear @charset, @namespace (pueden causar encoding attacks)
        $css = preg_replace('/@charset\s+/i', '/* blocked @charset */ ', $css);
        $css = preg_replace('/@namespace\s+/i', '/* blocked @namespace */ ', $css);
        // Bloquear javascript: en URLs (incluir variantes con escapes)
        $css = preg_replace('/url\s*\(\s*["\']?\s*j\s*a\s*v\s*a\s*s\s*c\s*r\s*i\s*p\s*t\s*:/i', 'url(about:blank', $css);
        // Bloquear expression() (IE)
        $css = preg_replace('/expression\s*\(/i', '/* blocked */(', $css);
        // Bloquear behavior (IE)
        $css = preg_replace('/behavior\s*:/i', '/* blocked */', $css);
        // Bloquear -moz-binding (Firefox legacy)
        $css = preg_replace('/-moz-binding\s*:/i', '/* blocked */', $css);
        // Bloquear data: URLs en CSS (pueden contener scripts)
        $css = preg_replace('/url\s*\(\s*["\']?\s*data\s*:/i', 'url(about:blank', $css);

        return $css;
    }

    private static function getPurifier(): \HTMLPurifier
    {
        if (self::$purifier === null) {
            $config = \HTMLPurifier_Config::createDefault();

            // Cache
            $cacheDir = storage_path('app/htmlpurifier');
            if (!is_dir($cacheDir)) {
                mkdir($cacheDir, 0755, true);
            }
            $config->set('Cache.SerializerPath', $cacheDir);

            // All allowed tags (including HTML5 registered via addElement below)
            $config->set('HTML.Allowed',
                'div[style|class|id|data-reveal|data-count|data-count-suffix|data-accordion|data-menu-toggle|data-mobile-menu|data-scroll-top],' .
                'span[style|class|data-reveal|data-count|data-count-suffix],p[style|class],' .
                'a[href|target|style|class|title],img[src|alt|style|class|width|height|loading],' .
                'h1[style|class|id],h2[style|class|id],h3[style|class|id],h4[style|class|id],h5[style|class|id],h6[style|class|id],' .
                'section[style|class|id|data-reveal],article[style|class],aside[style|class],header[style|class],footer[style|class],nav[style|class|data-menu-toggle|data-mobile-menu],main[style|class],' .
                'figure[style|class],figcaption[style|class],' .
                'details[style|class],summary[style|class],' .
                'ul[style|class],ol[style|class],li[style|class],' .
                'table[style|class],thead,tbody,tr,th[style|class],td[style|class],' .
                'strong,em,b,i,u,s,br,hr[style|class],' .
                'blockquote[style|class],pre[style|class],code,' .
                'form[style|class|action|method],input[type|placeholder|style|class|name|value|required],textarea[placeholder|rows|style|class|name|required],select[style|class|name],option[value|selected],button[type|style|class],label[for|style|class],' .
                'iframe[src|width|height|style|class|frameborder|allowfullscreen|loading],' .
                'video[src|controls|autoplay|loop|muted|style|class|width|height],source[src|type],' .
                'mark[style|class],small[style|class],sub,sup'
            );

            $config->set('CSS.AllowTricky', true);
            // CSS.Trusted=true necesario para estilos inline de secciones premium
            // La sanitizacion de CSS se hace via sanitizeCss() con regex
            $config->set('CSS.Trusted', true);
            $config->set('Attr.AllowedFrameTargets', ['_blank', '_self']);
            $config->set('HTML.SafeIframe', true);
            $config->set('URI.SafeIframeRegexp', '%^(https?:)?//(www\.youtube\.com/embed/|www\.google\.com/maps/embed|player\.vimeo\.com/video/|www\.youtube-nocookie\.com/embed/)%');
            $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true, 'tel' => true]);

            // Register HTML5 elements not natively supported
            $def = $config->getHTMLDefinition(true);
            if ($def) {
                // HTML5 semantic elements (Block type, inline content or Flow)
                $html5Block = [
                    'section', 'article', 'aside', 'header', 'footer', 'nav',
                    'figure', 'figcaption', 'main',
                ];
                foreach ($html5Block as $el) {
                    $def->addElement($el, 'Block', 'Flow', 'Common');
                }

                // Details/summary
                $def->addElement('details', 'Block', 'Flow', 'Common');
                $def->addElement('summary', 'Block', 'Flow', 'Common');

                // Form elements
                $def->addElement('form', 'Block', 'Flow', 'Common', [
                    'action' => 'URI',
                    'method' => 'Enum#get,post',
                ]);
                $def->addElement('input', 'Inline', 'Empty', 'Common', [
                    'type' => 'Text',
                    'name' => 'Text',
                    'value' => 'Text',
                    'placeholder' => 'Text',
                    'required' => 'Bool',
                ]);
                $def->addElement('textarea', 'Inline', 'Inline', 'Common', [
                    'name' => 'Text',
                    'rows' => 'Number',
                    'placeholder' => 'Text',
                    'required' => 'Bool',
                ]);
                $def->addElement('select', 'Inline', 'Required: option', 'Common', [
                    'name' => 'Text',
                ]);
                $def->addElement('option', 'Inline', 'Inline', 'Common', [
                    'value' => 'Text',
                    'selected' => 'Bool',
                ]);
                $def->addElement('button', 'Inline', 'Inline', 'Common', [
                    'type' => 'Enum#button,submit,reset',
                ]);
                $def->addElement('label', 'Inline', 'Inline', 'Common', [
                    'for' => 'ID',
                ]);

                // Media elements
                $def->addElement('video', 'Block', 'Optional: source | Flow', 'Common', [
                    'src' => 'URI',
                    'controls' => 'Bool',
                    'autoplay' => 'Bool',
                    'loop' => 'Bool',
                    'muted' => 'Bool',
                    'width' => 'Length',
                    'height' => 'Length',
                ]);
                $def->addElement('source', 'Inline', 'Empty', 'Common', [
                    'src' => 'URI',
                    'type' => 'Text',
                ]);

                // Mark element
                $def->addElement('mark', 'Inline', 'Inline', 'Common');

                // Add loading attribute to img
                $def->addAttribute('img', 'loading', 'Enum#lazy,eager');

                // Add allowfullscreen to iframe
                $def->addAttribute('iframe', 'allowfullscreen', 'Bool');
                $def->addAttribute('iframe', 'loading', 'Enum#lazy,eager');

                // Data attributes for JS effects on all elements (native + custom)
                $dataAttrs = [
                    'data-reveal', 'data-count', 'data-count-suffix', 'data-accordion',
                    'data-menu-toggle', 'data-mobile-menu', 'data-scroll-top',
                    'data-animate', 'data-animate-delay', 'data-hover', 'data-parallax',
                    'data-typewriter', 'data-marquee', 'data-lightbox', 'data-carousel',
                    'data-tabs', 'data-sticky', 'data-progress', 'data-dismiss',
                    'data-video-src', 'data-pricing-toggle', 'data-before-after',
                ];
                // Custom HTML5 elements
                $customElements = ['section', 'button', 'details', 'nav'];
                foreach ($customElements as $el) {
                    foreach ($dataAttrs as $attr) {
                        $def->addAttribute($el, $attr, 'Text');
                    }
                }
                // Native elements need attributes added via addAttribute too
                $nativeElements = ['div', 'span', 'a', 'ul', 'li', 'p', 'h1', 'h2', 'h3'];
                foreach ($nativeElements as $el) {
                    foreach ($dataAttrs as $attr) {
                        $def->addAttribute($el, $attr, 'Text');
                    }
                }
            }

            self::$purifier = new \HTMLPurifier($config);
        }

        return self::$purifier;
    }
}
