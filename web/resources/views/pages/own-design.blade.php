@extends('layouts.app')
@section('content')

@php
    $currService = app(\App\Services\CurrencyService::class);
    $targetCurr = session('currency', 'INR');
    $rate = $currService->getRate('INR', $targetCurr);
    $symbol = $currService->getSupportedCurrencies()[$targetCurr]['symbol'] ?? '₹';

    // Extract unique tags for filter pills
    $allTags = $designs->pluck('tag')->filter()->unique()->values()->all();
@endphp

<style>
  /* Premium Hero Section Styles with Brand Colors */
  .premium-hero-section {
    min-height: 520px;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #0F172A 0%, #1C30A3 45%, #2541C8 75%, #101827 100%);
    position: relative;
    padding: 120px 0 160px;
    overflow: hidden;
  }
  
  /* Floating SVG Shapes Container */
  .hero-svg-shapes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
    pointer-events: none;
  }

  .hero-shape {
    position: absolute;
    opacity: 0.35;
  }

  .shape-hexagon { animation: floatHexagon 15s ease-in-out infinite; }
  .shape-hexagon-1 { top: 10%; left: 5%; animation-delay: 0s; }
  .shape-hexagon-2 { top: 60%; right: 8%; animation-delay: -5s; }

  .shape-circle { animation: floatCircle 12s ease-in-out infinite; }
  .shape-circle-1 { top: 20%; right: 15%; animation-delay: -2s; }
  .shape-circle-2 { bottom: 30%; left: 25%; animation-delay: -7s; }

  .shape-wave { animation: floatWave 20s ease-in-out infinite; }
  .shape-wave-1 { top: 5%; right: 25%; animation-delay: -3s; }

  @keyframes floatHexagon {
    0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
    25% { transform: translate(20px, -30px) rotate(15deg) scale(1.05); }
    50% { transform: translate(-10px, -50px) rotate(-10deg) scale(0.95); }
    75% { transform: translate(30px, -20px) rotate(5deg) scale(1.02); }
  }

  @keyframes floatCircle {
    0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.15; }
    33% { transform: translate(-25px, -40px) scale(1.1); opacity: 0.2; }
    66% { transform: translate(15px, -60px) scale(0.9); opacity: 0.12; }
  }

  @keyframes floatWave {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(-30px, -20px) rotate(10deg); }
  }

  .hero-particles {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; z-index: 2;
  }

  .hero-gradient-overlay {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: radial-gradient(ellipse at 0% 50%, rgba(15, 23, 42, 0.6) 0%, transparent 60%),
                radial-gradient(ellipse at 100% 50%, rgba(37, 65, 200, 0.35) 0%, transparent 60%),
                radial-gradient(circle at 50% 100%, rgba(28, 48, 163, 0.5) 0%, transparent 40%);
    z-index: 1;
  }

  .hero-content {
    position: relative; z-index: 3; animation: heroFadeIn 1s ease-out;
  }

  @keyframes heroFadeIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .hero-artisan-badge {
    display: inline-flex; align-items: center; gap: 10px;
    background: linear-gradient(135deg, rgba(212, 165, 116, 0.25), rgba(255, 255, 255, 0.12));
    backdrop-filter: blur(14px);
    border: 1px dashed rgba(255, 255, 255, 0.4);
    padding: 12px 30px; border-radius: 50px; color: white; font-size: 14px; font-weight: 600;
    margin-bottom: 30px; animation: stitchPulse 3s ease-in-out infinite; position: relative;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  }

  @keyframes stitchPulse {
    0%, 100% { border-color: rgba(255, 255, 255, 0.4); transform: translateY(0); }
    50% { border-color: rgba(212, 165, 116, 0.8); transform: translateY(-5px); }
  }

  .artisan-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(38px, 5.5vw, 64px);
    font-weight: 800;
    background: linear-gradient(135deg, #ffffff 0%, #FDF8F3 40%, #D4A574 80%, #ffffff 100%);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: shimmerText 4s ease-in-out infinite;
    line-height: 1.15; margin-bottom: 18px;
  }

  @keyframes shimmerText {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
  }

  .artisan-subtitle {
    font-size: clamp(16px, 2vw, 20px);
    color: rgba(255, 255, 255, 0.92);
    font-style: italic; letter-spacing: 0.5px; line-height: 1.6;
  }

  .hero-wave {
    position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; line-height: 0; transform: rotate(180deg);
  }
  .hero-wave svg { position: relative; display: block; width: calc(100% + 1.3px); height: 75px; }
  .wave-fill { fill: #F8FAFC; }

  /* Gallery Section Styling */
  .gallery-section {
    background: #F8FAFC; padding: 70px 0 120px; position: relative;
  }

  /* Filter & Search Studio Toolbar */
  .cs_studio_toolbar {
    background: #ffffff;
    border-radius: 20px;
    padding: 20px 25px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    border: 1px solid rgba(226, 232, 240, 0.9);
    margin-bottom: 45px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
  }

  .cs_filter_pills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .cs_filter_pill_btn {
    padding: 9px 20px;
    border-radius: 50px;
    background: #F1F5F9;
    color: #475569;
    font-weight: 600;
    font-size: 13.5px;
    border: 1.5px solid transparent;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
  }

  .cs_filter_pill_btn:hover {
    background: #E2E8F0;
    color: #0F172A;
  }

  .cs_filter_pill_btn.active {
    background: linear-gradient(135deg, #1C30A3 0%, #2541C8 100%);
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(28, 48, 163, 0.3);
    border-color: #1C30A3;
  }

  .cs_toolbar_controls {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
  }

  .cs_search_wrapper {
    position: relative;
    min-width: 220px;
  }

  .cs_search_input {
    width: 100%;
    height: 44px;
    padding: 0 16px 0 42px;
    border-radius: 50px;
    border: 1.5px solid #E2E8F0;
    background: #F8FAFC;
    font-size: 13.5px;
    color: #0F172A;
    transition: all 0.3s ease;
  }

  .cs_search_input:focus {
    outline: none;
    border-color: #1C30A3;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(28, 48, 163, 0.1);
  }

  .cs_search_icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 14px;
  }

  .cs_select_sort {
    height: 44px;
    padding: 0 34px 0 16px;
    border-radius: 50px;
    border: 1.5px solid #E2E8F0;
    background: #F8FAFC url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%3C94A3B8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 14px center;
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
  }

  .cs_select_sort:focus {
    outline: none;
    border-color: #1C30A3;
    background-color: #ffffff;
  }

  /* Grid & Cards */
  .cs_design_grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
    gap: 30px;
    padding: 0 5px;
  }

  .cs_design_item {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    background: #fff;
    border: 1px solid rgba(226, 232, 240, 0.9);
    box-shadow: 0 10px 30px rgba(15,23,42,0.05);
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    cursor: pointer;
    display: flex;
    flex-direction: column;
  }

  .cs_design_item:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(15,23,42,0.12);
    border-color: #93C5FD;
  }

  .badge-handmade {
    position: absolute; top: 16px; right: 16px; z-index: 15;
    background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(10px);
    color: #D4A574; font-size: 11px; font-weight: 700; padding: 6px 14px;
    border-radius: 50px; border: 1px solid rgba(212, 165, 116, 0.4);
    letter-spacing: 0.5px; text-transform: uppercase;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  .badge-tag-pill {
    position: absolute; top: 16px; left: 16px; z-index: 15;
    background: rgba(255, 255, 255, 0.92); backdrop-filter: blur(10px);
    color: #1C30A3; font-size: 11px; font-weight: 800; padding: 6px 14px;
    border-radius: 50px; border: 1px solid rgba(226, 232, 240, 0.9);
    letter-spacing: 0.5px; text-transform: uppercase;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
  }

  .cs_design_thumb {
    position: relative;
    padding-top: 115%;
    overflow: hidden;
    background: #F1F5F9;
  }

  .cs_design_thumb img {
    position: absolute; top: 0; left: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.7s cubic-bezier(0.23, 1, 0.32, 1);
  }

  .cs_design_item:hover .cs_design_thumb img {
    transform: scale(1.08);
  }

  .cs_card_body {
    padding: 20px 22px;
    background: #ffffff;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    justify-content: space-between;
  }

  .cs_design_title {
    font-size: 18px; font-weight: 700; color: #0F172A; margin-bottom: 6px;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .cs_card_price_row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px dashed #E2E8F0;
  }

  .cs_card_price {
    font-size: 20px;
    font-weight: 800;
    color: #1C30A3;
  }

  .cs_card_btn {
    padding: 8px 16px;
    background: #EBF0FF;
    color: #1C30A3;
    border-radius: 50px;
    font-weight: 700;
    font-size: 12.5px;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .cs_design_item:hover .cs_card_btn {
    background: #1C30A3;
    color: #ffffff;
  }

  /* Empty State */
  .cs_empty_state {
    text-align: center;
    padding: 80px 20px;
    background: #ffffff;
    border-radius: 24px;
    border: 2px dashed #CBD5E1;
    margin: 30px auto;
    max-width: 580px;
  }

  .cs_empty_icon {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: #EBF0FF;
    color: #1C30A3;
    font-size: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
  }

  /* Pagination Styling */
  .cs_pagination_wrap {
    margin-top: 60px; display: flex; justify-content: center;
  }
  .cs_pagination_wrap .pagination { display: flex; gap: 8px; list-style: none; padding: 0; }
  .cs_pagination_wrap .page-link {
    width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;
    border-radius: 50% !important; border: 1.5px solid #E2E8F0; color: #0F172A;
    font-weight: 700; font-size: 14px; transition: all 0.3s ease; background: #fff; text-decoration: none;
  }
  .cs_pagination_wrap .page-item.active .page-link {
    background: #1C30A3; border-color: #1C30A3; color: #fff;
    box-shadow: 0 6px 20px rgba(28, 48, 163, 0.25);
  }
  .cs_pagination_wrap .page-link:hover:not(.active) {
    background: #EBF0FF; border-color: #1C30A3; color: #1C30A3; transform: translateY(-2px);
  }

  /* AGENCY-GRADE PERFECT COMPACT LIGHTBOX MODAL */
  .cs_design_lightbox {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    z-index: 10000; display: none; align-items: center; justify-content: center; padding: 15px;
  }

  .cs_design_lightbox.active { display: flex; }

  .cs_design_lightbox_overlay {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px); cursor: zoom-out;
  }

  .cs_design_lightbox_content {
    position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
    width: 860px; max-width: 92vw; height: auto; min-height: 520px; max-height: 640px;
    background: #ffffff; border-radius: 22px; overflow: hidden; display: flex;
    box-shadow: 0 20px 60px rgba(15, 23, 42, 0.3); z-index: 10001;
    animation: modalPopup 0.35s cubic-bezier(0.25, 1, 0.5, 1); border: 1px solid rgba(255,255,255,0.8);
  }

  @keyframes modalPopup {
    0% { transform: translate(-50%, -50%) scale(0.92); opacity: 0; }
    100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
  }

  .cs_lightbox_image_section {
    flex: 0.95; background: #F8FAFC; display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden; padding: 25px; border-right: 1px solid #E2E8F0;
  }

  .cs_lightbox_image_section img {
    max-width: 100%; max-height: 100%; object-fit: contain;
    filter: drop-shadow(0 12px 25px rgba(15,23,42,0.12)); transition: transform 0.4s ease;
  }
  .cs_lightbox_image_section img:hover {
    transform: scale(1.04);
  }

  .cs_lightbox_info_section {
    flex: 1.05; padding: 22px 24px; display: flex; flex-direction: column; justify-content: space-between;
    background: #ffffff; overflow-y: auto; text-align: left;
  }

  .cs_lightbox_info_section::-webkit-scrollbar { width: 4px; }
  .cs_lightbox_info_section::-webkit-scrollbar-track { background: #f1f5f9; }
  .cs_lightbox_info_section::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

  /* HARD OVERRIDE LEGACY CSS INJURIES FROM style.css */
  .cs_lightbox_info_section span {
    background: transparent !important;
    padding: 0 !important;
    border-radius: 0 !important;
    font-size: inherit !important;
    color: inherit !important;
    display: inline !important;
    box-shadow: none !important;
  }

  .cs_lightbox_info_section .badge {
    padding: 4px 10px !important;
    border-radius: 50px !important;
    font-size: 10.5px !important;
    display: inline-block !important;
  }

  .cs_lightbox_info_section .modal-form-step-num {
    background: #1C30A3 !important;
    color: #ffffff !important;
    width: 20px !important;
    height: 20px !important;
    border-radius: 50% !important;
    font-size: 10.5px !important;
    font-weight: 800 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 0 !important;
    margin-right: 6px !important;
  }

  .cs_lightbox_info_section .cs_modal_tag {
    background: #EBF0FF !important;
    color: #1C30A3 !important;
    padding: 4px 12px !important;
    border-radius: 50px !important;
    font-size: 10.5px !important;
    font-weight: 800 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    display: inline-block !important;
    border: 1px solid rgba(28, 48, 163, 0.15) !important;
  }

  .cs_lightbox_info_section .size-btn {
    background: #F8FAFC !important;
    color: #0F172A !important;
    padding: 7px 14px !important;
    border-radius: 10px !important;
    font-size: 12px !important;
    font-weight: 700 !important;
    border: 1.5px solid #E2E8F0 !important;
    min-width: 42px !important;
    text-align: center !important;
    display: inline-block !important;
    cursor: pointer !important;
    transition: all 0.25s ease !important;
  }

  .cs_lightbox_info_section .size-btn.active {
    background: linear-gradient(135deg, #1C30A3 0%, #2541C8 100%) !important;
    color: #ffffff !important;
    border-color: #1C30A3 !important;
    box-shadow: 0 3px 10px rgba(28, 48, 163, 0.25) !important;
  }

  .cs_lightbox_info_section .cs_feature_pill_icon {
    background: #ffffff !important;
    color: #1C30A3 !important;
    width: 30px !important;
    height: 30px !important;
    border-radius: 8px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 12.5px !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05) !important;
  }

  .cs_lightbox_info_section select.premium-form-input {
    height: 42px !important;
    line-height: normal !important;
    padding: 0 32px 0 40px !important;
    font-size: 13.5px !important;
    font-weight: 600 !important;
    color: #0F172A !important;
    background-color: #F8FAFC !important;
    border: 1.5px solid #E2E8F0 !important;
    border-radius: 12px !important;
    outline: none !important;
  }

  .cs_lightbox_info_section select.premium-form-input:focus {
    border-color: #1C30A3 !important;
    background-color: #ffffff !important;
    box-shadow: 0 0 0 3px rgba(28, 48, 163, 0.1) !important;
  }

  .cs_subtotal_badge {
    background: #EBF0FF !important;
    color: #1C30A3 !important;
    font-size: 12.5px !important;
    font-weight: 800 !important;
    padding: 6px 14px !important;
    border-radius: 50px !important;
    border: 1px solid rgba(28, 48, 163, 0.15) !important;
    display: inline-block !important;
    white-space: nowrap !important;
  }

  .cs_lightbox_close {
    position: absolute; top: 14px; right: 14px; background: #ffffff; color: #0F172A;
    border: 1.5px solid #E2E8F0; width: 34px; height: 34px; border-radius: 50%;
    font-size: 14px; cursor: pointer; z-index: 10005; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    display: flex; align-items: center; justify-content: center; transition: all 0.25s ease;
  }

  .cs_lightbox_close:hover {
    transform: rotate(90deg) scale(1.1); background: #1C30A3; border-color: #1C30A3; color: #ffffff;
  }

  .cs_buy_now_btn {
    width: 100%; padding: 13px 20px; background: linear-gradient(135deg, #1C30A3 0%, #2541C8 100%); color: #ffffff;
    border: none; border-radius: 14px; font-weight: 800; font-size: 14.5px; cursor: pointer;
    transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(28,48,163,0.22);
    display: flex; align-items: center; justify-content: center; gap: 8px;
  }

  .cs_buy_now_btn:hover {
    transform: translateY(-2px); box-shadow: 0 12px 25px rgba(28,48,163,0.35); filter: brightness(1.05);
  }

  .cs_qty_btn {
    color: #0F172A;
    background: #F1F5F9;
    border: 1.5px solid #E2E8F0;
    border-radius: 10px;
    font-weight: 800;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .cs_qty_btn:hover {
    background: #1C30A3;
    color: white;
    border-color: #1C30A3;
  }

  @media (max-width: 991px) {
    .cs_design_lightbox_content { flex-direction: column; height: 92vh; width: 94vw; max-height: 92vh; border-radius: 20px; }
    .cs_lightbox_image_section { height: 32vh; flex: none; padding: 15px; border-right: none; border-bottom: 1px solid #E2E8F0; }
    .cs_lightbox_info_section { width: 100%; height: calc(60vh - 30px); padding: 18px 16px; }
    .cs_design_grid { grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; }
    .cs_studio_toolbar { flex-direction: column; align-items: stretch; }
    .cs_toolbar_controls { flex-direction: column; width: 100%; }
    .cs_search_wrapper { width: 100%; }
    .cs_select_sort { width: 100%; }
  }
</style>

  <!-- Premium Animated Hero Section -->
  <section class="premium-hero-section position-relative overflow-hidden">
    <!-- Floating SVG Shapes Background -->
    <div class="hero-svg-shapes">
      <svg class="hero-shape shape-hexagon shape-hexagon-1" width="140" height="122" viewBox="0 0 120 104" fill="none">
        <path d="M60 0L113.923 31V73L60 104L6.07696 73V31L60 0Z" fill="rgba(255,255,255,0.06)"/>
      </svg>
      <svg class="hero-shape shape-hexagon shape-hexagon-2" width="100" height="87" viewBox="0 0 120 104" fill="none">
        <path d="M60 0L113.923 31V73L60 104L6.07696 73V31L60 0Z" stroke="rgba(255,255,255,0.12)" stroke-width="2" fill="none"/>
      </svg>
      
      <!-- Circles -->
      <svg class="hero-shape shape-circle shape-circle-1" width="120" height="120" viewBox="0 0 100 100" fill="none">
        <circle cx="50" cy="50" r="45" stroke="rgba(255,255,255,0.1)" stroke-width="2" fill="none"/>
      </svg>
      
      <!-- Waves -->
      <svg class="hero-shape shape-wave shape-wave-1" width="250" height="80" viewBox="0 0 200 60" fill="none">
        <path d="M0 30C30 10 70 50 100 30C130 10 170 50 200 30" stroke="rgba(255,255,255,0.1)" stroke-width="2" fill="none"/>
      </svg>
    </div>
    
    <div class="hero-particles" id="heroParticles"></div>
    <div class="hero-gradient-overlay"></div>
    
    <div class="container position-relative text-center" style="z-index: 5;">
      <div class="hero-content">
        <div class="hero-artisan-badge">
          <i class="fa-solid fa-scissors text-amber me-1"></i>
          <span>{{ gt('Handcrafted Studio Collection') }}</span>
          <i class="fa-solid fa-sparkles text-amber ms-1"></i>
        </div>
        <h1 class="artisan-title">{{ gt('Our Handmade Creations') }}</h1>
        <p class="artisan-subtitle">{{ gt('"Each piece tells a story of tradition, passion & artistry"') }}</p>
        
        <div class="d-flex justify-content-center gap-4 flex-wrap mt-4">
          <span class="d-inline-flex align-items-center text-white-90 font-weight-bold" style="font-size: 14px;">
            <i class="fa-solid fa-hand-sparkles text-amber me-2"></i>
            {{ gt('100% Handcrafted') }}
          </span>
          <span class="d-inline-flex align-items-center text-white-90 font-weight-bold" style="font-size: 14px;">
            <i class="fa-solid fa-heart me-2" style="color: #F43F5E;"></i>
            {{ gt('Made with Care') }}
          </span>
          <span class="d-inline-flex align-items-center text-white-90 font-weight-bold" style="font-size: 14px;">
            <i class="fa-solid fa-shield-halved text-amber me-2"></i>
            {{ gt('Artisan Certified Quality') }}
          </span>
        </div>
      </div>
    </div>
    <div class="hero-wave">
      <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="wave-fill"></path>
        <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="wave-fill"></path>
        <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="wave-fill"></path>
      </svg>
    </div>
  </section>

  <!-- Start Design Gallery -->
  <section class="position-relative overflow-hidden gallery-section">
    <div class="container" style="position: relative; z-index: 2;">
      
      <!-- Studio Interactive Toolbar -->
      <div class="cs_studio_toolbar">
        <ul class="cs_filter_pills cs_design_filters">
          <li class="active">
            <a href="#all" class="cs_filter_pill_btn active" data-filter="all">
              <i class="fa-solid fa-border-all"></i> {{ gt('All Designs') }}
            </a>
          </li>
          @foreach($allTags as $tag)
          <li>
            <a href="#{{ str_replace(' ', '-', strtolower($tag)) }}" class="cs_filter_pill_btn" data-filter="{{ str_replace(' ', '-', strtolower($tag)) }}">
              {{ $tag }}
            </a>
          </li>
          @endforeach
        </ul>

        <div class="cs_toolbar_controls">
          <div class="cs_search_wrapper">
            <i class="fa-solid fa-magnifying-glass cs_search_icon"></i>
            <input type="text" id="cs_design_search" class="cs_search_input" placeholder="{{ gt('Search designs...') }}">
          </div>

          <select id="cs_design_sort" class="cs_select_sort">
            <option value="default">{{ gt('Sort: Featured') }}</option>
            <option value="price-low">{{ gt('Price: Low to High') }}</option>
            <option value="price-high">{{ gt('Price: High to Low') }}</option>
            <option value="title-asc">{{ gt('Name: A to Z') }}</option>
          </select>
        </div>
      </div>

      <!-- Design Grid -->
      <div class="cs_design_grid" id="cs_design_grid">
        @foreach($designs as $design)
        @php
            $convertedPrice = number_format($design->price * $rate, 2);
        @endphp
        <!-- Design Card -->
        <div class="cs_design_item {{ str_replace(' ', '-', strtolower($design->tag)) }}" 
             data-id="{{ $design->id }}" 
             data-src="{{ env('MAIN_URL') . 'images/' . $design->image }}" 
             data-description="{{ $design->description }}" 
             data-price="{{ $design->price }}" 
             data-size="{{ $design->size }}" 
             data-cloth="{{ $design->cloth_types }}"
             data-title="{{ strtolower($design->title) }}">
          
          <span class="badge-tag-pill">{{ $design->tag }}</span>
          <span class="badge-handmade"><i class="fa-solid fa-wand-magic-sparkles me-1"></i> {{ gt('Handmade') }}</span>
          
          <div class="cs_design_thumb">
            <img src="{{ env('MAIN_URL') . 'images/' . $design->image }}" alt="{{ $design->title }}" loading="lazy">
          </div>

          <div class="cs_card_body">
            <h3 class="cs_design_title">{{ $design->title }}</h3>
            
            <div class="cs_card_price_row">
              <span class="cs_card_price">{{ $symbol }}{{ $convertedPrice }}</span>
              <button type="button" class="cs_card_btn">
                <span>{{ gt('Custom Order') }}</span>
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Empty State Fallback -->
      <div class="cs_empty_state" id="cs_no_results" style="display: none;">
        <div class="cs_empty_icon">
          <i class="fa-solid fa-palette"></i>
        </div>
        <h3 class="h4 font-weight-bold text-dark mb-2">{{ gt('No Artisan Designs Found') }}</h3>
        <p class="text-muted mb-0" style="font-size: 14px;">{{ gt('Try adjusting your search query or filter selection.') }}</p>
      </div>
      
      <div class="cs_pagination_wrap">
        {{ $designs->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </section>
  <!-- End Design Gallery -->

  <!-- Start Lightbox Modal (Agency-Grade Compact Size) -->
  <div class="cs_design_lightbox" id="cs_design_lightbox">
    <div class="cs_design_lightbox_overlay" id="cs_lightbox_overlay"></div>
    <div class="cs_design_lightbox_content">
      <button class="cs_lightbox_close" id="cs_lightbox_close">
        <i class="fa-solid fa-xmark"></i>
      </button>
      
      <div class="cs_lightbox_image_section">
        <img id="cs_lightbox_img" src="" alt="Design Preview">
      </div>
      
      <div class="cs_lightbox_info_section">
        <div>
          <div class="cs_modal_info_header mb-2">
            <span id="cs_lightbox_tag" class="cs_modal_tag mb-1"></span>
            <h2 id="cs_lightbox_title" style="font-size: 22px; margin-bottom: 4px; font-family: 'Playfair Display', serif; color: #0F172A; line-height: 1.2; font-weight: 800;"></h2>
            
            <div id="cs_lightbox_price" style="font-size: 22px; font-weight: 800; color: #1C30A3; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
              $0.00 <span class="badge bg-light text-muted font-weight-normal border ms-2" style="font-size: 10.5px;">{{ gt('Incl. GST') }}</span>
            </div>

            <p id="cs_lightbox_description" style="color: #475569; font-size: 12.5px; line-height: 1.5; font-style: italic; margin-bottom: 12px; display: none;"></p>
            
            <!-- Artisan Features Grid -->
            <div class="cs_design_features mb-3 p-2 px-3 rounded-3 border border-slate-200" style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; background-color: #F8FAFC;">
              <div class="d-flex align-items-center gap-2">
                <span class="cs_feature_pill_icon"><i class="fa-solid fa-hand-sparkles"></i></span>
                <span class="font-weight-bold" style="font-size: 12px; color: #0F172A;">{{ gt('Handmade') }}</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <span class="cs_feature_pill_icon" style="color: #10B981 !important;"><i class="fa-solid fa-leaf"></i></span>
                <span class="font-weight-bold" style="font-size: 12px; color: #0F172A;">{{ gt('Organic') }}</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <span class="cs_feature_pill_icon" style="color: #D4A574 !important;"><i class="fa-solid fa-shield-heart"></i></span>
                <span class="font-weight-bold" style="font-size: 12px; color: #0F172A;">{{ gt('Premium') }}</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <span class="cs_feature_pill_icon" style="color: #0284C7 !important;"><i class="fa-solid fa-palette"></i></span>
                <span class="font-weight-bold" style="font-size: 12px; color: #0F172A;">{{ gt('Unique') }}</span>
              </div>
            </div>

            <!-- Step 1: Size Selection -->
            <div id="cs_size_section" class="mb-2">
              <label class="d-flex align-items-center mb-1" style="font-size: 12.5px; font-weight: 700; color: #0F172A;">
                <span class="modal-form-step-num">1</span>
                <span>{{ gt('Select Size') }}</span>
                <span style="color: #EF4444;" class="ms-1">*</span>
              </label>
              <div id="cs_lightbox_sizes" class="d-flex flex-wrap gap-2">
                <!-- Sizes populated dynamically -->
              </div>
              <input type="hidden" id="selected_size" value="">
            </div>

            <!-- Step 2: Cloth Type Selection -->
            <div id="cs_cloth_section" class="mb-2">
              <label class="d-flex align-items-center mb-1" style="font-size: 12.5px; font-weight: 700; color: #0F172A;">
                <span class="modal-form-step-num">2</span>
                <span>{{ gt('Cloth Type') }}</span>
                <style>.cs_red_star { color: #EF4444 !important; background: transparent !important; padding: 0 !important; }</style>
                <span class="cs_red_star ms-1">*</span>
              </label>
              <div class="form-icon-wrapper">
                <select id="cs_lightbox_cloth" class="premium-form-input premium-form-select">
                  <!-- Cloth types populated dynamically -->
                </select>
                <i class="fa-solid fa-shirt input-icon"></i>
              </div>
            </div>

            <!-- Step 3: Quantity Selector & Subtotal Badge -->
            <div class="cs_quantity_selector mb-3">
              <label class="d-flex align-items-center mb-1" style="font-size: 12.5px; font-weight: 700; color: #0F172A;">
                <span class="modal-form-step-num">3</span>
                <span>{{ gt('Quantity') }}</span>
                <span style="color: #EF4444;" class="ms-1">*</span>
              </label>
              <div class="d-flex align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2">
                  <button type="button" id="qty_minus" class="cs_qty_btn" style="width: 36px; height: 36px;">-</button>
                  <input type="number" id="cs_lightbox_qty" value="1" min="1" class="premium-form-input text-center" style="width: 65px; padding: 0 10px; height: 36px; font-weight: 700; font-size: 13.5px;">
                  <button type="button" id="qty_plus" class="cs_qty_btn" style="width: 36px; height: 36px;">+</button>
                </div>
                <div id="cs_lightbox_subtotal" class="cs_subtotal_badge"></div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="cs_lightbox_actions pt-2 border-top border-slate-200 mt-2">
          <button type="button" class="cs_buy_now_btn" id="cs_buy_now_btn">
            <i class="fa-solid fa-cart-shopping me-2"></i> {{ gt('Add to Your Collection') }}
          </button>
          <p class="text-center text-muted mt-1 mb-0" style="font-size: 11px;">
            <i class="fa-solid fa-shield-halved me-1 text-primary"></i> {{ gt('Secure checkout with 100% quality guarantee') }}
          </p>
        </div>
      </div>
    </div>
  </div>
  <!-- End Lightbox Modal -->

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const appSetting = @json($appSetting);
      
      // Hero Particle Effects
      const heroParticles = document.getElementById('heroParticles');
      if (heroParticles) {
        for (let i = 0; i < 40; i++) {
          const particle = document.createElement('div');
          particle.style.cssText = `
            position: absolute;
            width: ${Math.random() * 4 + 2}px;
            height: ${Math.random() * 4 + 2}px;
            background: rgba(255, 255, 255, ${Math.random() * 0.4 + 0.2});
            border-radius: 50%;
            left: ${Math.random() * 100}%;
            top: ${Math.random() * 100}%;
            animation: float ${Math.random() * 10 + 10}s infinite ease-in-out;
            animation-delay: ${Math.random() * 5}s;
          `;
          heroParticles.appendChild(particle);
        }
      }

      // Delegate Handler for Size Pill Buttons inside Lightbox
      $(document).on('click', '.size-btn', function(e) {
        e.preventDefault();
        $('.size-btn').removeClass('active');
        $(this).addClass('active');
        $('#selected_size').val($(this).attr('data-size') || $(this).text().trim());
      });

      // ========== ADD TO CART HANDLER ==========
      const buyBtn = document.getElementById('cs_buy_now_btn');
      const designItems = document.querySelectorAll('.cs_design_item');

      if (buyBtn) {
        // Quantity +/- handlers
        document.getElementById('qty_minus')?.addEventListener('click', function() {
          const input = document.getElementById('cs_lightbox_qty');
          const minVal = (appSetting && appSetting.min_quantity) ? appSetting.min_quantity : 1;
          if (parseInt(input.value) > minVal) {
            input.value = parseInt(input.value) - 1;
            input.dispatchEvent(new Event('input'));
          }
        });
        document.getElementById('qty_plus')?.addEventListener('click', function() {
          const input = document.getElementById('cs_lightbox_qty');
          const maxVal = (appSetting && appSetting.max_quantity) ? appSetting.max_quantity : Infinity;
          if (parseInt(input.value) < maxVal) {
            input.value = parseInt(input.value) + 1;
            input.dispatchEvent(new Event('input'));
          }
        });

        buyBtn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();

          const lightbox = document.getElementById('cs_design_lightbox');
          if (!lightbox || !lightbox.classList.contains('active')) return;

          const lightboxTitle = document.getElementById('cs_lightbox_title');
          const currentTitle = lightboxTitle ? lightboxTitle.textContent : '';

          let currentItem = null;
          designItems.forEach(function(item) {
            const titleEl = item.querySelector('.cs_design_title');
            if (titleEl && titleEl.textContent.trim() === currentTitle.trim()) {
              currentItem = item;
            }
          });

          if (!currentItem) {
            Swal.fire('{{ gt("Error") }}', '{{ gt("Could not identify the product. Please try again.") }}', 'error');
            return;
          }

          const productId = currentItem.getAttribute('data-id');
          if (!productId) {
            Swal.fire('{{ gt("Error") }}', '{{ gt("Product not found.") }}', 'error');
            return;
          }

          buyBtn.disabled = true;
          buyBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> {{ gt("Adding...") }}';

          $.ajax({
            url: "{{ route('cart.add') }}",
            method: 'POST',
            data: {
              _token: "{{ csrf_token() }}",
              id: productId,
              type: 'own',
              quantity: document.getElementById('cs_lightbox_qty').value || 1,
              size: document.getElementById('selected_size').value,
              color: document.getElementById('cs_lightbox_cloth').value
            },
            beforeSend: function() {
              const qty = parseInt(document.getElementById('cs_lightbox_qty').value);
              if (appSetting) {
                if (qty < appSetting.min_quantity) {
                  Swal.fire('{{ gt("Error") }}', '{{ gt("Minimum") }} ' + appSetting.min_quantity + ' {{ gt("quantity required") }}', 'error');
                  buyBtn.disabled = false;
                  buyBtn.innerHTML = '<i class="fa-solid fa-cart-shopping me-2"></i> {{ gt("Add to Your Collection") }}';
                  return false;
                }
                if (appSetting.max_quantity && qty > appSetting.max_quantity) {
                  Swal.fire('{{ gt("Error") }}', '{{ gt("Maximum") }} ' + appSetting.max_quantity + ' {{ gt("quantity allowed") }}', 'error');
                  buyBtn.disabled = false;
                  buyBtn.innerHTML = '<i class="fa-solid fa-cart-shopping me-2"></i> {{ gt("Add to Your Collection") }}';
                  return false;
                }
              }
            },
            success: function(res) {
              window.location.href = "{{ route('cart.index') }}";
            },
            error: function(xhr) {
              buyBtn.disabled = false;
              buyBtn.innerHTML = '<i class="fa-solid fa-cart-shopping me-2"></i> {{ gt("Add to Your Collection") }}';

              if (xhr.status === 401 || xhr.status === 419) {
                window.location.href = "{{ route('login') }}";
              } else {
                let msg = '{{ gt("Failed to add item to cart.") }}';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                  msg = xhr.responseJSON.message;
                }
                Swal.fire('{{ gt("Error") }}', msg, 'error');
              }
            }
          });
        });
      }
    });
  </script>

@endsection
