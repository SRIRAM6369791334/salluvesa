@extends('layouts.app')

{{-- ═══════════ STYLES (pushed to <head> — no CSS inside @section) ══════════ --}}
@push('styles')
    {{-- Single consolidated Google Fonts load (removed duplicate) --}}
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&family=Red+Hat+Display:ital,wght@0,400;0,500;0,700;0,900;1,400&family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premium-ui.css') }}">
@endpush

@section('content')

{{-- CSRF meta (required by JS – placed before scripts) --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Hidden product context --}}
<input type="hidden" id="customproduct_id" value="{{ request('product_id', $product_id ?? '') }}">
<input type="hidden" id="design_id" value="{{ request('design_id') }}">

{{-- Mobile Blocker Overlay --}}
<style>
    .mobile-blocked-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: #f8fafc;
        z-index: 2147483647; /* Higher than everything */
        align-items: center;
        justify-content: center;
        text-align: center;
        flex-direction: column;
        padding: 2rem;
    }
    .mobile-blocked-overlay h2 {
        color: #111827;
        font-weight: 800;
        margin-top: 1.5rem;
        font-family: var(--font-display, 'Outfit', sans-serif);
    }
    .mobile-blocked-overlay p {
        color: #6b7280;
        max-width: 450px;
        margin-top: 1rem;
        line-height: 1.6;
    }
    /* Hide WhatsApp floating icon & scroll-top button specifically on Custom Designer page */
    .whatsapp_float_btn,
    #cs_scroll_btn {
        display: none !important;
    }

    @keyframes sizePulse {
        0% { outline: 3px solid #1C30A3; box-shadow: 0 0 10px rgba(28, 48, 163, 0.5); }
        50% { outline: 4px solid #ef4444; box-shadow: 0 0 15px rgba(239, 68, 68, 0.7); }
        100% { outline: 3px solid #1C30A3; box-shadow: 0 0 10px rgba(28, 48, 163, 0.5); }
    }
    .size-highlight-pulse {
        animation: sizePulse 0.6s ease-in-out 3;
        border-radius: 8px;
    }

    /* ════════════════════════ UNIFIED SIDEBAR PREMIUM UI ════════════════════════ */
    .cs_design_sidebar {
        background: #0f172a !important; /* Deep luxury navy */
        border-right: 1px solid #1e293b;
    }
    .cs_sidebar_tab {
        border-radius: 14px !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    .cs_sidebar_tab:hover {
        background: rgba(255, 255, 255, 0.08) !important;
        transform: translateY(-2px);
    }
    .cs_sidebar_tab.active {
        background: linear-gradient(135deg, #1C30A3 0%, #0d1b69 100%) !important;
        box-shadow: 0 6px 20px rgba(28, 48, 163, 0.4) !important;
    }

    .cs_design_drawer {
        width: 410px !important;
        background: #f8fafc !important; /* Soft off-white backdrop */
        border-right: 1.5px solid #e2e8f0 !important;
    }
    .cs_drawer_header {
        background: #ffffff !important;
        border-bottom: 1.5px solid #e2e8f0 !important;
        padding: 20px 24px !important;
    }
    .cs_drawer_header h3 {
        font-family: var(--font-display, 'Outfit', sans-serif);
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #0f172a;
    }
    .cs_drawer_content {
        padding: 20px 22px !important;
    }

    /* Section Cards inside Drawer */
    .cs_unified_mode .cs_tool_panel {
        background: #ffffff !important;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 16px !important;
        padding: 20px !important;
        margin-bottom: 20px !important;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03) !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .cs_unified_mode .cs_tool_panel:hover {
        border-color: #cbd5e1 !important;
        box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06) !important;
    }

    /* Size Buttons styling */
    .cs_size_grid .cs_size_btn {
        height: 42px !important;
        min-width: 50px !important;
        padding: 0 16px !important;
        border: 1.5px solid #cbd5e1 !important;
        background: #ffffff !important;
        color: #1e293b !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        border-radius: 10px !important;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    .cs_size_grid .cs_size_btn:hover {
        border-color: #1C30A3 !important;
        color: #1C30A3 !important;
        background: #f0f4ff !important;
        transform: translateY(-2px);
    }
    .cs_size_grid .cs_size_btn.active {
        background: linear-gradient(135deg, #1C30A3 0%, #0d1b69 100%) !important;
        color: #ffffff !important;
        border-color: #1C30A3 !important;
        box-shadow: 0 4px 14px rgba(28, 48, 163, 0.35) !important;
    }

    /* Upload Box styling */
    .cs_upload_box {
        border: 2px dashed #cbd5e1 !important;
        background: #f8fafc !important;
        border-radius: 16px !important;
        padding: 30px 20px !important;
        transition: all 0.3s ease !important;
    }
    .cs_upload_box:hover {
        border-color: #1C30A3 !important;
        background: #f0f4ff !important;
        transform: translateY(-2px);
    }
    .cs_upload_box i {
        color: #1C30A3 !important;
        transition: transform 0.3s ease;
    }
    .cs_upload_box:hover i {
        transform: scale(1.15);
    }

    @media (min-width: 200px) and (max-width: 1300px) {
        .mobile-blocked-overlay {
            display: flex !important;
        }
        /* Hide the design app, AND the site's default header/footer/buttons on this page */
        .cs_design_lab_app,
        .cs_site_header,
        .cs_footer,
        .whatsapp_float_btn,
        #cs_scroll_btn,
        .cs_page_heading {
            display: none !important;
        }
        
        /* Remove padding/margin from body so overlay takes full space flawlessly */
        body { padding: 0 !important; margin: 0 !important; }
    }
</style>

<div class="mobile-blocked-overlay">
    <i class="fas fa-laptop-code fa-4x" style="color: #1C30A3;"></i>
    <h2>Desktop Recommended</h2>
    <p>{{ gt('Our custom design studio requires a larger workspace. Please switch to a device with a screen wider than 1300px for the best designing experience.') }}</p>
    <a href="{{ url('/') }}" class="cs_btn_primary mt-4" style="text-decoration: none;"><i class="fas fa-home me-2"></i> {{ gt('Return Home') }}</a>
</div>

<div class="cs_design_lab_app">

    {{-- ══════════════════════════════ HEADER ══════════════════════════════ --}}
    <header class="cs_design_header">
        <a href="{{ url('/') }}" class="cs_header_logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
            <span>saalu<em>vesa</em></span>
        </a>

        <div class="cs_header_controls">
            <div class="cs_control_group">
                <button class="cs_header_btn" id="undo-btn" title="Undo (Ctrl+Z)" disabled>
                    <i class="fas fa-undo"></i>
                </button>
                <button class="cs_header_btn" id="redo-btn" title="Redo (Ctrl+Y)" disabled>
                    <i class="fas fa-redo"></i>
                </button>
            </div>

            <div class="cs_zoom_pill">
                <button id="zoom-out-btn" title="Zoom Out"><i class="fas fa-minus"></i></button>
                <span id="zoom-level">100%</span>
                <button id="zoom-in-btn" title="Zoom In"><i class="fas fa-plus"></i></button>
            </div>

            <div style="flex: 1;"></div>

            <div class="cs_header_btn_group" style="display: none !important;">
                <input type="text" id="design-name-input" class="cs_header_input" placeholder="{{ gt('Design Name') }}" value="Untitled Design">
            </div>

            <button class="cs_header_btn" id="save-design-btn" title="{{ gt('Save Draft') }}" style="display: none !important;">
                <i class="fas fa-save"></i> {{ gt('Save') }}
            </button>
            <button class="cs_header_btn accent" id="add-to-cart-btn" style="padding: 0 24px; font-weight: 700;">
                {{ gt('Get Price & Checkout') }} <i class="fas fa-chevron-right" style="margin-left: 10px;"></i>
            </button>
        </div>
    </header>

    {{-- ══════════════════════════════ MAIN LAYOUT ══════════════════════════ --}}
    <div class="cs_design_main">

        {{-- ══════════ SIDEBAR ══════════════════════════════════════════════ --}}
        <div class="cs_design_sidebar">
            <div class="cs_sidebar_nav">
                <button class="cs_sidebar_tab active" data-tool="upload" data-title="{{ gt('Upload Image') }}">
                    <i class="fas fa-upload"></i>
                    <span>{{ gt('Upload') }}</span>
                </button>
                <button class="cs_sidebar_tab" data-tool="text" data-title="{{ gt('Edit Text') }}">
                    <i class="fas fa-font"></i>
                    <span>{{ gt('Add Text') }}</span>
                </button>
                <button class="cs_sidebar_tab" data-tool="clipart" data-title="{{ gt('Add Art') }}" style="display: none !important;">
                    <i class="fas fa-shapes"></i>
                    <span>{{ gt('Add Art') }}</span>
                </button>
                <button class="cs_sidebar_tab" data-tool="product" data-title="{{ gt('Product Options') }}">
                    <i class="fas fa-tshirt"></i>
                    <span>{{ gt('Product') }}</span>
                </button>
                <!-- <button class="cs_sidebar_tab" data-tool="names-numbers" data-title="{{ gt('Personalize Team') }}">
                    <i class="fas fa-users-cog"></i>
                    <span>{{ gt('Personalize') }}</span>
                </button> -->
            </div>

            <div class="cs_sidebar_bottom" style="display: none !important;">
                <button class="cs_sidebar_tab" data-tool="layers" data-title="{{ gt('Manage Layers') }}" style="display: none !important;">
                    <i class="fas fa-layer-group"></i>
                    <span>{{ gt('Layers') }}</span>
                </button>
            </div>
        </div>

        {{-- ══════════ CONTEXTUAL DRAWER (UNIFIED SIDEBAR) ═══════════════════ --}}
        <div class="cs_design_drawer active" id="design-drawer">
            <div class="cs_drawer_header">
                <h3 id="drawer-title">{{ gt('Design Studio Tools') }}</h3>
                <button class="cs_drawer_close" id="close-drawer" aria-label="{{ gt('Close panel') }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="cs_drawer_content cs_unified_mode">

                {{-- ── 1. Product & Size Options (Prominent First Section) ─ --}}
                <div class="cs_tool_panel active" id="tool-panel-product" style="padding-bottom: 18px; border-bottom: 1.5px solid #e2e8f0; margin-bottom: 20px;">
                    <div style="font-size: 13px; font-weight: 700; color: #1C30A3; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fas fa-tshirt me-1"></i> 1. {{ gt('Select Size & Quantity') }}</span>
                        <span class="badge" style="background: #e0e7ff; color: #1C30A3; font-size: 10px; font-weight: 700; padding: 4px 8px; border-radius: 6px;">Required</span>
                    </div>
                    <div class="cs_drawer_section" style="margin-bottom: 14px;">
                        <label class="cs_drawer_label" style="font-weight: 600;">{{ gt('Select Size') }} <span style="color: #ef4444;">*</span></label>
                        <div class="cs_size_grid" id="product-size-grid">
                            {{-- Populated by ProductEngine --}}
                        </div>
                    </div>
                    <div class="cs_drawer_section" style="margin-bottom: 0;">
                        <label class="cs_drawer_label" style="font-weight: 600;">{{ gt('Quantity') }}</label>
                        <input type="number" class="cs_drawer_input" id="quantity-input"
                                value="1" min="1" placeholder="{{ gt('Qty') }}">
                    </div>
                </div>

                {{-- ── 2. Upload Image Panel ──────────────────────────────────────── --}}
                <div class="cs_tool_panel active" id="tool-panel-upload" style="padding-bottom: 18px; border-bottom: 1.5px solid #e2e8f0; margin-bottom: 20px;">
                    <div style="font-size: 13px; font-weight: 700; color: #1C30A3; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-upload"></i> 2. {{ gt('Upload Image / Logo') }}
                    </div>
                    <div class="cs_upload_box" id="upload-area" role="button" tabindex="0"
                         aria-label="{{ gt('Click or drag an image here to upload') }}">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <h4>{{ gt('Drop image here') }}</h4>
                        <p>{{ gt('PNG, JPG, WEBP up to 10MB — no SVG') }}</p>
                        {{-- Accept attribute enforced at JS level too --}}
                        <input type="file" id="file-input" hidden accept="image/png,image/jpeg,image/webp,image/gif">
                    </div>
                    <div class="cs_info_alert" style="margin-top: 15px;">
                        <i class="fas fa-shield-alt"></i>
                        <p>{{ gt('We respect copyrights. Please only upload art you own or have licensed.') }}</p>
                    </div>
                </div>

                {{-- ── 3. Add & Edit Text Panel ────────────────────────────────────────── --}}
                <div class="cs_tool_panel active" id="tool-panel-text">
                    <div style="font-size: 13px; font-weight: 700; color: #1C30A3; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-font"></i> 3. {{ gt('Add & Edit Text') }}
                    </div>
                    <div class="cs_drawer_section">
                        <label class="cs_drawer_label">{{ gt('New Design Layer') }}</label>
                        <button class="cs_btn_primary" style="width: 100%" id="add-text-btn">
                            <i class="fas fa-plus"></i> {{ gt('Add Text To Design') }}
                        </button>
                        <textarea id="text-content" class="cs_drawer_input" rows="2"
                                  placeholder="{{ gt('Your Text Here') }}"
                                  style="margin-top: 10px; display: none;"
                                  aria-label="{{ gt('Text content') }}"></textarea>
                    </div>

                    <div class="cs_drawer_section">
                        <label class="cs_drawer_label">{{ gt('Typography') }}</label>
                        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 10px; margin-bottom: 10px;">
                            <select class="cs_drawer_select" id="font-family" aria-label="{{ gt('Font family') }}">
                                <option value="Red Hat Display">Red Hat Display</option>
                                <option value="Bebas Neue">Bebas Neue</option>
                                <option value="Lobster">Lobster</option>
                                <option value="Outfit">Outfit</option>
                                <option value="Arial">Arial</option>
                                <option value="Times New Roman">Times New Roman</option>
                            </select>
                            <input type="number" class="cs_drawer_input" id="font-size"
                                   value="1" step="0.1" min="0.1" max="5"
                                   aria-label="{{ gt('Font size in inches') }}" title="{{ gt('Font Size (inches)') }}">
                        </div>
                        <div class="cs_control_group" style="background: transparent; padding: 0; margin: 0;">
                            <label class="cs_control_label">
                                <i class="fas fa-text-width"></i> {{ gt('Letter Spacing') }}
                            </label>
                            <input type="range" class="cs_range_slider" id="char-spacing"
                                   min="-100" max="500" value="0" aria-label="{{ gt('Letter spacing') }}">
                        </div>
                    </div>

                    <div class="cs_drawer_section">
                        <label class="cs_drawer_label">{{ gt('Styling') }}</label>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <div style="flex: 1;">
                                <label class="cs_control_sublabel">{{ gt('Fill Color') }}</label>
                                <input type="color" class="cs_drawer_color" id="text-color"
                                       value="#000000" title="{{ gt('Text Fill Color') }}" aria-label="{{ gt('Text fill color') }}">
                            </div>
                            <div style="flex: 1;">
                                <label class="cs_control_sublabel">{{ gt('Outline Color') }}</label>
                                <input type="color" class="cs_drawer_color" id="text-stroke-color"
                                       value="#ffffff" title="{{ gt('Text Outline Color') }}" aria-label="{{ gt('Text outline color') }}">
                            </div>
                        </div>

                        <div class="cs_switch_row">
                            <label class="cs_switch_label" for="text-stroke-enabled">{{ gt('Text Outline') }}</label>
                            <input type="checkbox" id="text-stroke-enabled" aria-label="{{ gt('Enable text outline') }}">
                        </div>
                        <div id="text-stroke-controls" style="display: none; padding-left: 10px; margin-top: 5px; border-left: 2px solid #eee;">
                            <label class="cs_control_sublabel">{{ gt('Thickness') }}</label>
                            <input type="range" class="cs_range_slider" id="text-stroke-width"
                                   min="0" max="0.5" step="0.01" value="0.02" aria-label="{{ gt('Outline thickness') }}">
                        </div>
                    </div>

                    <div class="cs_drawer_section">
                        <div class="cs_switch_row">
                            <label class="cs_switch_label" for="text-shadow-enabled">{{ gt('Text Shadow') }}</label>
                            <input type="checkbox" id="text-shadow-enabled" aria-label="{{ gt('Enable text shadow') }}">
                        </div>
                        <div id="text-shadow-controls" style="display: none; padding-left: 10px; margin-top: 5px; border-left: 2px solid #eee;">
                            <label class="cs_control_sublabel">{{ gt('Shadow Color') }}</label>
                            <input type="color" class="cs_drawer_color" id="text-shadow-color"
                                   value="#000000" style="margin-bottom: 5px;" aria-label="{{ gt('Shadow color') }}">
                            <label class="cs_control_sublabel">{{ gt('Blur') }}</label>
                            <input type="range" class="cs_range_slider" id="text-shadow-blur"
                                   min="0" max="20" value="4" aria-label="{{ gt('Shadow blur') }}">
                            <label class="cs_control_sublabel">{{ gt('Offset') }}</label>
                            <input type="range" class="cs_range_slider" id="text-shadow-offset"
                                   min="-1" max="1" step="0.01" value="0.05" aria-label="{{ gt('Shadow offset') }}">
                        </div>
                    </div>

                    <div class="cs_drawer_section">
                        <label class="cs_drawer_label">{{ gt('Alignment & Position') }}</label>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                            <button class="cs_btn_outline" data-align="left"   title="{{ gt('Align Left') }}">  <i class="fas fa-align-left"></i></button>
                            <button class="cs_btn_outline" data-align="center" title="{{ gt('Align Center') }}"><i class="fas fa-align-center"></i></button>
                            <button class="cs_btn_outline" data-align="right"  title="{{ gt('Align Right') }}"> <i class="fas fa-align-right"></i></button>
                            <button class="cs_btn_outline" data-align="top"    title="{{ gt('Align Top') }}">   <i class="fas fa-arrow-up"></i></button>
                            <button class="cs_btn_outline" data-align="middle" title="{{ gt('Align Middle') }}"><i class="fas fa-arrows-alt-v"></i></button>
                            <button class="cs_btn_outline" data-align="bottom" title="{{ gt('Align Bottom') }}"> <i class="fas fa-arrow-down"></i></button>
                        </div>
                    </div>
                </div>

                {{-- ── Art / Clipart Panel ────────────────────────────────── --}}
                <div class="cs_tool_panel" id="tool-panel-clipart">
                    <div class="cs_search_box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="{{ gt('Search art…') }}" aria-label="{{ gt('Search clipart') }}" id="clipart-search-input">
                    </div>
                    <div class="cs_category_pills">
                        <button class="cs_clipart_category_btn active" data-category="sports">{{ gt('Sports') }}</button>
                        <button class="cs_clipart_category_btn" data-category="symbols">{{ gt('Symbols') }}</button>
                        <button class="cs_clipart_category_btn" data-category="business">{{ gt('Business') }}</button>
                    </div>
                    <div class="cs_clipart_grid" id="clipart-list" style="margin-top: 20px;">
                        {{-- Populated by ClipartEngine --}}
                    </div>
                </div>

                {{-- ── Names / Numbers Panel ─────────────────────────────── --}}
                <div class="cs_tool_panel" id="tool-panel-names-numbers">
                    <p style="font-size: 13px; color: #6b7280; margin-bottom: 20px;">
                        {{ gt('Perfect for teams. Add unique names and numbers for each member.') }}
                    </p>
                    <div id="names-numbers-list">
                        <table class="table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="font-size: 11px; text-transform: uppercase; color: #9ca3af; text-align: left;">
                                    <th>{{ gt('Name') }}</th>
                                    <th width="60">{{ gt('No.') }}</th>
                                    <th width="80">{{ gt('Size') }}</th>
                                </tr>
                            </thead>
                            <tbody id="roster-tbody">
                                <tr>
                                    <td><input type="text" class="cs_drawer_input roster-name" placeholder="{{ gt('John') }}"></td>
                                    <td><input type="text" class="cs_drawer_input roster-number" placeholder="10"></td>
                                    <td>
                                        <select class="cs_drawer_select roster-size" aria-label="{{ gt('Size') }}">
                                            <option value="XS">XS</option>
                                            <option value="S">S</option>
                                            <option value="M" selected>M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                            <option value="XXL">XXL</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button class="cs_btn_outline" style="width: 100%; margin-top: 15px;" id="add-roster-row-btn">
                        {{ gt('+ Add Member') }}
                    </button>
                    <button class="cs_btn_primary" style="width: 100%; margin-top: 10px;" id="apply-roster-btn">
                        {{ gt('Apply Team Personalization') }}
                    </button>
                </div>

                {{-- ── Layers Panel ──────────────────────────────────────── --}}
                <div class="cs_tool_panel" id="tool-panel-layers">
                    <div id="layers-list">
                        {{-- Populated by LayerEngine --}}
                    </div>
                </div>

            </div>{{-- /.cs_drawer_content --}}
        </div>{{-- /.cs_design_drawer --}}

        {{-- ══════════ MAIN WORKSPACE ═══════════════════════════════════════ --}}
        <div class="cs_design_workspace">
            <div class="cs_workspace_canvas_area">
                <div class="cs_product_display_container">
                    <img src="" alt="Product Mockup" id="product-mockup-main" class="cs_product_mockup_img">

                    {{-- Second print area box (front-only: left chest pocket zone) --}}
                    <div id="print-area-second" style="
                        display: none;
                        position: absolute;
                        border: 1.5px dashed rgba(28,48,163,0.55);
                        border-radius: 3px;
                        pointer-events: none;
                        z-index: 10;
                        box-sizing: border-box;
                    ">
                        <span style="
                            position: absolute;
                            top: -18px; left: 0;
                            font-size: 9px;
                            font-weight: 600;
                            letter-spacing: .08em;
                            color: rgba(28,48,163,0.6);
                            text-transform: uppercase;
                            white-space: nowrap;
                        ">{{ gt('Chest Area') }}</span>
                    </div>

                    <div class="cs_canvas_stack" id="canvas-stack">
                        <div class="cs_print_area_bound"></div>
                        <div class="cs_safe_zone"></div>

                        <div class="cs_canvas_container active" id="canvas-container-front">
                            <canvas id="design-canvas-front"></canvas>
                        </div>
                        <div class="cs_canvas_container" id="canvas-container-back">
                            <canvas id="design-canvas-back"></canvas>
                        </div>
                        <div class="cs_canvas_container" id="canvas-container-right-shoulder">
                            <canvas id="design-canvas-right-shoulder"></canvas>
                        </div>
                        <div class="cs_canvas_container" id="canvas-container-left-shoulder">
                            <canvas id="design-canvas-left-shoulder"></canvas>
                        </div>
                    </div>
                </div>

                {{-- View switcher — includes shoulder views --}}
                <div class="cs_view_switcher">
                    <div class="cs_view_btn active" data-view="front" role="button" tabindex="0" title="{{ gt('Front') }}">
                        <div class="view_thumb_mini" id="thumb-front"></div>
                        <span>{{ gt('Front') }}</span>
                    </div>
                    <div class="cs_view_btn" data-view="back" role="button" tabindex="0" title="{{ gt('Back') }}">
                        <div class="view_thumb_mini" id="thumb-back"></div>
                        <span>{{ gt('Back') }}</span>
                    </div>
                    <div class="cs_view_btn" data-view="right-shoulder" role="button" tabindex="0" title="Right Shoulder">
                        <div class="view_thumb_mini" id="thumb-right-shoulder"></div>
                        <span>R. Shoulder</span>
                    </div>
                    <div class="cs_view_btn" data-view="left-shoulder" role="button" tabindex="0" title="Left Shoulder">
                        <div class="view_thumb_mini" id="thumb-left-shoulder"></div>
                        <span>L. Shoulder</span>
                    </div>
                </div>

                {{-- Floating canvas controls --}}
                <div class="cs_canvas_actions" style="bottom: 120px;">
                    <button class="cs_action_icon" id="duplicate-btn" title="{{ gt('Duplicate selected') }}">
                        <i class="fas fa-copy"></i>
                    </button>
                    <button class="cs_action_icon" id="clear-btn" title="{{ gt('Clear all on this side') }}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>

            {{-- ── Sticky Footer ─────────────────────────────────────────── --}}
            <div class="cs_design_footer">
                <div class="cs_footer_product_info">
                    <button class="cs_btn_outline" id="change-product-btn" style="margin-right: 20px;">
                        <i class="fas fa-plus-circle"></i> {{ gt('Change Product') }}
                    </button>
                    <div class="cs_divider" style="height: 40px;"></div>
                    <!-- <div class="product_mini_preview" id="footer-product-thumb" style="margin-left: 20px;"></div>
                    <div class="product_details_text">
                        <h4 id="footer-product-name">{{ gt('Loading product…') }}</h4>
                        <p>
                            {{ gt('Color:') }} <span id="footer-product-color-name" style="color: #111827; font-weight: 700;">—</span>
                        </p>
                    </div> -->
                </div>

                <div style="display: flex; align-items: center;">
                    <div class="cs_price_block">
                        <span class="cs_label">{{ gt('Estimated Price') }}</span>
                        <span class="cs_value" id="total-price" style="color: #111827;">{{ format_currency(0) }}</span>
                    </div>
                    <div class="cs_summary_pill" style="margin-left: 20px;">
                        <i class="fas fa-truck"></i> {{ gt('Free Shipping included') }}
                    </div>
                </div>
            </div>
        </div>{{-- /.cs_design_workspace --}}

    </div>{{-- /.cs_design_main --}}
</div>{{-- /.cs_design_lab_app --}}

@push('scripts')
    {{-- ════════════════════════════ CDN SCRIPTS ═══════════════════════════ --}}
    {{-- Fabric.js 5.3.0 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"
            crossorigin="anonymous"></script>
    {{-- html2canvas for capturing composite product previews --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    {{-- ════════════ Route injection (CSP-safe; no inline URL concatenation in JS) ══ --}}
    <script>
        window.__routes = {
            checkout   : "{{ route('checkout') }}",
            saveDesign : "{{ url('/api/designs/save') }}",
            updateDesign: "{{ url('/api/designs') }}",
            initDesign : "{{ url('/api/designs/init') }}",
            getDesign  : "{{ url('/api/designs') }}",
            addToCart  : "{{ route('cart.add') }}",
            customize  : "{{ route('customize-products.index') }}",
            uploadUserImage: "{{ url('/api/designs/upload-user-image') }}",
        };
        window.__appSetting = @json($appSetting);

        @php
            $currService = app(\App\Services\CurrencyService::class);
            $targetCurr = session('currency', 'INR');
            $rate = $currService->getRate('INR', $targetCurr);
            $symbol = $currService->getSupportedCurrencies()[$targetCurr]['symbol'] ?? '₹';
        @endphp
        window.__currency = {
            code: "{{ $targetCurr }}",
            symbol: "{{ $symbol }}",
            rate: {{ $rate }}
        };
    </script>

    {{-- ════════════════════════ ENGINE SCRIPTS ════════════════════════════ --}}
    {{-- Load order matters: EventBus → CanvasManager → BaseEngine → Engines → Customizer --}}
    <script src="{{ asset('js/design-lab/core/EventBus.js') }}"></script>
    <script src="{{ asset('js/design-lab/core/CanvasManager.js') }}"></script>
    <script src="{{ asset('js/design-lab/engines/BaseEngine.js') }}"></script>
    <script src="{{ asset('js/design-lab/engines/ColorEngine.js') }}"></script>
    <script src="{{ asset('js/design-lab/engines/TextEngine.js') }}"></script>
    <script src="{{ asset('js/design-lab/engines/ImageEngine.js') }}"></script>
    <script src="{{ asset('js/design-lab/engines/ClipartEngine.js') }}"></script>
    <script src="{{ asset('js/design-lab/engines/LayerEngine.js') }}"></script>
    <script src="{{ asset('js/design-lab/engines/TeamEngine.js') }}"></script>
    <script src="{{ asset('js/design-lab/engines/HistoryEngine.js') }}"></script>
    <script src="{{ asset('js/design-lab/engines/ExportEngine.js') }}"></script>
    <script src="{{ asset('js/design-lab/engines/ProductEngine.js') }}"></script>
    <script src="{{ asset('js/design-lab/engines/DraftEngine.js') }}"></script>
    <script src="{{ asset('js/design-lab/core/UIManager.js') }}"></script>
    {{-- Main bootstrapper --}}
    <script src="{{ asset('js/tshirt-customizer.js') }}"></script>

    {{-- ════════════════════ BOOTSTRAP + UI HELPERS ═══════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            // Roster: add row (no window.customizer coupling)
            document.getElementById('add-roster-row-btn')?.addEventListener('click', () => {
                const tbody = document.getElementById('roster-tbody');
                if (!tbody) return;
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="text" class="cs_drawer_input roster-name" placeholder="Name"></td>
                    <td><input type="text" class="cs_drawer_input roster-number" placeholder="No."></td>
                    <td>
                        <select class="cs_drawer_select roster-size" aria-label="Size">
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M" selected>M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </td>`;
                tbody.appendChild(row);
            });

            // Roster: apply via EventBus (no window.customizer)
            document.getElementById('apply-roster-btn')?.addEventListener('click', () => {
                window.DesignLab?.EventBus?.emit('roster:apply');
            });

            // Change product button
            document.getElementById('change-product-btn')?.addEventListener('click', () => {
                window.location.href = window.__routes?.customize || '{{ route('customize-products.index') }}';
            });

            // Bootstrap the Design Lab
            try {
                window.designLab = new TShirtCustomizer();
                await window.designLab.init();
            } catch (err) {
                console.error('[DesignLab] Bootstrap failed:', err);
                window.DesignLab?.EventBus?.emit('ui:notify', {
                    msg : "{{ gt('Design Lab failed to load. Please refresh the page.') }}",
                    icon: 'error'
                });
            }
        });
    </script>
@endpush

@endsection