<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor - {{ $page->title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- GrapesJS CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">

    {{-- Google Fonts - all 10 for the editor --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&family=Lato:wght@300;400;700&family=Playfair+Display:wght@400;500;600;700&family=Merriweather:wght@300;400;700&family=Raleway:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { overflow: hidden; font-family: 'Inter', sans-serif; background: #11111b; }

        .editor-wrapper { display: flex; flex-direction: column; height: 100vh; }

        /* ============ Top Bar ============ */
        .editor-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 12px;
            height: 48px;
            background: #1e1e2e;
            color: #fff;
            border-bottom: 1px solid #313244;
            z-index: 10;
            flex-shrink: 0;
        }
        .editor-topbar .left { display: flex; align-items: center; gap: 10px; }
        .editor-topbar .center { display: flex; align-items: center; gap: 12px; }
        .editor-topbar .right { display: flex; align-items: center; gap: 6px; }

        .back-link {
            color: #a6adc8;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            transition: all 0.15s;
        }
        .back-link:hover { background: #313244; color: #cdd6f4; }
        .back-link svg { width: 18px; height: 18px; }

        .topbar-divider {
            width: 1px;
            height: 24px;
            background: #313244;
            margin: 0 2px;
        }

        /* Inline editable page title */
        .page-title-input {
            font-size: 14px;
            font-weight: 500;
            color: #cdd6f4;
            background: transparent;
            border: 1px solid transparent;
            border-radius: 4px;
            padding: 4px 8px;
            outline: none;
            max-width: 220px;
            transition: all 0.15s;
        }
        .page-title-input:hover { border-color: #45475a; }
        .page-title-input:focus { border-color: #89b4fa; background: #181825; }

        /* Status badge */
        .page-status-badge {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            padding: 2px 7px;
            border-radius: 4px;
            letter-spacing: 0.5px;
        }
        .page-status-badge.draft { background: #45475a; color: #f9e2af; }
        .page-status-badge.published { background: #1e4620; color: #a6e3a1; }
        .page-status-badge.archived { background: #45475a; color: #6c7086; }

        /* Undo/Redo buttons */
        .undo-redo-group { display: flex; gap: 1px; }
        .btn-undo-redo {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            border-radius: 5px;
            color: #6c7086;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-undo-redo:hover { background: #313244; color: #cdd6f4; }
        .btn-undo-redo:active { background: #45475a; }
        .btn-undo-redo svg { width: 16px; height: 16px; }

        /* Device preview buttons */
        .device-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }
        .device-btns { display: flex; gap: 1px; background: #313244; border-radius: 6px; padding: 2px; }
        .device-btn {
            padding: 4px 10px;
            background: transparent;
            border: none;
            border-radius: 4px;
            color: #6c7086;
            cursor: pointer;
            transition: all 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .device-btn svg { width: 16px; height: 16px; }
        .device-btn.active { background: #45475a; color: #cdd6f4; }
        .device-btn:hover:not(.active) { color: #a6adc8; }
        .device-label {
            font-size: 10px;
            color: #585b70;
            letter-spacing: 0.3px;
            transition: color 0.2s;
        }

        /* Top bar buttons */
        .btn-editor {
            padding: 5px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }
        .btn-editor:disabled { opacity: 0.5; cursor: not-allowed; }
        .btn-editor svg { width: 14px; height: 14px; }

        .btn-ghost {
            background: transparent;
            color: #a6adc8;
            border: 1px solid #45475a;
        }
        .btn-ghost:hover:not(:disabled) { background: #313244; color: #cdd6f4; border-color: #585b70; }

        .btn-primary {
            background: linear-gradient(135deg, #89b4fa 0%, #b4befe 100%);
            color: #1e1e2e;
            font-weight: 600;
        }
        .btn-primary:hover:not(:disabled) { filter: brightness(1.1); box-shadow: 0 2px 8px rgba(137,180,250,0.3); }

        .btn-publish-bar {
            background: linear-gradient(135deg, #a6e3a1 0%, #94e2d5 100%);
            color: #1e1e2e;
            font-weight: 600;
        }
        .btn-publish-bar:hover:not(:disabled) { filter: brightness(1.1); box-shadow: 0 2px 8px rgba(166,227,161,0.3); }

        .btn-subtle {
            background: transparent;
            color: #a6adc8;
            padding: 5px 10px;
        }
        .btn-subtle:hover { background: #313244; color: #cdd6f4; }

        .btn-ai-wizard {
            background: linear-gradient(135deg, #cba6f7 0%, #f38ba8 100%);
            color: #1e1e2e;
            font-weight: 600;
        }
        .btn-ai-wizard:hover { filter: brightness(1.1); box-shadow: 0 2px 8px rgba(203,166,247,0.3); }

        .btn-templates-bar {
            background: transparent;
            color: #f9e2af;
            border: 1px solid rgba(249,226,175,0.3);
        }
        .btn-templates-bar:hover { background: rgba(249,226,175,0.1); border-color: rgba(249,226,175,0.5); }

        /* Save status dot */
        .save-indicator {
            display: flex;
            align-items: center;
            gap: 4px;
            position: relative;
        }
        .save-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #a6e3a1;
            transition: background 0.3s;
            flex-shrink: 0;
        }
        .save-dot.unsaved { background: #f9e2af; }
        .save-dot.saving { background: #f9e2af; animation: savePulse 0.8s ease-in-out infinite; }
        .save-dot.error { background: #f38ba8; }
        .save-dot.saved { background: #a6e3a1; animation: savePulseOnce 0.5s ease-out; }
        @keyframes savePulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }
        @keyframes savePulseOnce {
            0% { transform: scale(1.4); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }
        .save-tooltip {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 6px;
            background: #313244;
            color: #cdd6f4;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 4px;
            white-space: nowrap;
            z-index: 100;
        }
        .save-indicator:hover .save-tooltip { display: block; }

        /* ============ Main editor area ============ */
        .editor-main {
            flex: 1;
            display: flex;
            overflow: hidden;
        }

        /* ============ Toast notifications ============ */
        .toast-container {
            position: fixed;
            top: 56px;
            right: 16px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
        }
        .toast {
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            animation: toastIn 0.3s ease-out;
            pointer-events: auto;
            display: flex;
            align-items: center;
            gap: 8px;
            max-width: 350px;
        }
        .toast.success { background: #1e4620; border: 1px solid #a6e3a1; }
        .toast.error { background: #4a1520; border: 1px solid #f38ba8; }
        .toast.info { background: #1e2d4a; border: 1px solid #89b4fa; }
        .toast.hiding { animation: toastOut 0.3s ease-in forwards; }
        @keyframes toastIn { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes toastOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(40px); } }

        /* ============ Confirm Dialog ============ */
        .confirm-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 10001;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: confirmFadeIn 0.15s ease-out;
        }
        @keyframes confirmFadeIn { from { opacity: 0; } to { opacity: 1; } }
        .confirm-dialog {
            background: #1e1e2e;
            border: 1px solid #313244;
            border-radius: 12px;
            padding: 24px;
            max-width: 420px;
            width: 90%;
            color: #cdd6f4;
            box-shadow: 0 16px 48px rgba(0,0,0,0.4);
            animation: confirmSlideIn 0.2s ease-out;
        }
        @keyframes confirmSlideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .confirm-dialog h3 { font-size: 16px; font-weight: 600; margin-bottom: 8px; }
        .confirm-dialog p { font-size: 14px; color: #a6adc8; margin-bottom: 20px; line-height: 1.5; }
        .confirm-actions { display: flex; justify-content: flex-end; gap: 8px; }
        .confirm-cancel {
            padding: 8px 16px;
            background: #313244;
            color: #cdd6f4;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            font-weight: 500;
        }
        .confirm-cancel:hover { background: #45475a; }
        .confirm-ok {
            padding: 8px 16px;
            background: #89b4fa;
            color: #1e1e2e;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            font-weight: 600;
        }
        .confirm-ok:hover { background: #b4d0fb; }
        .confirm-ok.danger { background: #f38ba8; }
        .confirm-ok.danger:hover { background: #f5a0b8; }

        /* ============ Quick Add floating button ============ */
        .quick-add-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #89b4fa 0%, #b4befe 100%);
            color: #1e1e2e;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(137,180,250,0.4);
            z-index: 50;
            transition: all 0.2s;
        }
        .quick-add-btn:hover { transform: scale(1.1); box-shadow: 0 6px 20px rgba(137,180,250,0.5); }
        .quick-add-btn svg { width: 24px; height: 24px; }

        .quick-add-menu {
            position: fixed;
            bottom: 80px;
            right: 24px;
            background: #1e1e2e;
            border: 1px solid #313244;
            border-radius: 10px;
            padding: 6px;
            z-index: 50;
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
            display: none;
            min-width: 200px;
            animation: quickMenuIn 0.15s ease-out;
        }
        @keyframes quickMenuIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        .quick-add-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            color: #cdd6f4;
            font-size: 13px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.1s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-family: inherit;
        }
        .quick-add-item:hover { background: #313244; }
        .quick-add-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* ============ GrapesJS dark theme overrides ============ */
        .gjs-one-bg { background-color: #1e1e2e !important; }
        .gjs-two-color { color: #cdd6f4 !important; }
        .gjs-three-bg { background-color: #313244 !important; }
        .gjs-four-color, .gjs-four-color-h:hover { color: #89b4fa !important; }

        #gjs {
            flex: 1;
            height: 100%;
            border: none;
        }

        /* Canvas transition for responsive preview */
        .gjs-frame-wrapper { transition: width 0.3s ease, height 0.3s ease; }

        /* Panels styling */
        .gjs-pn-panel { background-color: #1e1e2e !important; }
        .gjs-pn-views-container { width: 280px; background: #1e1e2e !important; }
        .gjs-pn-views { border-bottom: 2px solid #313244 !important; }
        .gjs-pn-btn { color: #6c7086 !important; border-radius: 4px !important; }
        .gjs-pn-btn:hover { color: #cdd6f4 !important; }
        .gjs-pn-btn.gjs-pn-active { color: #89b4fa !important; box-shadow: 0 2px 0 #89b4fa !important; }

        /* Blocks */
        .gjs-block {
            background: #313244 !important;
            border: 1px solid #45475a !important;
            border-radius: 6px !important;
            color: #cdd6f4 !important;
            min-height: 65px !important;
            transition: border-color 0.15s !important;
        }
        .gjs-block:hover { border-color: #89b4fa !important; }
        .gjs-block-label { color: #cdd6f4 !important; font-size: 11px !important; }

        /* Block categories — styled as collapsible accordion */
        .gjs-block-category .gjs-title {
            background: #181825 !important;
            color: #a6adc8 !important;
            border-bottom: 1px solid #313244 !important;
            font-size: 12px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            padding: 10px 12px !important;
            cursor: pointer;
            transition: color 0.15s;
        }
        .gjs-block-category .gjs-title:hover { color: #cdd6f4 !important; }
        .gjs-block-category { border-bottom: 1px solid #181825 !important; }

        /* Style manager */
        .gjs-sm-sector .gjs-sm-sector-title {
            background: #181825 !important;
            color: #a6adc8 !important;
            border: none !important;
            border-bottom: 1px solid #313244 !important;
            font-size: 12px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }
        .gjs-sm-sector .gjs-sm-property { color: #cdd6f4 !important; }
        .gjs-sm-sector .gjs-sm-property .gjs-sm-label { color: #a6adc8 !important; }
        .gjs-clm-tags { background: #1e1e2e !important; padding: 8px !important; }
        .gjs-clm-tag { background: #313244 !important; color: #cdd6f4 !important; }
        .gjs-field { background: #313244 !important; color: #cdd6f4 !important; border: 1px solid #45475a !important; border-radius: 4px !important; }
        .gjs-field input, .gjs-field select, .gjs-field textarea { color: #cdd6f4 !important; }
        .gjs-field-arrow-u, .gjs-field-arrow-d { border-top-color: #6c7086 !important; border-bottom-color: #6c7086 !important; }
        .gjs-radio-item input:checked + .gjs-radio-item-label { background: #89b4fa !important; color: #1e1e2e !important; }
        .gjs-radio-item-label { background: #313244 !important; border-color: #45475a !important; }
        .gjs-color-preview { border-radius: 3px !important; }

        /* Layers panel */
        .gjs-layer { background: #1e1e2e !important; color: #cdd6f4 !important; }
        .gjs-layer.gjs-selected { background: #313244 !important; }
        .gjs-layer-title { border-bottom-color: #313244 !important; }
        .gjs-layer-name { color: #cdd6f4 !important; }

        /* Traits panel */
        .gjs-trt-trait { color: #cdd6f4 !important; }
        .gjs-trt-trait .gjs-label { color: #a6adc8 !important; }

        /* Toolbar */
        .gjs-toolbar { background: #313244 !important; }
        .gjs-toolbar-item { color: #cdd6f4 !important; }

        /* Scrollbars */
        .gjs-pn-views-container::-webkit-scrollbar,
        .gjs-blocks-cs::-webkit-scrollbar { width: 6px; }
        .gjs-pn-views-container::-webkit-scrollbar-track,
        .gjs-blocks-cs::-webkit-scrollbar-track { background: #181825; }
        .gjs-pn-views-container::-webkit-scrollbar-thumb,
        .gjs-blocks-cs::-webkit-scrollbar-thumb { background: #45475a; border-radius: 3px; }

        /* Modal overrides */
        .gjs-mdl-dialog { background: #1e1e2e !important; color: #cdd6f4 !important; border-radius: 12px !important; }
        .gjs-mdl-header { background: #181825 !important; border-bottom: 1px solid #313244 !important; }
        .gjs-mdl-title { color: #cdd6f4 !important; }
        .gjs-mdl-btn-close { color: #6c7086 !important; }

        /* RTE toolbar */
        .gjs-rte-toolbar { background: #313244 !important; border: 1px solid #45475a !important; border-radius: 6px !important; }
        .gjs-rte-actionbar { background: #313244 !important; }
        .gjs-rte-action { color: #cdd6f4 !important; border-right-color: #45475a !important; }

        /* ============ Modal shared styles ============ */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 1000;
            overflow-y: auto;
            display: none;
        }
        .modal-content {
            max-width: 900px;
            margin: 40px auto;
            background: #1e1e2e;
            border-radius: 12px;
            padding: 24px;
            color: #cdd6f4;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .modal-header h2 { font-size: 20px; font-weight: 600; }
        .modal-close {
            background: none;
            border: none;
            color: #6c7086;
            font-size: 24px;
            cursor: pointer;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.15s;
        }
        .modal-close:hover { background: #313244; color: #cdd6f4; }

        /* ============ AI Modal ============ */
        .ai-modal-content {
            max-width: 650px;
            margin: 40px auto;
            background: #1e1e2e;
            border-radius: 12px;
            padding: 24px;
            color: #cdd6f4;
        }
        .ai-tabs {
            display: flex;
            gap: 4px;
            margin-bottom: 20px;
            border-bottom: 1px solid #313244;
            padding-bottom: 12px;
        }
        .ai-tab {
            padding: 8px 16px;
            background: #313244;
            border: 1px solid #45475a;
            border-radius: 6px;
            color: #cdd6f4;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.15s;
            font-family: inherit;
        }
        .ai-tab:hover { border-color: #585b70; }
        .ai-tab.active { border-color: #89b4fa; color: #89b4fa; background: rgba(137,180,250,0.1); }

        .ai-panel { display: none; }
        .ai-panel.active { display: block; }

        .ai-field-label {
            display: block;
            font-size: 13px;
            margin-bottom: 4px;
            color: #a6adc8;
        }
        .ai-field-input {
            width: 100%;
            padding: 8px;
            background: #313244;
            border: 1px solid #45475a;
            border-radius: 6px;
            color: #cdd6f4;
            font-family: inherit;
        }
        .ai-field-input:focus { border-color: #89b4fa; outline: none; }

        .ai-submit-btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            font-family: inherit;
            transition: filter 0.15s;
        }
        .ai-submit-btn:hover { filter: brightness(1.1); }

        /* Variants cards */
        .variant-card {
            background: #313244;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 1px solid #45475a;
        }
        .variant-card p {
            font-size: 13px;
            line-height: 1.6;
            color: #cdd6f4;
            margin-bottom: 10px;
        }
        .variant-card .variant-apply {
            padding: 5px 14px;
            background: #a6e3a1;
            color: #1e1e2e;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
        }
        .variant-card .variant-apply:hover { filter: brightness(1.1); }

        @keyframes aispin { to { transform:rotate(360deg); } }

        /* ============ Effects badges in canvas ============ */
        .wc-fx-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            display: flex;
            gap: 2px;
            z-index: 5;
            pointer-events: none;
        }
        .wc-fx-badge span {
            display: inline-block;
            font-size: 9px;
            font-weight: 700;
            padding: 1px 4px;
            border-radius: 3px;
            color: #fff;
            line-height: 1.3;
            white-space: nowrap;
        }
        .wc-fx-badge .fx-anim { background: #6366f1; }
        .wc-fx-badge .fx-hover { background: #0ea5e9; }
        .wc-fx-badge .fx-lightbox { background: #f59e0b; }
        .wc-fx-badge .fx-typewriter { background: #ec4899; }
        .wc-fx-badge .fx-parallax { background: #8b5cf6; }
        .wc-fx-badge .fx-sticky { background: #14b8a6; }
        .wc-fx-badge .fx-carousel { background: #f97316; }
        .wc-fx-badge .fx-tabs { background: #06b6d4; }
        .wc-fx-badge .fx-progress { background: #22c55e; }
        .wc-fx-badge .fx-marquee { background: #a855f7; }
        .wc-fx-badge .fx-counter { background: #ef4444; }

        /* ============ SESSION PROTECTION STYLES START ============ */

        /* Connection status indicator (next to save dot) */
        .connection-indicator {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-right: 4px;
        }
        .connection-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #a6e3a1;
            transition: background 0.3s;
            flex-shrink: 0;
        }
        .connection-dot.connected { background: #a6e3a1; }
        .connection-dot.reconnecting { background: #f9e2af; animation: savePulse 1s ease-in-out infinite; }
        .connection-dot.disconnected { background: #f38ba8; }
        .connection-label {
            font-size: 10px;
            color: #585b70;
            white-space: nowrap;
            transition: color 0.3s;
        }
        .connection-dot.disconnected + .connection-label { color: #f38ba8; }
        .connection-dot.reconnecting + .connection-label { color: #f9e2af; }

        /* Session expired modal (persistent, no dismiss) */
        .session-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.75);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 20000;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: confirmFadeIn 0.2s ease-out;
        }
        .session-modal {
            background: #1e1e2e;
            border: 1px solid #313244;
            border-radius: 16px;
            padding: 32px;
            max-width: 450px;
            width: 90%;
            color: #cdd6f4;
            box-shadow: 0 24px 64px rgba(0,0,0,0.5);
            animation: confirmSlideIn 0.25s ease-out;
            text-align: center;
        }
        .session-modal .session-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            background: rgba(243,139,168,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .session-modal .session-icon svg {
            width: 28px;
            height: 28px;
            color: #f38ba8;
        }
        .session-modal h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .session-modal p {
            font-size: 14px;
            color: #a6adc8;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .session-modal .session-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .session-modal .btn-session-login {
            padding: 12px 20px;
            background: linear-gradient(135deg, #89b4fa 0%, #b4befe 100%);
            color: #1e1e2e;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: filter 0.15s;
        }
        .session-modal .btn-session-login:hover { filter: brightness(1.1); }
        .session-modal .btn-session-backup {
            padding: 10px 20px;
            background: #313244;
            color: #cdd6f4;
            border: 1px solid #45475a;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.15s;
        }
        .session-modal .btn-session-backup:hover { background: #45475a; border-color: #585b70; }

        /* Restore backup modal */
        .restore-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 15000;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: confirmFadeIn 0.2s ease-out;
        }
        .restore-modal {
            background: #1e1e2e;
            border: 1px solid #313244;
            border-radius: 16px;
            padding: 28px;
            max-width: 450px;
            width: 90%;
            color: #cdd6f4;
            box-shadow: 0 20px 48px rgba(0,0,0,0.5);
            animation: confirmSlideIn 0.25s ease-out;
        }
        .restore-modal h3 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .restore-modal p {
            font-size: 13px;
            color: #a6adc8;
            line-height: 1.6;
            margin-bottom: 6px;
        }
        .restore-modal .restore-timestamps {
            background: #181825;
            border-radius: 8px;
            padding: 12px;
            margin: 12px 0 20px;
            font-size: 12px;
            color: #a6adc8;
        }
        .restore-modal .restore-timestamps div {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
        }
        .restore-modal .restore-timestamps .label { color: #6c7086; }
        .restore-modal .restore-timestamps .value { color: #cdd6f4; font-weight: 500; }
        .restore-modal .restore-actions {
            display: flex;
            gap: 10px;
        }
        .restore-modal .btn-restore {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            border: none;
            transition: filter 0.15s;
        }
        .restore-modal .btn-restore.primary {
            background: linear-gradient(135deg, #a6e3a1 0%, #94e2d5 100%);
            color: #1e1e2e;
        }
        .restore-modal .btn-restore.primary:hover { filter: brightness(1.1); }
        .restore-modal .btn-restore.secondary {
            background: #313244;
            color: #cdd6f4;
            border: 1px solid #45475a;
        }
        .restore-modal .btn-restore.secondary:hover { background: #45475a; }

        /* ============ SESSION PROTECTION STYLES END ============ */
    </style>
</head>
<body>
    <div class="editor-wrapper">
        {{-- ============ Top Bar ============ --}}
        <div class="editor-topbar">
            {{-- LEFT: Back + Title + Status --}}
            <div class="left">
                <a href="/admin/pages" class="back-link" title="Volver al panel">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                </a>
                <input type="text" class="page-title-input" id="page-title-input" value="{{ $page->title }}" title="Clic para editar el t&iacute;tulo">
                <span class="page-status-badge {{ $page->status ?? 'draft' }}" id="status-badge">{{ $page->status ?? 'draft' }}</span>
            </div>

            {{-- CENTER: Undo/Redo + Devices --}}
            <div class="center">
                <div class="undo-redo-group">
                    <button class="btn-undo-redo" id="btn-undo" title="Deshacer (Ctrl+Z)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7v6h6"/><path d="M21 17a9 9 0 00-9-9 9 9 0 00-6.69 3L3 13"/></svg>
                    </button>
                    <button class="btn-undo-redo" id="btn-redo" title="Rehacer (Ctrl+Shift+Z)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 7v6h-6"/><path d="M3 17a9 9 0 019-9 9 9 0 016.69 3L21 13"/></svg>
                    </button>
                </div>

                <div class="topbar-divider"></div>

                <div class="device-group">
                    <div class="device-btns">
                        <button class="device-btn active" data-device="Desktop" data-label="Escritorio" data-dims="Ancho completo" title="Desktop">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        </button>
                        <button class="device-btn" data-device="Tablet" data-label="Tablet" data-dims="768px" title="Tablet">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                        </button>
                        <button class="device-btn" data-device="Mobile portrait" data-label="M&oacute;vil" data-dims="320px" title="Mobile">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                        </button>
                    </div>
                    <span class="device-label" id="device-label">Escritorio</span>
                </div>
            </div>

            {{-- RIGHT: Templates | AI | Save | Publish | Preview --}}
            <div class="right">
                {{-- Connection status indicator --}}
                <div class="connection-indicator" id="connection-indicator" title="Estado de conexi&oacute;n">
                    <div class="connection-dot connected" id="connection-dot"></div>
                    <span class="connection-label" id="connection-label"></span>
                </div>

                <div class="save-indicator" id="save-indicator">
                    <div class="save-dot saved" id="save-dot"></div>
                    <span class="save-tooltip" id="save-tooltip">Sin cambios</span>
                </div>

                <div class="topbar-divider"></div>

                <button class="btn-editor btn-templates-bar" id="btn-templates" title="Elegir template">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Templates
                </button>
                <button class="btn-editor btn-ai-wizard" id="btn-ai" title="Asistente IA">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"/></svg>
                    IA Wizard
                </button>

                <div class="topbar-divider"></div>

                <button class="btn-editor btn-ghost" id="btn-save" title="Guardar borrador (Ctrl+S)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Guardar
                </button>
                <button class="btn-editor btn-publish-bar" id="btn-publish" title="Publicar p&aacute;gina">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    Publicar
                </button>
                <button class="btn-editor btn-subtle" id="btn-preview" title="Vista previa (nueva pesta&ntilde;a)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                </button>
            </div>
        </div>

        {{-- GrapesJS Editor --}}
        <div class="editor-main">
            <div id="gjs"></div>
        </div>
    </div>

    {{-- Toast Container --}}
    <div class="toast-container" id="toast-container"></div>

    {{-- Quick Add Floating Button --}}
    <button class="quick-add-btn" id="quick-add-btn" title="Agregar contenido">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    </button>
    <div class="quick-add-menu" id="quick-add-menu">
        <button class="quick-add-item" id="qa-blocks">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Agregar bloque
        </button>
        <button class="quick-add-item" id="qa-ai">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"/></svg>
            Generar con IA
        </button>
    </div>

    {{-- Template Picker Modal --}}
    <div id="template-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Elegir Template</h2>
                <button id="close-template-modal" class="modal-close">&times;</button>
            </div>
            <div id="template-grid" style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px;">
                {{-- Templates loaded via JS --}}
            </div>
        </div>
    </div>

    {{-- AI Assistant Modal (Simplified: 3 tabs) --}}
    <div id="ai-modal" class="modal-overlay">
        <div class="ai-modal-content">
            <div class="modal-header">
                <h2>Asistente IA</h2>
                <button id="close-ai-modal" class="modal-close">&times;</button>
            </div>

            {{-- Tab Navigation: 3 tabs --}}
            <div class="ai-tabs" id="ai-tabs">
                <button class="ai-tab active" data-tab="generate">Generar</button>
                <button class="ai-tab" data-tab="translate">Traducir</button>
                <button class="ai-tab" data-tab="variants">Variantes</button>
            </div>

            {{-- Generate Tab (merged text + page generation) --}}
            <div class="ai-panel active" id="ai-panel-generate">
                <div style="margin-bottom:14px;">
                    <label class="ai-field-label">Modo</label>
                    <select id="ai-gen-mode" class="ai-field-input" style="margin-bottom:4px;">
                        <option value="section">Generar texto para secci&oacute;n</option>
                        <option value="page">Generar p&aacute;gina completa</option>
                    </select>
                </div>

                {{-- Section mode fields --}}
                <div id="ai-section-fields">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                        <div>
                            <label class="ai-field-label">Tipo de secci&oacute;n</label>
                            <select id="ai-section-type" class="ai-field-input">
                                <option value="hero">Hero / Banner</option>
                                <option value="features">Caracter&iacute;sticas</option>
                                <option value="about">Sobre Nosotros</option>
                                <option value="services">Servicios</option>
                                <option value="testimonials">Testimonios</option>
                                <option value="cta">Call to Action</option>
                                <option value="pricing">Precios</option>
                                <option value="faq">FAQ</option>
                                <option value="contact">Contacto</option>
                            </select>
                        </div>
                        <div>
                            <label class="ai-field-label">Tipo de negocio</label>
                            <input id="ai-business-type" type="text" placeholder="ej: restaurante, startup..." class="ai-field-input">
                        </div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                        <div>
                            <label class="ai-field-label">Tono</label>
                            <select id="ai-tone" class="ai-field-input">
                                <option value="profesional">Profesional</option>
                                <option value="casual">Casual</option>
                                <option value="formal">Formal</option>
                                <option value="divertido">Divertido</option>
                                <option value="inspirador">Inspirador</option>
                            </select>
                        </div>
                        <div>
                            <label class="ai-field-label">Idioma</label>
                            <select id="ai-lang" class="ai-field-input">
                                <option value="es">Espa&ntilde;ol</option>
                                <option value="en">English</option>
                                <option value="pt">Portugu&ecirc;s</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Page mode fields --}}
                <div id="ai-page-fields" style="display:none;">
                    <div style="margin-bottom:12px;">
                        <label class="ai-field-label">Tipo de negocio</label>
                        <input id="ai-page-biz" type="text" placeholder="ej: cl&iacute;nica dental..." class="ai-field-input">
                    </div>
                    <div style="margin-bottom:12px;">
                        <label class="ai-field-label">Descripci&oacute;n</label>
                        <textarea id="ai-page-desc" rows="3" placeholder="Describe tu negocio..." class="ai-field-input" style="resize:vertical;"></textarea>
                    </div>
                    <p style="font-size:12px; color:#6c7086; margin-bottom:12px;">Esto reemplazar&aacute; todo el contenido actual de la p&aacute;gina.</p>
                </div>

                <button id="ai-gen-btn" class="ai-submit-btn" style="background:linear-gradient(135deg, #89b4fa 0%, #b4befe 100%); color:#1e1e2e;">Generar</button>
            </div>

            {{-- Translate Tab --}}
            <div class="ai-panel" id="ai-panel-translate">
                <p style="font-size:13px; color:#a6adc8; margin-bottom:12px;">Selecciona un componente en el editor y trad&uacute;celo al idioma deseado.</p>
                <label class="ai-field-label">Idioma destino</label>
                <select id="ai-target-lang" class="ai-field-input" style="margin-bottom:12px;">
                    <option value="en">English</option>
                    <option value="es">Espa&ntilde;ol</option>
                    <option value="pt">Portugu&ecirc;s</option>
                    <option value="fr">Fran&ccedil;ais</option>
                </select>
                <button id="ai-translate-btn" class="ai-submit-btn" style="background:#f9e2af; color:#1e1e2e;">Traducir</button>
            </div>

            {{-- Variants Tab --}}
            <div class="ai-panel" id="ai-panel-variants">
                <p style="font-size:13px; color:#a6adc8; margin-bottom:12px;">Selecciona un texto en el editor para generar 3 variantes con bot&oacute;n individual de aplicar.</p>
                <label class="ai-field-label">Tono</label>
                <select id="ai-var-tone" class="ai-field-input" style="margin-bottom:12px;">
                    <option value="profesional">Profesional</option>
                    <option value="casual">Casual</option>
                    <option value="formal">Formal</option>
                </select>
                <button id="ai-var-btn" class="ai-submit-btn" style="background:linear-gradient(135deg, #cba6f7 0%, #f38ba8 100%); color:#1e1e2e;">Generar Variantes</button>
            </div>

            {{-- Loading --}}
            <div id="ai-loading" style="display:none; text-align:center; padding:20px;">
                <div style="display:inline-block; width:24px; height:24px; border:3px solid #45475a; border-top-color:#89b4fa; border-radius:50%; animation:aispin 0.8s linear infinite;"></div>
                <p style="margin-top:8px; color:#a6adc8;">Generando...</p>
            </div>

            {{-- Result (for text, translate, page) --}}
            <div id="ai-result" style="display:none; margin-top:16px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <span style="font-size:13px; font-weight:600; color:#a6adc8;">Resultado:</span>
                    <button id="ai-apply-btn" style="padding:6px 16px; background:#a6e3a1; color:#1e1e2e; border:none; border-radius:6px; font-weight:600; cursor:pointer; font-size:13px;">Aplicar</button>
                </div>
                <div id="ai-result-content" style="background:#313244; padding:16px; border-radius:8px; font-size:13px; line-height:1.6; max-height:250px; overflow-y:auto; white-space:pre-wrap;"></div>
            </div>

            {{-- Variants result (shows all 3 with individual apply buttons) --}}
            <div id="ai-variants-result" style="display:none; margin-top:16px;">
                <span style="font-size:13px; font-weight:600; color:#a6adc8; display:block; margin-bottom:10px;">3 Variantes:</span>
                <div id="ai-variants-list"></div>
            </div>
        </div>
    </div>

    {{-- GrapesJS core --}}
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-preset-webpage"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic"></script>

    <script>
    (function() {
        'use strict';

        // =====================================================================
        // Configuration
        // =====================================================================
        var PAGE_ID = {{ $page->id }};
        var PAGE_SLUG = '{{ $page->slug }}';
        var LOAD_URL = '/api/pages/' + PAGE_ID + '/load';
        var STORE_URL = '/api/pages/' + PAGE_ID + '/store';
        var TEMPLATES_URL = '/api/templates';
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
        var FONTS = [
            'Inter', 'Roboto', 'Open Sans', 'Montserrat', 'Poppins',
            'Lato', 'Playfair Display', 'Merriweather', 'Raleway', 'Space Grotesk'
        ];
        var currentStatus = '{{ $page->status ?? "draft" }}';
        var hasUnsavedChanges = false;
        var lastSaveTime = null;

        // =====================================================================
        // Reusable Confirm Dialog
        // =====================================================================
        function showConfirm(title, message, onConfirm, danger) {
            var overlay = document.createElement('div');
            overlay.className = 'confirm-overlay';
            overlay.innerHTML = '<div class="confirm-dialog">'
                + '<h3>' + title + '</h3>'
                + '<p>' + message + '</p>'
                + '<div class="confirm-actions">'
                + '<button class="confirm-cancel">Cancelar</button>'
                + '<button class="confirm-ok' + (danger ? ' danger' : '') + '">Continuar</button>'
                + '</div>'
                + '</div>';

            document.body.appendChild(overlay);

            overlay.querySelector('.confirm-cancel').addEventListener('click', function() {
                document.body.removeChild(overlay);
            });
            overlay.querySelector('.confirm-ok').addEventListener('click', function() {
                document.body.removeChild(overlay);
                onConfirm();
            });
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) document.body.removeChild(overlay);
            });
        }

        // =====================================================================
        // Toast Notification System
        // =====================================================================
        function showToast(message, type, duration) {
            type = type || 'info';
            duration = duration || 3000;
            var container = document.getElementById('toast-container');
            var toast = document.createElement('div');
            toast.className = 'toast ' + type;

            var icon = '';
            if (type === 'success') icon = '&#10003; ';
            else if (type === 'error') icon = '&#10007; ';
            else icon = '&#9432; ';

            toast.innerHTML = '<span>' + icon + '</span><span>' + message + '</span>';
            container.appendChild(toast);

            setTimeout(function() {
                toast.classList.add('hiding');
                setTimeout(function() {
                    if (toast.parentNode) toast.parentNode.removeChild(toast);
                }, 300);
            }, duration);
        }

        // =====================================================================
        // Save Status Indicator
        // =====================================================================
        function updateSaveDot(state, time) {
            var dot = document.getElementById('save-dot');
            var tooltip = document.getElementById('save-tooltip');
            dot.className = 'save-dot ' + state;

            if (state === 'saved') {
                lastSaveTime = time || new Date();
                hasUnsavedChanges = false;
                tooltip.textContent = 'Guardado: ' + lastSaveTime.toLocaleTimeString('es-CL', {hour:'2-digit', minute:'2-digit'});
            } else if (state === 'unsaved') {
                hasUnsavedChanges = true;
                tooltip.textContent = 'Cambios sin guardar';
            } else if (state === 'saving') {
                tooltip.textContent = 'Guardando...';
            } else if (state === 'error') {
                tooltip.textContent = 'Error al guardar';
            }
        }

        // =====================================================================
        // Status Badge Update
        // =====================================================================
        function updateStatusBadge(status) {
            currentStatus = status;
            var badge = document.getElementById('status-badge');
            badge.textContent = status;
            badge.className = 'page-status-badge ' + status;
        }

        // =====================================================================
        // GrapesJS Initialization
        // =====================================================================
        var editor = grapesjs.init({
            container: '#gjs',
            fromElement: false,
            height: '100%',
            width: 'auto',
            storageManager: false,

            // Device manager for responsive editing
            deviceManager: {
                devices: [
                    { name: 'Desktop', width: '' },
                    { name: 'Tablet', width: '768px', widthMedia: '992px' },
                    { name: 'Mobile portrait', width: '320px', widthMedia: '480px' },
                ]
            },

            // Canvas styling — load Google Fonts inside the iframe
            canvas: {
                styles: [
                    'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&family=Lato:wght@300;400;700&family=Playfair+Display:wght@400;500;600;700&family=Merriweather:wght@300;400;700&family=Raleway:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap',
                ],
            },

            // Plugins
            plugins: ['gjs-preset-webpage', 'gjs-blocks-basic'],
            pluginsOpts: {
                'gjs-preset-webpage': {
                    modalImportTitle: 'Importar HTML',
                    modalImportLabel: '<div style="margin-bottom:10px;">Pega tu HTML/CSS aqu\u00ed</div>',
                    modalImportContent: '',
                    filestackOpts: null,
                    aviaryOpts: false,
                    blocksBasicOpts: { flexGrid: true },
                    customStyleManager: [],
                },
                'gjs-blocks-basic': {
                    flexGrid: true,
                    stylePrefix: 'gjs-',
                    addBasicStyle: true,
                    category: 'Layout',
                    labelColumn1: '1 Columna',
                    labelColumn2: '2 Columnas',
                    labelColumn3: '3 Columnas',
                    labelColumn37: '2 Columnas 3/7',
                    labelText: 'Texto',
                    labelLink: 'Enlace',
                    labelImage: 'Imagen',
                    labelVideo: 'Video',
                    labelMap: 'Mapa',
                },
            },

            // Style manager sectors
            styleManager: {
                sectors: [
                    {
                        name: 'Layout',
                        open: true,
                        properties: [
                            'display',
                            {
                                extend: 'float',
                                type: 'radio',
                                default: 'none',
                                options: [
                                    { value: 'none', className: 'fa fa-times' },
                                    { value: 'left', className: 'fa fa-align-left' },
                                    { value: 'right', className: 'fa fa-align-right' },
                                ]
                            },
                            { extend: 'position', type: 'select' },
                            'top', 'right', 'left', 'bottom',
                            'width', 'height', 'max-width', 'min-height',
                            'margin', 'padding',
                            'flex-direction', 'flex-wrap', 'justify-content',
                            'align-items', 'align-content', 'order',
                            'flex-basis', 'flex-grow', 'flex-shrink', 'align-self', 'gap',
                        ],
                    },
                    {
                        name: 'Tipograf\u00eda',
                        open: false,
                        properties: [
                            {
                                property: 'font-family',
                                type: 'select',
                                defaults: 'Inter, sans-serif',
                                options: FONTS.map(function(f) {
                                    return { value: f + ', sans-serif', name: f };
                                }),
                            },
                            'font-size',
                            {
                                extend: 'font-weight',
                                type: 'select',
                                defaults: '400',
                                options: [
                                    { value: '300', name: 'Light (300)' },
                                    { value: '400', name: 'Regular (400)' },
                                    { value: '500', name: 'Medium (500)' },
                                    { value: '600', name: 'Semibold (600)' },
                                    { value: '700', name: 'Bold (700)' },
                                ],
                            },
                            'letter-spacing',
                            'color',
                            'line-height',
                            {
                                extend: 'text-align',
                                options: [
                                    { id: 'left', label: 'Left', className: 'fa fa-align-left' },
                                    { id: 'center', label: 'Center', className: 'fa fa-align-center' },
                                    { id: 'right', label: 'Right', className: 'fa fa-align-right' },
                                    { id: 'justify', label: 'Justify', className: 'fa fa-align-justify' },
                                ],
                            },
                            'text-decoration',
                            'text-transform',
                        ],
                    },
                    {
                        name: 'Decoraciones',
                        open: false,
                        properties: [
                            'background-color',
                            'background-image',
                            'background-repeat',
                            'background-position',
                            'background-size',
                            'background-attachment',
                            'border-radius',
                            'border',
                            'box-shadow',
                        ],
                    },
                    {
                        name: 'Extra',
                        open: false,
                        properties: [
                            'opacity',
                            'transition',
                            'transform',
                            'cursor',
                            'overflow',
                        ],
                    },
                ],
            },
        });

        // Track changes for unsaved indicator + localStorage backup
        editor.on('component:update', function() { updateSaveDot('unsaved'); debouncedBackup(); });
        editor.on('component:add', function() { updateSaveDot('unsaved'); debouncedBackup(); });
        editor.on('component:remove', function() { updateSaveDot('unsaved'); debouncedBackup(); });
        editor.on('style:property:update', function() { updateSaveDot('unsaved'); debouncedBackup(); });

        // =====================================================================
        // Custom Blocks — organized into categories
        // =====================================================================
        var bm = editor.BlockManager;

        // --- Secciones category (open by default) ---

        bm.add('hero-section', {
            label: 'Hero Section',
            category: 'Secciones',
            content: '<section style="padding:100px 20px; text-align:center; background:linear-gradient(135deg, #6366f1 0%, #0ea5e9 100%); color:#fff;">'
                + '<div style="max-width:800px; margin:0 auto;">'
                + '<h1 style="font-size:52px; font-weight:700; margin-bottom:20px; font-family:Montserrat, sans-serif; line-height:1.1;">Tu T\u00edtulo Principal Aqu\u00ed</h1>'
                + '<p style="font-size:20px; margin-bottom:36px; opacity:0.9; line-height:1.6;">Una descripci\u00f3n breve y convincente de tu producto o servicio que capte la atenci\u00f3n del visitante.</p>'
                + '<a href="#" style="display:inline-block; padding:16px 36px; background:#fff; color:#6366f1; border-radius:8px; text-decoration:none; font-weight:600; font-size:16px; transition:transform 0.2s;">Comenzar Ahora</a>'
                + '</div>'
                + '</section>',
            attributes: { class: 'gjs-fonts gjs-f-hero' },
        });

        bm.add('features-grid', {
            label: 'Feature Grid',
            category: 'Secciones',
            content: '<section style="padding:80px 20px; background:#fff;">'
                + '<div style="max-width:1100px; margin:0 auto; text-align:center;">'
                + '<h2 style="font-size:36px; font-weight:700; margin-bottom:16px; color:#1e293b;">Nuestras Caracter\u00edsticas</h2>'
                + '<p style="color:#64748b; margin-bottom:48px; font-size:18px;">Todo lo que necesitas en un solo lugar</p>'
                + '<div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:32px;">'
                + '<div style="padding:32px; border-radius:12px; background:#f8fafc; text-align:center;">'
                + '<div style="width:64px; height:64px; background:#eef2ff; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:28px;">&#9889;</div>'
                + '<h3 style="font-size:20px; font-weight:600; margin-bottom:8px; color:#1e293b;">R\u00e1pido</h3>'
                + '<p style="color:#64748b; line-height:1.6;">Rendimiento optimizado para la mejor experiencia de usuario.</p>'
                + '</div>'
                + '<div style="padding:32px; border-radius:12px; background:#f8fafc; text-align:center;">'
                + '<div style="width:64px; height:64px; background:#fef3c7; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:28px;">&#127912;</div>'
                + '<h3 style="font-size:20px; font-weight:600; margin-bottom:8px; color:#1e293b;">Personalizable</h3>'
                + '<p style="color:#64748b; line-height:1.6;">Adapta cada detalle a la identidad de tu marca.</p>'
                + '</div>'
                + '<div style="padding:32px; border-radius:12px; background:#f8fafc; text-align:center;">'
                + '<div style="width:64px; height:64px; background:#dcfce7; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:28px;">&#128274;</div>'
                + '<h3 style="font-size:20px; font-weight:600; margin-bottom:8px; color:#1e293b;">Seguro</h3>'
                + '<p style="color:#64748b; line-height:1.6;">Protecci\u00f3n de datos de nivel empresarial.</p>'
                + '</div>'
                + '</div>'
                + '</div>'
                + '</section>',
        });

        bm.add('testimonial-card', {
            label: 'Testimonios',
            category: 'Secciones',
            content: '<section style="padding:80px 20px; background:#f8fafc;">'
                + '<div style="max-width:1100px; margin:0 auto; text-align:center;">'
                + '<h2 style="font-size:36px; font-weight:700; margin-bottom:48px; color:#1e293b;">Lo que dicen nuestros clientes</h2>'
                + '<div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:24px;">'
                + '<div style="background:#fff; padding:32px; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.1); text-align:left;">'
                + '<div style="color:#f59e0b; font-size:18px; margin-bottom:12px;">&#9733;&#9733;&#9733;&#9733;&#9733;</div>'
                + '<p style="color:#475569; margin-bottom:20px; font-style:italic; line-height:1.7;">"Excelente servicio, super\u00f3 todas nuestras expectativas."</p>'
                + '<div style="display:flex; align-items:center; gap:12px;">'
                + '<div style="width:44px; height:44px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; font-weight:600; color:#64748b;">MG</div>'
                + '<div><div style="font-weight:600; color:#1e293b;">Mar\u00eda Garc\u00eda</div><div style="color:#94a3b8; font-size:14px;">CEO, StartupXYZ</div></div>'
                + '</div>'
                + '</div>'
                + '<div style="background:#fff; padding:32px; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.1); text-align:left;">'
                + '<div style="color:#f59e0b; font-size:18px; margin-bottom:12px;">&#9733;&#9733;&#9733;&#9733;&#9733;</div>'
                + '<p style="color:#475569; margin-bottom:20px; font-style:italic; line-height:1.7;">"La mejor decisi\u00f3n para nuestro negocio. Resultados incre\u00edbles."</p>'
                + '<div style="display:flex; align-items:center; gap:12px;">'
                + '<div style="width:44px; height:44px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; font-weight:600; color:#64748b;">CL</div>'
                + '<div><div style="font-weight:600; color:#1e293b;">Carlos L\u00f3pez</div><div style="color:#94a3b8; font-size:14px;">Director, TechCorp</div></div>'
                + '</div>'
                + '</div>'
                + '<div style="background:#fff; padding:32px; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.1); text-align:left;">'
                + '<div style="color:#f59e0b; font-size:18px; margin-bottom:12px;">&#9733;&#9733;&#9733;&#9733;&#9733;</div>'
                + '<p style="color:#475569; margin-bottom:20px; font-style:italic; line-height:1.7;">"F\u00e1cil de usar y los resultados son muy profesionales."</p>'
                + '<div style="display:flex; align-items:center; gap:12px;">'
                + '<div style="width:44px; height:44px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; font-weight:600; color:#64748b;">AM</div>'
                + '<div><div style="font-weight:600; color:#1e293b;">Ana Mart\u00ednez</div><div style="color:#94a3b8; font-size:14px;">Dise\u00f1adora, CreativeStudio</div></div>'
                + '</div>'
                + '</div>'
                + '</div>'
                + '</div>'
                + '</section>',
        });

        bm.add('image-text-side', {
            label: 'Imagen + Texto',
            category: 'Secciones',
            content: '<section style="padding:80px 20px; background:#fff;">'
                + '<div style="max-width:1100px; margin:0 auto; display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:center;">'
                + '<div>'
                + '<img src="https://picsum.photos/600/400" alt="Imagen" style="width:100%; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1);">'
                + '</div>'
                + '<div>'
                + '<h2 style="font-size:36px; font-weight:700; margin-bottom:16px; color:#1e293b; line-height:1.2;">Sobre Nosotros</h2>'
                + '<p style="font-size:18px; color:#64748b; margin-bottom:24px; line-height:1.7;">Somos un equipo apasionado por crear soluciones innovadoras que transforman negocios.</p>'
                + '<a href="#" style="display:inline-block; padding:12px 28px; background:#6366f1; color:#fff; border-radius:8px; text-decoration:none; font-weight:600; font-size:16px;">Conocer M\u00e1s</a>'
                + '</div>'
                + '</div>'
                + '</section>',
        });

        bm.add('pricing-table', {
            label: 'Tabla de Precios',
            category: 'Secciones',
            content: '<section style="padding:80px 20px; background:#fff;">'
                + '<div style="max-width:1100px; margin:0 auto; text-align:center;">'
                + '<h2 style="font-size:36px; font-weight:700; margin-bottom:16px; color:#1e293b;">Planes y Precios</h2>'
                + '<p style="color:#64748b; margin-bottom:48px; font-size:18px;">Elige el plan perfecto para ti</p>'
                + '<div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:24px; align-items:start;">'
                + '<div style="border:1px solid #e2e8f0; border-radius:16px; padding:36px 28px; text-align:center;">'
                + '<h3 style="font-size:22px; font-weight:600; margin-bottom:8px; color:#1e293b;">B\u00e1sico</h3>'
                + '<p style="color:#94a3b8; font-size:14px; margin-bottom:16px;">Para empezar</p>'
                + '<div style="font-size:48px; font-weight:700; margin:16px 0; color:#1e293b;">$9<span style="font-size:16px; font-weight:400; color:#94a3b8;">/mes</span></div>'
                + '<ul style="list-style:none; padding:0; margin-bottom:28px; color:#475569; font-size:15px;">'
                + '<li style="padding:10px 0; border-bottom:1px solid #f1f5f9;">5 P\u00e1ginas</li>'
                + '<li style="padding:10px 0; border-bottom:1px solid #f1f5f9;">1 GB Almacenamiento</li>'
                + '<li style="padding:10px 0;">Soporte Email</li>'
                + '</ul>'
                + '<a href="#" style="display:block; padding:14px; border:2px solid #6366f1; color:#6366f1; border-radius:8px; text-decoration:none; font-weight:600;">Elegir Plan</a>'
                + '</div>'
                + '<div style="border:2px solid #6366f1; border-radius:16px; padding:36px 28px; text-align:center; position:relative; box-shadow:0 8px 30px rgba(99,102,241,0.15);">'
                + '<div style="position:absolute; top:-14px; left:50%; transform:translateX(-50%); background:#6366f1; color:#fff; padding:5px 20px; border-radius:20px; font-size:13px; font-weight:600;">Popular</div>'
                + '<h3 style="font-size:22px; font-weight:600; margin-bottom:8px; color:#1e293b;">Pro</h3>'
                + '<p style="color:#94a3b8; font-size:14px; margin-bottom:16px;">Para crecer</p>'
                + '<div style="font-size:48px; font-weight:700; margin:16px 0; color:#1e293b;">$29<span style="font-size:16px; font-weight:400; color:#94a3b8;">/mes</span></div>'
                + '<ul style="list-style:none; padding:0; margin-bottom:28px; color:#475569; font-size:15px;">'
                + '<li style="padding:10px 0; border-bottom:1px solid #f1f5f9;">P\u00e1ginas ilimitadas</li>'
                + '<li style="padding:10px 0; border-bottom:1px solid #f1f5f9;">10 GB Almacenamiento</li>'
                + '<li style="padding:10px 0;">Soporte Prioritario</li>'
                + '</ul>'
                + '<a href="#" style="display:block; padding:14px; background:#6366f1; color:#fff; border-radius:8px; text-decoration:none; font-weight:600;">Elegir Plan</a>'
                + '</div>'
                + '<div style="border:1px solid #e2e8f0; border-radius:16px; padding:36px 28px; text-align:center;">'
                + '<h3 style="font-size:22px; font-weight:600; margin-bottom:8px; color:#1e293b;">Enterprise</h3>'
                + '<p style="color:#94a3b8; font-size:14px; margin-bottom:16px;">Para escalar</p>'
                + '<div style="font-size:48px; font-weight:700; margin:16px 0; color:#1e293b;">$99<span style="font-size:16px; font-weight:400; color:#94a3b8;">/mes</span></div>'
                + '<ul style="list-style:none; padding:0; margin-bottom:28px; color:#475569; font-size:15px;">'
                + '<li style="padding:10px 0; border-bottom:1px solid #f1f5f9;">Todo ilimitado</li>'
                + '<li style="padding:10px 0; border-bottom:1px solid #f1f5f9;">100 GB Almacenamiento</li>'
                + '<li style="padding:10px 0;">Soporte 24/7</li>'
                + '</ul>'
                + '<a href="#" style="display:block; padding:14px; border:2px solid #6366f1; color:#6366f1; border-radius:8px; text-decoration:none; font-weight:600;">Elegir Plan</a>'
                + '</div>'
                + '</div>'
                + '</div>'
                + '</section>',
        });

        bm.add('faq-accordion', {
            label: 'FAQ Acorde\u00f3n',
            category: 'Secciones',
            content: '<section style="padding:80px 20px; background:#fff;">'
                + '<div style="max-width:750px; margin:0 auto;">'
                + '<h2 style="font-size:36px; font-weight:700; margin-bottom:16px; text-align:center; color:#1e293b;">Preguntas Frecuentes</h2>'
                + '<p style="text-align:center; color:#64748b; margin-bottom:40px; font-size:18px;">Encuentra respuestas a las preguntas m\u00e1s comunes</p>'
                + '<div style="display:flex; flex-direction:column; gap:12px;">'
                + '<details style="background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0;">'
                + '<summary style="padding:18px 20px; cursor:pointer; font-weight:600; font-size:16px; color:#1e293b; list-style:none;">\u00bfC\u00f3mo funciona el servicio?</summary>'
                + '<div style="padding:0 20px 18px; color:#64748b; line-height:1.7;">Nuestro servicio te permite crear tu sitio web de manera visual, arrastrando y soltando componentes.</div>'
                + '</details>'
                + '<details style="background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0;">'
                + '<summary style="padding:18px 20px; cursor:pointer; font-weight:600; font-size:16px; color:#1e293b; list-style:none;">\u00bfPuedo cambiar de plan?</summary>'
                + '<div style="padding:0 20px 18px; color:#64748b; line-height:1.7;">S\u00ed, puedes actualizar o cambiar tu plan en cualquier momento desde tu panel de administraci\u00f3n.</div>'
                + '</details>'
                + '<details style="background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0;">'
                + '<summary style="padding:18px 20px; cursor:pointer; font-weight:600; font-size:16px; color:#1e293b; list-style:none;">\u00bfOfrecen soporte t\u00e9cnico?</summary>'
                + '<div style="padding:0 20px 18px; color:#64748b; line-height:1.7;">Todos los planes incluyen soporte t\u00e9cnico. Los planes Pro y Enterprise cuentan con soporte prioritario.</div>'
                + '</details>'
                + '<details style="background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0;">'
                + '<summary style="padding:18px 20px; cursor:pointer; font-weight:600; font-size:16px; color:#1e293b; list-style:none;">\u00bfHay prueba gratuita?</summary>'
                + '<div style="padding:0 20px 18px; color:#64748b; line-height:1.7;">S\u00ed, ofrecemos 14 d\u00edas de prueba gratuita en todos los planes.</div>'
                + '</details>'
                + '</div>'
                + '</div>'
                + '</section>',
        });

        bm.add('stats-counter', {
            label: 'Estad\u00edsticas',
            category: 'Secciones',
            content: '<section style="padding:80px 20px; background:linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color:#fff;">'
                + '<div style="max-width:1100px; margin:0 auto;">'
                + '<h2 style="font-size:36px; font-weight:700; margin-bottom:48px; text-align:center;">Nuestros N\u00fameros</h2>'
                + '<div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:32px; text-align:center;">'
                + '<div><div style="font-size:48px; font-weight:700; color:#89b4fa; margin-bottom:8px;">500+</div><div style="font-size:16px; color:#94a3b8; text-transform:uppercase; letter-spacing:1px;">Clientes</div></div>'
                + '<div><div style="font-size:48px; font-weight:700; color:#a6e3a1; margin-bottom:8px;">1200+</div><div style="font-size:16px; color:#94a3b8; text-transform:uppercase; letter-spacing:1px;">Proyectos</div></div>'
                + '<div><div style="font-size:48px; font-weight:700; color:#f9e2af; margin-bottom:8px;">98%</div><div style="font-size:16px; color:#94a3b8; text-transform:uppercase; letter-spacing:1px;">Satisfacci\u00f3n</div></div>'
                + '<div><div style="font-size:48px; font-weight:700; color:#f38ba8; margin-bottom:8px;">10+</div><div style="font-size:16px; color:#94a3b8; text-transform:uppercase; letter-spacing:1px;">A\u00f1os</div></div>'
                + '</div>'
                + '</div>'
                + '</section>',
        });

        bm.add('cta-section', {
            label: 'Call to Action',
            category: 'Secciones',
            content: '<section style="padding:80px 20px; background:#1e293b; text-align:center; color:#fff;">'
                + '<div style="max-width:700px; margin:0 auto;">'
                + '<h2 style="font-size:36px; font-weight:700; margin-bottom:16px;">\u00bfListo para empezar?</h2>'
                + '<p style="font-size:18px; opacity:0.8; margin-bottom:32px;">\u00danete a miles de usuarios que ya conf\u00edan en nosotros.</p>'
                + '<a href="#" style="display:inline-block; padding:16px 40px; background:#6366f1; color:#fff; border-radius:8px; text-decoration:none; font-weight:600; font-size:16px;">Empezar Gratis</a>'
                + '</div>'
                + '</section>',
        });

        bm.add('footer', {
            label: 'Footer',
            category: 'Secciones',
            content: '<footer style="padding:48px 20px; background:#1e293b; color:#94a3b8;">'
                + '<div style="max-width:1100px; margin:0 auto; display:grid; grid-template-columns:repeat(4, 1fr); gap:32px;">'
                + '<div><h4 style="color:#fff; font-size:18px; font-weight:600; margin-bottom:16px;">Tu Marca</h4><p style="font-size:14px; line-height:1.6;">Descripci\u00f3n breve de tu empresa.</p></div>'
                + '<div><h4 style="color:#fff; font-size:16px; font-weight:600; margin-bottom:16px;">Enlaces</h4><ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:8px;"><li><a href="#" style="color:#94a3b8; text-decoration:none; font-size:14px;">Inicio</a></li><li><a href="#" style="color:#94a3b8; text-decoration:none; font-size:14px;">Nosotros</a></li><li><a href="#" style="color:#94a3b8; text-decoration:none; font-size:14px;">Servicios</a></li><li><a href="#" style="color:#94a3b8; text-decoration:none; font-size:14px;">Contacto</a></li></ul></div>'
                + '<div><h4 style="color:#fff; font-size:16px; font-weight:600; margin-bottom:16px;">Legal</h4><ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:8px;"><li><a href="#" style="color:#94a3b8; text-decoration:none; font-size:14px;">Privacidad</a></li><li><a href="#" style="color:#94a3b8; text-decoration:none; font-size:14px;">T\u00e9rminos</a></li></ul></div>'
                + '<div><h4 style="color:#fff; font-size:16px; font-weight:600; margin-bottom:16px;">Contacto</h4><p style="font-size:14px; line-height:1.8;">info@tuempresa.com<br>+56 9 1234 5678</p></div>'
                + '</div>'
                + '<div style="border-top:1px solid #334155; margin-top:32px; padding-top:24px; text-align:center; font-size:13px;">&copy; 2026 Tu Empresa. Todos los derechos reservados.</div>'
                + '</footer>',
        });

        // --- B\u00e1sicos category ---

        bm.add('section-container', {
            label: 'Secci\u00f3n',
            category: 'B\u00e1sicos',
            content: '<section style="padding:60px 20px;"><div style="max-width:1100px; margin:0 auto;"></div></section>',
        });

        bm.add('heading', {
            label: 'T\u00edtulo',
            category: 'B\u00e1sicos',
            content: '<h2 style="font-size:32px; font-weight:700; margin-bottom:16px; color:#1e293b;">Tu T\u00edtulo Aqu\u00ed</h2>',
        });

        bm.add('paragraph', {
            label: 'P\u00e1rrafo',
            category: 'B\u00e1sicos',
            content: '<p style="font-size:16px; line-height:1.7; color:#475569;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
        });

        bm.add('button', {
            label: 'Bot\u00f3n',
            category: 'B\u00e1sicos',
            content: '<a href="#" style="display:inline-block; padding:12px 28px; background:#6366f1; color:#fff; border-radius:8px; text-decoration:none; font-weight:600; font-size:16px;">Bot\u00f3n</a>',
        });

        bm.add('divider', {
            label: 'Separador',
            category: 'B\u00e1sicos',
            content: '<hr style="border:none; border-top:1px solid #e2e8f0; margin:32px 0;">',
        });

        bm.add('spacer', {
            label: 'Espaciador',
            category: 'B\u00e1sicos',
            content: '<div style="height:60px;"></div>',
        });

        bm.add('image-caption', {
            label: 'Imagen + Pie',
            category: 'B\u00e1sicos',
            content: '<figure style="text-align:center; margin:0;">'
                + '<img src="https://picsum.photos/800/400" style="width:100%; border-radius:8px;" alt="Imagen">'
                + '<figcaption style="margin-top:8px; color:#64748b; font-size:14px;">Descripci\u00f3n de la imagen</figcaption>'
                + '</figure>',
        });

        // --- Formularios category ---

        bm.add('contact-form', {
            label: 'Formulario Contacto',
            category: 'Formularios',
            content: '<section style="padding:80px 20px; background:#f8fafc;">'
                + '<div style="max-width:600px; margin:0 auto;">'
                + '<h2 style="font-size:36px; font-weight:700; margin-bottom:8px; text-align:center; color:#1e293b;">Cont\u00e1ctanos</h2>'
                + '<p style="text-align:center; color:#64748b; margin-bottom:32px;">Estaremos encantados de ayudarte</p>'
                + '<form data-contact-form style="display:flex; flex-direction:column; gap:16px;">'
                + '<input type="hidden" name="_token" value="{{ csrf_token() }}">'
                + '<input type="text" name="website" value="" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;top:-9999px;opacity:0;height:0;width:0;">'
                + '<input type="text" name="name" placeholder="Nombre completo" required style="padding:14px 16px; border:1px solid #e2e8f0; border-radius:8px; font-size:16px; font-family:inherit; outline:none;">'
                + '<input type="email" name="email" placeholder="Email" required style="padding:14px 16px; border:1px solid #e2e8f0; border-radius:8px; font-size:16px; font-family:inherit; outline:none;">'
                + '<input type="tel" name="phone" placeholder="Tel\u00e9fono (opcional)" style="padding:14px 16px; border:1px solid #e2e8f0; border-radius:8px; font-size:16px; font-family:inherit; outline:none;">'
                + '<textarea name="message" placeholder="Tu mensaje..." rows="5" required style="padding:14px 16px; border:1px solid #e2e8f0; border-radius:8px; font-size:16px; font-family:inherit; resize:vertical; outline:none;"></textarea>'
                + '<button type="submit" style="padding:16px 32px; background:#6366f1; color:#fff; border:none; border-radius:8px; font-size:16px; font-weight:600; cursor:pointer; font-family:inherit;">Enviar Mensaje</button>'
                + '</form>'
                + '</div>'
                + '</section>',
        });

        bm.add('newsletter-signup', {
            label: 'Newsletter',
            category: 'Formularios',
            content: '<section style="padding:80px 20px; background:linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color:#fff;">'
                + '<div style="max-width:600px; margin:0 auto; text-align:center;">'
                + '<h2 style="font-size:36px; font-weight:700; margin-bottom:12px;">Suscr\u00edbete a nuestro newsletter</h2>'
                + '<p style="font-size:18px; margin-bottom:32px; opacity:0.9; line-height:1.6;">Recibe las \u00faltimas noticias directamente en tu bandeja de entrada.</p>'
                + '<form style="display:flex; gap:12px; max-width:480px; margin:0 auto;">'
                + '<input type="email" placeholder="tu@email.com" style="flex:1; padding:14px 18px; border:none; border-radius:8px; font-size:16px; font-family:inherit; outline:none;">'
                + '<button type="submit" style="padding:14px 28px; background:#1e293b; color:#fff; border:none; border-radius:8px; font-size:16px; font-weight:600; cursor:pointer; white-space:nowrap; font-family:inherit;">Suscribirse</button>'
                + '</form>'
                + '<p style="font-size:13px; margin-top:12px; opacity:0.7;">Sin spam. Cancela cuando quieras.</p>'
                + '</div>'
                + '</section>',
        });

        // --- Media category ---

        bm.add('video-embed', {
            label: 'Video',
            category: 'Media',
            content: '<div style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:8px;">'
                + '<iframe style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;" src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe>'
                + '</div>',
        });

        bm.add('map-embed', {
            label: 'Mapa',
            category: 'Media',
            content: '<div style="border-radius:8px; overflow:hidden;">'
                + '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3329.5!2d-70.65!3d-33.44!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzPCsDI2JzI0LjAiUyA3MMKwMzknMDAuMCJX!5e0!3m2!1ses!2scl!4v1" width="100%" height="400" style="border:0;" allowfullscreen loading="lazy"></iframe>'
                + '</div>',
        });

        bm.add('gallery-grid', {
            label: 'Galer\u00eda',
            category: 'Media',
            content: '<section style="padding:80px 20px; background:#fff;">'
                + '<div style="max-width:1100px; margin:0 auto; text-align:center;">'
                + '<h2 style="font-size:36px; font-weight:700; margin-bottom:16px; color:#1e293b;">Nuestra Galer\u00eda</h2>'
                + '<p style="color:#64748b; margin-bottom:40px; font-size:18px;">Conoce nuestro trabajo</p>'
                + '<div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px;">'
                + '<div style="border-radius:12px; overflow:hidden;"><img src="https://picsum.photos/400/300?random=1" alt="Galer\u00eda 1" style="width:100%; height:250px; object-fit:cover; display:block;"></div>'
                + '<div style="border-radius:12px; overflow:hidden;"><img src="https://picsum.photos/400/300?random=2" alt="Galer\u00eda 2" style="width:100%; height:250px; object-fit:cover; display:block;"></div>'
                + '<div style="border-radius:12px; overflow:hidden;"><img src="https://picsum.photos/400/300?random=3" alt="Galer\u00eda 3" style="width:100%; height:250px; object-fit:cover; display:block;"></div>'
                + '<div style="border-radius:12px; overflow:hidden;"><img src="https://picsum.photos/400/300?random=4" alt="Galer\u00eda 4" style="width:100%; height:250px; object-fit:cover; display:block;"></div>'
                + '<div style="border-radius:12px; overflow:hidden;"><img src="https://picsum.photos/400/300?random=5" alt="Galer\u00eda 5" style="width:100%; height:250px; object-fit:cover; display:block;"></div>'
                + '<div style="border-radius:12px; overflow:hidden;"><img src="https://picsum.photos/400/300?random=6" alt="Galer\u00eda 6" style="width:100%; height:250px; object-fit:cover; display:block;"></div>'
                + '</div>'
                + '</div>'
                + '</section>',
        });

        // =====================================================================
        // Force "Secciones" category open by default, others closed
        // =====================================================================
        editor.on('load', function() {
            setTimeout(function() {
                var categories = editor.BlockManager.getCategories();
                categories.each(function(cat) {
                    if (cat.get('id') === 'Secciones') {
                        cat.set('open', true);
                    } else {
                        cat.set('open', false);
                    }
                });
            }, 100);
        });

        // =====================================================================
        // Storage: Load & Save
        // =====================================================================

        function loadPageContent() {
            updateSaveDot('saving');

            fetch(LOAD_URL, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                credentials: 'same-origin',
            })
            .then(function(resp) {
                if (!resp.ok) throw new Error('HTTP ' + resp.status);
                return resp.json();
            })
            .then(function(data) {
                var content = data.content || data;

                if (content.components && content.components.length > 0) {
                    try {
                        editor.loadProjectData({
                            pages: [{ component: content.components, style: content.styles || [] }]
                        });
                    } catch (e) {
                        if (content.html) {
                            editor.setComponents(content.html);
                            editor.setStyle(content.css || '');
                        }
                    }
                } else if (content.html) {
                    editor.setComponents(content.html);
                    editor.setStyle(content.css || '');
                }

                if (data.status) {
                    updateStatusBadge(data.status);
                }

                updateSaveDot('saved');
            })
            .catch(function(err) {
                console.error('Error loading page:', err);
                updateSaveDot('saved');
            });
        }

        function savePageContent(status) {
            updateSaveDot('saving');

            var html = editor.getHtml();
            var css = editor.getCss();
            var projectData = editor.getProjectData();
            var pageFrame = (projectData.pages && projectData.pages[0] && projectData.pages[0].frames && projectData.pages[0].frames[0]) ? projectData.pages[0].frames[0] : null;
            var components = pageFrame && pageFrame.component ? [pageFrame.component] : [];
            var styles = projectData.styles || [];

            var payload = {
                html: html,
                css: css,
                components: components,
                styles: styles,
            };
            if (status) {
                payload.status = status;
            }

            return fetch(STORE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                credentials: 'same-origin',
                body: JSON.stringify(payload),
            })
            .then(function(resp) {
                // === SESSION PROTECTION: Smart error handling for manual save ===
                if (resp.status === 401) {
                    showSessionExpiredModal();
                    throw new Error('Sesi\u00f3n expirada');
                }
                if (resp.status === 419) {
                    // CSRF mismatch — try to refresh and inform user
                    refreshCsrfAndRetry(null);
                    throw new Error('Token CSRF expirado. Int\u00e9ntalo de nuevo.');
                }
                if (!resp.ok) throw new Error('HTTP ' + resp.status);
                return resp.json();
            })
            .then(function(data) {
                serverLastSaved = Date.now();
                backupToLocalStorage(); // Update backup as confirmed save
                if (status === 'published') {
                    updateSaveDot('saved');
                    updateStatusBadge('published');
                    showToast('P\u00e1gina publicada exitosamente', 'success');
                } else {
                    updateSaveDot('saved');
                    if (status === 'draft') {
                        updateStatusBadge('draft');
                    }
                    showToast('Borrador guardado', 'success');
                }
                return true;
            })
            .catch(function(err) {
                updateSaveDot('error');
                console.error('Error saving:', err);
                showToast('Error al guardar: ' + err.message, 'error', 5000);
                backupToLocalStorage(); // Safety backup on failure
                setTimeout(function() { updateSaveDot('unsaved'); }, 5000);
                return false;
            });
        }

        // =====================================================================
        // === SESSION PROTECTION START ===
        // =====================================================================

        // --- State variables for session protection ---
        var sessionExpired = false;
        var isOnline = navigator.onLine;
        var autoSaveRetries = 0;
        var MAX_AUTOSAVE_RETRIES = 3;
        var autoSavePaused = false;
        var serverLastSaved = {{ $page->updated_at ? $page->updated_at->timestamp * 1000 : 'Date.now()' }};
        var intentionalNavigation = false;

        // --- Connection Status Indicator ---
        function updateConnectionStatus(status) {
            var dot = document.getElementById('connection-dot');
            var label = document.getElementById('connection-label');
            dot.className = 'connection-dot ' + status;
            if (status === 'connected') {
                label.textContent = '';
            } else if (status === 'reconnecting') {
                label.textContent = 'Reconectando...';
            } else if (status === 'disconnected') {
                label.textContent = 'Sin conexi\u00f3n';
            }
        }

        // --- localStorage Backup System ---
        var backupTimer = null;

        function backupToLocalStorage() {
            try {
                var backup = {
                    html: editor.getHtml(),
                    css: editor.getCss(),
                    pageId: PAGE_ID,
                    timestamp: Date.now(),
                    pageTitle: document.getElementById('page-title-input').value || 'Page ' + PAGE_ID
                };
                localStorage.setItem('wc_editor_backup_' + PAGE_ID, JSON.stringify(backup));
            } catch(e) {
                console.warn('Backup to localStorage failed:', e);
            }
        }

        function debouncedBackup() {
            if (backupTimer) clearTimeout(backupTimer);
            backupTimer = setTimeout(backupToLocalStorage, 5000);
        }

        function getLocalBackup() {
            try {
                var raw = localStorage.getItem('wc_editor_backup_' + PAGE_ID);
                if (!raw) return null;
                return JSON.parse(raw);
            } catch(e) {
                return null;
            }
        }

        function formatTimeAgo(timestamp) {
            var diff = Date.now() - timestamp;
            var minutes = Math.floor(diff / 60000);
            if (minutes < 1) return 'hace unos segundos';
            if (minutes === 1) return 'hace 1 minuto';
            if (minutes < 60) return 'hace ' + minutes + ' minutos';
            var hours = Math.floor(minutes / 60);
            if (hours === 1) return 'hace 1 hora';
            return 'hace ' + hours + ' horas';
        }

        function formatTimestamp(timestamp) {
            var d = new Date(timestamp);
            return d.toLocaleString('es-CL', { day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit' });
        }

        // --- Restore Backup Modal ---
        function showRestoreModal(backupData) {
            var overlay = document.createElement('div');
            overlay.className = 'restore-modal-overlay';
            overlay.innerHTML = '<div class="restore-modal">'
                + '<h3>Respaldo local encontrado</h3>'
                + '<p>Se encontr\u00f3 un respaldo local m\u00e1s reciente que la versi\u00f3n del servidor (' + formatTimeAgo(backupData.timestamp) + ').</p>'
                + '<div class="restore-timestamps">'
                + '<div><span class="label">Respaldo local:</span><span class="value">' + formatTimestamp(backupData.timestamp) + '</span></div>'
                + '<div><span class="label">Servidor:</span><span class="value">' + formatTimestamp(serverLastSaved) + '</span></div>'
                + '</div>'
                + '<div class="restore-actions">'
                + '<button class="btn-restore primary" id="btn-restore-backup">Restaurar respaldo</button>'
                + '<button class="btn-restore secondary" id="btn-discard-backup">Descartar</button>'
                + '</div>'
                + '</div>';

            document.body.appendChild(overlay);

            document.getElementById('btn-restore-backup').addEventListener('click', function() {
                editor.setComponents(backupData.html || '');
                editor.setStyle(backupData.css || '');
                updateSaveDot('unsaved');
                showToast('Respaldo local restaurado', 'success');
                document.body.removeChild(overlay);
            });

            document.getElementById('btn-discard-backup').addEventListener('click', function() {
                localStorage.removeItem('wc_editor_backup_' + PAGE_ID);
                showToast('Respaldo descartado', 'info');
                document.body.removeChild(overlay);
            });
        }

        function checkLocalBackup() {
            var backup = getLocalBackup();
            if (!backup) return;
            // If backup is newer than server data and has content
            if (backup.timestamp > serverLastSaved && backup.html && backup.html.trim().length > 0) {
                // Small delay to let editor fully initialize
                setTimeout(function() {
                    showRestoreModal(backup);
                }, 800);
            }
        }

        // --- Session Expiry Modal (persistent, cannot be dismissed) ---
        function showSessionExpiredModal() {
            if (document.getElementById('session-expired-modal')) return;
            sessionExpired = true;
            autoSavePaused = true;

            // Make a final backup before showing modal
            backupToLocalStorage();

            var overlay = document.createElement('div');
            overlay.className = 'session-modal-overlay';
            overlay.id = 'session-expired-modal';
            overlay.innerHTML = '<div class="session-modal">'
                + '<div class="session-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></div>'
                + '<h3>Tu sesi\u00f3n ha expirado</h3>'
                + '<p>Tus cambios no guardados se han respaldado localmente. Inicia sesi\u00f3n de nuevo para continuar editando.</p>'
                + '<div class="session-actions">'
                + '<button class="btn-session-login" id="btn-session-login">Iniciar sesi\u00f3n</button>'
                + '<button class="btn-session-backup" id="btn-session-download">Descargar respaldo</button>'
                + '</div>'
                + '</div>';

            document.body.appendChild(overlay);

            document.getElementById('btn-session-login').addEventListener('click', function() {
                window.open('/admin/login', '_blank');
            });

            document.getElementById('btn-session-download').addEventListener('click', function() {
                var backup = getLocalBackup();
                var html = '';
                if (backup) {
                    html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Respaldo - ' + (backup.pageTitle || 'Page') + '</title>'
                        + '<style>' + (backup.css || '') + '</style></head><body>' + (backup.html || '') + '</body></html>';
                } else {
                    html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Respaldo</title>'
                        + '<style>' + editor.getCss() + '</style></head><body>' + editor.getHtml() + '</body></html>';
                }
                var blob = new Blob([html], { type: 'text/html' });
                var url = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'respaldo-pagina-' + PAGE_ID + '-' + new Date().toISOString().slice(0,10) + '.html';
                a.click();
                URL.revokeObjectURL(url);
                showToast('Respaldo descargado', 'success');
            });
        }

        // --- Heartbeat: keep session alive + refresh CSRF ---
        var heartbeatInterval = null;

        function sendHeartbeat() {
            if (sessionExpired) return;

            fetch('/api/heartbeat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                credentials: 'same-origin',
            })
            .then(function(resp) {
                if (resp.ok) {
                    return resp.json();
                }
                if (resp.status === 401 || resp.status === 419) {
                    showSessionExpiredModal();
                    return null;
                }
                throw new Error('HTTP ' + resp.status);
            })
            .then(function(data) {
                if (!data) return;
                // Refresh CSRF token
                if (data.csrf) {
                    CSRF_TOKEN = data.csrf;
                    var metaTag = document.querySelector('meta[name="csrf-token"]');
                    if (metaTag) metaTag.content = data.csrf;
                }
                updateConnectionStatus('connected');
            })
            .catch(function(err) {
                // Network error — could be offline
                if (!navigator.onLine) {
                    updateConnectionStatus('disconnected');
                } else {
                    updateConnectionStatus('reconnecting');
                }
            });
        }

        // Start heartbeat every 5 minutes (300000ms)
        heartbeatInterval = setInterval(sendHeartbeat, 300000);
        // Send initial heartbeat after 10 seconds
        setTimeout(sendHeartbeat, 10000);

        // --- CSRF Token Refresh via Heartbeat ---
        function refreshCsrfAndRetry(retryFn) {
            fetch('/api/heartbeat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                credentials: 'same-origin',
            })
            .then(function(resp) {
                if (resp.ok) return resp.json();
                if (resp.status === 401 || resp.status === 419) {
                    showSessionExpiredModal();
                    return null;
                }
                throw new Error('HTTP ' + resp.status);
            })
            .then(function(data) {
                if (!data) return;
                if (data.csrf) {
                    CSRF_TOKEN = data.csrf;
                    var metaTag = document.querySelector('meta[name="csrf-token"]');
                    if (metaTag) metaTag.content = data.csrf;
                }
                if (retryFn) retryFn();
            })
            .catch(function() {
                // Cannot refresh, session likely expired
                showSessionExpiredModal();
            });
        }

        // --- beforeunload Warning ---
        window.addEventListener('beforeunload', function(e) {
            if (hasUnsavedChanges && !intentionalNavigation) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Mark intentional navigation for preview/publish redirects
        document.getElementById('btn-preview').addEventListener('click', function() {
            intentionalNavigation = true;
            setTimeout(function() { intentionalNavigation = false; }, 1000);
        });

        // --- Offline/Online Detection ---
        window.addEventListener('online', function() {
            isOnline = true;
            updateConnectionStatus('reconnecting');
            showToast('Conexi\u00f3n restaurada', 'success');
            // Immediately try a heartbeat to verify session
            sendHeartbeat();
            // Resume auto-save if paused only due to offline
            if (!sessionExpired) {
                autoSavePaused = false;
            }
        });

        window.addEventListener('offline', function() {
            isOnline = false;
            updateConnectionStatus('disconnected');
            showToast('Sin conexi\u00f3n a internet', 'error', 5000);
            // Backup to localStorage immediately
            backupToLocalStorage();
        });

        // =====================================================================
        // Auto-save every 30 seconds (with smart error handling)
        // =====================================================================
        var autoSaveInterval = setInterval(function() {
            if (!hasUnsavedChanges || autoSavePaused || sessionExpired) return;
            if (!isOnline) {
                backupToLocalStorage();
                return;
            }

            updateSaveDot('saving');

            var html = editor.getHtml();
            var css = editor.getCss();
            var projectData = editor.getProjectData();
            var pageFrame = (projectData.pages && projectData.pages[0] && projectData.pages[0].frames && projectData.pages[0].frames[0]) ? projectData.pages[0].frames[0] : null;
            var components = pageFrame && pageFrame.component ? [pageFrame.component] : [];
            var styles = projectData.styles || [];

            fetch(STORE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                credentials: 'same-origin',
                body: JSON.stringify({ html: html, css: css, components: components, styles: styles }),
            })
            .then(function(resp) {
                if (resp.ok) {
                    autoSaveRetries = 0;
                    updateSaveDot('saved');
                    updateConnectionStatus('connected');
                    serverLastSaved = Date.now();
                    // Update localStorage backup as confirmed
                    backupToLocalStorage();
                    return;
                }

                // --- Smart error handling by status code ---
                if (resp.status === 401) {
                    // Session expired
                    showSessionExpiredModal();
                    return;
                }
                if (resp.status === 419) {
                    // CSRF mismatch — refresh token and retry
                    updateSaveDot('error');
                    refreshCsrfAndRetry(function() {
                        // Retry will happen on next auto-save cycle
                        updateSaveDot('unsaved');
                    });
                    return;
                }
                if (resp.status === 429) {
                    // Rate limited — pause for 30 seconds
                    updateSaveDot('error');
                    showToast('Demasiadas peticiones. Reintentando en 30s...', 'info');
                    autoSavePaused = true;
                    setTimeout(function() { autoSavePaused = false; }, 30000);
                    return;
                }
                if (resp.status >= 500) {
                    // Server error — retry up to 3 times
                    autoSaveRetries++;
                    updateSaveDot('error');
                    if (autoSaveRetries >= MAX_AUTOSAVE_RETRIES) {
                        showToast('Error del servidor persistente. Cambios respaldados localmente.', 'error', 5000);
                        backupToLocalStorage();
                        autoSavePaused = true;
                        // Resume after 30 seconds
                        setTimeout(function() {
                            autoSavePaused = false;
                            autoSaveRetries = 0;
                        }, 30000);
                    } else {
                        showToast('Error del servidor. Reintentando... (' + autoSaveRetries + '/' + MAX_AUTOSAVE_RETRIES + ')', 'error');
                    }
                    return;
                }

                // Other errors
                updateSaveDot('error');
            })
            .catch(function() {
                // Network error
                updateConnectionStatus('disconnected');
                updateSaveDot('unsaved');
                backupToLocalStorage();
            });
        }, 30000);

        // =====================================================================
        // === SESSION PROTECTION END ===
        // =====================================================================

        // =====================================================================
        // Keyboard shortcuts
        // =====================================================================
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                savePageContent('draft');
            }
        });

        // =====================================================================
        // Toolbar Button Handlers
        // =====================================================================

        // Undo/Redo
        document.getElementById('btn-undo').addEventListener('click', function() {
            editor.runCommand('core:undo');
        });
        document.getElementById('btn-redo').addEventListener('click', function() {
            editor.runCommand('core:redo');
        });

        // Save button
        document.getElementById('btn-save').addEventListener('click', function() {
            this.disabled = true;
            var btn = this;
            savePageContent('draft').then(function() {
                btn.disabled = false;
            });
        });

        // Publish button
        document.getElementById('btn-publish').addEventListener('click', function() {
            this.disabled = true;
            var btn = this;
            savePageContent('published').then(function() {
                btn.disabled = false;
            });
        });

        // Preview button — open page in new tab
        document.getElementById('btn-preview').addEventListener('click', function() {
            window.open('/' + PAGE_SLUG, '_blank');
        });

        // Device preview buttons with label update
        document.querySelectorAll('.device-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.device-btn').forEach(function(b) {
                    b.classList.remove('active');
                });
                this.classList.add('active');
                editor.setDevice(this.dataset.device);
                var label = document.getElementById('device-label');
                label.textContent = this.dataset.label + (this.dataset.dims && this.dataset.dims !== 'Ancho completo' ? ' (' + this.dataset.dims + ')' : '');
            });
        });

        // Inline title editing
        document.getElementById('page-title-input').addEventListener('change', function() {
            var newTitle = this.value.trim();
            if (newTitle) {
                updateSaveDot('unsaved');
            }
        });

        // =====================================================================
        // Quick Add floating button
        // =====================================================================
        (function() {
            var qBtn = document.getElementById('quick-add-btn');
            var qMenu = document.getElementById('quick-add-menu');
            var menuOpen = false;

            qBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                menuOpen = !menuOpen;
                qMenu.style.display = menuOpen ? 'block' : 'none';
            });

            document.addEventListener('click', function() {
                if (menuOpen) {
                    menuOpen = false;
                    qMenu.style.display = 'none';
                }
            });

            qMenu.addEventListener('click', function(e) { e.stopPropagation(); });

            document.getElementById('qa-blocks').addEventListener('click', function() {
                menuOpen = false;
                qMenu.style.display = 'none';
                // Open blocks panel
                var blocksBtn = document.querySelector('.gjs-pn-btn[data-tooltip="Open Blocks"]') ||
                                document.querySelector('.gjs-pn-views .gjs-pn-btn:first-child');
                if (blocksBtn) blocksBtn.click();
            });

            document.getElementById('qa-ai').addEventListener('click', function() {
                menuOpen = false;
                qMenu.style.display = 'none';
                document.getElementById('ai-modal').style.display = 'block';
                // Switch to generate tab
                document.querySelectorAll('.ai-tab').forEach(function(t) { t.classList.remove('active'); });
                document.querySelector('.ai-tab[data-tab="generate"]').classList.add('active');
                document.querySelectorAll('.ai-panel').forEach(function(p) { p.classList.remove('active'); p.style.display = 'none'; });
                var genPanel = document.getElementById('ai-panel-generate');
                genPanel.classList.add('active');
                genPanel.style.display = 'block';
            });
        })();

        // =====================================================================
        // Template Picker (with confirmation dialog)
        // =====================================================================
        document.getElementById('btn-templates').addEventListener('click', function() {
            var modal = document.getElementById('template-modal');
            var grid = document.getElementById('template-grid');
            modal.style.display = 'block';
            grid.innerHTML = '<p style="grid-column:1/-1; text-align:center; color:#a6adc8;">Cargando templates...</p>';

            fetch(TEMPLATES_URL, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                credentials: 'same-origin',
            })
            .then(function(resp) { return resp.json(); })
            .then(function(templates) {
                var blankCard = '<div class="template-card" data-slug="" style="border:2px dashed #45475a; border-radius:8px; padding:24px; cursor:pointer; text-align:center; transition:all 0.15s;" onmouseover="this.style.borderColor=\'#89b4fa\'" onmouseout="this.style.borderColor=\'#45475a\'">'
                    + '<div style="font-size:40px; margin-bottom:12px;">&#128196;</div>'
                    + '<h4 style="font-weight:600;">P\u00e1gina en Blanco</h4>'
                    + '<p style="font-size:13px; color:#6c7086; margin-top:4px;">Empezar desde cero</p>'
                    + '</div>';

                grid.innerHTML = blankCard;

                if (templates && templates.length > 0) {
                    templates.forEach(function(t) {
                        grid.innerHTML += '<div class="template-card" data-slug="' + t.slug + '" style="border:1px solid #45475a; border-radius:8px; overflow:hidden; cursor:pointer; transition:all 0.15s;" onmouseover="this.style.borderColor=\'#89b4fa\'" onmouseout="this.style.borderColor=\'#45475a\'">'
                            + (t.thumbnail ? '<img src="' + t.thumbnail + '" style="width:100%; height:140px; object-fit:cover;">' : '<div style="width:100%; height:140px; background:#313244; display:flex; align-items:center; justify-content:center; font-size:32px;">&#127912;</div>')
                            + '<div style="padding:12px;">'
                            + '<h4 style="font-weight:600; margin-bottom:4px;">' + t.name + '</h4>'
                            + '<p style="font-size:13px; color:#6c7086;">' + (t.description || t.category || '') + '</p>'
                            + '</div>'
                            + '</div>';
                    });
                }

                // Attach click handlers with confirmation
                grid.querySelectorAll('.template-card').forEach(function(card) {
                    card.addEventListener('click', function() {
                        var slug = this.dataset.slug;
                        var applyTemplate = function() {
                            if (slug) {
                                fetch(TEMPLATES_URL + '/' + slug, {
                                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                                    credentials: 'same-origin',
                                })
                                .then(function(r) { return r.json(); })
                                .then(function(template) {
                                    if (template.content) {
                                        if (template.content.components && template.content.components.length) {
                                            editor.loadProjectData({
                                                pages: [{ component: template.content.components, style: template.content.styles || [] }]
                                            });
                                        } else if (template.content.html) {
                                            editor.setComponents(template.content.html);
                                            editor.setStyle(template.content.css || '');
                                        }
                                    }
                                    showToast('Template "' + template.name + '" aplicado', 'success');
                                    modal.style.display = 'none';
                                })
                                .catch(function(err) {
                                    showToast('Error al cargar template', 'error');
                                });
                            } else {
                                editor.setComponents('');
                                editor.setStyle('');
                                showToast('P\u00e1gina en blanco', 'info');
                                modal.style.display = 'none';
                            }
                        };

                        showConfirm(
                            'Cargar template',
                            'Esto reemplazar\u00e1 todo el contenido actual. \u00bfContinuar?',
                            applyTemplate,
                            true
                        );
                    });
                });
            })
            .catch(function(err) {
                grid.innerHTML = '<p style="grid-column:1/-1; text-align:center; color:#f38ba8;">Error cargando templates.</p>';
            });
        });

        document.getElementById('close-template-modal').addEventListener('click', function() {
            document.getElementById('template-modal').style.display = 'none';
        });

        document.getElementById('template-modal').addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });

        // =====================================================================
        // AI Assistant (Simplified: 3 tabs — Generar, Traducir, Variantes)
        // =====================================================================
        (function() {
            var aiModal = document.getElementById('ai-modal');
            var lastAiResult = null;
            var lastAiType = null;

            document.getElementById('btn-ai').addEventListener('click', function() { aiModal.style.display = 'block'; });
            document.getElementById('close-ai-modal').addEventListener('click', function() { aiModal.style.display = 'none'; });
            aiModal.addEventListener('click', function(e) { if (e.target === aiModal) aiModal.style.display = 'none'; });

            // Tab switching
            document.querySelectorAll('.ai-tab').forEach(function(tab) {
                tab.addEventListener('click', function() {
                    document.querySelectorAll('.ai-tab').forEach(function(t) { t.classList.remove('active'); });
                    this.classList.add('active');
                    document.querySelectorAll('.ai-panel').forEach(function(p) { p.classList.remove('active'); p.style.display = 'none'; });
                    var panel = document.getElementById('ai-panel-' + this.dataset.tab);
                    panel.classList.add('active');
                    panel.style.display = 'block';
                    document.getElementById('ai-result').style.display = 'none';
                    document.getElementById('ai-variants-result').style.display = 'none';
                });
            });

            // Generate mode toggle (section vs page)
            document.getElementById('ai-gen-mode').addEventListener('change', function() {
                if (this.value === 'page') {
                    document.getElementById('ai-section-fields').style.display = 'none';
                    document.getElementById('ai-page-fields').style.display = 'block';
                } else {
                    document.getElementById('ai-section-fields').style.display = 'block';
                    document.getElementById('ai-page-fields').style.display = 'none';
                }
            });

            function aiLoading(show) {
                document.getElementById('ai-loading').style.display = show ? 'block' : 'none';
                if (show) {
                    document.getElementById('ai-result').style.display = 'none';
                    document.getElementById('ai-variants-result').style.display = 'none';
                }
            }

            function aiShowResult(data, type) {
                aiLoading(false);
                lastAiResult = data;
                lastAiType = type;
                var el = document.getElementById('ai-result-content');
                el.textContent = typeof data === 'object' ? JSON.stringify(data, null, 2) : data;
                document.getElementById('ai-result').style.display = 'block';
                document.getElementById('ai-apply-btn').style.display = 'inline-block';
                document.getElementById('ai-variants-result').style.display = 'none';
            }

            function aiShowVariants(data) {
                aiLoading(false);
                lastAiResult = data;
                lastAiType = 'variants';
                document.getElementById('ai-result').style.display = 'none';

                var container = document.getElementById('ai-variants-list');
                container.innerHTML = '';

                var variants = data.variants || [];
                if (!variants.length) {
                    container.innerHTML = '<p style="color:#f38ba8;">No se generaron variantes.</p>';
                    document.getElementById('ai-variants-result').style.display = 'block';
                    return;
                }

                variants.forEach(function(variant, idx) {
                    var card = document.createElement('div');
                    card.className = 'variant-card';
                    card.innerHTML = '<p>' + (typeof variant === 'string' ? variant : JSON.stringify(variant)) + '</p>'
                        + '<button class="variant-apply" data-idx="' + idx + '">Aplicar variante ' + (idx + 1) + '</button>';
                    container.appendChild(card);
                });

                document.getElementById('ai-variants-result').style.display = 'block';

                container.querySelectorAll('.variant-apply').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var idx = parseInt(this.dataset.idx);
                        var sel = editor.getSelected();
                        if (sel && variants[idx]) {
                            sel.components(typeof variants[idx] === 'string' ? variants[idx] : JSON.stringify(variants[idx]));
                            showToast('Variante ' + (idx + 1) + ' aplicada', 'success');
                            aiModal.style.display = 'none';
                        } else {
                            showToast('Selecciona un componente primero', 'error');
                        }
                    });
                });
            }

            function aiShowError(msg) {
                aiLoading(false);
                document.getElementById('ai-result-content').innerHTML = '<span style="color:#f38ba8;">' + msg + '</span>';
                document.getElementById('ai-result').style.display = 'block';
                document.getElementById('ai-apply-btn').style.display = 'none';
                document.getElementById('ai-variants-result').style.display = 'none';
            }

            function aiCall(endpoint, body) {
                return fetch('/api/ai' + endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(body),
                }).then(function(r) {
                    if (!r.ok) {
                        return r.json().catch(function() { return {}; }).then(function(e) {
                            throw new Error(e.error || 'Error del servidor');
                        });
                    }
                    return r.json();
                });
            }

            // Generate button (handles both section text and full page)
            document.getElementById('ai-gen-btn').addEventListener('click', function() {
                var mode = document.getElementById('ai-gen-mode').value;

                if (mode === 'page') {
                    var biz = document.getElementById('ai-page-biz').value;
                    var desc = document.getElementById('ai-page-desc').value;
                    if (!biz || !desc) return aiShowError('Completa todos los campos');

                    showConfirm(
                        'Generar p\u00e1gina completa',
                        'Esto reemplazar\u00e1 todo el contenido actual. \u00bfContinuar?',
                        function() {
                            aiLoading(true);
                            aiCall('/generate-page', { business_type: biz, description: desc })
                            .then(function(data) { aiShowResult(data, 'page'); })
                            .catch(function(e) { aiShowError(e.message); });
                        },
                        true
                    );
                } else {
                    var bizType = document.getElementById('ai-business-type').value;
                    if (!bizType) return aiShowError('Ingresa el tipo de negocio');
                    aiLoading(true);
                    aiCall('/generate-text', {
                        section_type: document.getElementById('ai-section-type').value,
                        business_type: bizType,
                        tone: document.getElementById('ai-tone').value,
                        language: document.getElementById('ai-lang').value,
                    }).then(function(data) {
                        aiShowResult(data, 'text');
                    }).catch(function(e) { aiShowError(e.message); });
                }
            });

            // Translate
            document.getElementById('ai-translate-btn').addEventListener('click', function() {
                var sel = editor.getSelected();
                if (!sel) return aiShowError('Selecciona un componente primero');
                aiLoading(true);
                aiCall('/translate', {
                    content: sel.toHTML(),
                    target_language: document.getElementById('ai-target-lang').value,
                }).then(function(data) {
                    aiShowResult(data.translated, 'translate');
                }).catch(function(e) { aiShowError(e.message); });
            });

            // Variants — shows all 3 with individual apply buttons
            document.getElementById('ai-var-btn').addEventListener('click', function() {
                var sel = editor.getSelected();
                if (!sel) return aiShowError('Selecciona un texto primero');
                var text = (sel.view && sel.view.el) ? sel.view.el.textContent : '';
                if (!text.trim()) return aiShowError('No se encontr\u00f3 texto en el componente');
                aiLoading(true);
                aiCall('/generate-variants', {
                    text: text.trim(),
                    variants: 3,
                    tone: document.getElementById('ai-var-tone').value,
                }).then(function(data) {
                    aiShowVariants(data);
                }).catch(function(e) { aiShowError(e.message); });
            });

            // Apply AI result (for non-variant results)
            document.getElementById('ai-apply-btn').addEventListener('click', function() {
                if (!lastAiResult) return;
                switch (lastAiType) {
                    case 'text': {
                        var html = '<section style="padding:60px 20px; text-align:center;">'
                            + '<div style="max-width:800px; margin:0 auto;">'
                            + '<h2 style="font-size:36px; font-weight:700; margin-bottom:12px; color:#1e293b;">' + (lastAiResult.title || '') + '</h2>'
                            + '<p style="font-size:18px; color:#64748b; margin-bottom:16px;">' + (lastAiResult.subtitle || '') + '</p>'
                            + '<p style="line-height:1.7; margin-bottom:24px; color:#475569;">' + (lastAiResult.description || '') + '</p>'
                            + (lastAiResult.cta ? '<a href="#" style="display:inline-block; padding:12px 28px; background:#6366f1; color:#fff; border-radius:8px; text-decoration:none; font-weight:600;">' + lastAiResult.cta + '</a>' : '')
                            + '</div></section>';
                        var sel = editor.getSelected();
                        if (sel) { sel.components(html); } else { editor.addComponents(html); }
                        showToast('Texto aplicado al editor', 'success');
                        break;
                    }
                    case 'translate': {
                        var sel2 = editor.getSelected();
                        if (sel2 && typeof lastAiResult === 'string') {
                            sel2.components(lastAiResult);
                            showToast('Traducci\u00f3n aplicada', 'success');
                        }
                        break;
                    }
                    case 'page': {
                        if (lastAiResult.html) {
                            editor.setComponents(lastAiResult.html);
                            if (lastAiResult.css) editor.setStyle(lastAiResult.css);
                            showToast('P\u00e1gina generada aplicada', 'success');
                        }
                        break;
                    }
                }
                aiModal.style.display = 'none';
            });
        })();

        // =====================================================================
        // === EFFECTS INTEGRATION START ===
        // =====================================================================

        // -----------------------------------------------------------------
        // 1. Effects Traits — extend default component type with data-* traits
        // -----------------------------------------------------------------
        (function() {

            // Common effect traits available on all components
            var effectTraits = [
                {
                    type: 'select',
                    name: 'data-animate',
                    label: 'Animacion',
                    changeProp: false,
                    options: [
                        { value: '', name: 'Ninguna' },
                        { value: 'fade-up', name: 'Fade Up' },
                        { value: 'fade-down', name: 'Fade Down' },
                        { value: 'fade-left', name: 'Fade Left' },
                        { value: 'fade-right', name: 'Fade Right' },
                        { value: 'fade-zoom', name: 'Zoom In' },
                        { value: 'flip-up', name: 'Flip Up' },
                        { value: 'flip-left', name: 'Flip Left' },
                    ]
                },
                {
                    type: 'number',
                    name: 'data-animate-delay',
                    label: 'Anim. Delay (ms)',
                    default: 0,
                    min: 0,
                    max: 3000,
                    step: 100,
                },
                {
                    type: 'number',
                    name: 'data-animate-duration',
                    label: 'Anim. Duracion (ms)',
                    default: 600,
                    min: 100,
                    max: 3000,
                    step: 100,
                },
                {
                    type: 'select',
                    name: 'data-hover',
                    label: 'Hover',
                    changeProp: false,
                    options: [
                        { value: '', name: 'Ninguno' },
                        { value: 'scale', name: 'Escalar' },
                        { value: 'shadow', name: 'Sombra' },
                        { value: 'lift', name: 'Elevar' },
                        { value: 'glow', name: 'Brillo' },
                        { value: 'border', name: 'Borde' },
                    ]
                },
            ];

            // Extend the default component type to include effects traits
            var origDefault = editor.DomComponents.getType('default');
            var origDefaultModel = origDefault.model;

            editor.DomComponents.addType('default', {
                model: {
                    defaults: Object.assign({}, origDefaultModel.prototype.defaults, {
                        traits: (origDefaultModel.prototype.defaults.traits || []).concat(effectTraits),
                    }),
                },
            });

            // -----------------------------------------------------------------
            // 3. Context-sensitive traits — show extra options for specific tags
            // -----------------------------------------------------------------
            editor.on('component:selected', function(component) {
                if (!component) return;

                var tagName = (component.get('tagName') || '').toLowerCase();
                var el = component.getEl();
                var traits = component.get('traits');

                // Helper: check if trait already exists
                function hasTrait(name) {
                    return traits.where({ name: name }).length > 0;
                }

                // Helper: add a trait if not present
                function addTraitIfMissing(traitDef) {
                    if (!hasTrait(traitDef.name)) {
                        component.addTrait(traitDef);
                    }
                }

                // Helper: remove a trait by name
                function removeTraitIfPresent(name) {
                    if (hasTrait(name)) {
                        component.removeTrait(name);
                    }
                }

                // --- Image-specific: lightbox traits ---
                if (tagName === 'img') {
                    addTraitIfMissing({
                        type: 'checkbox',
                        name: 'data-lightbox',
                        label: 'Lightbox',
                        valueTrue: '',
                        valueFalse: null,
                    });
                    addTraitIfMissing({
                        type: 'text',
                        name: 'data-lightbox-group',
                        label: 'Lightbox Grupo',
                        placeholder: 'ej: gallery',
                    });
                    addTraitIfMissing({
                        type: 'text',
                        name: 'data-lightbox-caption',
                        label: 'Lightbox Caption',
                        placeholder: 'Descripcion',
                    });
                }

                // --- Text elements: typewriter ---
                if (['h1','h2','h3','h4','h5','h6','p','span'].indexOf(tagName) !== -1) {
                    addTraitIfMissing({
                        type: 'checkbox',
                        name: 'data-typewriter',
                        label: 'Typewriter',
                        valueTrue: '',
                        valueFalse: null,
                    });
                    addTraitIfMissing({
                        type: 'number',
                        name: 'data-typewriter-speed',
                        label: 'Typewriter Vel. (ms)',
                        default: 50,
                        min: 10,
                        max: 200,
                        step: 10,
                    });
                    addTraitIfMissing({
                        type: 'number',
                        name: 'data-typewriter-delay',
                        label: 'Typewriter Delay (ms)',
                        default: 0,
                        min: 0,
                        max: 5000,
                        step: 100,
                    });
                }

                // --- Containers (section, div): parallax ---
                if (['section','div'].indexOf(tagName) !== -1) {
                    addTraitIfMissing({
                        type: 'number',
                        name: 'data-parallax',
                        label: 'Parallax (0.1-0.9)',
                        placeholder: '0.3',
                        min: 0,
                        max: 0.9,
                        step: 0.1,
                    });
                }

                // --- Nav elements: sticky ---
                if (['nav','header'].indexOf(tagName) !== -1) {
                    addTraitIfMissing({
                        type: 'checkbox',
                        name: 'data-sticky',
                        label: 'Sticky',
                        valueTrue: '',
                        valueFalse: null,
                    });
                    addTraitIfMissing({
                        type: 'number',
                        name: 'data-sticky-offset',
                        label: 'Sticky Offset (px)',
                        default: 100,
                        min: 0,
                        max: 500,
                        step: 10,
                    });
                }
            });

            // -----------------------------------------------------------------
            // 4. Visual preview hints — badges on elements with effects
            // -----------------------------------------------------------------

            // Map of data attributes to badge info
            var fxBadgeMap = {
                'data-animate':   { cls: 'fx-anim',      text: 'ANIM' },
                'data-hover':     { cls: 'fx-hover',      text: 'HOVER' },
                'data-lightbox':  { cls: 'fx-lightbox',   text: 'LB' },
                'data-typewriter':{ cls: 'fx-typewriter',  text: 'TW' },
                'data-parallax':  { cls: 'fx-parallax',   text: 'PX' },
                'data-sticky':    { cls: 'fx-sticky',     text: 'STICKY' },
                'data-carousel':  { cls: 'fx-carousel',   text: 'CAROUSEL' },
                'data-tabs':      { cls: 'fx-tabs',       text: 'TABS' },
                'data-progress':  { cls: 'fx-progress',   text: 'PROG' },
                'data-marquee':   { cls: 'fx-marquee',    text: 'MARQUEE' },
                'data-count':     { cls: 'fx-counter',    text: 'COUNT' },
            };

            function updateEffectBadges(component) {
                if (!component || !component.getEl) return;
                var el = component.getEl();
                if (!el) return;

                // Remove existing badge
                var existing = el.querySelector('.wc-fx-badge');
                if (existing) existing.remove();

                // Collect active effects
                var badges = [];
                var attrs = component.getAttributes();
                for (var attr in fxBadgeMap) {
                    if (attrs[attr] !== undefined && attrs[attr] !== null && attrs[attr] !== '') {
                        badges.push(fxBadgeMap[attr]);
                    }
                    // Handle boolean-like attributes (present = truthy)
                    if (attrs.hasOwnProperty(attr) && (attrs[attr] === '' || attrs[attr] === true)) {
                        // Already captured above via !== undefined check
                    }
                }

                // Also check for boolean attributes that have empty string values
                Object.keys(fxBadgeMap).forEach(function(attrName) {
                    if (el.hasAttribute && el.hasAttribute(attrName) && badges.indexOf(fxBadgeMap[attrName]) === -1) {
                        badges.push(fxBadgeMap[attrName]);
                    }
                });

                if (badges.length === 0) return;

                // Create badge container
                var badgeEl = document.createElement('div');
                badgeEl.className = 'wc-fx-badge';
                badges.forEach(function(b) {
                    var span = document.createElement('span');
                    span.className = b.cls;
                    span.textContent = b.text;
                    badgeEl.appendChild(span);
                });

                // Ensure the element is positioned for absolute children
                var computed = el.ownerDocument.defaultView.getComputedStyle(el);
                if (computed.position === 'static') {
                    el.style.position = 'relative';
                }
                el.appendChild(badgeEl);
            }

            // Inject badge styles into the canvas iframe
            editor.on('load', function() {
                var frame = editor.Canvas.getFrameEl();
                if (frame && frame.contentDocument) {
                    var styleEl = frame.contentDocument.createElement('style');
                    styleEl.textContent = ''
                        + '.wc-fx-badge { position:absolute; top:2px; right:2px; display:flex; gap:2px; z-index:5; pointer-events:none; }'
                        + '.wc-fx-badge span { display:inline-block; font-size:9px; font-weight:700; padding:1px 4px; border-radius:3px; color:#fff; line-height:1.3; white-space:nowrap; }'
                        + '.wc-fx-badge .fx-anim { background:#6366f1; }'
                        + '.wc-fx-badge .fx-hover { background:#0ea5e9; }'
                        + '.wc-fx-badge .fx-lightbox { background:#f59e0b; }'
                        + '.wc-fx-badge .fx-typewriter { background:#ec4899; }'
                        + '.wc-fx-badge .fx-parallax { background:#8b5cf6; }'
                        + '.wc-fx-badge .fx-sticky { background:#14b8a6; }'
                        + '.wc-fx-badge .fx-carousel { background:#f97316; }'
                        + '.wc-fx-badge .fx-tabs { background:#06b6d4; }'
                        + '.wc-fx-badge .fx-progress { background:#22c55e; }'
                        + '.wc-fx-badge .fx-marquee { background:#a855f7; }'
                        + '.wc-fx-badge .fx-counter { background:#ef4444; }';
                    frame.contentDocument.head.appendChild(styleEl);
                }
            });

            // Update badges when traits change or components are updated
            editor.on('component:update', function(component) {
                updateEffectBadges(component);
            });

            // Update all badges after page load
            editor.on('load', function() {
                setTimeout(function() {
                    var allComponents = editor.DomComponents.getWrapper().find('*');
                    allComponents.forEach(function(comp) {
                        updateEffectBadges(comp);
                    });
                }, 500);
            });

        })();

        // -----------------------------------------------------------------
        // 2. Effects Blocks — "Efectos" category
        // -----------------------------------------------------------------
        (function() {
            var bm = editor.BlockManager;

            // --- Carousel / Slider ---
            bm.add('fx-carousel', {
                label: 'Carousel / Slider',
                category: 'Efectos',
                content: '<div data-carousel data-carousel-autoplay="3000" data-carousel-loop="true" data-carousel-dots="true" data-carousel-arrows="true" style="max-width:900px; margin:0 auto; overflow:hidden; border-radius:12px;">'
                    + '<div style="padding:80px 40px; background:linear-gradient(135deg, #6366f1, #8b5cf6); color:#fff; text-align:center;">'
                    + '<h3 style="font-size:28px; font-weight:700; margin-bottom:12px;">Slide 1</h3>'
                    + '<p style="font-size:16px; opacity:0.9;">Contenido del primer slide</p>'
                    + '</div>'
                    + '<div style="padding:80px 40px; background:linear-gradient(135deg, #0ea5e9, #06b6d4); color:#fff; text-align:center;">'
                    + '<h3 style="font-size:28px; font-weight:700; margin-bottom:12px;">Slide 2</h3>'
                    + '<p style="font-size:16px; opacity:0.9;">Contenido del segundo slide</p>'
                    + '</div>'
                    + '<div style="padding:80px 40px; background:linear-gradient(135deg, #f59e0b, #f97316); color:#fff; text-align:center;">'
                    + '<h3 style="font-size:28px; font-weight:700; margin-bottom:12px;">Slide 3</h3>'
                    + '<p style="font-size:16px; opacity:0.9;">Contenido del tercer slide</p>'
                    + '</div>'
                    + '</div>',
            });

            // --- Tabs ---
            bm.add('fx-tabs', {
                label: 'Tabs',
                category: 'Efectos',
                content: '<div data-tabs style="max-width:700px; margin:0 auto; padding:40px 20px;">'
                    + '<div style="display:flex; gap:8px; margin-bottom:20px;">'
                    + '<button data-tab-trigger="tab1" class="tab-active" style="padding:10px 24px; border:1px solid #e2e8f0; border-radius:6px; background:#6366f1; color:#fff; font-weight:600; cursor:pointer; font-family:inherit; font-size:14px;">Tab 1</button>'
                    + '<button data-tab-trigger="tab2" style="padding:10px 24px; border:1px solid #e2e8f0; border-radius:6px; background:#f8fafc; color:#475569; font-weight:500; cursor:pointer; font-family:inherit; font-size:14px;">Tab 2</button>'
                    + '<button data-tab-trigger="tab3" style="padding:10px 24px; border:1px solid #e2e8f0; border-radius:6px; background:#f8fafc; color:#475569; font-weight:500; cursor:pointer; font-family:inherit; font-size:14px;">Tab 3</button>'
                    + '</div>'
                    + '<div data-tab-content="tab1" class="tab-active" style="padding:24px; background:#f8fafc; border-radius:8px; border:1px solid #e2e8f0;"><p style="color:#475569; line-height:1.7;">Contenido del tab 1. Edita este texto con lo que necesites.</p></div>'
                    + '<div data-tab-content="tab2" style="padding:24px; background:#f8fafc; border-radius:8px; border:1px solid #e2e8f0; display:none;"><p style="color:#475569; line-height:1.7;">Contenido del tab 2. Personaliza esta seccion.</p></div>'
                    + '<div data-tab-content="tab3" style="padding:24px; background:#f8fafc; border-radius:8px; border:1px solid #e2e8f0; display:none;"><p style="color:#475569; line-height:1.7;">Contenido del tab 3. Agrega tus propios elementos.</p></div>'
                    + '</div>',
            });

            // --- Progress Bars ---
            bm.add('fx-progress', {
                label: 'Barras de Progreso',
                category: 'Efectos',
                content: '<div style="max-width:600px; margin:0 auto; padding:40px 20px;">'
                    + '<div style="margin-bottom:20px;">'
                    + '<div style="display:flex; justify-content:space-between; margin-bottom:8px;"><span style="font-weight:600; color:#1e293b;">Habilidad 1</span><span style="color:#64748b;">90%</span></div>'
                    + '<div data-progress="90" data-progress-duration="1500" style="height:8px; background:#e2e8f0; border-radius:4px; overflow:hidden;"><div style="height:100%; width:0; background:#6366f1; border-radius:4px; transition:width 1.5s ease;"></div></div>'
                    + '</div>'
                    + '<div style="margin-bottom:20px;">'
                    + '<div style="display:flex; justify-content:space-between; margin-bottom:8px;"><span style="font-weight:600; color:#1e293b;">Habilidad 2</span><span style="color:#64748b;">75%</span></div>'
                    + '<div data-progress="75" data-progress-duration="1500" style="height:8px; background:#e2e8f0; border-radius:4px; overflow:hidden;"><div style="height:100%; width:0; background:#0ea5e9; border-radius:4px; transition:width 1.5s ease;"></div></div>'
                    + '</div>'
                    + '<div style="margin-bottom:20px;">'
                    + '<div style="display:flex; justify-content:space-between; margin-bottom:8px;"><span style="font-weight:600; color:#1e293b;">Habilidad 3</span><span style="color:#64748b;">60%</span></div>'
                    + '<div data-progress="60" data-progress-duration="1500" style="height:8px; background:#e2e8f0; border-radius:4px; overflow:hidden;"><div style="height:100%; width:0; background:#f59e0b; border-radius:4px; transition:width 1.5s ease;"></div></div>'
                    + '</div>'
                    + '</div>',
            });

            // --- Marquee ---
            bm.add('fx-marquee', {
                label: 'Marquee / Ticker',
                category: 'Efectos',
                content: '<div data-marquee data-marquee-speed="40" data-marquee-direction="left" style="padding:20px 0; background:#f8fafc; overflow:hidden; white-space:nowrap;">'
                    + '<span style="display:inline-block; padding:0 40px; font-size:18px; color:#475569; font-weight:500;">&#10022; Texto 1</span>'
                    + '<span style="display:inline-block; padding:0 40px; font-size:18px; color:#475569; font-weight:500;">&#10022; Texto 2</span>'
                    + '<span style="display:inline-block; padding:0 40px; font-size:18px; color:#475569; font-weight:500;">&#10022; Texto 3</span>'
                    + '<span style="display:inline-block; padding:0 40px; font-size:18px; color:#475569; font-weight:500;">&#10022; Texto 4</span>'
                    + '<span style="display:inline-block; padding:0 40px; font-size:18px; color:#475569; font-weight:500;">&#10022; Texto 5</span>'
                    + '<span style="display:inline-block; padding:0 40px; font-size:18px; color:#475569; font-weight:500;">&#10022; Texto 6</span>'
                    + '</div>',
            });

            // --- Image Gallery with Lightbox ---
            bm.add('fx-lightbox-gallery', {
                label: 'Galeria Lightbox',
                category: 'Efectos',
                content: '<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px; max-width:900px; margin:0 auto; padding:40px 20px;">'
                    + '<img src="https://picsum.photos/400/300?random=10" data-lightbox data-lightbox-group="gallery" data-lightbox-caption="Foto 1" data-hover="scale" alt="Galeria 1" style="width:100%; border-radius:8px; cursor:pointer; aspect-ratio:4/3; object-fit:cover;">'
                    + '<img src="https://picsum.photos/400/300?random=11" data-lightbox data-lightbox-group="gallery" data-lightbox-caption="Foto 2" data-hover="scale" alt="Galeria 2" style="width:100%; border-radius:8px; cursor:pointer; aspect-ratio:4/3; object-fit:cover;">'
                    + '<img src="https://picsum.photos/400/300?random=12" data-lightbox data-lightbox-group="gallery" data-lightbox-caption="Foto 3" data-hover="scale" alt="Galeria 3" style="width:100%; border-radius:8px; cursor:pointer; aspect-ratio:4/3; object-fit:cover;">'
                    + '<img src="https://picsum.photos/400/300?random=13" data-lightbox data-lightbox-group="gallery" data-lightbox-caption="Foto 4" data-hover="scale" alt="Galeria 4" style="width:100%; border-radius:8px; cursor:pointer; aspect-ratio:4/3; object-fit:cover;">'
                    + '<img src="https://picsum.photos/400/300?random=14" data-lightbox data-lightbox-group="gallery" data-lightbox-caption="Foto 5" data-hover="scale" alt="Galeria 5" style="width:100%; border-radius:8px; cursor:pointer; aspect-ratio:4/3; object-fit:cover;">'
                    + '<img src="https://picsum.photos/400/300?random=15" data-lightbox data-lightbox-group="gallery" data-lightbox-caption="Foto 6" data-hover="scale" alt="Galeria 6" style="width:100%; border-radius:8px; cursor:pointer; aspect-ratio:4/3; object-fit:cover;">'
                    + '</div>',
            });

            // --- Counter Section ---
            bm.add('fx-counter', {
                label: 'Contadores',
                category: 'Efectos',
                content: '<section style="padding:60px 20px; background:#0f172a; color:#fff; text-align:center;">'
                    + '<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:24px; max-width:900px; margin:0 auto;">'
                    + '<div><span data-count="500" data-count-suffix="+" style="font-size:3rem; font-weight:800; display:block;">0</span><p style="color:#94a3b8; margin-top:8px; font-size:14px; text-transform:uppercase; letter-spacing:1px;">Clientes</p></div>'
                    + '<div><span data-count="1200" data-count-suffix="+" style="font-size:3rem; font-weight:800; display:block;">0</span><p style="color:#94a3b8; margin-top:8px; font-size:14px; text-transform:uppercase; letter-spacing:1px;">Proyectos</p></div>'
                    + '<div><span data-count="98" data-count-suffix="%" style="font-size:3rem; font-weight:800; display:block;">0</span><p style="color:#94a3b8; margin-top:8px; font-size:14px; text-transform:uppercase; letter-spacing:1px;">Satisfaccion</p></div>'
                    + '<div><span data-count="10" data-count-suffix="+" style="font-size:3rem; font-weight:800; display:block;">0</span><p style="color:#94a3b8; margin-top:8px; font-size:14px; text-transform:uppercase; letter-spacing:1px;">Anos</p></div>'
                    + '</div>'
                    + '</section>',
            });

            // --- Typewriter Heading ---
            bm.add('fx-typewriter', {
                label: 'Titulo Typewriter',
                category: 'Efectos',
                content: '<h2 data-typewriter data-typewriter-speed="60" data-typewriter-delay="0" style="font-size:2.5rem; font-weight:700; text-align:center; min-height:4rem; color:#1e293b; padding:40px 20px;">'
                    + 'Tu texto con efecto maquina de escribir'
                    + '</h2>',
            });

            // --- Sticky Navbar ---
            bm.add('fx-sticky-nav', {
                label: 'Navbar Sticky',
                category: 'Efectos',
                content: '<nav data-sticky data-sticky-offset="100" style="padding:16px 24px; background:#fff; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e2e8f0; z-index:100;">'
                    + '<span style="font-weight:700; font-size:18px; color:#1e293b;">Logo</span>'
                    + '<div style="display:flex; gap:24px;">'
                    + '<a href="#" style="text-decoration:none; color:#64748b; font-weight:500; font-size:15px;">Inicio</a>'
                    + '<a href="#" style="text-decoration:none; color:#64748b; font-weight:500; font-size:15px;">Servicios</a>'
                    + '<a href="#" style="text-decoration:none; color:#64748b; font-weight:500; font-size:15px;">Nosotros</a>'
                    + '<a href="#" style="text-decoration:none; color:#64748b; font-weight:500; font-size:15px;">Contacto</a>'
                    + '</div>'
                    + '</nav>',
            });

            // Keep "Efectos" category closed by default (Secciones stays open)
            editor.on('load', function() {
                setTimeout(function() {
                    var categories = editor.BlockManager.getCategories();
                    categories.each(function(cat) {
                        if (cat.get('id') === 'Efectos') {
                            cat.set('open', false);
                        }
                    });
                }, 150);
            });

        })();

        // =====================================================================
        // === EFFECTS INTEGRATION END ===
        // =====================================================================

        // =====================================================================
        // Load content on init
        // =====================================================================
        loadPageContent();

        // === SESSION PROTECTION: Check for local backup after content loads ===
        checkLocalBackup();

    })();
    </script>
</body>
</html>
