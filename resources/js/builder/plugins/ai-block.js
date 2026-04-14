/**
 * AI Block Plugin for WebComposer
 * Adds AI-powered content generation directly in the GrapesJS editor.
 */
export default (editor, opts = {}) => {
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

    const defaultOpts = {
        apiBaseUrl: '/api/ai',
        ...opts,
    };

    // Add AI command
    editor.Commands.add('open-ai-panel', {
        run(editor) {
            showAIModal(editor);
        },
    });

    // Add AI button to the panel
    editor.Panels.addButton('options', {
        id: 'ai-assistant',
        className: 'fa fa-magic',
        command: 'open-ai-panel',
        attributes: { title: 'Asistente IA' },
    });

    function showAIModal(editor) {
        const modal = editor.Modal;
        modal.setTitle('Asistente IA');
        modal.setContent(getModalContent());
        modal.open();

        // Attach event listeners after content is set
        setTimeout(() => initModalEvents(editor, modal), 50);
    }

    function getModalContent() {
        return `
        <div style="font-family:Inter,sans-serif; color:#cdd6f4; min-width:500px;">
            <!-- Tab Navigation -->
            <div style="display:flex; border-bottom:2px solid #313244; margin-bottom:20px;" id="ai-tabs">
                <button class="ai-tab active" data-tab="generate" style="padding:10px 20px; background:none; border:none; color:#89b4fa; font-weight:600; cursor:pointer; border-bottom:2px solid #89b4fa; margin-bottom:-2px;">Generar Texto</button>
                <button class="ai-tab" data-tab="seo" style="padding:10px 20px; background:none; border:none; color:#6c7086; cursor:pointer;">SEO</button>
                <button class="ai-tab" data-tab="translate" style="padding:10px 20px; background:none; border:none; color:#6c7086; cursor:pointer;">Traducir</button>
                <button class="ai-tab" data-tab="page" style="padding:10px 20px; background:none; border:none; color:#6c7086; cursor:pointer;">Generar P\u00e1gina</button>
                <button class="ai-tab" data-tab="variants" style="padding:10px 20px; background:none; border:none; color:#6c7086; cursor:pointer;">Variantes</button>
            </div>

            <!-- Generate Text Tab -->
            <div class="ai-tab-content" id="tab-generate">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                    <div>
                        <label style="display:block; font-size:13px; margin-bottom:4px; color:#a6adc8;">Tipo de secci\u00f3n</label>
                        <select id="ai-section-type" style="width:100%; padding:8px 12px; background:#313244; border:1px solid #45475a; border-radius:6px; color:#cdd6f4; font-size:14px;">
                            <option value="hero">Hero / Banner</option>
                            <option value="features">Caracter\u00edsticas</option>
                            <option value="about">Sobre Nosotros</option>
                            <option value="services">Servicios</option>
                            <option value="testimonials">Testimonios</option>
                            <option value="cta">Call to Action</option>
                            <option value="pricing">Precios</option>
                            <option value="faq">FAQ</option>
                            <option value="contact">Contacto</option>
                            <option value="team">Equipo</option>
                            <option value="stats">Estad\u00edsticas</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:13px; margin-bottom:4px; color:#a6adc8;">Tipo de negocio</label>
                        <input id="ai-business-type" type="text" placeholder="ej: restaurante italiano, startup tech..." style="width:100%; padding:8px 12px; background:#313244; border:1px solid #45475a; border-radius:6px; color:#cdd6f4; font-size:14px;">
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                    <div>
                        <label style="display:block; font-size:13px; margin-bottom:4px; color:#a6adc8;">Tono</label>
                        <select id="ai-tone" style="width:100%; padding:8px 12px; background:#313244; border:1px solid #45475a; border-radius:6px; color:#cdd6f4; font-size:14px;">
                            <option value="profesional">Profesional</option>
                            <option value="casual">Casual</option>
                            <option value="formal">Formal</option>
                            <option value="divertido">Divertido</option>
                            <option value="inspirador">Inspirador</option>
                            <option value="t\u00e9cnico">T\u00e9cnico</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:13px; margin-bottom:4px; color:#a6adc8;">Idioma</label>
                        <select id="ai-language" style="width:100%; padding:8px 12px; background:#313244; border:1px solid #45475a; border-radius:6px; color:#cdd6f4; font-size:14px;">
                            <option value="es">Espa\u00f1ol</option>
                            <option value="en">English</option>
                            <option value="pt">Portugu\u00eas</option>
                            <option value="fr">Fran\u00e7ais</option>
                        </select>
                    </div>
                </div>
                <button id="ai-generate-btn" style="width:100%; padding:10px; background:#89b4fa; color:#1e1e2e; border:none; border-radius:6px; font-weight:600; cursor:pointer; font-size:14px;">
                    Generar Texto
                </button>
            </div>

            <!-- SEO Tab -->
            <div class="ai-tab-content" id="tab-seo" style="display:none;">
                <p style="font-size:13px; color:#a6adc8; margin-bottom:12px;">Analiza el contenido actual de la p\u00e1gina y genera sugerencias SEO optimizadas.</p>
                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:13px; margin-bottom:4px; color:#a6adc8;">T\u00edtulo de la p\u00e1gina</label>
                    <input id="ai-seo-title" type="text" placeholder="T\u00edtulo actual de la p\u00e1gina" style="width:100%; padding:8px 12px; background:#313244; border:1px solid #45475a; border-radius:6px; color:#cdd6f4; font-size:14px;">
                </div>
                <button id="ai-seo-btn" style="width:100%; padding:10px; background:#a6e3a1; color:#1e1e2e; border:none; border-radius:6px; font-weight:600; cursor:pointer; font-size:14px;">
                    Generar SEO
                </button>
            </div>

            <!-- Translate Tab -->
            <div class="ai-tab-content" id="tab-translate" style="display:none;">
                <p style="font-size:13px; color:#a6adc8; margin-bottom:12px;">Traduce el contenido del componente seleccionado.</p>
                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:13px; margin-bottom:4px; color:#a6adc8;">Idioma destino</label>
                    <select id="ai-translate-lang" style="width:100%; padding:8px 12px; background:#313244; border:1px solid #45475a; border-radius:6px; color:#cdd6f4; font-size:14px;">
                        <option value="es">Espa\u00f1ol</option>
                        <option value="en">English</option>
                        <option value="pt">Portugu\u00eas</option>
                        <option value="fr">Fran\u00e7ais</option>
                        <option value="de">Deutsch</option>
                        <option value="it">Italiano</option>
                    </select>
                </div>
                <button id="ai-translate-btn" style="width:100%; padding:10px; background:#f9e2af; color:#1e1e2e; border:none; border-radius:6px; font-weight:600; cursor:pointer; font-size:14px;">
                    Traducir Selecci\u00f3n
                </button>
            </div>

            <!-- Generate Page Tab -->
            <div class="ai-tab-content" id="tab-page" style="display:none;">
                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:13px; margin-bottom:4px; color:#a6adc8;">Tipo de negocio</label>
                    <input id="ai-page-business" type="text" placeholder="ej: cl\u00ednica dental, academia de idiomas..." style="width:100%; padding:8px 12px; background:#313244; border:1px solid #45475a; border-radius:6px; color:#cdd6f4; font-size:14px;">
                </div>
                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:13px; margin-bottom:4px; color:#a6adc8;">Descripci\u00f3n del negocio</label>
                    <textarea id="ai-page-desc" rows="3" placeholder="Describe tu negocio, qu\u00e9 ofreces, tu p\u00fablico objetivo..." style="width:100%; padding:8px 12px; background:#313244; border:1px solid #45475a; border-radius:6px; color:#cdd6f4; font-size:14px; resize:vertical;"></textarea>
                </div>
                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:13px; margin-bottom:4px; color:#a6adc8;">Secciones (opcional)</label>
                    <input id="ai-page-sections" type="text" placeholder="hero, features, about, testimonials, cta" style="width:100%; padding:8px 12px; background:#313244; border:1px solid #45475a; border-radius:6px; color:#cdd6f4; font-size:14px;">
                </div>
                <button id="ai-page-btn" style="width:100%; padding:10px; background:#cba6f7; color:#1e1e2e; border:none; border-radius:6px; font-weight:600; cursor:pointer; font-size:14px;">
                    Generar P\u00e1gina Completa
                </button>
                <p style="font-size:12px; color:#6c7086; margin-top:8px; text-align:center;">Esto reemplazar\u00e1 todo el contenido actual del editor</p>
            </div>

            <!-- Variants Tab -->
            <div class="ai-tab-content" id="tab-variants" style="display:none;">
                <p style="font-size:13px; color:#a6adc8; margin-bottom:12px;">Selecciona un componente de texto en el editor y genera variantes alternativas.</p>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:13px; margin-bottom:4px; color:#a6adc8;">Cantidad</label>
                        <select id="ai-variants-count" style="width:100%; padding:8px 12px; background:#313244; border:1px solid #45475a; border-radius:6px; color:#cdd6f4; font-size:14px;">
                            <option value="2">2 variantes</option>
                            <option value="3" selected>3 variantes</option>
                            <option value="5">5 variantes</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:13px; margin-bottom:4px; color:#a6adc8;">Tono</label>
                        <select id="ai-variants-tone" style="width:100%; padding:8px 12px; background:#313244; border:1px solid #45475a; border-radius:6px; color:#cdd6f4; font-size:14px;">
                            <option value="profesional">Profesional</option>
                            <option value="casual">Casual</option>
                            <option value="formal">Formal</option>
                            <option value="divertido">Divertido</option>
                        </select>
                    </div>
                </div>
                <button id="ai-variants-btn" style="width:100%; padding:10px; background:#f38ba8; color:#1e1e2e; border:none; border-radius:6px; font-weight:600; cursor:pointer; font-size:14px;">
                    Generar Variantes
                </button>
            </div>

            <!-- Result Area -->
            <div id="ai-result" style="margin-top:16px; display:none;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <span style="font-size:13px; font-weight:600; color:#a6adc8;">Resultado:</span>
                    <button id="ai-apply-btn" style="padding:6px 16px; background:#a6e3a1; color:#1e1e2e; border:none; border-radius:6px; font-weight:600; cursor:pointer; font-size:13px;">Aplicar al editor</button>
                </div>
                <div id="ai-result-content" style="background:#313244; padding:16px; border-radius:8px; font-size:14px; line-height:1.6; max-height:300px; overflow-y:auto; white-space:pre-wrap;"></div>
            </div>

            <!-- Loading indicator -->
            <div id="ai-loading" style="display:none; text-align:center; padding:20px;">
                <div style="display:inline-block; width:24px; height:24px; border:3px solid #45475a; border-top-color:#89b4fa; border-radius:50%; animation:spin 0.8s linear infinite;"></div>
                <p style="margin-top:8px; color:#a6adc8; font-size:14px;">Generando con IA...</p>
            </div>
            <style>@keyframes spin { to { transform: rotate(360deg); } }</style>
        </div>`;
    }

    function initModalEvents(editor, modal) {
        let lastResult = null;
        let lastResultType = null;

        // Tab switching
        document.querySelectorAll('.ai-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.ai-tab').forEach(t => {
                    t.style.color = '#6c7086';
                    t.style.borderBottom = 'none';
                    t.classList.remove('active');
                });
                this.style.color = '#89b4fa';
                this.style.borderBottom = '2px solid #89b4fa';
                this.classList.add('active');

                document.querySelectorAll('.ai-tab-content').forEach(c => c.style.display = 'none');
                const targetTab = document.getElementById('tab-' + this.dataset.tab);
                if (targetTab) targetTab.style.display = 'block';

                // Hide result when switching tabs
                const resultEl = document.getElementById('ai-result');
                if (resultEl) resultEl.style.display = 'none';
            });
        });

        function showLoading() {
            const el = document.getElementById('ai-loading');
            const resultEl = document.getElementById('ai-result');
            if (el) el.style.display = 'block';
            if (resultEl) resultEl.style.display = 'none';
        }

        function hideLoading() {
            const el = document.getElementById('ai-loading');
            if (el) el.style.display = 'none';
        }

        function showResult(content, type) {
            hideLoading();
            lastResult = content;
            lastResultType = type;
            const resultEl = document.getElementById('ai-result');
            const contentEl = document.getElementById('ai-result-content');
            if (resultEl && contentEl) {
                if (typeof content === 'object') {
                    contentEl.textContent = JSON.stringify(content, null, 2);
                } else {
                    contentEl.textContent = content;
                }
                resultEl.style.display = 'block';
            }
        }

        function showError(message) {
            hideLoading();
            const resultEl = document.getElementById('ai-result');
            const contentEl = document.getElementById('ai-result-content');
            if (resultEl && contentEl) {
                contentEl.innerHTML = '<span style="color:#f38ba8;">' + message + '</span>';
                resultEl.style.display = 'block';
                const applyBtn = document.getElementById('ai-apply-btn');
                if (applyBtn) applyBtn.style.display = 'none';
            }
        }

        async function aiRequest(endpoint, body) {
            const resp = await fetch(defaultOpts.apiBaseUrl + endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                credentials: 'same-origin',
                body: JSON.stringify(body),
            });
            if (!resp.ok) {
                const err = await resp.json().catch(() => ({}));
                throw new Error(err.error || 'Error del servidor');
            }
            return resp.json();
        }

        // Generate Text
        const genBtn = document.getElementById('ai-generate-btn');
        if (genBtn) {
            genBtn.addEventListener('click', async () => {
                const businessType = document.getElementById('ai-business-type')?.value;
                if (!businessType) { showError('Ingresa el tipo de negocio'); return; }
                showLoading();
                try {
                    const data = await aiRequest('/generate-text', {
                        section_type: document.getElementById('ai-section-type')?.value,
                        business_type: businessType,
                        tone: document.getElementById('ai-tone')?.value,
                        language: document.getElementById('ai-language')?.value,
                    });
                    showResult(data, 'text');
                } catch (e) { showError(e.message); }
            });
        }

        // Generate SEO
        const seoBtn = document.getElementById('ai-seo-btn');
        if (seoBtn) {
            seoBtn.addEventListener('click', async () => {
                const title = document.getElementById('ai-seo-title')?.value;
                const content = editor.getHtml();
                if (!title) { showError('Ingresa el t\u00edtulo de la p\u00e1gina'); return; }
                showLoading();
                try {
                    const data = await aiRequest('/generate-seo', { title, content });
                    showResult(data, 'seo');
                } catch (e) { showError(e.message); }
            });
        }

        // Translate
        const translateBtn = document.getElementById('ai-translate-btn');
        if (translateBtn) {
            translateBtn.addEventListener('click', async () => {
                const selected = editor.getSelected();
                if (!selected) { showError('Selecciona un componente en el editor primero'); return; }
                const content = selected.toHTML();
                showLoading();
                try {
                    const data = await aiRequest('/translate', {
                        content,
                        target_language: document.getElementById('ai-translate-lang')?.value,
                    });
                    showResult(data.translated, 'translate');
                } catch (e) { showError(e.message); }
            });
        }

        // Generate Page
        const pageBtn = document.getElementById('ai-page-btn');
        if (pageBtn) {
            pageBtn.addEventListener('click', async () => {
                const business = document.getElementById('ai-page-business')?.value;
                const desc = document.getElementById('ai-page-desc')?.value;
                if (!business || !desc) { showError('Completa el tipo de negocio y la descripci\u00f3n'); return; }
                showLoading();
                try {
                    const data = await aiRequest('/generate-page', {
                        business_type: business,
                        description: desc,
                        sections: document.getElementById('ai-page-sections')?.value || '',
                    });
                    showResult(data, 'page');
                } catch (e) { showError(e.message); }
            });
        }

        // Variants
        const variantsBtn = document.getElementById('ai-variants-btn');
        if (variantsBtn) {
            variantsBtn.addEventListener('click', async () => {
                const selected = editor.getSelected();
                if (!selected) { showError('Selecciona un componente de texto en el editor'); return; }
                const text = selected.view?.el?.textContent || selected.get('content') || '';
                if (!text.trim()) { showError('El componente seleccionado no tiene texto'); return; }
                showLoading();
                try {
                    const data = await aiRequest('/generate-variants', {
                        text: text.trim(),
                        variants: parseInt(document.getElementById('ai-variants-count')?.value || '3'),
                        tone: document.getElementById('ai-variants-tone')?.value,
                    });
                    showResult(data, 'variants');
                } catch (e) { showError(e.message); }
            });
        }

        // Apply result to editor
        const applyBtn = document.getElementById('ai-apply-btn');
        if (applyBtn) {
            applyBtn.addEventListener('click', () => {
                if (!lastResult) return;

                switch (lastResultType) {
                    case 'text': {
                        const selected = editor.getSelected();
                        if (selected) {
                            const html = `<div>
                                <h2>${lastResult.title || ''}</h2>
                                <p><strong>${lastResult.subtitle || ''}</strong></p>
                                <p>${lastResult.description || ''}</p>
                                ${lastResult.cta ? `<a href="#">${lastResult.cta}</a>` : ''}
                            </div>`;
                            selected.components(html);
                        } else {
                            editor.addComponents(`<section style="padding:60px 20px; text-align:center;">
                                <div style="max-width:800px; margin:0 auto;">
                                    <h2 style="font-size:36px; font-weight:700; margin-bottom:12px;">${lastResult.title || ''}</h2>
                                    <p style="font-size:18px; color:#64748b; margin-bottom:16px;">${lastResult.subtitle || ''}</p>
                                    <p style="font-size:16px; line-height:1.7; margin-bottom:24px;">${lastResult.description || ''}</p>
                                    ${lastResult.cta ? `<a href="#" style="display:inline-block; padding:12px 28px; background:#6366f1; color:#fff; border-radius:8px; text-decoration:none; font-weight:600;">${lastResult.cta}</a>` : ''}
                                </div>
                            </section>`);
                        }
                        break;
                    }
                    case 'translate': {
                        const selected = editor.getSelected();
                        if (selected && typeof lastResult === 'string') {
                            selected.components(lastResult);
                        }
                        break;
                    }
                    case 'page': {
                        if (lastResult.html) {
                            editor.setComponents(lastResult.html);
                            if (lastResult.css) editor.setStyle(lastResult.css);
                        }
                        break;
                    }
                    case 'variants': {
                        if (lastResult.variants && lastResult.variants.length > 0) {
                            const selected = editor.getSelected();
                            if (selected) {
                                selected.components(lastResult.variants[0]);
                            }
                        }
                        break;
                    }
                }

                modal.close();
            });
        }
    }
};
