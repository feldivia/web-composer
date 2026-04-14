/**
 * Custom Blocks Plugin for WebComposer
 * Registers advanced reusable blocks for the GrapesJS editor.
 */
export default (editor, opts = {}) => {
    const bm = editor.BlockManager;

    // ===== Navigation / Header =====
    bm.add('navbar', {
        label: 'Navbar',
        category: 'Navegación',
        content: `<nav style="display:flex; align-items:center; justify-content:space-between; padding:16px 32px; background:#fff; box-shadow:0 1px 3px rgba(0,0,0,0.1); position:sticky; top:0; z-index:100;">
            <a href="/" style="font-size:24px; font-weight:700; color:#1e293b; text-decoration:none;">Tu Logo</a>
            <div style="display:flex; gap:24px; align-items:center;">
                <a href="#" style="color:#475569; text-decoration:none; font-size:15px; font-weight:500;">Inicio</a>
                <a href="#" style="color:#475569; text-decoration:none; font-size:15px; font-weight:500;">Nosotros</a>
                <a href="#" style="color:#475569; text-decoration:none; font-size:15px; font-weight:500;">Servicios</a>
                <a href="#" style="color:#475569; text-decoration:none; font-size:15px; font-weight:500;">Blog</a>
                <a href="#" style="display:inline-block; padding:10px 24px; background:#6366f1; color:#fff; border-radius:8px; text-decoration:none; font-weight:600; font-size:14px;">Contacto</a>
            </div>
        </nav>`,
    });

    // ===== Gallery =====
    bm.add('gallery-grid', {
        label: 'Galería',
        category: 'Media',
        content: `<section style="padding:60px 20px; background:#fff;">
            <div style="max-width:1100px; margin:0 auto;">
                <h2 style="font-size:32px; font-weight:700; text-align:center; margin-bottom:32px;">Galería</h2>
                <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px;">
                    <img src="https://picsum.photos/400/300?random=1" style="width:100%; height:250px; object-fit:cover; border-radius:8px;" alt="Galería 1">
                    <img src="https://picsum.photos/400/300?random=2" style="width:100%; height:250px; object-fit:cover; border-radius:8px;" alt="Galería 2">
                    <img src="https://picsum.photos/400/300?random=3" style="width:100%; height:250px; object-fit:cover; border-radius:8px;" alt="Galería 3">
                    <img src="https://picsum.photos/400/300?random=4" style="width:100%; height:250px; object-fit:cover; border-radius:8px;" alt="Galería 4">
                    <img src="https://picsum.photos/400/300?random=5" style="width:100%; height:250px; object-fit:cover; border-radius:8px;" alt="Galería 5">
                    <img src="https://picsum.photos/400/300?random=6" style="width:100%; height:250px; object-fit:cover; border-radius:8px;" alt="Galería 6">
                </div>
            </div>
        </section>`,
    });

    // ===== Team Section =====
    bm.add('team-section', {
        label: 'Equipo',
        category: 'Secciones',
        content: `<section style="padding:80px 20px; background:#fff;">
            <div style="max-width:1100px; margin:0 auto; text-align:center;">
                <h2 style="font-size:36px; font-weight:700; margin-bottom:48px;">Nuestro Equipo</h2>
                <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:24px;">
                    <div style="text-align:center;">
                        <img src="https://picsum.photos/200/200?random=10" style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-bottom:16px;" alt="Miembro">
                        <h4 style="font-weight:600; margin-bottom:4px;">Ana García</h4>
                        <p style="color:#64748b; font-size:14px;">CEO & Fundadora</p>
                    </div>
                    <div style="text-align:center;">
                        <img src="https://picsum.photos/200/200?random=11" style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-bottom:16px;" alt="Miembro">
                        <h4 style="font-weight:600; margin-bottom:4px;">Carlos López</h4>
                        <p style="color:#64748b; font-size:14px;">CTO</p>
                    </div>
                    <div style="text-align:center;">
                        <img src="https://picsum.photos/200/200?random=12" style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-bottom:16px;" alt="Miembro">
                        <h4 style="font-weight:600; margin-bottom:4px;">María Torres</h4>
                        <p style="color:#64748b; font-size:14px;">Diseñadora</p>
                    </div>
                    <div style="text-align:center;">
                        <img src="https://picsum.photos/200/200?random=13" style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-bottom:16px;" alt="Miembro">
                        <h4 style="font-weight:600; margin-bottom:4px;">Pedro Ruiz</h4>
                        <p style="color:#64748b; font-size:14px;">Desarrollador</p>
                    </div>
                </div>
            </div>
        </section>`,
    });

    // ===== FAQ / Accordion =====
    bm.add('faq-section', {
        label: 'FAQ',
        category: 'Secciones',
        content: `<section style="padding:80px 20px; background:#f8fafc;">
            <div style="max-width:800px; margin:0 auto;">
                <h2 style="font-size:36px; font-weight:700; text-align:center; margin-bottom:48px;">Preguntas Frecuentes</h2>
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <details style="background:#fff; border-radius:8px; padding:20px; box-shadow:0 1px 2px rgba(0,0,0,0.05);">
                        <summary style="font-weight:600; cursor:pointer; font-size:16px;">¿Cómo funciona el servicio?</summary>
                        <p style="margin-top:12px; color:#475569; line-height:1.6;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris.</p>
                    </details>
                    <details style="background:#fff; border-radius:8px; padding:20px; box-shadow:0 1px 2px rgba(0,0,0,0.05);">
                        <summary style="font-weight:600; cursor:pointer; font-size:16px;">¿Cuáles son los planes disponibles?</summary>
                        <p style="margin-top:12px; color:#475569; line-height:1.6;">Ofrecemos tres planes adaptados a diferentes necesidades: Básico, Pro y Enterprise.</p>
                    </details>
                    <details style="background:#fff; border-radius:8px; padding:20px; box-shadow:0 1px 2px rgba(0,0,0,0.05);">
                        <summary style="font-weight:600; cursor:pointer; font-size:16px;">¿Ofrecen soporte técnico?</summary>
                        <p style="margin-top:12px; color:#475569; line-height:1.6;">Sí, todos los planes incluyen soporte técnico vía email. Los planes Pro y Enterprise incluyen soporte prioritario.</p>
                    </details>
                </div>
            </div>
        </section>`,
    });

    // ===== Stats / Counter =====
    bm.add('stats-section', {
        label: 'Estadísticas',
        category: 'Secciones',
        content: `<section style="padding:60px 20px; background:#6366f1; color:#fff;">
            <div style="max-width:1100px; margin:0 auto; display:grid; grid-template-columns:repeat(4, 1fr); gap:24px; text-align:center;">
                <div>
                    <div style="font-size:48px; font-weight:700;">500+</div>
                    <div style="font-size:16px; opacity:0.8; margin-top:4px;">Clientes</div>
                </div>
                <div>
                    <div style="font-size:48px; font-weight:700;">1200+</div>
                    <div style="font-size:16px; opacity:0.8; margin-top:4px;">Proyectos</div>
                </div>
                <div>
                    <div style="font-size:48px; font-weight:700;">98%</div>
                    <div style="font-size:16px; opacity:0.8; margin-top:4px;">Satisfacción</div>
                </div>
                <div>
                    <div style="font-size:48px; font-weight:700;">24/7</div>
                    <div style="font-size:16px; opacity:0.8; margin-top:4px;">Soporte</div>
                </div>
            </div>
        </section>`,
    });

    // ===== Blog Posts Preview =====
    bm.add('blog-preview', {
        label: 'Blog Preview',
        category: 'Secciones',
        content: `<section style="padding:80px 20px; background:#fff;">
            <div style="max-width:1100px; margin:0 auto;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
                    <h2 style="font-size:32px; font-weight:700;">Últimas Publicaciones</h2>
                    <a href="/blog" style="color:#6366f1; text-decoration:none; font-weight:600;">Ver todas →</a>
                </div>
                <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:24px;">
                    <article style="border-radius:12px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                        <img src="https://picsum.photos/400/250?random=20" style="width:100%; height:200px; object-fit:cover;" alt="Post">
                        <div style="padding:20px;">
                            <span style="font-size:13px; color:#6366f1; font-weight:600;">Tecnología</span>
                            <h3 style="font-size:18px; font-weight:600; margin:8px 0;">Título del artículo aquí</h3>
                            <p style="color:#64748b; font-size:14px; line-height:1.5;">Breve descripción del contenido del post...</p>
                        </div>
                    </article>
                    <article style="border-radius:12px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                        <img src="https://picsum.photos/400/250?random=21" style="width:100%; height:200px; object-fit:cover;" alt="Post">
                        <div style="padding:20px;">
                            <span style="font-size:13px; color:#6366f1; font-weight:600;">Diseño</span>
                            <h3 style="font-size:18px; font-weight:600; margin:8px 0;">Segundo artículo interesante</h3>
                            <p style="color:#64748b; font-size:14px; line-height:1.5;">Otro resumen breve del contenido...</p>
                        </div>
                    </article>
                    <article style="border-radius:12px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                        <img src="https://picsum.photos/400/250?random=22" style="width:100%; height:200px; object-fit:cover;" alt="Post">
                        <div style="padding:20px;">
                            <span style="font-size:13px; color:#6366f1; font-weight:600;">Negocios</span>
                            <h3 style="font-size:18px; font-weight:600; margin:8px 0;">Tercer artículo destacado</h3>
                            <p style="color:#64748b; font-size:14px; line-height:1.5;">Descripción del tercer post...</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>`,
    });

    // ===== Icon List =====
    bm.add('icon-list', {
        label: 'Lista con Iconos',
        category: 'Básicos',
        content: `<ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:16px;">
            <li style="display:flex; align-items:flex-start; gap:12px;">
                <span style="display:flex; align-items:center; justify-content:center; width:32px; height:32px; background:#ede9fe; border-radius:50%; color:#6366f1; font-size:16px; flex-shrink:0;">✓</span>
                <div>
                    <strong style="font-weight:600;">Primer beneficio</strong>
                    <p style="color:#64748b; font-size:14px; margin-top:2px;">Descripción breve del beneficio.</p>
                </div>
            </li>
            <li style="display:flex; align-items:flex-start; gap:12px;">
                <span style="display:flex; align-items:center; justify-content:center; width:32px; height:32px; background:#ede9fe; border-radius:50%; color:#6366f1; font-size:16px; flex-shrink:0;">✓</span>
                <div>
                    <strong style="font-weight:600;">Segundo beneficio</strong>
                    <p style="color:#64748b; font-size:14px; margin-top:2px;">Descripción breve del beneficio.</p>
                </div>
            </li>
            <li style="display:flex; align-items:flex-start; gap:12px;">
                <span style="display:flex; align-items:center; justify-content:center; width:32px; height:32px; background:#ede9fe; border-radius:50%; color:#6366f1; font-size:16px; flex-shrink:0;">✓</span>
                <div>
                    <strong style="font-weight:600;">Tercer beneficio</strong>
                    <p style="color:#64748b; font-size:14px; margin-top:2px;">Descripción breve del beneficio.</p>
                </div>
            </li>
        </ul>`,
    });

    // ===== Two Column Content =====
    bm.add('two-col-image-text', {
        label: 'Imagen + Texto',
        category: 'Layout',
        content: `<section style="padding:80px 20px; background:#fff;">
            <div style="max-width:1100px; margin:0 auto; display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:center;">
                <img src="https://picsum.photos/600/400?random=30" style="width:100%; border-radius:12px;" alt="Imagen">
                <div>
                    <h2 style="font-size:32px; font-weight:700; margin-bottom:16px;">Título de la sección</h2>
                    <p style="color:#475569; font-size:16px; line-height:1.7; margin-bottom:24px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                    <a href="#" style="display:inline-block; padding:12px 28px; background:#6366f1; color:#fff; border-radius:8px; text-decoration:none; font-weight:600;">Saber Más</a>
                </div>
            </div>
        </section>`,
    });

    // ===== WhatsApp Button (Floating) =====
    bm.add('whatsapp-button', {
        label: 'WhatsApp',
        category: 'Extras',
        content: `<a href="https://wa.me/56912345678?text=Hola" target="_blank" style="position:fixed; bottom:24px; right:24px; width:60px; height:60px; background:#25d366; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(37,211,102,0.4); z-index:999; text-decoration:none; font-size:28px;">💬</a>`,
    });

    // ===== Tabs =====
    bm.add('tabs-section', {
        label: 'Tabs',
        category: 'Interactivos',
        content: `<div style="max-width:800px; margin:0 auto; padding:40px 20px;">
            <div style="display:flex; border-bottom:2px solid #e2e8f0; margin-bottom:24px;">
                <button style="padding:12px 24px; background:none; border:none; border-bottom:2px solid #6366f1; color:#6366f1; font-weight:600; cursor:pointer; margin-bottom:-2px;">Tab 1</button>
                <button style="padding:12px 24px; background:none; border:none; color:#64748b; cursor:pointer;">Tab 2</button>
                <button style="padding:12px 24px; background:none; border:none; color:#64748b; cursor:pointer;">Tab 3</button>
            </div>
            <div>
                <p style="color:#475569; line-height:1.7;">Contenido del primer tab. Este contenido se muestra cuando el tab está activo. Puedes personalizar el contenido de cada tab según tus necesidades.</p>
            </div>
        </div>`,
    });

    // ===== Alert / Banner =====
    bm.add('alert-banner', {
        label: 'Banner/Alerta',
        category: 'Extras',
        content: `<div style="padding:16px 24px; background:#ede9fe; border-left:4px solid #6366f1; border-radius:0 8px 8px 0; display:flex; align-items:center; gap:12px;">
            <span style="font-size:20px;">ℹ️</span>
            <p style="margin:0; color:#4338ca; font-size:15px;">Este es un mensaje informativo importante para tus visitantes.</p>
        </div>`,
    });

    // ===== Card =====
    bm.add('card', {
        label: 'Tarjeta',
        category: 'Básicos',
        content: `<div style="background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.1); overflow:hidden; max-width:350px;">
            <img src="https://picsum.photos/400/250?random=40" style="width:100%; height:200px; object-fit:cover;" alt="Card">
            <div style="padding:20px;">
                <h3 style="font-size:18px; font-weight:600; margin-bottom:8px;">Título de la tarjeta</h3>
                <p style="color:#64748b; font-size:14px; line-height:1.5; margin-bottom:16px;">Descripción breve del contenido de esta tarjeta.</p>
                <a href="#" style="color:#6366f1; text-decoration:none; font-weight:600; font-size:14px;">Leer más →</a>
            </div>
        </div>`,
    });

    // ===== Social Links =====
    bm.add('social-links', {
        label: 'Redes Sociales',
        category: 'Extras',
        content: `<div style="display:flex; gap:12px; justify-content:center; padding:20px;">
            <a href="#" style="display:flex; align-items:center; justify-content:center; width:44px; height:44px; background:#f1f5f9; border-radius:50%; text-decoration:none; font-size:18px; transition:background 0.2s;">📘</a>
            <a href="#" style="display:flex; align-items:center; justify-content:center; width:44px; height:44px; background:#f1f5f9; border-radius:50%; text-decoration:none; font-size:18px;">📷</a>
            <a href="#" style="display:flex; align-items:center; justify-content:center; width:44px; height:44px; background:#f1f5f9; border-radius:50%; text-decoration:none; font-size:18px;">🐦</a>
            <a href="#" style="display:flex; align-items:center; justify-content:center; width:44px; height:44px; background:#f1f5f9; border-radius:50%; text-decoration:none; font-size:18px;">💼</a>
            <a href="#" style="display:flex; align-items:center; justify-content:center; width:44px; height:44px; background:#f1f5f9; border-radius:50%; text-decoration:none; font-size:18px;">▶️</a>
        </div>`,
    });
};
