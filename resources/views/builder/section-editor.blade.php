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
        .toolbar-btn.edit-btn { color: #6366f1; }
        .toolbar-btn.edit-btn:hover { background: #eef2ff; color: #4f46e5; }
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
        .palette-presets {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
            margin-bottom: 4px;
        }
        .palette-preset {
            display: flex;
            gap: 3px;
            padding: 6px 8px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #fff;
        }
        .palette-preset:hover {
            border-color: #6366f1;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(99,102,241,0.15);
        }
        .palette-preset .ps {
            flex: 1;
            height: 20px;
            border-radius: 4px;
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

        /* ---- Section Edit Panel ---- */
        .edit-panel {
            position: fixed;
            top: 56px;
            right: -420px;
            width: 400px;
            height: calc(100vh - 56px);
            background: #fff;
            border-left: 1px solid #e2e8f0;
            box-shadow: -4px 0 24px rgba(0,0,0,0.08);
            z-index: 250;
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .edit-panel.open { right: 0; }
        .edit-panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }
        .edit-panel-title {
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .edit-panel-close {
            width: 32px;
            height: 32px;
            border: none;
            background: none;
            cursor: pointer;
            border-radius: 8px;
            color: #64748b;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .edit-panel-close:hover { background: #f1f5f9; color: #1e293b; }
        .edit-panel-body {
            flex: 1;
            overflow-y: auto;
            padding: 16px 20px;
        }
        .edit-field {
            margin-bottom: 16px;
        }
        .edit-field-label {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .edit-field input[type="text"],
        .edit-field textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            background: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
            resize: vertical;
        }
        .edit-field input[type="text"]:focus,
        .edit-field textarea:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99,102,241,0.15);
        }
        .edit-field textarea { min-height: 80px; }
        /* Link list editor */
        .edit-links-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .edit-link-row {
            display: flex;
            gap: 6px;
            align-items: center;
        }
        .edit-link-row input {
            flex: 1;
            padding: 7px 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 12px;
            font-family: 'Inter', sans-serif;
        }
        .edit-link-row input:focus {
            outline: none;
            border-color: #6366f1;
        }
        .edit-link-remove {
            width: 28px;
            height: 28px;
            border: none;
            background: none;
            cursor: pointer;
            color: #94a3b8;
            border-radius: 6px;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .edit-link-remove:hover { background: #fef2f2; color: #ef4444; }
        .edit-link-add {
            padding: 6px 12px;
            border: 1px dashed #d1d5db;
            background: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            color: #6366f1;
            font-weight: 500;
            transition: all 0.2s;
        }
        .edit-link-add:hover { border-color: #6366f1; background: #f5f3ff; }
        .edit-panel-actions {
            padding: 12px 20px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }
        .edit-panel-actions button {
            flex: 1;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .btn-apply {
            background: #6366f1;
            color: #fff;
            border: none;
        }
        .btn-apply:hover { background: #4f46e5; }
        .btn-cancel {
            background: #fff;
            color: #64748b;
            border: 1px solid #d1d5db;
        }
        .btn-cancel:hover { background: #f9fafb; }
        /* Image field in edit panel */
        .edit-image-preview {
            width: 100%;
            max-height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-bottom: 6px;
            cursor: pointer;
        }
        .edit-image-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border: 1px solid #d1d5db;
            background: #fff;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            color: #475569;
            transition: all 0.2s;
        }
        .edit-image-btn:hover { border-color: #6366f1; color: #6366f1; }

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

        /* ---- Loading Overlay ---- */
        .loading-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(6px);
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }
        .loading-overlay.visible { display: flex; }
        .loading-spinner {
            width: 40px; height: 40px;
            border: 4px solid #e2e8f0;
            border-top-color: #6366f1;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .loading-text {
            font-size: 15px;
            font-weight: 500;
            color: #475569;
        }
        .loading-subtext {
            font-size: 13px;
            color: #94a3b8;
        }

        /* ---- Image hover overlay ---- */
        .section-wrapper img {
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .section-wrapper img:hover {
            opacity: 0.8;
        }
        .img-overlay-hint {
            position: absolute;
            background: rgba(0,0,0,0.6);
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 6px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s;
            z-index: 40;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .section-wrapper img:hover + .img-overlay-hint,
        .img-overlay-hint.visible { opacity: 1; }

        /* ---- Image Picker Modal ---- */
        .image-picker-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 500;
            background: rgba(0,0,0,0.55);
            align-items: center;
            justify-content: center;
        }
        .image-picker-overlay.visible { display: flex; }
        .image-picker-modal {
            background: #fff;
            border-radius: 16px;
            width: 90%;
            max-width: 680px;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 24px 48px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .ip-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .ip-header h3 { font-size: 16px; font-weight: 600; color: #1e293b; }
        .ip-tabs {
            display: flex;
            border-bottom: 1px solid #e2e8f0;
        }
        .ip-tab {
            flex: 1;
            padding: 10px;
            text-align: center;
            font-size: 13px;
            font-weight: 500;
            color: #64748b;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
            background: none;
            border-top: none;
            border-left: none;
            border-right: none;
            font-family: 'Inter', sans-serif;
        }
        .ip-tab:hover { color: #1e293b; }
        .ip-tab.active { color: #6366f1; border-bottom-color: #6366f1; }
        .ip-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            min-height: 300px;
        }
        .ip-dropzone {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .ip-dropzone:hover, .ip-dropzone.dragover {
            border-color: #6366f1;
            background: #eef2ff;
        }
        .ip-dropzone-icon { font-size: 32px; margin-bottom: 8px; }
        .ip-dropzone-text { font-size: 14px; color: #475569; }
        .ip-dropzone-hint { font-size: 12px; color: #94a3b8; margin-top: 4px; }
        .ip-progress {
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            margin-top: 16px;
            overflow: hidden;
            display: none;
        }
        .ip-progress.visible { display: block; }
        .ip-progress-bar {
            height: 100%;
            background: #6366f1;
            border-radius: 2px;
            width: 0;
            transition: width 0.3s;
        }
        .ip-gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
        }
        .ip-gallery-item {
            aspect-ratio: 1;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .ip-gallery-item:hover { border-color: #6366f1; }
        .ip-gallery-item.selected { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99,102,241,0.3); }
        .ip-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .ip-footer {
            padding: 12px 20px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }
        .ip-btn {
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }
        .ip-btn-cancel { background: #f1f5f9; border: 1px solid #d1d5db; color: #475569; }
        .ip-btn-cancel:hover { background: #e2e8f0; }
        .ip-btn-apply { background: #6366f1; border: none; color: #fff; }
        .ip-btn-apply:hover { background: #4f46e5; }
        .ip-gallery-empty { text-align: center; padding: 40px; color: #94a3b8; font-size: 14px; }
        .ip-url-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            margin-top: 16px;
        }
        .ip-url-input:focus { outline: none; border-color: #6366f1; }

        /* ---- Effects Panel ---- */
        .effects-panel {
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
        .effects-panel.open { transform: translateX(0); }
        .effect-group {
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        .effect-group:last-child { border-bottom: none; }
        .effect-label {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .effect-select {
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
        .effect-select:focus { outline: none; border-color: #6366f1; }
        .effect-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            background: #eef2ff;
            color: #6366f1;
            font-size: 10px;
            font-weight: 600;
            border-radius: 10px;
        }
        .effect-hint {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 4px;
        }
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
            <button class="topbar-btn topbar-btn-ghost" onclick="toggleEffectsPanel()" title="Efectos">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                Efectos
            </button>
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
            <a href="{{ route('builder.wizard', $page) }}" class="topbar-btn topbar-btn-ghost" title="Regenerar pagina completa con Wizard IA">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Wizard IA
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
                        <button class="toolbar-btn edit-btn" onclick="openEditPanel({{ $index }})" title="Editar contenido">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </button>
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
            <div class="style-panel-label">Paleta de colores</div>
            <div class="palette-presets">
                <div class="palette-preset" onclick="applyPalette('#1E40AF','#3B82F6','#60A5FA','#F8FAFC','#0F172A')" title="Corporativo Azul">
                    <span class="ps" style="background:#1E40AF"></span><span class="ps" style="background:#3B82F6"></span><span class="ps" style="background:#60A5FA"></span>
                </div>
                <div class="palette-preset" onclick="applyPalette('#1E293B','#334155','#94A3B8','#F1F5F9','#0F172A')" title="Elegante Oscuro">
                    <span class="ps" style="background:#1E293B"></span><span class="ps" style="background:#334155"></span><span class="ps" style="background:#94A3B8"></span>
                </div>
                <div class="palette-preset" onclick="applyPalette('#4F46E5','#6366F1','#A5B4FC','#FAFAFE','#1E1B4B')" title="Indigo Moderno">
                    <span class="ps" style="background:#4F46E5"></span><span class="ps" style="background:#6366F1"></span><span class="ps" style="background:#A5B4FC"></span>
                </div>
                <div class="palette-preset" onclick="applyPalette('#047857','#059669','#6EE7B7','#F0FDF4','#022C22')" title="Esmeralda">
                    <span class="ps" style="background:#047857"></span><span class="ps" style="background:#059669"></span><span class="ps" style="background:#6EE7B7"></span>
                </div>
                <div class="palette-preset" onclick="applyPalette('#881337','#BE123C','#FDA4AF','#FFF1F2','#1C1917')" title="Borgona">
                    <span class="ps" style="background:#881337"></span><span class="ps" style="background:#BE123C"></span><span class="ps" style="background:#FDA4AF"></span>
                </div>
                <div class="palette-preset" onclick="applyPalette('#0C4A6E','#0369A1','#7DD3FC','#F0F9FF','#082F49')" title="Oceano Profundo">
                    <span class="ps" style="background:#0C4A6E"></span><span class="ps" style="background:#0369A1"></span><span class="ps" style="background:#7DD3FC"></span>
                </div>
                <div class="palette-preset" onclick="applyPalette('#292524','#44403C','#D97706','#FAFAF9','#1C1917')" title="Grafito & Dorado">
                    <span class="ps" style="background:#292524"></span><span class="ps" style="background:#44403C"></span><span class="ps" style="background:#D97706"></span>
                </div>
                <div class="palette-preset" onclick="applyPalette('#7C3AED','#8B5CF6','#C4B5FD','#FAF5FF','#2E1065')" title="Violeta Suave">
                    <span class="ps" style="background:#7C3AED"></span><span class="ps" style="background:#8B5CF6"></span><span class="ps" style="background:#C4B5FD"></span>
                </div>
                <div class="palette-preset" onclick="applyPalette('#818CF8','#6366F1','#A78BFA','#0F172A','#E2E8F0')" title="Nocturno">
                    <span class="ps" style="background:#818CF8"></span><span class="ps" style="background:#6366F1"></span><span class="ps" style="background:#A78BFA"></span>
                </div>
            </div>
        </div>

        <div class="style-panel-section">
            <div class="style-panel-label">Ajuste manual</div>
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

    {{-- Section Edit Panel --}}
    <div class="edit-panel" id="editPanel">
        <div class="edit-panel-header">
            <div class="edit-panel-title" id="editPanelTitle">Editar seccion</div>
            <button class="edit-panel-close" onclick="closeEditPanel()">&times;</button>
        </div>
        <div class="edit-panel-body" id="editPanelBody">
            {{-- Populated by JS --}}
        </div>
        <div class="edit-panel-actions">
            <button class="btn-cancel" onclick="closeEditPanel()">Cancelar</button>
            <button class="btn-apply" onclick="applyEditPanel()">Aplicar cambios</button>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <div class="loading-text" id="loadingText">Procesando...</div>
        <div class="loading-subtext" id="loadingSubtext">Esto puede tomar unos segundos</div>
    </div>

    {{-- Image Picker Modal --}}
    <div class="image-picker-overlay" id="imagePickerOverlay">
        <div class="image-picker-modal">
            <div class="ip-header">
                <h3>Seleccionar imagen</h3>
                <button class="modal-close" onclick="closeImagePicker()">&times;</button>
            </div>
            <div class="ip-tabs">
                <button class="ip-tab active" onclick="switchImageTab('upload')">Subir imagen</button>
                <button class="ip-tab" onclick="switchImageTab('gallery')">Galeria</button>
                <button class="ip-tab" onclick="switchImageTab('url')">URL externa</button>
            </div>
            <div class="ip-body">
                <div id="ipUploadTab">
                    <div class="ip-dropzone" id="ipDropzone">
                        <div class="ip-dropzone-icon">&#128247;</div>
                        <div class="ip-dropzone-text">Arrastra una imagen aqui o haz clic para seleccionar</div>
                        <div class="ip-dropzone-hint">JPG, PNG, WebP, GIF — Max 10MB</div>
                        <input type="file" id="ipFileInput" accept="image/jpeg,image/png,image/webp,image/gif" style="display:none;">
                    </div>
                    <div class="ip-progress" id="ipProgress">
                        <div class="ip-progress-bar" id="ipProgressBar"></div>
                    </div>
                </div>
                <div id="ipGalleryTab" style="display:none;">
                    <div class="ip-gallery-grid" id="ipGalleryGrid"></div>
                    <div class="ip-gallery-empty" id="ipGalleryEmpty" style="display:none;">No hay imagenes subidas aun</div>
                </div>
                <div id="ipUrlTab" style="display:none;">
                    <p style="font-size:13px;color:#475569;margin-bottom:8px;">Ingresa la URL de una imagen externa:</p>
                    <input type="url" class="ip-url-input" id="ipUrlInput" placeholder="https://ejemplo.com/imagen.jpg">
                    <div id="ipUrlPreview" style="margin-top:16px;text-align:center;"></div>
                </div>
            </div>
            <div class="ip-footer">
                <button class="ip-btn ip-btn-cancel" onclick="closeImagePicker()">Cancelar</button>
                <button class="ip-btn ip-btn-apply" id="ipApplyBtn" onclick="applySelectedImage()">Usar imagen</button>
            </div>
        </div>
    </div>

    {{-- Effects Panel --}}
    <div class="effects-panel" id="effectsPanel">
        <div class="style-panel-title">
            Efectos
            <button class="style-panel-close" onclick="toggleEffectsPanel()">&times;</button>
        </div>
        <p style="font-size:12px;color:#94a3b8;margin-bottom:16px;">Selecciona una seccion y aplica efectos de animacion.</p>
        <div id="effectsTarget" style="font-size:13px;color:#6366f1;font-weight:500;margin-bottom:16px;display:none;"></div>

        <div class="effect-group">
            <div class="effect-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Animacion al hacer scroll
            </div>
            <select class="effect-select" id="effectAnimate" onchange="applyEffect()">
                <option value="">Ninguna</option>
                <option value="fade-up">Aparecer desde abajo</option>
                <option value="fade-down">Aparecer desde arriba</option>
                <option value="fade-left">Aparecer desde la izquierda</option>
                <option value="fade-right">Aparecer desde la derecha</option>
                <option value="fade-zoom">Zoom de entrada</option>
                <option value="flip-up">Voltear hacia arriba</option>
            </select>
            <div class="effect-hint">La seccion se anima cuando el usuario llega a ella</div>
        </div>

        <div class="effect-group">
            <div class="effect-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2 2 4-4"/></svg>
                Retardo de animacion
            </div>
            <select class="effect-select" id="effectDelay" onchange="applyEffect()">
                <option value="">Sin retardo</option>
                <option value="200">200ms</option>
                <option value="400">400ms</option>
                <option value="600">600ms</option>
            </select>
        </div>

        <div class="effect-group">
            <div class="effect-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 14h6v6H4zM14 4h6v6h-6z"/><path d="M4 4h6v6H4zM14 14h6v6h-6z"/></svg>
                Efecto hover
            </div>
            <select class="effect-select" id="effectHover" onchange="applyEffect()">
                <option value="">Ninguno</option>
                <option value="scale">Escalar</option>
                <option value="shadow">Sombra</option>
                <option value="lift">Elevar</option>
                <option value="glow">Brillo</option>
            </select>
            <div class="effect-hint">Efecto al pasar el mouse sobre la seccion</div>
        </div>

        <div class="effect-group">
            <div class="effect-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M2 12h20"/></svg>
                Parallax
            </div>
            <select class="effect-select" id="effectParallax" onchange="applyEffect()">
                <option value="">Desactivado</option>
                <option value="0.1">Suave (0.1)</option>
                <option value="0.2">Medio (0.2)</option>
                <option value="0.3">Fuerte (0.3)</option>
            </select>
            <div class="effect-hint">Desplazamiento en profundidad al hacer scroll</div>
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
            showLoading('Regenerando seccion con IA...', 'Generando nuevo contenido');

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
                    hideLoading();
                    var statusEl = document.getElementById('saveStatus');
                    statusEl.textContent = 'Error al regenerar';
                    statusEl.className = 'save-status error';
                }
            })
            .catch(function() {
                hideLoading();
                var statusEl = document.getElementById('saveStatus');
                statusEl.textContent = 'Error al regenerar';
                statusEl.className = 'save-status error';
            });
        }

        function rebuildPage() {
            showLoading('Actualizando pagina...', 'Guardando cambios');
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
            showLoading('Agregando seccion...', 'Generando contenido con IA');

            fetch(@json(route('builder.sections.add', $page)), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    section_id: sectionId,
                    insert_index: addInsertIndex
                })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.success) {
                    // Actualizar estado local
                    sectionIds = data.section_ids || sectionIds;
                    if (data.section_content) {
                        sectionContent[sectionId] = data.section_content;
                    }

                    // Inyectar HTML en el DOM
                    var preview = document.getElementById('pagePreview');
                    var wrappers = preview.querySelectorAll('.section-wrapper');
                    var meta = getSectionMeta(sectionId);

                    // Crear nuevo wrapper
                    var newWrapper = document.createElement('div');
                    newWrapper.className = 'section-wrapper';
                    newWrapper.setAttribute('data-section-id', sectionId);
                    newWrapper.innerHTML =
                        '<div class="section-toolbar">' +
                            '<button class="toolbar-btn" title="Subir">&#9650;</button>' +
                            '<button class="toolbar-btn" title="Bajar">&#9660;</button>' +
                            '<button class="toolbar-btn edit-btn" title="Editar contenido"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>' +
                            '<button class="toolbar-btn" title="Regenerar con IA"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></button>' +
                            '<button class="toolbar-btn danger" title="Eliminar">&times;</button>' +
                        '</div>' +
                        data.html;

                    // Crear gap
                    var newGap = document.createElement('div');
                    newGap.className = 'add-section-gap';
                    newGap.innerHTML = '<button class="add-section-btn">+ Agregar seccion</button>';

                    // Insertar en posicion correcta
                    var gaps = preview.querySelectorAll('.add-section-gap');
                    if (addInsertIndex >= 0 && gaps[addInsertIndex]) {
                        gaps[addInsertIndex].after(newWrapper);
                        newWrapper.after(newGap);
                    } else {
                        // Al final (antes del gap final)
                        var lastGap = gaps[gaps.length - 1];
                        if (lastGap) {
                            lastGap.before(newWrapper);
                            lastGap.before(newGap);
                        }
                    }

                    // Actualizar CSS
                    if (data.css) {
                        document.getElementById('sectionStyles').textContent = data.css;
                    }

                    // Reconectar eventos
                    rebindToolbarEvents();
                    enableInlineEditing();
                    enableImageClicks();
                    buildSidebar();
                    markDirty();
                    hideLoading();

                    // Scroll a la nueva seccion
                    newWrapper.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    hideLoading();
                    alert('Error: ' + (data.message || 'No se pudo agregar la seccion'));
                }
            })
            .catch(function(err) {
                hideLoading();
                alert('Error de conexion al agregar seccion');
            });
        }

        function rebindToolbarEvents() {
            var wrappers = document.querySelectorAll('.section-wrapper');
            for (var i = 0; i < wrappers.length; i++) {
                (function(idx) {
                    var toolbar = wrappers[idx].querySelector('.section-toolbar');
                    if (!toolbar) return;
                    var btns = toolbar.querySelectorAll('.toolbar-btn');
                    if (btns[0]) btns[0].onclick = function() { moveSection(idx, -1); };
                    if (btns[1]) btns[1].onclick = function() { moveSection(idx, 1); };
                    if (btns[2]) btns[2].onclick = function() { openEditPanel(idx); };
                    if (btns[3]) btns[3].onclick = function() { regenerateSection(idx); };
                    if (btns[4]) btns[4].onclick = function() { deleteSection(idx); };
                })(i);
            }

            // Rebind add-section-gap buttons
            var gaps = document.querySelectorAll('.add-section-gap');
            for (var g = 0; g < gaps.length; g++) {
                (function(idx) {
                    var btn = gaps[idx].querySelector('.add-section-btn');
                    if (btn) btn.onclick = function() { openAddModal(idx); };
                })(g);
            }
        }

        // ============================================================
        // Style Panel
        // ============================================================
        var stylePanelOpen = false;

        function toggleStylePanel() {
            stylePanelOpen = !stylePanelOpen;
            var panel = document.getElementById('stylePanel');
            var main = document.getElementById('mainContent');

            // Close effects panel if open
            if (stylePanelOpen && effectsPanelOpen) {
                effectsPanelOpen = false;
                document.getElementById('effectsPanel').classList.remove('open');
            }

            if (stylePanelOpen) {
                panel.classList.add('open');
                main.classList.add('style-panel-open');
            } else {
                panel.classList.remove('open');
                if (!effectsPanelOpen) main.classList.remove('style-panel-open');
            }
        }

        function applyPalette(primary, secondary, accent, background, text) {
            updateColor('primary', primary);
            updateColor('secondary', secondary);
            updateColor('accent', accent);
            updateColor('background', background);
            updateColor('text', text);

            // Sync color picker inputs
            document.getElementById('colorPrimary').value = primary;
            document.getElementById('colorSecondary').value = secondary;
            document.getElementById('colorAccent').value = accent;
            document.getElementById('colorBackground').value = background;
            document.getElementById('colorText').value = text;
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
        // Section Edit Panel
        // ============================================================
        var editPanelIndex = -1;
        var editPanelSectionId = '';
        var editPanelFields = [];

        function openEditPanel(index) {
            var sectionId = sectionIds[index];
            if (!sectionId) return;

            editPanelIndex = index;
            editPanelSectionId = sectionId;

            // Close other panels
            var stylePanel = document.getElementById('stylePanel');
            if (stylePanel && stylePanel.classList.contains('open')) toggleStylePanel();
            var effectsPanel = document.getElementById('effectsPanel');
            if (effectsPanel && effectsPanel.classList.contains('open')) toggleEffectsPanel();

            // Fetch section fields from API
            fetch('/builder/' + pageId + '/sections/' + sectionId + '/edit', {
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (!data.success) return;

                editPanelFields = data.fields;
                document.getElementById('editPanelTitle').innerHTML =
                    '<span>' + (data.section_icon || '') + '</span> ' + (data.section_name || 'Editar');

                var body = document.getElementById('editPanelBody');
                body.innerHTML = '';

                data.fields.forEach(function(field) {
                    var div = document.createElement('div');
                    div.className = 'edit-field';

                    var label = document.createElement('div');
                    label.className = 'edit-field-label';
                    label.textContent = field.label;
                    div.appendChild(label);

                    if (field.type === 'text') {
                        var input = document.createElement('input');
                        input.type = 'text';
                        input.value = field.value || '';
                        input.dataset.key = field.key;
                        input.dataset.type = 'text';
                        div.appendChild(input);

                    } else if (field.type === 'textarea') {
                        var ta = document.createElement('textarea');
                        ta.value = field.value || '';
                        ta.dataset.key = field.key;
                        ta.dataset.type = 'textarea';
                        ta.rows = 3;
                        div.appendChild(ta);

                    } else if (field.type === 'image') {
                        var imgVal = field.value || '';
                        if (imgVal) {
                            var imgEl = document.createElement('img');
                            imgEl.src = imgVal;
                            imgEl.className = 'edit-image-preview';
                            imgEl.onclick = function() { editImageField(field.key); };
                            div.appendChild(imgEl);
                        }
                        var imgBtn = document.createElement('button');
                        imgBtn.className = 'edit-image-btn';
                        imgBtn.textContent = imgVal ? 'Cambiar imagen' : 'Elegir imagen';
                        imgBtn.dataset.key = field.key;
                        imgBtn.onclick = function() { editImageField(field.key); };
                        div.appendChild(imgBtn);
                        var imgInput = document.createElement('input');
                        imgInput.type = 'hidden';
                        imgInput.value = imgVal;
                        imgInput.dataset.key = field.key;
                        imgInput.dataset.type = 'image';
                        div.appendChild(imgInput);

                    } else if (field.type === 'links') {
                        var linksList = document.createElement('div');
                        linksList.className = 'edit-links-list';
                        linksList.dataset.key = field.key;
                        linksList.dataset.type = 'links';

                        var links = Array.isArray(field.value) ? field.value : [];
                        links.forEach(function(link, li) {
                            linksList.appendChild(createLinkRow(link.text || '', link.url || '#', li));
                        });

                        var addBtn = document.createElement('button');
                        addBtn.className = 'edit-link-add';
                        addBtn.textContent = '+ Agregar enlace';
                        addBtn.onclick = function() {
                            linksList.insertBefore(createLinkRow('Nuevo enlace', '#', linksList.children.length - 1), addBtn);
                        };
                        linksList.appendChild(addBtn);
                        div.appendChild(linksList);

                    } else if (field.type === 'stats' || field.type === 'features' || field.type === 'testimonials' || field.type === 'pricing' || field.type === 'faq' || field.type === 'gallery' || field.type === 'marquee') {
                        // Complex array types — JSON editor
                        var ta2 = document.createElement('textarea');
                        ta2.value = JSON.stringify(field.value, null, 2);
                        ta2.dataset.key = field.key;
                        ta2.dataset.type = 'json';
                        ta2.rows = 6;
                        ta2.style.fontFamily = 'monospace';
                        ta2.style.fontSize = '11px';
                        div.appendChild(ta2);

                    } else {
                        // Fallback to text input
                        var inp = document.createElement('input');
                        inp.type = 'text';
                        inp.value = typeof field.value === 'string' ? field.value : JSON.stringify(field.value);
                        inp.dataset.key = field.key;
                        inp.dataset.type = 'text';
                        div.appendChild(inp);
                    }

                    body.appendChild(div);
                });

                document.getElementById('editPanel').classList.add('open');

                // Highlight active section
                var wrappers = document.querySelectorAll('.section-wrapper');
                wrappers.forEach(function(w) { w.classList.remove('active'); });
                if (wrappers[index]) {
                    wrappers[index].classList.add('active');
                    wrappers[index].scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        }

        function createLinkRow(text, url, index) {
            var row = document.createElement('div');
            row.className = 'edit-link-row';

            var textInput = document.createElement('input');
            textInput.type = 'text';
            textInput.value = text;
            textInput.placeholder = 'Texto';
            textInput.dataset.linkField = 'text';

            var urlInput = document.createElement('input');
            urlInput.type = 'text';
            urlInput.value = url;
            urlInput.placeholder = 'URL (#seccion o /pagina)';
            urlInput.dataset.linkField = 'url';

            var removeBtn = document.createElement('button');
            removeBtn.className = 'edit-link-remove';
            removeBtn.innerHTML = '&times;';
            removeBtn.onclick = function() { row.remove(); };

            row.appendChild(textInput);
            row.appendChild(urlInput);
            row.appendChild(removeBtn);
            return row;
        }

        function editImageField(fieldKey) {
            // Use the existing image picker and update the hidden input on selection
            window._editPanelImageKey = fieldKey;
            currentImageTarget = null; // Clear regular image target
            openImagePicker();
        }

        function closeEditPanel() {
            document.getElementById('editPanel').classList.remove('open');
            editPanelIndex = -1;
            editPanelSectionId = '';
            editPanelFields = [];
            var wrappers = document.querySelectorAll('.section-wrapper');
            wrappers.forEach(function(w) { w.classList.remove('active'); });
        }

        function applyEditPanel() {
            if (editPanelIndex === -1 || !editPanelSectionId) return;

            var body = document.getElementById('editPanelBody');
            var content = {};

            // Collect values from form
            body.querySelectorAll('[data-key]').forEach(function(el) {
                var key = el.dataset.key;
                var type = el.dataset.type;

                if (type === 'text' || type === 'textarea') {
                    content[key] = el.value;
                } else if (type === 'image') {
                    if (el.value) content[key] = el.value;
                } else if (type === 'json') {
                    try {
                        content[key] = JSON.parse(el.value);
                    } catch(e) {
                        alert('Error en JSON del campo "' + key + '". Revisa la sintaxis.');
                        return;
                    }
                } else if (type === 'links') {
                    var links = [];
                    el.querySelectorAll('.edit-link-row').forEach(function(row) {
                        var t = row.querySelector('[data-link-field="text"]');
                        var u = row.querySelector('[data-link-field="url"]');
                        if (t && u && t.value.trim()) {
                            links.push({ text: t.value.trim(), url: u.value.trim() || '#' });
                        }
                    });
                    content[key] = links;
                }
            });

            showLoading('Aplicando cambios...', 'Re-renderizando seccion');

            // POST to render endpoint
            fetch('/builder/' + pageId + '/sections/render', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    section_id: editPanelSectionId,
                    content: content,
                }),
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                hideLoading();
                if (!data.success) {
                    alert(data.message || 'Error al aplicar cambios');
                    return;
                }

                // Replace section HTML in DOM
                var wrappers = document.querySelectorAll('.section-wrapper');
                var wrapper = wrappers[editPanelIndex];
                if (wrapper) {
                    // Keep toolbar, replace content
                    var toolbar = wrapper.querySelector('.section-toolbar');
                    wrapper.innerHTML = '';
                    wrapper.appendChild(toolbar);
                    wrapper.insertAdjacentHTML('beforeend', data.html);

                    // Re-enable inline editing and image clicks on new content
                    enableInlineEditing();
                    enableImageClicks();
                    rebindToolbarEvents();
                }

                // Update sectionContent
                sectionContent[editPanelSectionId] = content;
                markDirty();

                closeEditPanel();
            })
            .catch(function(err) {
                hideLoading();
                alert('Error de red al aplicar cambios');
            });
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
        // Loading Overlay
        // ============================================================
        function showLoading(text, subtext) {
            document.getElementById('loadingText').textContent = text || 'Procesando...';
            document.getElementById('loadingSubtext').textContent = subtext || '';
            document.getElementById('loadingOverlay').classList.add('visible');
        }
        function hideLoading() {
            document.getElementById('loadingOverlay').classList.remove('visible');
        }

        // ============================================================
        // Image Picker
        // ============================================================
        var currentImageTarget = null;
        var selectedImageUrl = '';
        var galleryCache = null;

        function enableImageClicks() {
            var imgs = document.querySelectorAll('.section-wrapper img');
            imgs.forEach(function(img) {
                if (img._imageClickBound) return;
                img._imageClickBound = true;
                img.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    currentImageTarget = img;
                    selectedImageUrl = '';
                    openImagePicker();
                });
            });
        }

        function openImagePicker() {
            document.getElementById('imagePickerOverlay').classList.add('visible');
            switchImageTab('upload');
        }

        function closeImagePicker() {
            document.getElementById('imagePickerOverlay').classList.remove('visible');
            currentImageTarget = null;
            selectedImageUrl = '';
        }

        function switchImageTab(tab) {
            document.querySelectorAll('.ip-tab').forEach(function(t, i) {
                t.classList.toggle('active', (i === 0 && tab === 'upload') || (i === 1 && tab === 'gallery') || (i === 2 && tab === 'url'));
            });
            document.getElementById('ipUploadTab').style.display = tab === 'upload' ? '' : 'none';
            document.getElementById('ipGalleryTab').style.display = tab === 'gallery' ? '' : 'none';
            document.getElementById('ipUrlTab').style.display = tab === 'url' ? '' : 'none';

            if (tab === 'gallery') loadGallery();
        }

        function loadGallery() {
            if (galleryCache) {
                renderGallery(galleryCache);
                return;
            }
            var grid = document.getElementById('ipGalleryGrid');
            grid.innerHTML = '<div style="text-align:center;padding:20px;color:#94a3b8;">Cargando...</div>';

            fetch('/api/media', {
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                galleryCache = data.data || data || [];
                renderGallery(galleryCache);
            })
            .catch(function() {
                grid.innerHTML = '';
                document.getElementById('ipGalleryEmpty').style.display = 'block';
            });
        }

        function renderGallery(items) {
            var grid = document.getElementById('ipGalleryGrid');
            var empty = document.getElementById('ipGalleryEmpty');
            grid.innerHTML = '';

            if (!items || items.length === 0) {
                empty.style.display = 'block';
                return;
            }
            empty.style.display = 'none';

            items.forEach(function(item) {
                var url = item.url || item.path || item;
                var div = document.createElement('div');
                div.className = 'ip-gallery-item';
                div.innerHTML = '<img src="' + url + '" alt="" loading="lazy">';
                div.onclick = function() {
                    document.querySelectorAll('.ip-gallery-item').forEach(function(g) { g.classList.remove('selected'); });
                    div.classList.add('selected');
                    selectedImageUrl = url;
                };
                grid.appendChild(div);
            });
        }

        function applySelectedImage() {
            // Check URL tab
            if (document.getElementById('ipUrlTab').style.display !== 'none') {
                var urlVal = document.getElementById('ipUrlInput').value.trim();
                if (urlVal) selectedImageUrl = urlVal;
            }

            if (!selectedImageUrl) {
                alert('Selecciona una imagen primero');
                return;
            }

            // If called from edit panel image field
            if (window._editPanelImageKey) {
                var key = window._editPanelImageKey;
                var hiddenInput = document.querySelector('#editPanelBody input[data-key="' + key + '"][data-type="image"]');
                if (hiddenInput) hiddenInput.value = selectedImageUrl;
                var previewImg = hiddenInput ? hiddenInput.parentElement.querySelector('.edit-image-preview') : null;
                if (previewImg) {
                    previewImg.src = selectedImageUrl;
                } else if (hiddenInput) {
                    var newImg = document.createElement('img');
                    newImg.src = selectedImageUrl;
                    newImg.className = 'edit-image-preview';
                    hiddenInput.parentElement.insertBefore(newImg, hiddenInput.parentElement.firstChild);
                }
                window._editPanelImageKey = null;
                closeImagePicker();
                return;
            }

            if (!currentImageTarget) {
                alert('Selecciona una imagen primero');
                return;
            }

            currentImageTarget.src = selectedImageUrl;
            markDirty();
            closeImagePicker();
        }

        // Upload handlers
        document.addEventListener('DOMContentLoaded', function() {
            var dropzone = document.getElementById('ipDropzone');
            var fileInput = document.getElementById('ipFileInput');

            if (dropzone) {
                dropzone.onclick = function() { fileInput.click(); };

                dropzone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    dropzone.classList.add('dragover');
                });
                dropzone.addEventListener('dragleave', function() {
                    dropzone.classList.remove('dragover');
                });
                dropzone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    dropzone.classList.remove('dragover');
                    if (e.dataTransfer.files.length > 0) uploadImage(e.dataTransfer.files[0]);
                });
            }

            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    if (fileInput.files.length > 0) uploadImage(fileInput.files[0]);
                });
            }

            // URL preview
            var urlInput = document.getElementById('ipUrlInput');
            if (urlInput) {
                urlInput.addEventListener('input', function() {
                    var preview = document.getElementById('ipUrlPreview');
                    if (urlInput.value.match(/^https?:\/\/.+\.(jpg|jpeg|png|gif|webp|svg)/i)) {
                        preview.innerHTML = '<img src="' + urlInput.value + '" style="max-width:200px;max-height:150px;border-radius:8px;border:1px solid #e2e8f0;">';
                        selectedImageUrl = urlInput.value;
                    } else {
                        preview.innerHTML = '';
                    }
                });
            }

            // Close image picker on overlay click
            var overlay = document.getElementById('imagePickerOverlay');
            if (overlay) {
                overlay.addEventListener('click', function(e) {
                    if (e.target === this) closeImagePicker();
                });
            }
        });

        function uploadImage(file) {
            if (file.size > 10 * 1024 * 1024) {
                alert('La imagen es demasiado grande (max 10MB)');
                return;
            }

            var progress = document.getElementById('ipProgress');
            var bar = document.getElementById('ipProgressBar');
            progress.classList.add('visible');
            bar.style.width = '30%';

            var formData = new FormData();
            formData.append('file', file);

            fetch('/api/media/upload', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function(r) {
                bar.style.width = '80%';
                return r.json();
            })
            .then(function(data) {
                bar.style.width = '100%';
                setTimeout(function() {
                    progress.classList.remove('visible');
                    bar.style.width = '0';
                }, 500);

                if (data.url || data.path) {
                    selectedImageUrl = data.url || data.path;
                    galleryCache = null; // Invalidate cache
                    // Auto-apply if there's a target
                    if (currentImageTarget) {
                        currentImageTarget.src = selectedImageUrl;
                        markDirty();
                        closeImagePicker();
                    }
                } else {
                    alert('Error al subir la imagen');
                }
            })
            .catch(function() {
                progress.classList.remove('visible');
                bar.style.width = '0';
                alert('Error al subir la imagen');
            });
        }

        // ============================================================
        // Effects Panel
        // ============================================================
        var effectsPanelOpen = false;
        var effectsTargetIndex = -1;

        function toggleEffectsPanel() {
            effectsPanelOpen = !effectsPanelOpen;
            var panel = document.getElementById('effectsPanel');
            var main = document.getElementById('mainContent');

            // Close style panel if open
            if (effectsPanelOpen && stylePanelOpen) {
                toggleStylePanel();
            }

            if (effectsPanelOpen) {
                panel.classList.add('open');
                main.classList.add('style-panel-open');
                selectEffectsSection(0);
            } else {
                panel.classList.remove('open');
                if (!stylePanelOpen) main.classList.remove('style-panel-open');
            }
        }

        function selectEffectsSection(index) {
            effectsTargetIndex = index;
            var wrappers = document.querySelectorAll('.section-wrapper');
            if (!wrappers[index]) return;

            var secId = wrappers[index].getAttribute('data-section-id');
            var meta = getSectionMeta(secId);
            var target = document.getElementById('effectsTarget');
            target.textContent = (meta ? meta.icon + ' ' + meta.name : secId);
            target.style.display = 'block';

            // Read current effects from the section's first child element
            var sectionEl = wrappers[index].querySelector('section, div:not(.section-toolbar)');
            if (!sectionEl) sectionEl = wrappers[index];

            document.getElementById('effectAnimate').value = sectionEl.getAttribute('data-animate') || '';
            document.getElementById('effectDelay').value = sectionEl.getAttribute('data-animate-delay') || '';
            document.getElementById('effectHover').value = sectionEl.getAttribute('data-hover') || '';
            document.getElementById('effectParallax').value = sectionEl.getAttribute('data-parallax') || '';

            // Highlight in sidebar
            document.querySelectorAll('.sidebar-item').forEach(function(el, i) {
                el.classList.toggle('active', i === index);
            });
        }

        function applyEffect() {
            var wrappers = document.querySelectorAll('.section-wrapper');
            if (effectsTargetIndex < 0 || !wrappers[effectsTargetIndex]) return;

            var sectionEl = wrappers[effectsTargetIndex].querySelector('section, div:not(.section-toolbar)');
            if (!sectionEl) sectionEl = wrappers[effectsTargetIndex];

            var animate = document.getElementById('effectAnimate').value;
            var delay = document.getElementById('effectDelay').value;
            var hover = document.getElementById('effectHover').value;
            var parallax = document.getElementById('effectParallax').value;

            // Apply or remove attributes
            if (animate) { sectionEl.setAttribute('data-animate', animate); }
            else { sectionEl.removeAttribute('data-animate'); }

            if (delay) { sectionEl.setAttribute('data-animate-delay', delay); }
            else { sectionEl.removeAttribute('data-animate-delay'); }

            if (hover) { sectionEl.setAttribute('data-hover', hover); }
            else { sectionEl.removeAttribute('data-hover'); }

            if (parallax) { sectionEl.setAttribute('data-parallax', parallax); }
            else { sectionEl.removeAttribute('data-parallax'); }

            markDirty();
        }

        // Allow clicking sections to select them for effects
        document.addEventListener('click', function(e) {
            if (!effectsPanelOpen) return;
            var wrapper = e.target.closest('.section-wrapper');
            if (wrapper) {
                var idx = Array.from(document.querySelectorAll('.section-wrapper')).indexOf(wrapper);
                if (idx >= 0) selectEffectsSection(idx);
            }
        });

        // ============================================================
        // Init
        // ============================================================
        buildSidebar();
        enableInlineEditing();
        enableImageClicks();

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
