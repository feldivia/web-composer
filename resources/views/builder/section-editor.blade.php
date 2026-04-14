<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor - {{ $page->title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&family=Open+Sans:wght@400;600;700&family=Raleway:wght@300;400;500;600&family=Merriweather:wght@300;400;700&family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f3f5;
            min-height: 100vh;
            color: #1e293b;
        }

        /* ---- Top Bar ---- */
        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
            height: 52px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 16px;
            gap: 12px;
        }
        .topbar-back {
            color: #64748b;
            text-decoration: none;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 6px 10px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .topbar-back:hover { background: #f1f5f9; color: #1e293b; }
        .topbar-divider {
            width: 1px;
            height: 24px;
            background: #e2e8f0;
        }
        .topbar-title {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .topbar-btn {
            padding: 7px 16px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .topbar-btn-ghost {
            background: transparent;
            color: #64748b;
        }
        .topbar-btn-ghost:hover { background: #f1f5f9; color: #1e293b; }
        .topbar-btn-outline {
            background: #fff;
            color: #374151;
            border: 1px solid #d1d5db;
        }
        .topbar-btn-outline:hover { background: #f9fafb; border-color: #9ca3af; }
        .topbar-btn-primary {
            background: #6366f1;
            color: #fff;
        }
        .topbar-btn-primary:hover { background: #4f46e5; }
        .topbar-btn-success {
            background: #059669;
            color: #fff;
        }
        .topbar-btn-success:hover { background: #047857; }
        .save-status {
            font-size: 12px;
            color: #94a3b8;
            white-space: nowrap;
        }
        .save-status.saving { color: #f59e0b; }
        .save-status.saved { color: #10b981; }
        .save-status.error { color: #ef4444; }

        /* ---- Left Sidebar (section nav) ---- */
        .sidebar {
            position: fixed;
            top: 52px;
            left: 0;
            bottom: 0;
            width: 60px;
            background: #fff;
            border-right: 1px solid #e2e8f0;
            z-index: 100;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 0;
            gap: 2px;
        }
        .sidebar-item {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 18px;
            color: #64748b;
            background: transparent;
            border: none;
            position: relative;
        }
        .sidebar-item:hover { background: #f1f5f9; color: #1e293b; }
        .sidebar-item.active {
            background: #eef2ff;
            color: #6366f1;
        }
        .sidebar-item .sidebar-tooltip {
            display: none;
            position: absolute;
            left: 56px;
            top: 50%;
            transform: translateY(-50%);
            background: #1e293b;
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
            pointer-events: none;
            z-index: 110;
        }
        .sidebar-item:hover .sidebar-tooltip { display: block; }

        /* ---- Main Content ---- */
        .main-content {
            margin-left: 60px;
            margin-top: 52px;
            min-height: calc(100vh - 52px);
            transition: margin-right 0.3s;
        }
        .main-content.style-panel-open {
            margin-right: 320px;
        }

        /* ---- Page Preview ---- */
        .page-preview {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            min-height: calc(100vh - 52px);
            box-shadow: 0 0 40px rgba(0,0,0,0.06);
        }

        /* ---- Section Wrapper ---- */
        .section-wrapper {
            position: relative;
            transition: all 0.2s;
        }
        .section-wrapper:hover {
            outline: 2px solid #6366f1;
            outline-offset: -2px;
        }
        .section-wrapper.active {
            outline: 2px solid #6366f1;
            outline-offset: -2px;
        }

        /* Section toolbar */
        .section-toolbar {
            display: none;
            position: absolute;
            top: 8px;
            right: 8px;
            z-index: 50;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            padding: 4px;
            gap: 2px;
        }
        .section-wrapper:hover .section-toolbar,
        .section-wrapper.active .section-toolbar {
            display: flex;
        }
        .toolbar-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 6px;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            font-size: 14px;
        }
        .toolbar-btn:hover { background: #f1f5f9; color: #1e293b; }
        .toolbar-btn.danger:hover { background: #fef2f2; color: #ef4444; }
        .toolbar-btn[title]::after {
            content: attr(title);
            display: none;
        }

        /* Add section button between sections */
        .add-section-gap {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px 0;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .add-section-gap:hover { opacity: 1; }
        .section-wrapper:hover + .add-section-gap,
        .add-section-gap:hover {
            opacity: 1;
        }
        .add-section-btn {
            padding: 6px 16px;
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            background: #fff;
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .add-section-btn:hover {
            border-color: #6366f1;
            color: #6366f1;
            background: #eef2ff;
        }

        /* ---- Inline Editing ---- */
        [contenteditable="true"]:focus {
            outline: 2px solid #6366f1;
            outline-offset: 2px;
            border-radius: 4px;
        }

        /* Inline format toolbar */
        .inline-toolbar {
            display: none;
            position: fixed;
            z-index: 300;
            background: #1e293b;
            border-radius: 8px;
            padding: 4px;
            gap: 2px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }
        .inline-toolbar.visible { display: flex; }
        .inline-toolbar button {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 5px;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.15s;
        }
        .inline-toolbar button:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .inline-toolbar button.active { background: rgba(255,255,255,0.15); color: #a78bfa; }

        /* ---- Right Style Panel ---- */
        .style-panel {
            position: fixed;
            top: 52px;
            right: 0;
            bottom: 0;
            width: 320px;
            background: #fff;
            border-left: 1px solid #e2e8f0;
            z-index: 100;
            overflow-y: auto;
            padding: 20px;
            transform: translateX(100%);
            transition: transform 0.3s;
        }
        .style-panel.open { transform: translateX(0); }
        .style-panel-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .style-panel-close {
            width: 28px;
            height: 28px;
            border: none;
            border-radius: 6px;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        .style-panel-close:hover { background: #f1f5f9; }
        .style-panel-section {
            margin-bottom: 24px;
        }
        .style-panel-label {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }
        .color-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
        }
        .color-item {
            text-align: center;
        }
        .color-swatch-input {
            width: 40px;
            height: 40px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            padding: 0;
            background: none;
            -webkit-appearance: none;
            appearance: none;
            overflow: hidden;
        }
        .color-swatch-input::-webkit-color-swatch-wrapper { padding: 0; }
        .color-swatch-input::-webkit-color-swatch { border: none; border-radius: 8px; }
        .color-swatch-input::-moz-color-swatch { border: none; border-radius: 8px; }
        .color-label {
            font-size: 10px;
            color: #94a3b8;
            margin-top: 4px;
        }
        .font-select-group {
            margin-bottom: 12px;
        }
        .font-select-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
        }
        .font-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: #1e293b;
            cursor: pointer;
        }
        .font-select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99,102,241,0.15);
        }

        /* ---- Add Section Modal ---- */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 400;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.visible { display: flex; }
        .modal-content {
            background: #fff;
            border-radius: 16px;
            max-width: 700px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            padding: 24px;
            box-shadow: 0 24px 48px rgba(0,0,0,0.15);
        }
        .modal-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-close {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 8px;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .modal-close:hover { background: #f1f5f9; }
        .modal-sections-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 10px;
        }
        .modal-section-card {
            padding: 14px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .modal-section-card:hover {
            border-color: #6366f1;
            background: #eef2ff;
        }
        .modal-section-icon {
            font-size: 22px;
            margin-bottom: 6px;
        }
        .modal-section-name {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
        }
        .modal-section-desc {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
        }
        .modal-category-title {
            font-size: 12px;
            font-weight: 600;
            color: #6366f1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 16px 0 8px 0;
        }
        .modal-category-title:first-child { margin-top: 0; }
    </style>
</head>
<body>
    {{-- Top Bar --}}
    <div class="topbar">
        <a href="{{ route('filament.admin.resources.pages.index') }}" class="topbar-back">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
            Panel
        </a>
        <div class="topbar-divider"></div>
        <div class="topbar-title">{{ $page->title }}</div>
        <div class="topbar-actions">
            <span class="save-status" id="saveStatus">Sin cambios</span>
            <button class="topbar-btn topbar-btn-ghost" onclick="toggleStylePanel()" title="Estilos">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r="2.5"/><path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16"/></svg>
                Estilos
            </button>
            <button class="topbar-btn topbar-btn-outline" onclick="savePage()" id="btnSave">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17,21 17,13 7,13 7,21"/><polyline points="7,3 7,8 15,8"/></svg>
                Guardar
            </button>
            <a href="{{ route('page.preview', $page) }}" target="_blank" class="topbar-btn topbar-btn-ghost">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Vista previa
            </a>
            <a href="{{ route('builder.editor', $page) }}" class="topbar-btn topbar-btn-ghost" title="Editor avanzado GrapesJS">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                Avanzado
            </a>
        </div>
    </div>

    {{-- Left Sidebar --}}
    <div class="sidebar" id="sidebar">
        {{-- Populated by JS --}}
    </div>

    {{-- Main Content --}}
    <div class="main-content" id="mainContent">
        <div class="page-preview" id="pagePreview">
            {{-- Section CSS --}}
            <style id="sectionStyles">{!! $combinedCss !!}</style>

            {{-- Rendered sections --}}
            @foreach ($renderedSections as $index => $section)
                <div class="section-wrapper" data-section-id="{{ $section['id'] }}" data-index="{{ $index }}">
                    <div class="section-toolbar">
                        <button class="toolbar-btn" onclick="moveSection({{ $index }}, -1)" title="Subir">&#9650;</button>
                        <button class="toolbar-btn" onclick="moveSection({{ $index }}, 1)" title="Bajar">&#9660;</button>
                        <button class="toolbar-btn" onclick="regenerateSection({{ $index }})" title="Regenerar con IA">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </button>
                        <button class="toolbar-btn danger" onclick="deleteSection({{ $index }})" title="Eliminar">&times;</button>
                    </div>
                    {!! $section['html'] !!}
                </div>

                @if ($index < count($renderedSections) - 1)
                    <div class="add-section-gap">
                        <button class="add-section-btn" onclick="openAddModal({{ $index + 1 }})">
                            + Agregar seccion
                        </button>
                    </div>
                @endif
            @endforeach

            {{-- Final add button --}}
            <div class="add-section-gap" style="opacity:1; padding:24px 0;">
                <button class="add-section-btn" onclick="openAddModal(-1)">
                    + Agregar seccion al final
                </button>
            </div>
        </div>
    </div>

    {{-- Inline Format Toolbar --}}
    <div class="inline-toolbar" id="inlineToolbar">
        <button onclick="formatText('bold')" title="Negrita"><strong>B</strong></button>
        <button onclick="formatText('italic')" title="Cursiva"><em>I</em></button>
        <button onclick="formatLink()" title="Enlace">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
        </button>
    </div>

    {{-- Style Panel --}}
    <div class="style-panel" id="stylePanel">
        <div class="style-panel-title">
            Estilos del sitio
            <button class="style-panel-close" onclick="toggleStylePanel()">&times;</button>
        </div>

        <div class="style-panel-section">
            <div class="style-panel-label">Colores</div>
            <div class="color-grid">
                <div class="color-item">
                    <input type="color" class="color-swatch-input" id="colorPrimary" value="{{ $colors['primary'] ?? '#6366F1' }}" onchange="updateColor('primary', this.value)">
                    <div class="color-label">Primario</div>
                </div>
                <div class="color-item">
                    <input type="color" class="color-swatch-input" id="colorSecondary" value="{{ $colors['secondary'] ?? '#0EA5E9' }}" onchange="updateColor('secondary', this.value)">
                    <div class="color-label">Secundario</div>
                </div>
                <div class="color-item">
                    <input type="color" class="color-swatch-input" id="colorAccent" value="{{ $colors['accent'] ?? '#F59E0B' }}" onchange="updateColor('accent', this.value)">
                    <div class="color-label">Acento</div>
                </div>
                <div class="color-item">
                    <input type="color" class="color-swatch-input" id="colorBackground" value="{{ $colors['background'] ?? '#FFFFFF' }}" onchange="updateColor('background', this.value)">
                    <div class="color-label">Fondo</div>
                </div>
                <div class="color-item">
                    <input type="color" class="color-swatch-input" id="colorText" value="{{ $colors['text'] ?? '#1E293B' }}" onchange="updateColor('text', this.value)">
                    <div class="color-label">Texto</div>
                </div>
            </div>
        </div>

        <div class="style-panel-section">
            <div class="style-panel-label">Tipografias</div>
            <div class="font-select-group">
                <div class="font-select-label">Titulos</div>
                <select class="font-select" id="fontHeading" onchange="updateFont('heading', this.value)">
                    @foreach (config('webcomposer.fonts', []) as $font)
                        <option value="{{ $font }}" {{ ($fonts['heading'] ?? '') === $font ? 'selected' : '' }}>{{ $font }}</option>
                    @endforeach
                </select>
            </div>
            <div class="font-select-group">
                <div class="font-select-label">Cuerpo</div>
                <select class="font-select" id="fontBody" onchange="updateFont('body', this.value)">
                    @foreach (config('webcomposer.fonts', []) as $font)
                        <option value="{{ $font }}" {{ ($fonts['body'] ?? '') === $font ? 'selected' : '' }}>{{ $font }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Add Section Modal --}}
    <div class="modal-overlay" id="addSectionModal">
        <div class="modal-content">
            <div class="modal-title">
                Agregar seccion
                <button class="modal-close" onclick="closeAddModal()">&times;</button>
            </div>
            <div id="modalSectionsList">
                {{-- Populated by JS --}}
            </div>
        </div>
    </div>

    <script>
        // ============================================================
        // State
        // ============================================================
        var pageId = @json($page->id);
        var storeUrl = '/api/pages/' + pageId + '/store';
        var heartbeatUrl = @json(route('api.heartbeat'));
        var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        var sectionIds = @json($sectionIds);
        var sectionContent = @json($sectionContent);
        var colors = @json($colors);
        var fonts = @json($fonts);
        var businessName = @json($businessName);
        var businessDescription = @json($businessDescription);
        var library = @json($library);
        var isDirty = false;
        var addInsertIndex = -1; // Where to insert new section

        // ============================================================
        // Sidebar
        // ============================================================
        function buildSidebar() {
            var sidebar = document.getElementById('sidebar');
            sidebar.innerHTML = '';

            var wrappers = document.querySelectorAll('.section-wrapper');
            for (var i = 0; i < wrappers.length; i++) {
                var secId = wrappers[i].getAttribute('data-section-id');
                var meta = getSectionMeta(secId);
                var btn = document.createElement('button');
                btn.className = 'sidebar-item';
                btn.setAttribute('data-index', i);
                btn.innerHTML = '<span>' + (meta ? meta.icon || (i + 1) : (i + 1)) + '</span>' +
                    '<span class="sidebar-tooltip">' + (meta ? meta.name : secId) + '</span>';
                btn.onclick = (function(idx) {
                    return function() { scrollToSection(idx); };
                })(i);
                sidebar.appendChild(btn);
            }
        }

        function getSectionMeta(sectionId) {
            for (var catKey in library) {
                var sections = library[catKey].sections || [];
                for (var i = 0; i < sections.length; i++) {
                    if (sections[i].id === sectionId) return sections[i];
                }
            }
            return null;
        }

        function scrollToSection(index) {
            var wrappers = document.querySelectorAll('.section-wrapper');
            if (wrappers[index]) {
                wrappers[index].scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Highlight sidebar
                document.querySelectorAll('.sidebar-item').forEach(function(el) {
                    el.classList.remove('active');
                });
                var sidebarItems = document.querySelectorAll('.sidebar-item');
                if (sidebarItems[index]) sidebarItems[index].classList.add('active');
            }
        }

        // ============================================================
        // Inline Text Editing
        // ============================================================
        function enableInlineEditing() {
            var editableSelectors = 'h1, h2, h3, h4, h5, h6, p, span, a, li, td, th, blockquote, figcaption, label, strong, em';
            var preview = document.getElementById('pagePreview');
            var elements = preview.querySelectorAll('.section-wrapper ' + editableSelectors);

            elements.forEach(function(el) {
                // Skip elements that contain other block elements
                if (el.querySelector('h1, h2, h3, h4, h5, h6, p, div, ul, ol, table')) return;
                // Skip if already set
                if (el.getAttribute('contenteditable') === 'true') return;

                el.setAttribute('contenteditable', 'true');
                el.style.cursor = 'text';

                el.addEventListener('focus', function() {
                    showInlineToolbar(el);
                });

                el.addEventListener('blur', function() {
                    setTimeout(function() {
                        hideInlineToolbar();
                    }, 200);
                    markDirty();
                });

                el.addEventListener('input', function() {
                    markDirty();
                });
            });
        }

        function showInlineToolbar(el) {
            var toolbar = document.getElementById('inlineToolbar');
            var rect = el.getBoundingClientRect();
            toolbar.style.left = rect.left + 'px';
            toolbar.style.top = (rect.top - 44) + 'px';
            toolbar.classList.add('visible');
        }

        function hideInlineToolbar() {
            document.getElementById('inlineToolbar').classList.remove('visible');
        }

        function formatText(command) {
            document.execCommand(command, false, null);
        }

        function formatLink() {
            var url = prompt('URL del enlace:', 'https://');
            if (url) {
                document.execCommand('createLink', false, url);
            }
        }

        // ============================================================
        // Section Actions
        // ============================================================
        function moveSection(index, direction) {
            var newIndex = index + direction;
            if (newIndex < 0 || newIndex >= sectionIds.length) return;

            // Swap in data
            var tempId = sectionIds[index];
            sectionIds[index] = sectionIds[newIndex];
            sectionIds[newIndex] = tempId;

            // Swap DOM
            var preview = document.getElementById('pagePreview');
            var wrappers = preview.querySelectorAll('.section-wrapper');
            if (direction === -1 && wrappers[index] && wrappers[newIndex]) {
                preview.insertBefore(wrappers[index], wrappers[newIndex]);
            } else if (direction === 1 && wrappers[index] && wrappers[newIndex]) {
                preview.insertBefore(wrappers[newIndex], wrappers[index]);
            }

            // Rebuild since DOM order changed
            rebuildPage();
            markDirty();
        }

        function deleteSection(index) {
            if (!confirm('Eliminar esta seccion?')) return;

            sectionIds.splice(index, 1);
            rebuildPage();
            markDirty();
        }

        function regenerateSection(index) {
            var sectionId = sectionIds[index];
            var statusEl = document.getElementById('saveStatus');
            statusEl.textContent = 'Regenerando...';
            statusEl.className = 'save-status saving';

            // Call wizard generate endpoint for just this section
            fetch(@json(route('builder.wizard.generate', $page)), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    business_name: businessName,
                    business_description: businessDescription,
                    sections: sectionIds,
                    colors: colors,
                    fonts: fonts
                })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.success) {
                    window.location.reload();
                } else {
                    statusEl.textContent = 'Error al regenerar';
                    statusEl.className = 'save-status error';
                }
            })
            .catch(function() {
                statusEl.textContent = 'Error al regenerar';
                statusEl.className = 'save-status error';
            });
        }

        function rebuildPage() {
            // Reload page to re-render with new section order
            // For a smooth experience we simply reload
            savePage(function() {
                window.location.reload();
            });
        }

        // ============================================================
        // Add Section
        // ============================================================
        function openAddModal(insertAfterIndex) {
            addInsertIndex = insertAfterIndex;
            var modal = document.getElementById('addSectionModal');
            var list = document.getElementById('modalSectionsList');
            list.innerHTML = '';

            for (var catKey in library) {
                var cat = library[catKey];
                var sections = cat.sections || [];
                if (sections.length === 0) continue;

                var title = document.createElement('div');
                title.className = 'modal-category-title';
                title.textContent = cat.name || catKey;
                list.appendChild(title);

                var grid = document.createElement('div');
                grid.className = 'modal-sections-grid';

                for (var i = 0; i < sections.length; i++) {
                    var sec = sections[i];
                    var card = document.createElement('div');
                    card.className = 'modal-section-card';
                    card.innerHTML =
                        '<div class="modal-section-icon">' + (sec.icon || '') + '</div>' +
                        '<div class="modal-section-name">' + (sec.name || sec.id) + '</div>' +
                        '<div class="modal-section-desc">' + (sec.description || '') + '</div>';
                    card.onclick = (function(s) {
                        return function() { addSection(s.id); };
                    })(sec);
                    grid.appendChild(card);
                }

                list.appendChild(grid);
            }

            modal.classList.add('visible');
        }

        function closeAddModal() {
            document.getElementById('addSectionModal').classList.remove('visible');
        }

        function addSection(sectionId) {
            closeAddModal();

            if (addInsertIndex === -1) {
                sectionIds.push(sectionId);
            } else {
                sectionIds.splice(addInsertIndex, 0, sectionId);
            }

            // Regenerate the whole page with new sections
            var statusEl = document.getElementById('saveStatus');
            statusEl.textContent = 'Agregando seccion...';
            statusEl.className = 'save-status saving';

            fetch(@json(route('builder.wizard.generate', $page)), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    business_name: businessName,
                    business_description: businessDescription,
                    sections: sectionIds,
                    colors: colors,
                    fonts: fonts
                })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.success) {
                    window.location.reload();
                } else {
                    statusEl.textContent = 'Error al agregar seccion';
                    statusEl.className = 'save-status error';
                }
            })
            .catch(function() {
                statusEl.textContent = 'Error';
                statusEl.className = 'save-status error';
            });
        }

        // ============================================================
        // Style Panel
        // ============================================================
        var stylePanelOpen = false;

        function toggleStylePanel() {
            stylePanelOpen = !stylePanelOpen;
            var panel = document.getElementById('stylePanel');
            var main = document.getElementById('mainContent');

            if (stylePanelOpen) {
                panel.classList.add('open');
                main.classList.add('style-panel-open');
            } else {
                panel.classList.remove('open');
                main.classList.remove('style-panel-open');
            }
        }

        function updateColor(key, value) {
            colors[key] = value;

            // Apply CSS variable to preview
            var preview = document.getElementById('pagePreview');
            var varName = '--color-' + key;
            preview.style.setProperty(varName, value);

            markDirty();
        }

        function updateFont(type, value) {
            fonts[type] = value;

            // Apply CSS variable
            var preview = document.getElementById('pagePreview');
            if (type === 'heading') {
                preview.style.setProperty('--font-heading', "'" + value + "', sans-serif");
            } else {
                preview.style.setProperty('--font-body', "'" + value + "', sans-serif");
            }

            markDirty();
        }

        // ============================================================
        // Save
        // ============================================================
        function markDirty() {
            isDirty = true;
            var statusEl = document.getElementById('saveStatus');
            statusEl.textContent = 'Cambios sin guardar';
            statusEl.className = 'save-status';
        }

        function collectPageHtml() {
            var wrappers = document.querySelectorAll('.section-wrapper');
            var htmlParts = [];
            for (var i = 0; i < wrappers.length; i++) {
                // Clone and remove toolbar
                var clone = wrappers[i].cloneNode(true);
                var toolbar = clone.querySelector('.section-toolbar');
                if (toolbar) toolbar.remove();

                // Remove contenteditable attributes
                var editables = clone.querySelectorAll('[contenteditable]');
                for (var j = 0; j < editables.length; j++) {
                    editables[j].removeAttribute('contenteditable');
                    editables[j].style.cursor = '';
                }

                htmlParts.push(clone.innerHTML);
            }
            return htmlParts.join('\n');
        }

        function savePage(callback) {
            var statusEl = document.getElementById('saveStatus');
            statusEl.textContent = 'Guardando...';
            statusEl.className = 'save-status saving';

            var html = collectPageHtml();
            var css = document.getElementById('sectionStyles').textContent;

            // Also backup to localStorage
            try {
                localStorage.setItem('wc_backup_' + pageId, JSON.stringify({
                    html: html,
                    css: css,
                    sections: sectionIds,
                    colors: colors,
                    fonts: fonts,
                    timestamp: Date.now()
                }));
            } catch(e) {}

            fetch(storeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    html: html,
                    css: css,
                    components: [],
                    styles: [],
                    sections: sectionIds,
                    section_content: sectionContent,
                    colors: colors,
                    fonts: fonts,
                    business_name: businessName,
                    business_description: businessDescription
                })
            })
            .then(function(r) {
                if (r.ok) {
                    isDirty = false;
                    statusEl.textContent = 'Guardado';
                    statusEl.className = 'save-status saved';
                    if (callback) callback();
                } else {
                    statusEl.textContent = 'Error al guardar';
                    statusEl.className = 'save-status error';
                }
            })
            .catch(function() {
                statusEl.textContent = 'Error de conexion';
                statusEl.className = 'save-status error';
            });
        }

        // ============================================================
        // Auto-save every 30 seconds
        // ============================================================
        setInterval(function() {
            if (isDirty) {
                savePage();
            }
        }, 30000);

        // ============================================================
        // Session Protection
        // ============================================================
        // Heartbeat every 60 seconds
        setInterval(function() {
            fetch(heartbeatUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            }).catch(function() {});
        }, 60000);

        // Warn before leaving with unsaved changes
        window.addEventListener('beforeunload', function(e) {
            if (isDirty) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Keyboard shortcut: Ctrl+S to save
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                savePage();
            }
        });

        // ============================================================
        // Init
        // ============================================================
        buildSidebar();
        enableInlineEditing();

        // Set CSS variables on page preview
        var preview = document.getElementById('pagePreview');
        preview.style.setProperty('--color-primary', colors.primary || '#6366F1');
        preview.style.setProperty('--color-secondary', colors.secondary || '#0EA5E9');
        preview.style.setProperty('--color-accent', colors.accent || '#F59E0B');
        preview.style.setProperty('--color-background', colors.background || '#FFFFFF');
        preview.style.setProperty('--color-text', colors.text || '#1E293B');
        preview.style.setProperty('--font-heading', "'" + (fonts.heading || 'Space Grotesk') + "', sans-serif");
        preview.style.setProperty('--font-body', "'" + (fonts.body || 'Inter') + "', sans-serif");
    </script>
</body>
</html>
