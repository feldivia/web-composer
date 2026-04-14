<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Page;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@webcomposer.test'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => User::ROLE_ADMIN,
            ]
        );

        // Create editor user
        User::updateOrCreate(
            ['email' => 'editor@webcomposer.test'],
            [
                'name' => 'Editor',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => User::ROLE_EDITOR,
            ]
        );

        // Create writer user
        User::updateOrCreate(
            ['email' => 'writer@webcomposer.test'],
            [
                'name' => 'Writer',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => User::ROLE_WRITER,
            ]
        );

        // Create viewer user (writer role)
        User::updateOrCreate(
            ['email' => 'viewer@webcomposer.test'],
            [
                'name' => 'Viewer',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => User::ROLE_WRITER,
            ]
        );

        // Create default homepage (only if it doesn't exist)
        Page::firstOrCreate(
            ['slug' => 'inicio'],
            [
                'title' => 'Inicio',
                'type' => 'page',
                'content' => [
                    'html' => $this->getHomepageHtml(),
                    'css' => '',
                    'components' => [],
                    'styles' => [],
                ],
                'css' => '',
                'is_homepage' => true,
                'status' => 'published',
                'published_at' => now(),
                'seo_title' => 'WebComposer - Crea sitios web increibles sin codigo',
                'seo_description' => 'CMS moderno con editor visual drag-and-drop, inteligencia artificial y templates profesionales. Crea tu web en minutos.',
            ]
        );

        // Seed settings
        $this->call(SettingsSeeder::class);

        // Seed page templates
        $this->call(PageTemplateSeeder::class);

        // Seed pre-built blocks
        $this->call(BlockSeeder::class);
    }

    private function getHomepageHtml(): string
    {
        return '<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <span class="hero-badge">Plataforma CMS Moderna</span>
        <h1>Crea sitios web <span>increibles</span> sin codigo</h1>
        <p class="hero-subtitle">WebComposer es el constructor visual que te permite disenar, publicar y gestionar tu sitio web profesional con inteligencia artificial integrada.</p>
        <div class="hero-buttons">
            <a href="/admin" class="btn-primary">Comenzar Gratis</a>
            <a href="#features" class="btn-secondary">Ver Funciones</a>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <span class="hero-stat-number" data-count="10">10</span>
                <span class="hero-stat-label">Templates Profesionales</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-number" data-count="50" data-count-suffix="+">50+</span>
                <span class="hero-stat-label">Bloques Visuales</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-number" data-count="10">10</span>
                <span class="hero-stat-label">Google Fonts</span>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features-section" id="features">
    <div class="section-header" data-reveal>
        <span class="section-label">Funcionalidades</span>
        <h2 class="section-title">Todo lo que necesitas para tu web</h2>
        <p class="section-subtitle">Herramientas poderosas y faciles de usar para crear sitios web profesionales sin escribir una sola linea de codigo.</p>
    </div>
    <div class="features-grid">
        <div class="feature-card" data-reveal>
            <div class="feature-icon purple">&#9998;</div>
            <h3>Editor Visual Drag &amp; Drop</h3>
            <p>Arrastra bloques, edita textos en vivo y personaliza cada detalle de tu pagina con nuestro editor intuitivo.</p>
        </div>
        <div class="feature-card" data-reveal>
            <div class="feature-icon blue">&#9881;</div>
            <h3>Inteligencia Artificial</h3>
            <p>Genera textos, optimiza SEO y traduce contenido automaticamente con IA integrada en el editor.</p>
        </div>
        <div class="feature-card" data-reveal>
            <div class="feature-icon amber">&#9733;</div>
            <h3>Templates Profesionales</h3>
            <p>10 plantillas modernas por industria. Restaurantes, clinicas, portafolios, tiendas y mas, listos para personalizar.</p>
        </div>
        <div class="feature-card" data-reveal>
            <div class="feature-icon green">&#128241;</div>
            <h3>100% Responsive</h3>
            <p>Todos los sitios se adaptan automaticamente a moviles, tablets y escritorio. Disena una vez, funciona en todos lados.</p>
        </div>
        <div class="feature-card" data-reveal>
            <div class="feature-icon rose">&#128200;</div>
            <h3>Blog Integrado</h3>
            <p>Sistema completo de blog con categorias, tags, SEO automatico, RSS y programacion de publicaciones.</p>
        </div>
        <div class="feature-card" data-reveal>
            <div class="feature-icon cyan">&#128640;</div>
            <h3>Optimizado para SEO</h3>
            <p>Meta tags automaticos, sitemap XML, schema markup, Open Graph y URLs amigables desde el primer momento.</p>
        </div>
    </div>
</section>

<!-- STEPS -->
<section class="steps-section">
    <div class="section-header" data-reveal>
        <span class="section-label">Como funciona</span>
        <h2 class="section-title">Tu web lista en 3 pasos</h2>
        <p class="section-subtitle">Desde la idea hasta la publicacion en minutos, no en semanas.</p>
    </div>
    <div class="steps-grid">
        <div class="step-item" data-reveal>
            <div class="step-number">1</div>
            <h3>Elige un template</h3>
            <p>Selecciona entre 10 plantillas profesionales disenadas para diferentes industrias y personaliza colores y fuentes.</p>
        </div>
        <div class="step-item" data-reveal>
            <div class="step-number">2</div>
            <h3>Personaliza tu contenido</h3>
            <p>Usa el editor visual para modificar textos, imagenes y estructura. La IA te ayuda a generar contenido atractivo.</p>
        </div>
        <div class="step-item" data-reveal>
            <div class="step-number">3</div>
            <h3>Publica tu sitio</h3>
            <p>Un click para publicar. Tu web esta optimizada, es rapida y se ve profesional en cualquier dispositivo.</p>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-item" data-reveal>
            <span class="stat-number" data-count="99" data-count-suffix="%">99%</span>
            <p class="stat-label">Uptime garantizado</p>
        </div>
        <div class="stat-item" data-reveal>
            <span class="stat-number" data-count="300" data-count-suffix="ms">300ms</span>
            <p class="stat-label">Tiempo de carga</p>
        </div>
        <div class="stat-item" data-reveal>
            <span class="stat-number" data-count="100" data-count-suffix="+">100+</span>
            <p class="stat-label">Efectos y animaciones</p>
        </div>
        <div class="stat-item" data-reveal>
            <span class="stat-number" data-count="24" data-count-suffix="/7">24/7</span>
            <p class="stat-label">Soporte disponible</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="cta-card" data-reveal>
        <h2>Listo para crear tu sitio web?</h2>
        <p>Comienza hoy con WebComposer y transforma tu presencia digital con el poder de la inteligencia artificial.</p>
        <a href="/admin" class="btn-white">Acceder al Panel</a>
    </div>
</section>';
    }
}
