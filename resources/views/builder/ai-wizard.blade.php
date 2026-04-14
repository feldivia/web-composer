<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wizard IA - {{ $page->title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&family=Open+Sans:wght@400;600;700&family=Raleway:wght@300;400;500;600&family=Merriweather:wght@300;400;700&family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            color: #e2e8f0;
            overflow-x: hidden;
        }

        /* ---- Progress Bar ---- */
        .wizard-progress {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(15, 12, 41, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 16px 24px;
        }
        .progress-inner {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .progress-step {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.3);
            transition: color 0.4s;
        }
        .progress-step.active { color: #a78bfa; }
        .progress-step.done { color: #34d399; }
        .progress-step .step-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            background: rgba(255,255,255,0.06);
            border: 2px solid rgba(255,255,255,0.1);
            transition: all 0.4s;
        }
        .progress-step.active .step-num {
            background: linear-gradient(135deg, #7c3aed, #6366f1);
            border-color: #a78bfa;
            box-shadow: 0 0 16px rgba(124,58,237,0.4);
        }
        .progress-step.done .step-num {
            background: #059669;
            border-color: #34d399;
        }
        .progress-line {
            flex: 1;
            height: 2px;
            background: rgba(255,255,255,0.08);
            border-radius: 2px;
            position: relative;
            overflow: hidden;
        }
        .progress-line .fill {
            position: absolute;
            left: 0; top: 0;
            height: 100%;
            background: linear-gradient(90deg, #7c3aed, #6366f1);
            border-radius: 2px;
            width: 0;
            transition: width 0.5s ease;
        }
        .progress-line.done .fill { width: 100%; }

        /* ---- Back Link ---- */
        .back-link {
            position: fixed;
            top: 16px;
            left: 24px;
            z-index: 101;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .back-link:hover { color: #fff; background: rgba(255,255,255,0.08); }

        /* ---- Main Container ---- */
        .wizard-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 100px 24px 120px;
            position: relative;
        }

        /* ---- Steps ---- */
        .wizard-step {
            display: none;
            animation: fadeSlideIn 0.4s ease-out;
        }
        .wizard-step.active { display: block; }

        @keyframes fadeSlideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .step-title {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #e2e8f0, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            line-height: 1.2;
        }
        .step-subtitle {
            font-size: 16px;
            color: rgba(255,255,255,0.5);
            margin-bottom: 40px;
        }

        /* ---- Form Controls ---- */
        .form-group { margin-bottom: 24px; }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255,255,255,0.8);
            margin-bottom: 8px;
        }
        .form-input, .form-textarea {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            color: #e2e8f0;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s;
            outline: none;
        }
        .form-input:focus, .form-textarea:focus {
            border-color: #7c3aed;
            background: rgba(255,255,255,0.1);
            box-shadow: 0 0 0 3px rgba(124,58,237,0.2);
        }
        .form-input::placeholder, .form-textarea::placeholder {
            color: rgba(255,255,255,0.25);
        }
        .form-textarea {
            resize: vertical;
            min-height: 120px;
            line-height: 1.6;
        }
        .form-error {
            color: #f87171;
            font-size: 13px;
            margin-top: 6px;
            display: none;
        }
        .form-error.visible { display: block; }

        /* ---- Section Picker (Step 2) ---- */
        .section-picker-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            align-items: start;
        }

        /* Catalog side */
        .section-catalog { }
        .catalog-category {
            margin-bottom: 28px;
        }
        .catalog-category-header {
            font-size: 14px;
            font-weight: 600;
            color: #a78bfa;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            user-select: none;
        }
        .catalog-category-header .chevron {
            transition: transform 0.3s;
            font-size: 11px;
        }
        .catalog-category-header.collapsed .chevron {
            transform: rotate(-90deg);
        }
        .catalog-category-items {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
        }
        .catalog-category-items.collapsed {
            display: none;
        }
        .catalog-card {
            background: rgba(255,255,255,0.04);
            border: 2px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 14px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            user-select: none;
        }
        .catalog-card:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }
        .catalog-card.selected {
            border-color: #7c3aed;
            background: rgba(124,58,237,0.12);
            box-shadow: 0 0 0 1px rgba(124,58,237,0.5), 0 0 20px rgba(124,58,237,0.15);
        }
        .catalog-card .card-icon {
            font-size: 24px;
            margin-bottom: 6px;
            display: block;
        }
        .catalog-card .card-name {
            font-size: 13px;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 3px;
        }
        .catalog-card .card-desc {
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            line-height: 1.4;
        }
        .catalog-card .check-mark {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            border: 2px solid rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .catalog-card.selected .check-mark {
            background: linear-gradient(135deg, #7c3aed, #6366f1);
            border-color: #a78bfa;
        }
        .catalog-card.selected .check-mark::after {
            content: '';
            display: block;
            width: 5px;
            height: 9px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg) translate(-1px, -1px);
        }

        /* Selected sidebar */
        .selected-sidebar {
            position: sticky;
            top: 80px;
        }
        .selected-panel {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 20px;
        }
        .selected-panel-title {
            font-size: 15px;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 4px;
        }
        .selected-count {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            margin-bottom: 16px;
        }
        .selected-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-height: 60px;
        }
        .selected-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            cursor: grab;
            transition: all 0.2s;
            user-select: none;
        }
        .selected-item:active { cursor: grabbing; }
        .selected-item:hover { background: rgba(255,255,255,0.1); }
        .selected-item.drag-over {
            border-color: #7c3aed;
            background: rgba(124,58,237,0.15);
        }
        .selected-item .drag-handle {
            color: rgba(255,255,255,0.3);
            font-size: 14px;
            flex-shrink: 0;
            line-height: 1;
        }
        .selected-item .item-icon {
            font-size: 16px;
            flex-shrink: 0;
        }
        .selected-item .item-name {
            font-size: 13px;
            font-weight: 500;
            color: #e2e8f0;
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .selected-item .item-remove {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: none;
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.4);
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
            line-height: 1;
        }
        .selected-item .item-remove:hover {
            background: rgba(239,68,68,0.2);
            color: #f87171;
        }
        .selected-empty {
            padding: 24px;
            text-align: center;
            color: rgba(255,255,255,0.25);
            font-size: 13px;
        }

        /* ---- Style Selection (Step 3) ---- */
        .style-section { margin-bottom: 40px; }
        .style-section-title {
            font-size: 18px;
            font-weight: 600;
            color: rgba(255,255,255,0.9);
            margin-bottom: 16px;
        }

        .palettes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 14px;
        }
        .palette-card {
            background: rgba(255,255,255,0.04);
            border: 2px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 18px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .palette-card:hover {
            background: rgba(255,255,255,0.08);
            transform: translateY(-2px);
        }
        .palette-card.selected {
            border-color: #7c3aed;
            background: rgba(124,58,237,0.12);
            box-shadow: 0 0 0 1px rgba(124,58,237,0.5), 0 0 20px rgba(124,58,237,0.15);
        }
        .palette-name {
            font-size: 14px;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 12px;
        }
        .palette-swatches {
            display: flex;
            gap: 6px;
        }
        .palette-swatches .swatch {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 2px solid rgba(255,255,255,0.1);
        }

        .fonts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 14px;
        }
        .font-card {
            background: rgba(255,255,255,0.04);
            border: 2px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .font-card:hover {
            background: rgba(255,255,255,0.08);
            transform: translateY(-2px);
        }
        .font-card.selected {
            border-color: #7c3aed;
            background: rgba(124,58,237,0.12);
            box-shadow: 0 0 0 1px rgba(124,58,237,0.5), 0 0 20px rgba(124,58,237,0.15);
        }
        .font-card .font-pair-name {
            font-size: 13px;
            font-weight: 600;
            color: #a78bfa;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .font-card .font-preview-heading {
            font-size: 22px;
            font-weight: 700;
            color: #e2e8f0;
            margin-bottom: 6px;
            line-height: 1.2;
        }
        .font-card .font-preview-body {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
            line-height: 1.6;
        }

        /* ---- Generation Step 4 ---- */
        .generation-screen {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 60vh;
            text-align: center;
        }
        .generation-spinner {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            border: 3px solid rgba(124,58,237,0.2);
            border-top-color: #7c3aed;
            animation: spin 1s linear infinite;
            margin-bottom: 32px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .generation-title {
            font-size: 24px;
            font-weight: 700;
            color: #e2e8f0;
            margin-bottom: 32px;
        }
        .generation-steps {
            display: flex;
            flex-direction: column;
            gap: 16px;
            width: 100%;
            max-width: 400px;
        }
        .gen-step {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            color: rgba(255,255,255,0.3);
            transition: all 0.4s;
        }
        .gen-step.active { color: #a78bfa; }
        .gen-step.done { color: #34d399; }
        .gen-step .gen-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.06);
            flex-shrink: 0;
            font-size: 12px;
            transition: all 0.4s;
        }
        .gen-step.active .gen-icon { background: rgba(124,58,237,0.3); }
        .gen-step.done .gen-icon { background: rgba(5,150,105,0.3); }
        .generation-error {
            color: #f87171;
            background: rgba(248,113,113,0.1);
            border: 1px solid rgba(248,113,113,0.2);
            border-radius: 12px;
            padding: 16px 24px;
            margin-top: 24px;
            font-size: 14px;
            display: none;
            max-width: 400px;
            width: 100%;
        }
        .generation-error.visible { display: block; }
        .generation-retry {
            margin-top: 16px;
            display: none;
        }
        .generation-retry.visible { display: block; }

        /* ---- Navigation ---- */
        .wizard-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(15, 12, 41, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 16px 24px;
        }
        .nav-inner {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn {
            padding: 12px 28px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-secondary {
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.12);
            color: #fff;
        }
        .btn-primary {
            background: linear-gradient(135deg, #7c3aed, #6366f1);
            color: #fff;
            box-shadow: 0 4px 16px rgba(124,58,237,0.4);
        }
        .btn-primary:hover {
            box-shadow: 0 6px 24px rgba(124,58,237,0.5);
            transform: translateY(-1px);
        }
        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .btn-skip {
            background: transparent;
            color: rgba(255,255,255,0.4);
            border: none;
            font-size: 13px;
        }
        .btn-skip:hover { color: rgba(255,255,255,0.7); }

        /* ---- Responsive ---- */
        @media (max-width: 768px) {
            .section-picker-layout {
                grid-template-columns: 1fr;
            }
            .selected-sidebar {
                position: static;
                order: -1;
            }
            .step-title { font-size: 24px; }
            .palettes-grid, .fonts-grid { grid-template-columns: 1fr 1fr; }
            .back-link { display: none; }
        }
        @media (max-width: 480px) {
            .catalog-category-items { grid-template-columns: 1fr; }
            .palettes-grid, .fonts-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    {{-- Back Link --}}
    <a href="{{ route('filament.admin.resources.pages.index') }}" class="back-link">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
        Volver al panel
    </a>

    {{-- Progress Bar --}}
    <div class="wizard-progress">
        <div class="progress-inner">
            <div class="progress-step active" data-step="1">
                <span class="step-num">1</span>
                <span class="step-label">Negocio</span>
            </div>
            <div class="progress-line" data-after="1"><div class="fill"></div></div>
            <div class="progress-step" data-step="2">
                <span class="step-num">2</span>
                <span class="step-label">Secciones</span>
            </div>
            <div class="progress-line" data-after="2"><div class="fill"></div></div>
            <div class="progress-step" data-step="3">
                <span class="step-num">3</span>
                <span class="step-label">Estilo</span>
            </div>
            <div class="progress-line" data-after="3"><div class="fill"></div></div>
            <div class="progress-step" data-step="4">
                <span class="step-num">4</span>
                <span class="step-label">Generar</span>
            </div>
        </div>
    </div>

    {{-- Wizard Container --}}
    <div class="wizard-container">

        {{-- Step 1: Business Info --}}
        <div class="wizard-step active" data-step="1">
            <h1 class="step-title">Cuentanos sobre tu negocio</h1>
            <p class="step-subtitle">Esta informacion sera usada por la IA para generar contenido personalizado para tu pagina.</p>

            <div class="form-group">
                <label class="form-label" for="business_name">Nombre o tipo de tu negocio</label>
                <input
                    type="text"
                    id="business_name"
                    class="form-input"
                    placeholder="Clinica Dental Sonrisa, Restaurante La Dolce Vita..."
                    maxlength="255"
                    autocomplete="off"
                >
                <div class="form-error" id="error_business_name">Por favor, ingresa el nombre o tipo de tu negocio.</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="business_description">Describe tu negocio en detalle</label>
                <textarea
                    id="business_description"
                    class="form-textarea"
                    placeholder="Ofrecemos pasta artesanal, pizzas al horno de lena, ambiente familiar con terraza al aire libre. Llevamos 15 anos en el barrio y nos especializamos en recetas tradicionales..."
                    maxlength="5000"
                    rows="5"
                ></textarea>
                <div class="form-error" id="error_business_description">Por favor, describe tu negocio con al menos unas palabras.</div>
            </div>
        </div>

        {{-- Step 2: Section Picker --}}
        <div class="wizard-step" data-step="2">
            <h1 class="step-title">Elige tus secciones</h1>
            <p class="step-subtitle">Selecciona las secciones para tu pagina y arrastra para ordenarlas.</p>

            <div class="section-picker-layout">
                {{-- Catalog --}}
                <div class="section-catalog" id="sectionCatalog">
                    {{-- Se rellena con JavaScript desde sectionLibrary --}}
                </div>

                {{-- Selected sidebar --}}
                <div class="selected-sidebar">
                    <div class="selected-panel">
                        <div class="selected-panel-title">Tu pagina</div>
                        <div class="selected-count" id="selectedCount">0 secciones seleccionadas</div>
                        <div class="selected-list" id="selectedList">
                            <div class="selected-empty" id="selectedEmpty">Haz clic en las secciones del catalogo para agregarlas</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-error" id="error_sections" style="margin-top:12px;">Selecciona al menos 2 secciones.</div>
        </div>

        {{-- Step 3: Style --}}
        <div class="wizard-step" data-step="3">
            <h1 class="step-title">Elige tu estilo</h1>
            <p class="step-subtitle">Selecciona la paleta de colores y tipografias para tu pagina.</p>

            <div class="style-section">
                <h3 class="style-section-title">Paleta de colores</h3>
                <div class="palettes-grid">
                    <div class="palette-card selected" data-palette="ai" data-colors='{}' onclick="selectPalette(this)" style="border-style: dashed;">
                        <div class="palette-name" style="display:flex; align-items:center; gap:8px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            IA elige por mi
                        </div>
                        <div class="palette-swatches">
                            <div class="swatch" style="background:linear-gradient(135deg,#7c3aed,#06b6d4); border:none;"></div>
                            <div class="swatch" style="background:linear-gradient(135deg,#ec4899,#f59e0b); border:none;"></div>
                            <div class="swatch" style="background:linear-gradient(135deg,#10b981,#3b82f6); border:none;"></div>
                        </div>
                        <div style="font-size:11px; color:#94a3b8; margin-top:8px;">La IA generara colores ideales para tu negocio</div>
                    </div>
                    <div class="palette-card" data-palette="profesional" data-colors='{"primary":"#6366F1","secondary":"#0EA5E9","accent":"#F59E0B","background":"#FFFFFF","text":"#1E293B"}' onclick="selectPalette(this)">
                        <div class="palette-name">Profesional</div>
                        <div class="palette-swatches">
                            <div class="swatch" style="background:#6366F1;"></div>
                            <div class="swatch" style="background:#0EA5E9;"></div>
                            <div class="swatch" style="background:#F59E0B;"></div>
                            <div class="swatch" style="background:#FFFFFF; border-color:rgba(0,0,0,0.15);"></div>
                            <div class="swatch" style="background:#1E293B;"></div>
                        </div>
                    </div>
                    <div class="palette-card" data-palette="calido" data-colors='{"primary":"#D97706","secondary":"#EA580C","accent":"#DC2626","background":"#FFFBEB","text":"#1C1917"}' onclick="selectPalette(this)">
                        <div class="palette-name">Calido</div>
                        <div class="palette-swatches">
                            <div class="swatch" style="background:#D97706;"></div>
                            <div class="swatch" style="background:#EA580C;"></div>
                            <div class="swatch" style="background:#DC2626;"></div>
                            <div class="swatch" style="background:#FFFBEB; border-color:rgba(0,0,0,0.15);"></div>
                            <div class="swatch" style="background:#1C1917;"></div>
                        </div>
                    </div>
                    <div class="palette-card" data-palette="elegante" data-colors='{"primary":"#1E293B","secondary":"#B8860B","accent":"#D4AF37","background":"#F8FAFC","text":"#0F172A"}' onclick="selectPalette(this)">
                        <div class="palette-name">Elegante</div>
                        <div class="palette-swatches">
                            <div class="swatch" style="background:#1E293B;"></div>
                            <div class="swatch" style="background:#B8860B;"></div>
                            <div class="swatch" style="background:#D4AF37;"></div>
                            <div class="swatch" style="background:#F8FAFC; border-color:rgba(0,0,0,0.15);"></div>
                            <div class="swatch" style="background:#0F172A;"></div>
                        </div>
                    </div>
                    <div class="palette-card" data-palette="natural" data-colors='{"primary":"#059669","secondary":"#065F46","accent":"#92400E","background":"#F0FDF4","text":"#1A2E05"}' onclick="selectPalette(this)">
                        <div class="palette-name">Natural</div>
                        <div class="palette-swatches">
                            <div class="swatch" style="background:#059669;"></div>
                            <div class="swatch" style="background:#065F46;"></div>
                            <div class="swatch" style="background:#92400E;"></div>
                            <div class="swatch" style="background:#F0FDF4; border-color:rgba(0,0,0,0.15);"></div>
                            <div class="swatch" style="background:#1A2E05;"></div>
                        </div>
                    </div>
                    <div class="palette-card" data-palette="moderno" data-colors='{"primary":"#7C3AED","secondary":"#EC4899","accent":"#06B6D4","background":"#FAF5FF","text":"#1E1B4B"}' onclick="selectPalette(this)">
                        <div class="palette-name">Moderno</div>
                        <div class="palette-swatches">
                            <div class="swatch" style="background:#7C3AED;"></div>
                            <div class="swatch" style="background:#EC4899;"></div>
                            <div class="swatch" style="background:#06B6D4;"></div>
                            <div class="swatch" style="background:#FAF5FF; border-color:rgba(0,0,0,0.15);"></div>
                            <div class="swatch" style="background:#1E1B4B;"></div>
                        </div>
                    </div>
                    <div class="palette-card" data-palette="oceano" data-colors='{"primary":"#0369A1","secondary":"#0891B2","accent":"#F97316","background":"#F0F9FF","text":"#0C4A6E"}' onclick="selectPalette(this)">
                        <div class="palette-name">Oceano</div>
                        <div class="palette-swatches">
                            <div class="swatch" style="background:#0369A1;"></div>
                            <div class="swatch" style="background:#0891B2;"></div>
                            <div class="swatch" style="background:#F97316;"></div>
                            <div class="swatch" style="background:#F0F9FF; border-color:rgba(0,0,0,0.15);"></div>
                            <div class="swatch" style="background:#0C4A6E;"></div>
                        </div>
                    </div>
                    <div class="palette-card" data-palette="nocturno" data-colors='{"primary":"#818CF8","secondary":"#C084FC","accent":"#FB923C","background":"#0F172A","text":"#E2E8F0"}' onclick="selectPalette(this)">
                        <div class="palette-name">Nocturno</div>
                        <div class="palette-swatches">
                            <div class="swatch" style="background:#818CF8;"></div>
                            <div class="swatch" style="background:#C084FC;"></div>
                            <div class="swatch" style="background:#FB923C;"></div>
                            <div class="swatch" style="background:#0F172A;"></div>
                            <div class="swatch" style="background:#E2E8F0; border-color:rgba(0,0,0,0.15);"></div>
                        </div>
                    </div>
                    <div class="palette-card" data-palette="coral" data-colors='{"primary":"#E11D48","secondary":"#F43F5E","accent":"#FCD34D","background":"#FFF1F2","text":"#1C1917"}' onclick="selectPalette(this)">
                        <div class="palette-name">Coral</div>
                        <div class="palette-swatches">
                            <div class="swatch" style="background:#E11D48;"></div>
                            <div class="swatch" style="background:#F43F5E;"></div>
                            <div class="swatch" style="background:#FCD34D;"></div>
                            <div class="swatch" style="background:#FFF1F2; border-color:rgba(0,0,0,0.15);"></div>
                            <div class="swatch" style="background:#1C1917;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="style-section">
                <h3 class="style-section-title">Par de tipografias</h3>
                <div class="fonts-grid">
                    <div class="font-card selected" data-fonts='{"heading":"Space Grotesk","body":"Inter"}' onclick="selectFont(this)">
                        <div class="font-pair-name">Moderna</div>
                        <div class="font-preview-heading" style="font-family:'Space Grotesk',sans-serif;">Titulo de ejemplo</div>
                        <div class="font-preview-body" style="font-family:'Inter',sans-serif;">Texto de ejemplo para ver esta combinacion de fuentes.</div>
                    </div>
                    <div class="font-card" data-fonts='{"heading":"Playfair Display","body":"Lato"}' onclick="selectFont(this)">
                        <div class="font-pair-name">Clasica</div>
                        <div class="font-preview-heading" style="font-family:'Playfair Display',serif;">Titulo de ejemplo</div>
                        <div class="font-preview-body" style="font-family:'Lato',sans-serif;">Texto de ejemplo para ver esta combinacion de fuentes.</div>
                    </div>
                    <div class="font-card" data-fonts='{"heading":"Montserrat","body":"Open Sans"}' onclick="selectFont(this)">
                        <div class="font-pair-name">Limpia</div>
                        <div class="font-preview-heading" style="font-family:'Montserrat',sans-serif;">Titulo de ejemplo</div>
                        <div class="font-preview-body" style="font-family:'Open Sans',sans-serif;">Texto de ejemplo para ver esta combinacion de fuentes.</div>
                    </div>
                    <div class="font-card" data-fonts='{"heading":"Raleway","body":"Merriweather"}' onclick="selectFont(this)">
                        <div class="font-pair-name">Elegante</div>
                        <div class="font-preview-heading" style="font-family:'Raleway',sans-serif;">Titulo de ejemplo</div>
                        <div class="font-preview-body" style="font-family:'Merriweather',serif;">Texto de ejemplo para ver esta combinacion de fuentes.</div>
                    </div>
                    <div class="font-card" data-fonts='{"heading":"Poppins","body":"Roboto"}' onclick="selectFont(this)">
                        <div class="font-pair-name">Amigable</div>
                        <div class="font-preview-heading" style="font-family:'Poppins',sans-serif;">Titulo de ejemplo</div>
                        <div class="font-preview-body" style="font-family:'Roboto',sans-serif;">Texto de ejemplo para ver esta combinacion de fuentes.</div>
                    </div>
                    <div class="font-card" data-fonts='{"heading":"Montserrat","body":"Merriweather"}' onclick="selectFont(this)">
                        <div class="font-pair-name">Editorial</div>
                        <div class="font-preview-heading" style="font-family:'Montserrat',sans-serif;">Titulo de ejemplo</div>
                        <div class="font-preview-body" style="font-family:'Merriweather',serif;">Texto de ejemplo para ver esta combinacion de fuentes.</div>
                    </div>
                    <div class="font-card" data-fonts='{"heading":"Playfair Display","body":"Open Sans"}' onclick="selectFont(this)">
                        <div class="font-pair-name">Sofisticada</div>
                        <div class="font-preview-heading" style="font-family:'Playfair Display',serif;">Titulo de ejemplo</div>
                        <div class="font-preview-body" style="font-family:'Open Sans',sans-serif;">Texto de ejemplo para ver esta combinacion de fuentes.</div>
                    </div>
                    <div class="font-card" data-fonts='{"heading":"Poppins","body":"Lato"}' onclick="selectFont(this)">
                        <div class="font-pair-name">Startup</div>
                        <div class="font-preview-heading" style="font-family:'Poppins',sans-serif;">Titulo de ejemplo</div>
                        <div class="font-preview-body" style="font-family:'Lato',sans-serif;">Texto de ejemplo para ver esta combinacion de fuentes.</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Step 4: Generation --}}
        <div class="wizard-step" data-step="4">
            <div class="generation-screen">
                <div class="generation-spinner" id="genSpinner"></div>
                <h2 class="generation-title">Generando tu pagina...</h2>

                <div class="generation-steps">
                    <div class="gen-step" id="genStep1">
                        <span class="gen-icon">1</span>
                        <span>Analizando tu negocio...</span>
                    </div>
                    <div class="gen-step" id="genStep2">
                        <span class="gen-icon">2</span>
                        <span>Generando textos...</span>
                    </div>
                    <div class="gen-step" id="genStep3">
                        <span class="gen-icon">3</span>
                        <span>Armando secciones...</span>
                    </div>
                    <div class="gen-step" id="genStep4">
                        <span class="gen-icon">&#10003;</span>
                        <span>Listo!</span>
                    </div>
                </div>

                <div class="generation-error" id="genError"></div>
                <div class="generation-retry" id="genRetry">
                    <button class="btn btn-primary" onclick="retryGeneration()">Reintentar</button>
                </div>
            </div>
        </div>

    </div>

    {{-- Navigation --}}
    <div class="wizard-nav" id="wizardNav">
        <div class="nav-inner">
            <div>
                <button class="btn btn-secondary" id="btnPrev" onclick="prevStep()" style="display:none;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
                    Anterior
                </button>
            </div>
            <div style="display:flex; gap:12px; align-items:center;">
                <a href="{{ route('builder.editor', $page) }}" class="btn btn-skip">Saltar y usar editor</a>
                <button class="btn btn-primary" id="btnNext" onclick="nextStep()">
                    Siguiente
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        // ============================================================
        // Data from server
        // ============================================================
        var sectionLibrary = @json($sectionLibrary);
        var pageId = @json($page->id);
        var generateUrl = @json(route('builder.wizard.generate', $page));
        var editorUrl = @json(route('builder.editor', $page));
        var sectionsUrl = @json(route('builder.sections', $page));
        var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Default selected section IDs
        var defaultSections = [
            'hero-split', 'services-cards', 'about-split', 'stats-bar',
            'testimonials-grid', 'cta-gradient', 'contact-split', 'footer-4col'
        ];

        // ============================================================
        // Wizard State
        // ============================================================
        var currentStep = 1;
        var totalSteps = 4;
        // selectedSections: ordered array of {id, name, icon}
        var selectedSections = [];

        // ============================================================
        // Build Section Catalog
        // ============================================================
        function buildCatalog() {
            var catalog = document.getElementById('sectionCatalog');
            catalog.innerHTML = '';

            // Flatten for lookup
            var allSections = {};
            for (var catKey in sectionLibrary) {
                var cat = sectionLibrary[catKey];
                var sections = cat.sections || [];
                for (var i = 0; i < sections.length; i++) {
                    allSections[sections[i].id] = sections[i];
                }
            }

            // Pre-select defaults
            for (var d = 0; d < defaultSections.length; d++) {
                var defId = defaultSections[d];
                if (allSections[defId]) {
                    selectedSections.push({
                        id: defId,
                        name: allSections[defId].name || defId,
                        icon: allSections[defId].icon || ''
                    });
                }
            }

            // Build categories
            for (var catKey in sectionLibrary) {
                var cat = sectionLibrary[catKey];
                var catName = cat.name || catKey;
                var sections = cat.sections || [];

                if (sections.length === 0) continue;

                var catDiv = document.createElement('div');
                catDiv.className = 'catalog-category';

                var header = document.createElement('div');
                header.className = 'catalog-category-header';
                header.innerHTML = '<span class="chevron">&#9660;</span> ' + catName;
                header.onclick = (function(hdr, items) {
                    return function() {
                        hdr.classList.toggle('collapsed');
                        items.classList.toggle('collapsed');
                    };
                })(header, null); // will fix reference below

                var items = document.createElement('div');
                items.className = 'catalog-category-items';

                // Fix closure reference
                header.onclick = (function(hdr, itms) {
                    return function() {
                        hdr.classList.toggle('collapsed');
                        itms.classList.toggle('collapsed');
                    };
                })(header, items);

                for (var i = 0; i < sections.length; i++) {
                    var sec = sections[i];
                    var card = document.createElement('div');
                    card.className = 'catalog-card';
                    card.setAttribute('data-section-id', sec.id);
                    if (isSelected(sec.id)) {
                        card.classList.add('selected');
                    }
                    card.innerHTML =
                        '<div class="check-mark"></div>' +
                        '<span class="card-icon">' + (sec.icon || '') + '</span>' +
                        '<div class="card-name">' + (sec.name || sec.id) + '</div>' +
                        '<div class="card-desc">' + (sec.description || '') + '</div>';
                    card.onclick = (function(s) {
                        return function() { toggleSection(s.id, s.name || s.id, s.icon || ''); };
                    })(sec);
                    items.appendChild(card);
                }

                catDiv.appendChild(header);
                catDiv.appendChild(items);
                catalog.appendChild(catDiv);
            }

            renderSelectedList();
        }

        function isSelected(id) {
            for (var i = 0; i < selectedSections.length; i++) {
                if (selectedSections[i].id === id) return true;
            }
            return false;
        }

        function toggleSection(id, name, icon) {
            if (isSelected(id)) {
                // Remove
                selectedSections = selectedSections.filter(function(s) { return s.id !== id; });
            } else {
                // Add
                selectedSections.push({ id: id, name: name, icon: icon });
            }
            updateCatalogCards();
            renderSelectedList();
        }

        function removeSection(id) {
            selectedSections = selectedSections.filter(function(s) { return s.id !== id; });
            updateCatalogCards();
            renderSelectedList();
        }

        function updateCatalogCards() {
            var cards = document.querySelectorAll('.catalog-card');
            for (var i = 0; i < cards.length; i++) {
                var cId = cards[i].getAttribute('data-section-id');
                if (isSelected(cId)) {
                    cards[i].classList.add('selected');
                } else {
                    cards[i].classList.remove('selected');
                }
            }
        }

        // ============================================================
        // Selected List with Drag & Drop
        // ============================================================
        var draggedIndex = null;

        function renderSelectedList() {
            var list = document.getElementById('selectedList');
            var empty = document.getElementById('selectedEmpty');
            var count = document.getElementById('selectedCount');

            list.innerHTML = '';
            count.textContent = selectedSections.length + ' secciones seleccionadas';

            if (selectedSections.length === 0) {
                var emptyDiv = document.createElement('div');
                emptyDiv.className = 'selected-empty';
                emptyDiv.id = 'selectedEmpty';
                emptyDiv.textContent = 'Haz clic en las secciones del catalogo para agregarlas';
                list.appendChild(emptyDiv);
                return;
            }

            for (var i = 0; i < selectedSections.length; i++) {
                var sec = selectedSections[i];
                var item = document.createElement('div');
                item.className = 'selected-item';
                item.setAttribute('draggable', 'true');
                item.setAttribute('data-index', i);

                item.innerHTML =
                    '<span class="drag-handle">&#9776;</span>' +
                    '<span class="item-icon">' + sec.icon + '</span>' +
                    '<span class="item-name">' + sec.name + '</span>' +
                    '<button class="item-remove" data-id="' + sec.id + '">&times;</button>';

                // Drag events
                item.ondragstart = (function(idx) {
                    return function(e) {
                        draggedIndex = idx;
                        e.dataTransfer.effectAllowed = 'move';
                        e.dataTransfer.setData('text/plain', idx);
                        setTimeout(function() {
                            e.target.style.opacity = '0.4';
                        }, 0);
                    };
                })(i);

                item.ondragend = function(e) {
                    e.target.style.opacity = '1';
                    // Clear drag-over styles
                    var items = document.querySelectorAll('.selected-item');
                    for (var j = 0; j < items.length; j++) {
                        items[j].classList.remove('drag-over');
                    }
                };

                item.ondragover = function(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    this.classList.add('drag-over');
                };

                item.ondragleave = function(e) {
                    this.classList.remove('drag-over');
                };

                item.ondrop = (function(targetIdx) {
                    return function(e) {
                        e.preventDefault();
                        this.classList.remove('drag-over');
                        if (draggedIndex === null || draggedIndex === targetIdx) return;

                        // Reorder
                        var moved = selectedSections.splice(draggedIndex, 1)[0];
                        selectedSections.splice(targetIdx, 0, moved);
                        draggedIndex = null;
                        renderSelectedList();
                    };
                })(i);

                // Remove button
                var removeBtn = item.querySelector('.item-remove');
                removeBtn.onclick = (function(secId) {
                    return function(e) {
                        e.stopPropagation();
                        removeSection(secId);
                    };
                })(sec.id);

                list.appendChild(item);
            }
        }

        // ============================================================
        // Step Navigation
        // ============================================================
        function goToStep(step) {
            if (step < 1 || step > totalSteps) return;

            document.querySelectorAll('.wizard-step').forEach(function(el) {
                el.classList.remove('active');
            });

            var target = document.querySelector('.wizard-step[data-step="' + step + '"]');
            if (target) target.classList.add('active');

            currentStep = step;
            updateProgress();
            updateNav();

            if (step === 4) {
                startGeneration();
            }

            window.scrollTo(0, 0);
        }

        function nextStep() {
            if (!validateStep(currentStep)) return;
            goToStep(currentStep + 1);
        }

        function prevStep() {
            goToStep(currentStep - 1);
        }

        // ============================================================
        // Validation
        // ============================================================
        function validateStep(step) {
            hideAllErrors();

            if (step === 1) {
                var name = document.getElementById('business_name').value.trim();
                var desc = document.getElementById('business_description').value.trim();
                var valid = true;

                if (!name) {
                    showError('error_business_name');
                    valid = false;
                }
                if (!desc || desc.length < 10) {
                    showError('error_business_description');
                    valid = false;
                }
                return valid;
            }

            if (step === 2) {
                if (selectedSections.length < 2) {
                    showError('error_sections');
                    return false;
                }
                return true;
            }

            return true;
        }

        function showError(id) {
            var el = document.getElementById(id);
            if (el) el.classList.add('visible');
        }

        function hideAllErrors() {
            document.querySelectorAll('.form-error').forEach(function(el) {
                el.classList.remove('visible');
            });
        }

        // ============================================================
        // Progress Bar
        // ============================================================
        function updateProgress() {
            document.querySelectorAll('.progress-step').forEach(function(el) {
                var s = parseInt(el.getAttribute('data-step'));
                el.classList.remove('active', 'done');
                if (s === currentStep) el.classList.add('active');
                if (s < currentStep) el.classList.add('done');
            });

            document.querySelectorAll('.progress-line').forEach(function(el) {
                var after = parseInt(el.getAttribute('data-after'));
                el.classList.remove('done');
                if (after < currentStep) el.classList.add('done');
            });
        }

        // ============================================================
        // Navigation Buttons
        // ============================================================
        function updateNav() {
            var btnPrev = document.getElementById('btnPrev');
            var btnNext = document.getElementById('btnNext');
            var nav = document.getElementById('wizardNav');

            if (currentStep === 4) {
                nav.style.display = 'none';
                return;
            }

            nav.style.display = 'block';
            btnPrev.style.display = currentStep > 1 ? 'inline-flex' : 'none';

            if (currentStep === 3) {
                btnNext.innerHTML = 'Generar con IA <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';
            } else {
                btnNext.innerHTML = 'Siguiente <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';
            }
        }

        // ============================================================
        // Palette & Font Selection (Step 3)
        // ============================================================
        function selectPalette(card) {
            document.querySelectorAll('.palette-card').forEach(function(el) {
                el.classList.remove('selected');
            });
            card.classList.add('selected');
        }

        function selectFont(card) {
            document.querySelectorAll('.font-card').forEach(function(el) {
                el.classList.remove('selected');
            });
            card.classList.add('selected');
        }

        function getSelectedColors() {
            var selected = document.querySelector('.palette-card.selected');
            if (!selected) return null;
            var palette = selected.getAttribute('data-palette');
            if (palette === 'ai') return { _ai_generate: true };
            return JSON.parse(selected.getAttribute('data-colors'));
        }

        function getSelectedFonts() {
            var selected = document.querySelector('.font-card.selected');
            if (!selected) return null;
            return JSON.parse(selected.getAttribute('data-fonts'));
        }

        function getSelectedSectionIds() {
            return selectedSections.map(function(s) { return s.id; });
        }

        // ============================================================
        // Generation (Step 4)
        // ============================================================
        var generationInProgress = false;
        var generationAttempts = 0;
        var maxGenerationAttempts = 3;

        function startGeneration() {
            if (generationInProgress) return;
            generationAttempts++;
            if (generationAttempts > maxGenerationAttempts) {
                document.getElementById('genSpinner').style.display = 'none';
                document.getElementById('genError').textContent = 'Se alcanzo el maximo de intentos. Recarga la pagina e intenta de nuevo.';
                document.getElementById('genError').classList.add('visible');
                return;
            }
            generationInProgress = true;

            // Reset UI
            document.getElementById('genError').classList.remove('visible');
            document.getElementById('genRetry').classList.remove('visible');
            document.getElementById('genSpinner').style.display = 'block';

            var genSteps = ['genStep1', 'genStep2', 'genStep3', 'genStep4'];
            genSteps.forEach(function(id) {
                var el = document.getElementById(id);
                el.classList.remove('active', 'done');
            });

            // Step 1: Analyzing
            setGenStep('genStep1', 'active');

            // Timer
            var elapsedSeconds = 0;
            var timerEl = document.getElementById('genTimer');
            if (!timerEl) {
                timerEl = document.createElement('p');
                timerEl.id = 'genTimer';
                timerEl.style.cssText = 'font-size:0.85rem; color:rgba(255,255,255,0.5); margin-top:1rem; text-align:center;';
                document.querySelector('.generation-screen').insertBefore(timerEl, document.getElementById('genError'));
            }
            var timerInterval = setInterval(function() {
                elapsedSeconds++;
                if (elapsedSeconds < 5) {
                    timerEl.textContent = 'Conectando con la IA...';
                } else if (elapsedSeconds < 20) {
                    timerEl.textContent = 'Generando textos (' + elapsedSeconds + 's)...';
                } else {
                    timerEl.textContent = 'Casi listo (' + elapsedSeconds + 's)...';
                }
            }, 1000);

            setTimeout(function() {
                setGenStep('genStep1', 'done');
                setGenStep('genStep2', 'active');

                callGenerateAPI()
                    .then(function(data) {
                        clearInterval(timerInterval);
                        if (timerEl) timerEl.textContent = '';
                        setGenStep('genStep2', 'done');
                        setGenStep('genStep3', 'active');

                        setTimeout(function() {
                            setGenStep('genStep3', 'done');
                            setGenStep('genStep4', 'active');
                            document.getElementById('genSpinner').style.display = 'none';

                            setTimeout(function() {
                                setGenStep('genStep4', 'done');
                                window.location.href = data.redirect || sectionsUrl;
                            }, 600);
                        }, 500);
                    })
                    .catch(function(error) {
                        clearInterval(timerInterval);
                        if (timerEl) timerEl.textContent = '';
                        setGenStep('genStep2', 'done');
                        document.getElementById('genSpinner').style.display = 'none';
                        document.getElementById('genError').textContent = error.message || 'Error al generar la pagina. Intenta de nuevo.';
                        document.getElementById('genError').classList.add('visible');
                        document.getElementById('genRetry').classList.add('visible');
                        generationInProgress = false;
                    });
            }, 800);
        }

        function setGenStep(id, state) {
            var el = document.getElementById(id);
            el.classList.remove('active', 'done');
            el.classList.add(state);
        }

        function callGenerateAPI() {
            var payload = {
                business_name: document.getElementById('business_name').value.trim(),
                business_description: document.getElementById('business_description').value.trim(),
                sections: getSelectedSectionIds(),
                colors: getSelectedColors(),
                fonts: getSelectedFonts()
            };

            return fetch(generateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(function(response) {
                if (!response.ok) {
                    return response.text().then(function(text) {
                        try {
                            var data = JSON.parse(text);
                            throw new Error(data.message || 'Error del servidor (' + response.status + ')');
                        } catch(e) {
                            if (e.message && !e.message.includes('JSON')) throw e;
                            throw new Error('Error del servidor (' + response.status + '). Intenta de nuevo.');
                        }
                    });
                }
                return response.json();
            })
            .then(function(data) {
                if (!data || !data.success) {
                    throw new Error((data && data.message) || 'Error al generar la pagina');
                }
                return data;
            });
        }

        function retryGeneration() {
            generationInProgress = false;
            startGeneration();
        }

        // ============================================================
        // Init
        // ============================================================
        buildCatalog();
        updateProgress();
        updateNav();
    </script>
</body>
</html>
