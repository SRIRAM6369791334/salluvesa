@extends('layouts.app')
@section('content')

<style>
  /* Premium Hero Section Styles with Brand Colors */
  .premium-hero-section {
    min-height: 450px;
    display: flex;
    align-items: center;
    /* 3-Color Gradient: Left to Right - Navy → Royal Blue → Bright Blue */
    background: linear-gradient(90deg, #0A1854 0%, #1C30A3 50%, #2E5DD8 100%);
    position: relative;
    padding: 120px 0 180px;
    overflow: hidden;
  }
  
.cs_design_lightbox_info span {
  background:#fdfaf7;
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
  .cs_qty_btn{
    color: #000000;
    }

  /* Individual Shape Styles */
  .hero-shape {
    position: absolute;
    opacity: 0.4;
  }

  /* Hexagon Shape (matching logo) */
  .shape-hexagon {
    animation: floatHexagon 15s ease-in-out infinite;
  }

  .shape-hexagon-1 {
    top: 10%;
    left: 5%;
    animation-delay: 0s;
  }

  .shape-hexagon-2 {
    top: 60%;
    right: 8%;
    animation-delay: -5s;
  }

  .shape-hexagon-3 {
    bottom: 15%;
    left: 15%;
    animation-delay: -10s;
  }

  /* Circle Shapes */
  .shape-circle {
    animation: floatCircle 12s ease-in-out infinite;
  }

  .shape-circle-1 {
    top: 20%;
    right: 15%;
    animation-delay: -2s;
  }

  .shape-circle-2 {
    bottom: 30%;
    left: 25%;
    animation-delay: -7s;
  }

  .shape-circle-3 {
    top: 45%;
    left: 60%;
    animation-delay: -4s;
  }

  /* Wave/Curve Shapes */
  .shape-wave {
    animation: floatWave 20s ease-in-out infinite;
  }

  .shape-wave-1 {
    top: 5%;
    right: 25%;
    animation-delay: -3s;
  }

  .shape-wave-2 {
    bottom: 10%;
    right: 40%;
    animation-delay: -8s;
  }

  /* Diamond Shapes */
  .shape-diamond {
    animation: floatDiamond 18s ease-in-out infinite;
  }

  .shape-diamond-1 {
    top: 35%;
    left: 10%;
    animation-delay: -6s;
  }

  .shape-diamond-2 {
    top: 15%;
    right: 45%;
    animation-delay: -12s;
  }

  /* Star/Burst Shapes */
  .shape-star {
    animation: floatStar 14s ease-in-out infinite;
  }

  .shape-star-1 {
    bottom: 25%;
    right: 12%;
    animation-delay: -4s;
  }

  .shape-star-2 {
    top: 55%;
    left: 40%;
    animation-delay: -9s;
  }

  /* Shape Animations */
  @keyframes floatHexagon {
    0%, 100% {
      transform: translate(0, 0) rotate(0deg) scale(1);
    }
    25% {
      transform: translate(20px, -30px) rotate(15deg) scale(1.05);
    }
    50% {
      transform: translate(-10px, -50px) rotate(-10deg) scale(0.95);
    }
    75% {
      transform: translate(30px, -20px) rotate(5deg) scale(1.02);
    }
  }

  @keyframes floatCircle {
    0%, 100% {
      transform: translate(0, 0) scale(1);
      opacity: 0.15;
    }
    33% {
      transform: translate(-25px, -40px) scale(1.1);
      opacity: 0.2;
    }
    66% {
      transform: translate(15px, -60px) scale(0.9);
      opacity: 0.12;
    }
  }

  @keyframes floatWave {
    0%, 100% {
      transform: translate(0, 0) rotate(0deg);
    }
    50% {
      transform: translate(-30px, -20px) rotate(10deg);
    }
  }

  @keyframes floatDiamond {
    0%, 100% {
      transform: translate(0, 0) rotate(45deg) scale(1);
    }
    50% {
      transform: translate(20px, -35px) rotate(90deg) scale(1.1);
    }
  }

  @keyframes floatStar {
    0%, 100% {
      transform: translate(0, 0) rotate(0deg) scale(1);
      opacity: 0.15;
    }
    25% {
      transform: translate(-15px, -25px) rotate(72deg) scale(1.15);
      opacity: 0.25;
    }
    50% {
      transform: translate(10px, -45px) rotate(144deg) scale(0.9);
      opacity: 0.1;
    }
    75% {
      transform: translate(-20px, -30px) rotate(216deg) scale(1.05);
      opacity: 0.2;
    }
  }

  .hero-particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 2;
  }

  .hero-gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(ellipse at 0% 50%, rgba(10, 24, 84, 0.4) 0%, transparent 50%),
                radial-gradient(ellipse at 100% 50%, rgba(46, 93, 216, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 50% 100%, rgba(28, 48, 163, 0.5) 0%, transparent 40%);
    z-index: 1;
  }

  .hero-content {
    position: relative;
    z-index: 3;
    animation: heroFadeIn 1s ease-out;
  }

  @keyframes heroFadeIn {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    padding: 10px 24px;
    border-radius: 50px;
    color: white;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 30px;
    animation: badgeFloat 3s ease-in-out infinite;
  }

  @keyframes badgeFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
  }

  .badge-icon {
    font-size: 18px;
    animation: iconSpin 4s linear infinite;
  }

  @keyframes iconSpin {
    0%, 90%, 100% { transform: rotate(0deg); }
    95% { transform: rotate(15deg); }
  }

  .premium-hero-title {
    font-size: 56px;
    font-weight: 900;
    font-family: 'Merriweather', serif;
    color: white;
    margin: 0 0 20px 0;
    line-height: 1.2;
    letter-spacing: -1px;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
  }

  .hero-subtitle {
    font-size: 18px;
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  }

  .hero-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    transform: rotate(180deg);
  }

  .hero-wave svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 80px;
  }

  .wave-fill {
    fill: #ffffff;
  }

  /* Custom Premium Styles for Own Design Page */
  :root {
    --primary-color: #1C30A3;
    --accent-color: #FF4D4D;
    --text-muted: #5e5e5e;
    --glass-bg: rgba(255, 255, 255, 0.7);
    --glass-border: rgba(255, 255, 255, 0.4);
    --shadow-premium: 0 20px 40px rgba(0, 0, 0, 0.1);
    --transition-smooth: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    /* Artisan/Craft Theme Colors */
    --craft-gold: #D4A574;
    --craft-cream: #FDF8F3;
    --craft-brown: #8B4513;
    --craft-terracotta: #C97D5D;
    --stitch-color: #654321;
    --fabric-shadow: 0 25px 50px rgba(139, 69, 19, 0.15);
  }

  /* Artisan Hero Enhancements */
  .premium-hero-section {
    background: linear-gradient(135deg, #0A1854 0%, #1C30A3 40%, #2E5DD8 70%, #D4A574 100%);
  }

  .hero-artisan-badge {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, rgba(212, 165, 116, 0.3), rgba(255, 255, 255, 0.15));
    backdrop-filter: blur(15px);
    border: 2px dashed rgba(255, 255, 255, 0.4);
    padding: 14px 32px;
    border-radius: 50px;
    color: white;
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 35px;
    animation: stitchPulse 3s ease-in-out infinite;
    position: relative;
  }

  .hero-artisan-badge::before {
    content: '✂️';
    font-size: 20px;
    animation: scissorSnip 2s ease-in-out infinite;
  }

  @keyframes stitchPulse {
    0%, 100% { border-color: rgba(255, 255, 255, 0.4); transform: translateY(0); }
    50% { border-color: rgba(212, 165, 116, 0.8); transform: translateY(-5px); }
  }

  @keyframes scissorSnip {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(-10deg); }
    75% { transform: rotate(10deg); }
  }

  /* Handwritten Title Effect */
  .artisan-title {
    font-family: 'Playfair Display', 'Merriweather', serif;
    font-size: 64px;
    font-weight: 800;
    background: linear-gradient(135deg, #ffffff 0%, #D4A574 50%, #ffffff 100%);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: shimmerText 4s ease-in-out infinite;
    text-shadow: none;
    position: relative;
  }

  @keyframes shimmerText {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
  }

  .artisan-subtitle {
    font-size: 20px;
    color: rgba(255, 255, 255, 0.95);
    font-style: italic;
    letter-spacing: 1px;
  }

  /* Floating Artisan Elements */
  .artisan-floating-elements {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 2;
  }

  .artisan-element {
    position: absolute;
    opacity: 0.6;
  }

  .needle-thread {
    animation: sewingMotion 8s ease-in-out infinite;
  }

  @keyframes sewingMotion {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    25% { transform: translate(20px, -15px) rotate(15deg); }
    50% { transform: translate(0, -30px) rotate(-10deg); }
    75% { transform: translate(-20px, -15px) rotate(5deg); }
  }

  .cs_page_heading {
    padding: 160px 0 100px;
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
  }

  .cs_hero_overlay {
    background: linear-gradient(135deg, rgba(28, 48, 163, 0.8) 0%, rgba(0, 0, 0, 0.6) 100%);
    top: 0; left: 0; width: 100%; height: 100%;
  }

  .cs_design_filters {
    display: flex;
    justify-content: center;
    gap: 15px;
    padding: 0;
    margin-bottom: 50px;
    flex-wrap: wrap;
  }

  .cs_design_filters li {
    list-style: none;
  }

  .cs_design_filters li a {
    padding: 14px 32px;
    border-radius: 50px;
    background: var(--craft-cream);
    color: #1C30A3;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: var(--transition-smooth);
    border: 2px dashed transparent;
    display: inline-block;
    position: relative;
  }

  .cs_design_filters li a::before {
    content: '🧵';
    margin-right: 8px;
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
  }

  .cs_design_filters li a:hover::before,
  .cs_design_filters li.active a::before {
    opacity: 1;
    transform: translateX(0);
  }

  .cs_design_filters li.active a,
  .cs_design_filters li a:hover {
    background:#1C30A3;
    color: #fff;
    box-shadow: 0 15px 35px rgba(28, 48, 163, 0.25);
    transform: translateY(-3px);
    border-color: rgba(255, 255, 255, 0.3);
  }

  .cs_design_grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
    padding: 0 15px;
  }

  .cs_design_item {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    background: #fff;
    box-shadow: var(--shadow-premium);
    transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
    cursor: pointer;
    transform-style: preserve-3d;
    perspective: 1000px;
  }

  /* Stitched Border Effect */
  .cs_design_item::before {
    content: '';
    position: absolute;
    top: 8px; left: 8px; right: 8px; bottom: 8px;
    border: 2px dashed var(--craft-gold);
    border-radius: 18px;
    opacity: 0;
    transition: all 0.4s ease;
    z-index: 10;
    pointer-events: none;
  }

  /* Handmade Stamp */
  .cs_design_item::after {
    content: '✋ HANDMADE';
    position: absolute;
    top: 20px;
    right: -30px;
    background: #1C30A3;
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 6px 40px;
    transform: rotate(45deg);
    z-index: 15;
    letter-spacing: 1px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    opacity: 0;
    transition: opacity 0.4s ease;
  }

  .cs_design_thumb {
    position: relative;
    padding-top: 125%;
    overflow: hidden;
  }

  .cs_design_thumb img {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
  }

  /* Fabric Texture Overlay on Hover */
  .cs_design_thumb::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4A574' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0;
    transition: opacity 0.5s ease;
    pointer-events: none;
  }

  .cs_design_overlay {
    position: absolute;
    bottom: 20px;
    left: 20px;
    right: 20px;
    background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(253,248,243,0.9));
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 2px solid  #1C30A3;
    box-shadow: 0 10px 20px #1C30A3;
    border-radius: 18px;
    padding: 22px;
    transform: translateY(25px) scale(0.95);
    opacity: 0;
    transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    z-index: 12;
  }

  /* 3D Tilt Hover Effect */
  .cs_design_item:hover {
    transform: translateY(-15px) rotateX(5deg) rotateY(-3deg);
    box-shadow: 
      0 35px 70px rgba(139, 69, 19, 0.2),
      0 15px 30px rgba(28, 48, 163, 0.1);
  }

  .cs_design_item:hover::before {
    opacity: 1;
  }

  .cs_design_item:hover::after {
    opacity: 1;
  }

  .cs_design_item:hover img {
    transform: scale(1.12);
  }

  .cs_design_item:hover .cs_design_thumb::after {
    opacity: 1;
  }

  .cs_design_item:hover .cs_design_overlay {
    transform: translateY(0) scale(1);
    opacity: 1;
  }

  .cs_design_title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 5px;
    color: var(--primary-color);
  }

  .cs_design_tag {
    display: inline-block;
    font-size: 12px;
    padding: 4px 12px;
    background: rgba(28, 48, 163, 0.1);
    color: var(--primary-color);
    border-radius: 20px;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 10px;
  }

  .cs_design_cta {
    display: flex;
    align-items: center;
    color: var(--primary-color);
    font-weight: 600;
    font-size: 14px;
    margin-top: 10px;
    transition: gap 0.3s ease;
  }

  .cs_design_cta::after {
    content: '\2192';
    margin-left: 8px;
    transition: transform 0.3s ease;
  }
  .cs_design_item:hover .cs_design_cta::after {
    transform: translateX(5px);
  }

  /* Premium Pagination Styling */
  .cs_pagination_wrap {
    margin-top: 60px;
    display: flex;
    justify-content: center;
  }
  .cs_pagination_wrap .pagination {
    display: flex;
    gap: 10px;
    list-style: none;
    padding: 0;
  }
  .cs_pagination_wrap .page-item {
    margin: 0;
  }
  .cs_pagination_wrap .page-link {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50% !important;
    border: 1px solid #e1e8ed;
    color: #1C30A3;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    background: #fff;
    text-decoration: none;
  }
  .cs_pagination_wrap .page-item.active .page-link {
    background: #1C30A3;
    border-color: #1C30A3;
    color: #fff;
    box-shadow: 0 5px 15px rgba(28, 48, 163, 0.3);
  }
  .cs_pagination_wrap .page-item.disabled .page-link {
    color: #ccc;
    cursor: not-allowed;
    background: #f8f9fa;
  }
  .cs_pagination_wrap .page-link:hover:not(.active) {
    background: #f0f4ff;
    border-color: #1C30A3;
    transform: translateY(-2px);
  }

  /* Lightbox Scrollbar Fixes */
  .cs_design_lightbox {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }

  .cs_design_lightbox.active {
    display: flex;
  }

  .cs_design_lightbox_overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    backdrop-filter: blur(10px);
    cursor: zoom-out;
  }

  .cs_design_lightbox_content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 96vw;
    height: 94vh;
    max-width: 1600px;
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    display: flex;
    box-shadow: 0 30px 90px rgba(0, 0, 0, 0.4);
    z-index: 10001;
    animation: swalPopup 0.4s cubic-bezier(0.25, 1, 0.5, 1);
  }

  @keyframes swalPopup {
    0% { transform: translate(-50%, -50%) scale(0.85); opacity: 0; }
    100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
  }

  .cs_lightbox_image_section {
    flex: 1;
    background: #fdfaf7;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    padding: 40px;
  }

  .cs_lightbox_image_section img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: drop-shadow(0 20px 40px rgba(0,0,0,0.15));
    transition: transform 0.5s ease;
  }

  .cs_lightbox_info_section {
    width: 500px;
    padding: 50px 45px;
    display: flex;
    flex-direction: column;
    background: #fff;
    overflow-y: auto;
    border-left: 1px solid #eee;
  }

  .cs_lightbox_info_section::-webkit-scrollbar {
    width: 6px;
  }
  .cs_lightbox_info_section::-webkit-scrollbar-track {
    background: #fdfaf7;
  }
  .cs_lightbox_info_section::-webkit-scrollbar-thumb {
    background: #1C30A3;
    border-radius: 10px;
  }

  .cs_lightbox_close {
    position: absolute;
    top: 25px; right: 25px;
    background: #fdfaf7;
    color: var(--text-color);
    border: 1px solid #eaeaea;
    width: 48px; height: 48px;
    border-radius: 50%;
    font-size: 20px;
    cursor: pointer;
    z-index: 10005;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-smooth);
  }

  .cs_lightbox_close:hover {
    transform: rotate(90deg) scale(1.1);
    background: #1C30A3;
    border-color: #1C30A3;
    color: #fff;
    box-shadow: 0 10px 20px rgba(28, 48, 163, 0.2);
  }

  .cs_buy_now_btn {
    width: 100%;
    padding: 18px;
    background: var(--primary-color);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: var(--transition-smooth);
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .cs_buy_now_btn:hover {
    background: #ffffffff;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px #1C30A3;
  }

  @media (max-width: 1199px) {
    .cs_page_heading {
      padding: 140px 0 80px;
    }
    
    .cs_design_grid {
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 25px;
    }
  }

  @media (max-width: 991px) {
    .cs_page_heading {
      padding: 120px 0 60px;
    }

    .cs_design_lightbox_content {
      flex-direction: column;
      height: 96vh;
      width: 96vw;
      border-radius: 20px;
      overflow-y: hidden;
    }

    .cs_lightbox_image_section {
      height: 40vh;
      flex: none;
      padding: 20px;
    }

    .cs_lightbox_info_section {
      width: 100%;
      height: 56vh;
      padding: 35px 25px;
      border-left: none;
      border-top: 1px solid #eee;
    }
    
    .cs_lightbox_image_section {
      height: 40vh;
      min-height: 300px;
      padding: 20px;
    }

    .cs_lightbox_image_section img {
      max-height: 100%;
    }

    .cs_lightbox_close {
      top: 15px;
      right: 15px;
      width: 38px;
      height: 38px;
    }
  }

  /* Size Selection Styles */
  .size-btn {
    padding: 8px 15px;
    border: 1px solid #ddd;
    background: white;
    color: #1a1a2e;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    min-width: 45px;
    text-align: center;
  }

  .size-btn:hover {
    border-color: #1C30A3;
    color: #1C30A3;
    background: rgba(28, 48, 163, 0.05);
  }

  .size-btn.active {
    background: #1C30A3;
    color: white;
    border-color: #1C30A3;
    box-shadow: 0 4px 10px rgba(28, 48, 163, 0.3);
  }

  /* Animation Keyframes */
  @keyframes textReveal {
    0% {
      transform: translateY(100%);
      opacity: 0;
    }
    100% {
      transform: translateY(0);
      opacity: 1;
    }
  }

  @keyframes shine {
    100% {
      left: 125%;
    }
  }

  .cs_lightbox_info_section::-webkit-scrollbar {
    width: 6px;
  }
  .cs_lightbox_info_section::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }
  .cs_lightbox_info_section::-webkit-scrollbar-thumb {
    background: #1C30A3;
    border-radius: 10px;
  }
  .cs_lightbox_info_section::-webkit-scrollbar-thumb:hover {
    background: #0A1854;
  }

  .cs_lightbox_info_section {
    padding-bottom: 60px !important;
  }

  .cs_lightbox_actions {
    margin-top: 30px;
  }

  /* Hero Text Reveal */
  .cs_hero_title_wrapper {
    overflow: hidden;
    display: inline-block;
  }

  .cs_hero_title_char {
    display: inline-block;
    transform: translateY(100%);
    opacity: 0;
    animation: textReveal 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
  }

  /* Card Shine Effect */
  .cs_design_item::before {
    content: '';
    position: absolute;
    top: 0; left: -75%;
    width: 50%; height: 100%;
    background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 100%);
    transform: skewX(-25deg);
    z-index: 5;
    transition: all 0.5s;
    pointer-events: none;
  }

  .cs_design_item:hover::before {
    animation: shine 0.75s;
  }

  @media (max-width: 767px) {
    .cs_hero_overlay {
      background: linear-gradient(135deg, rgba(28, 48, 163, 0.9) 0%, rgba(0, 0, 0, 0.7) 100%);
    }

    .cs_page_heading h1 {
      font-size: 36px !important; /* Force override utility classes if needed */
    }

    .cs_page_heading p {
      font-size: 16px !important;
      padding: 0 20px;
    }

    .cs_design_filters {
      gap: 10px;
      margin-bottom: 30px;
    }

    .cs_design_filters li a {
      padding: 8px 20px;
      font-size: 13px;
    }

    .cs_design_grid {
      grid-template-columns: 1fr; /* Single column on mobile */
      gap: 30px;
      padding: 0 20px;
    }
    
    .cs_design_thumb {
      padding-top: 100%; /* Square images on mobile */
    }

    .cs_design_overlay {
      opacity: 1; /* Always visible on mobile for better UX */
      transform: translateY(0);
      background: rgba(255, 255, 255, 0.9);
      bottom: 0; left: 0; right: 0;
      border-radius: 0;
      border-bottom-left-radius: 20px;
      border-bottom-right-radius: 20px;
      padding: 15px;
      
    }

    .cs_design_title {
      font-size: 18px;
      margin-bottom: 2px;
    }
    
    .cs_design_tag {
      font-size: 11px;
      margin-bottom: 5px;
    }

    .cs_lightbox_info_section {
      padding: 25px 20px;
    }

    #cs_lightbox_title {
      font-size: 24px !important;
      margin-bottom: 10px !important;
    }

    #cs_lightbox_description {
      font-size: 14px !important;
      margin-bottom: 20px !important;
    }

    .cs_design_features {
      margin-bottom: 25px !important;
      font-size: 14px;
    }
  }

  /* Gallery Section Animated Background */
  .gallery-section {
    background: linear-gradient(90deg, 
      rgba(10, 24, 84, 0.08) 0%, 
      rgba(28, 48, 163, 0.12) 35%,
      rgba(46, 93, 216, 0.08) 65%,
      rgba(10, 24, 84, 0.06) 100%);
    position: relative;
  }

  .gallery-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
      radial-gradient(ellipse at 10% 20%, rgba(28, 48, 163, 0.1) 0%, transparent 40%),
      radial-gradient(ellipse at 90% 80%, rgba(46, 93, 216, 0.08) 0%, transparent 40%),
      radial-gradient(ellipse at 50% 50%, rgba(10, 24, 84, 0.05) 0%, transparent 50%);
    z-index: 0;
    pointer-events: none;
  }

  .gallery-bg-shapes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
    pointer-events: none;
  }

  .gallery-shape {
    position: absolute;
  }

  /* Hexagon Positions & Animations */
  .gallery-hexagon-1 {
    top: 5%;
    left: 3%;
    animation: galleryFloat1 18s ease-in-out infinite;
  }

  .gallery-hexagon-2 {
    top: 40%;
    right: 5%;
    animation: galleryFloat2 20s ease-in-out infinite;
    animation-delay: -5s;
  }

  .gallery-hexagon-3 {
    bottom: 10%;
    left: 20%;
    animation: galleryFloat3 16s ease-in-out infinite;
    animation-delay: -10s;
  }

  /* Circle Positions & Animations */
  .gallery-circle-1 {
    top: 15%;
    right: 15%;
    animation: galleryFloat2 22s ease-in-out infinite;
    animation-delay: -3s;
  }

  .gallery-circle-2 {
    bottom: 25%;
    left: 8%;
    animation: galleryFloat1 19s ease-in-out infinite;
    animation-delay: -8s;
  }

  .gallery-circle-3 {
    top: 60%;
    right: 25%;
    animation: galleryFloat3 15s ease-in-out infinite;
    animation-delay: -2s;
  }

  /* Wave Positions & Animations */
  .gallery-wave-1 {
    top: 8%;
    left: 30%;
    animation: galleryFloat2 25s ease-in-out infinite;
    animation-delay: -4s;
  }

  .gallery-wave-2 {
    bottom: 15%;
    right: 10%;
    animation: galleryFloat1 23s ease-in-out infinite;
    animation-delay: -12s;
  }

  /* Diamond Positions & Animations */
  .gallery-diamond-1 {
    top: 30%;
    left: 12%;
    animation: galleryRotate 20s linear infinite;
  }

  .gallery-diamond-2 {
    bottom: 35%;
    right: 8%;
    animation: galleryRotate 25s linear infinite reverse;
    animation-delay: -6s;
  }

  /* Star Positions & Animations */
  .gallery-star-1 {
    top: 50%;
    left: 5%;
    animation: galleryStar 18s ease-in-out infinite;
    animation-delay: -7s;
  }

  .gallery-star-2 {
    top: 20%;
    right: 35%;
    animation: galleryStar 22s ease-in-out infinite;
    animation-delay: -11s;
  }

  /* Additional Shape Positions */
  .gallery-hexagon-4 {
    top: 70%;
    right: 20%;
    animation: galleryFloat1 17s ease-in-out infinite;
    animation-delay: -3s;
  }

  .gallery-hexagon-5 {
    top: 25%;
    left: 45%;
    animation: galleryFloat2 21s ease-in-out infinite;
    animation-delay: -8s;
  }

  .gallery-circle-4 {
    bottom: 5%;
    right: 35%;
    animation: galleryFloat3 24s ease-in-out infinite;
    animation-delay: -5s;
  }

  .gallery-circle-5 {
    top: 80%;
    left: 35%;
    animation: galleryFloat1 20s ease-in-out infinite;
    animation-delay: -14s;
  }

  .gallery-wave-3 {
    top: 55%;
    left: 60%;
    animation: galleryFloat2 26s ease-in-out infinite;
    animation-delay: -9s;
  }

  .gallery-diamond-3 {
    top: 75%;
    left: 55%;
    animation: galleryRotate 28s linear infinite;
    animation-delay: -12s;
  }

  .gallery-star-3 {
    bottom: 20%;
    left: 50%;
    animation: galleryStar 19s ease-in-out infinite;
    animation-delay: -6s;
  }

  .gallery-cross-1 {
    top: 35%;
    right: 30%;
    animation: gallerySpin 30s linear infinite;
  }

  .gallery-cross-2 {
    bottom: 40%;
    left: 25%;
    animation: gallerySpin 35s linear infinite reverse;
    animation-delay: -15s;
  }

  .gallery-dots-1 {
    top: 10%;
    left: 50%;
    animation: galleryPulse 8s ease-in-out infinite;
  }

  .gallery-dots-2 {
    bottom: 8%;
    right: 50%;
    animation: galleryPulse 10s ease-in-out infinite;
    animation-delay: -4s;
  }

  .gallery-ring-1 {
    top: 45%;
    left: 80%;
    animation: galleryFloat1 22s ease-in-out infinite;
    animation-delay: -10s;
  }

  .gallery-ring-2 {
    top: 65%;
    left: 10%;
    animation: galleryFloat2 19s ease-in-out infinite;
    animation-delay: -7s;
  }

  /* Gallery Animation Keyframes */
  @keyframes galleryFloat1 {
    0%, 100% {
      transform: translate(0, 0) scale(1);
    }
    25% {
      transform: translate(15px, -20px) scale(1.05);
    }
    50% {
      transform: translate(-10px, -35px) scale(0.95);
    }
    75% {
      transform: translate(20px, -15px) scale(1.02);
    }
  }

  @keyframes galleryFloat2 {
    0%, 100% {
      transform: translate(0, 0) scale(1);
    }
    33% {
      transform: translate(-20px, 25px) scale(1.08);
    }
    66% {
      transform: translate(15px, -30px) scale(0.92);
    }
  }

  @keyframes galleryFloat3 {
    0%, 100% {
      transform: translate(0, 0);
    }
    50% {
      transform: translate(25px, -40px);
    }
  }

  @keyframes galleryRotate {
    0% {
      transform: rotate(0deg) translate(0, 0);
    }
    25% {
      transform: rotate(90deg) translate(10px, -15px);
    }
    50% {
      transform: rotate(180deg) translate(0, 0);
    }
    75% {
      transform: rotate(270deg) translate(-10px, 15px);
    }
    100% {
      transform: rotate(360deg) translate(0, 0);
    }
  }

  @keyframes galleryStar {
    0%, 100% {
      transform: rotate(0deg) scale(1);
      opacity: 1;
    }
    25% {
      transform: rotate(72deg) scale(1.1);
      opacity: 0.8;
    }
    50% {
      transform: rotate(144deg) scale(0.9);
      opacity: 1;
    }
    75% {
      transform: rotate(216deg) scale(1.05);
      opacity: 0.9;
    }
  }

  @keyframes gallerySpin {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }

  @keyframes galleryPulse {
    0%, 100% {
      transform: scale(1);
      opacity: 1;
    }
    50% {
      transform: scale(1.2);
      opacity: 0.6;
    }
  }
</style>

  <!-- Premium Animated Hero Section -->
  <section class="premium-hero-section position-relative overflow-hidden">
    <!-- Floating SVG Shapes Background -->
    <div class="hero-svg-shapes">
      <!-- Hexagons (matching Castbull logo) -->
      <svg class="hero-shape shape-hexagon shape-hexagon-1" width="140" height="122" viewBox="0 0 120 104" fill="none">
        <path d="M60 0L113.923 31V73L60 104L6.07696 73V31L60 0Z" fill="rgba(255,255,255,0.5)"/>
      </svg>
      <svg class="hero-shape shape-hexagon shape-hexagon-2" width="100" height="87" viewBox="0 0 120 104" fill="none">
        <path d="M60 0L113.923 31V73L60 104L6.07696 73V31L60 0Z" stroke="rgba(255,255,255,0.6)" stroke-width="3" fill="none"/>
      </svg>
      <svg class="hero-shape shape-hexagon shape-hexagon-3" width="80" height="70" viewBox="0 0 120 104" fill="none">
        <path d="M60 0L113.923 31V73L60 104L6.07696 73V31L60 0Z" fill="rgba(255,255,255,0.4)"/>
      </svg>
      
      <!-- Circles -->
      <svg class="hero-shape shape-circle shape-circle-1" width="120" height="120" viewBox="0 0 100 100" fill="none">
        <circle cx="50" cy="50" r="45" stroke="rgba(255,255,255,0.5)" stroke-width="3" fill="none"/>
        <circle cx="50" cy="50" r="30" fill="rgba(255,255,255,0.2)"/>
      </svg>
      <svg class="hero-shape shape-circle shape-circle-2" width="80" height="80" viewBox="0 0 60 60" fill="none">
        <circle cx="30" cy="30" r="28" fill="rgba(255,255,255,0.35)"/>
      </svg>
      <svg class="hero-shape shape-circle shape-circle-3" width="60" height="60" viewBox="0 0 40 40" fill="none">
        <circle cx="20" cy="20" r="18" stroke="rgba(255,255,255,0.45)" stroke-width="2" fill="none"/>
      </svg>
      
      <!-- Wave/Curve Shapes -->
      <svg class="hero-shape shape-wave shape-wave-1" width="250" height="80" viewBox="0 0 200 60" fill="none">
        <path d="M0 30C30 10 70 50 100 30C130 10 170 50 200 30" stroke="rgba(255,255,255,0.45)" stroke-width="3" fill="none"/>
      </svg>
      <svg class="hero-shape shape-wave shape-wave-2" width="200" height="70" viewBox="0 0 150 50" fill="none">
        <path d="M0 25C25 5 50 45 75 25C100 5 125 45 150 25" stroke="rgba(255,255,255,0.35)" stroke-width="2" fill="none"/>
      </svg>
      
      <!-- Diamond Shapes -->
      <svg class="hero-shape shape-diamond shape-diamond-1" width="70" height="70" viewBox="0 0 50 50" fill="none">
        <rect x="25" y="0" width="35" height="35" transform="rotate(45 25 0)" fill="rgba(255,255,255,0.35)"/>
      </svg>
      <svg class="hero-shape shape-diamond shape-diamond-2" width="55" height="55" viewBox="0 0 35 35" fill="none">
        <rect x="17.5" y="0" width="24" height="24" transform="rotate(45 17.5 0)" stroke="rgba(255,255,255,0.45)" stroke-width="2" fill="none"/>
      </svg>
      
      <!-- Star/Burst Shapes -->
      <svg class="hero-shape shape-star shape-star-1" width="80" height="80" viewBox="0 0 60 60" fill="none">
        <path d="M30 0L33.5 23.5H57L38 38L44 60L30 46L16 60L22 38L3 23.5H26.5L30 0Z" fill="rgba(255,255,255,0.4)"/>
      </svg>
      <svg class="hero-shape shape-star shape-star-2" width="60" height="60" viewBox="0 0 40 40" fill="none">
        <path d="M20 0L22.5 15.5H38L25 25L29.5 40L20 30.5L10.5 40L15 25L2 15.5H17.5L20 0Z" stroke="rgba(255,255,255,0.4)" stroke-width="1.5" fill="none"/>
      </svg>
      
      <!-- Additional Decorative Elements -->
      <svg class="hero-shape" style="position: absolute; top: 70%; left: 70%; opacity: 0.35; animation: floatCircle 16s ease-in-out infinite;" width="100" height="100" viewBox="0 0 80 80" fill="none">
        <circle cx="40" cy="40" r="35" stroke="rgba(255,255,255,0.5)" stroke-width="3" stroke-dasharray="8 4" fill="none"/>
      </svg>
      <svg class="hero-shape" style="position: absolute; top: 25%; left: 45%; opacity: 0.3; animation: floatDiamond 22s ease-in-out infinite;" width="90" height="90" viewBox="0 0 70 70" fill="none">
        <polygon points="35,0 70,35 35,70 0,35" fill="rgba(255,255,255,0.35)"/>
      </svg>
    </div>
    
    <div class="hero-particles" id="heroParticles"></div>
    <div class="hero-gradient-overlay"></div>
    
    <!-- Artisan Floating Elements -->
    <div class="artisan-floating-elements">
      <svg class="artisan-element needle-thread" style="top: 15%; left: 8%;" width="60" height="60" viewBox="0 0 60 60" fill="none">
        <path d="M30 5L30 40" stroke="rgba(212,165,116,0.8)" stroke-width="2" stroke-dasharray="4 3"/>
        <ellipse cx="30" cy="48" rx="8" ry="4" stroke="rgba(255,255,255,0.6)" stroke-width="1.5" fill="none"/>
        <circle cx="30" cy="8" r="3" fill="rgba(212,165,116,0.9)"/>
      </svg>
      <svg class="artisan-element" style="top: 25%; right: 12%; animation: sewingMotion 10s ease-in-out infinite reverse;" width="50" height="50" viewBox="0 0 50 50" fill="none">
        <path d="M10 25 L20 15 L30 25 L20 35 Z" fill="rgba(255,255,255,0.4)"/>
        <path d="M25 25 L35 15 L45 25 L35 35 Z" stroke="rgba(212,165,116,0.6)" stroke-width="1.5" fill="none"/>
      </svg>
      <svg class="artisan-element" style="bottom: 20%; left: 15%; animation: sewingMotion 12s ease-in-out infinite;" width="40" height="40" viewBox="0 0 40 40" fill="none">
        <circle cx="20" cy="20" r="15" stroke="rgba(255,255,255,0.5)" stroke-width="1.5" fill="none" stroke-dasharray="6 4"/>
        <circle cx="20" cy="20" r="8" fill="rgba(212,165,116,0.4)"/>
      </svg>
      <svg class="artisan-element" style="bottom: 30%; right: 20%; animation: sewingMotion 15s ease-in-out infinite reverse;" width="45" height="45" viewBox="0 0 45 45" fill="none">
        <path d="M22.5 5 L40 22.5 L22.5 40 L5 22.5 Z" stroke="rgba(255,255,255,0.5)" stroke-width="2" fill="rgba(212,165,116,0.2)"/>
      </svg>
    </div>
    
    <div class="container position-relative text-center" style="z-index: 5;">
      <div class="hero-content">
        <div class="hero-artisan-badge">
          <span>{{ gt('Handcrafted with Love') }}</span>
          <span style="font-size: 18px;">❤️</span>
        </div>
        <h1 class="artisan-title">{{ gt('Our Handmade Creations') }}</h1>
        <p class="artisan-subtitle">{{ gt('"Each piece tells a story of tradition, passion & artistry"') }}</p>
        <div style="margin-top: 30px; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
          <span style="display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.9); font-size: 14px;">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 2L12 8H18L13 12L15 18L10 14L5 18L7 12L2 8H8L10 2Z" fill="rgba(212,165,116,0.9)"/></svg>
            {{ gt('100% Handcrafted') }}
          </span>
          <span style="display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.9); font-size: 14px;">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="7" stroke="rgba(212,165,116,0.9)" stroke-width="1.5" fill="none"/><path d="M10 6V10L13 12" stroke="rgba(212,165,116,0.9)" stroke-width="1.5"/></svg>
            {{ gt('Made with Care') }}
          </span>
          <span style="display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.9); font-size: 14px;">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M3 10L8 15L17 5" stroke="rgba(212,165,116,0.9)" stroke-width="2"/></svg>
            {{ gt('Premium Quality') }}
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
    <!-- Animated Background for Gallery -->
    <div class="gallery-bg-shapes">
      <!-- Hexagons -->
      <svg class="gallery-shape gallery-hexagon-1" width="100" height="87" viewBox="0 0 120 104" fill="none">
        <path d="M60 0L113.923 31V73L60 104L6.07696 73V31L60 0Z" fill="rgba(28,48,163,0.08)"/>
      </svg>
      <svg class="gallery-shape gallery-hexagon-2" width="70" height="61" viewBox="0 0 120 104" fill="none">
        <path d="M60 0L113.923 31V73L60 104L6.07696 73V31L60 0Z" stroke="rgba(28,48,163,0.12)" stroke-width="2" fill="none"/>
      </svg>
      <svg class="gallery-shape gallery-hexagon-3" width="50" height="43" viewBox="0 0 120 104" fill="none">
        <path d="M60 0L113.923 31V73L60 104L6.07696 73V31L60 0Z" fill="rgba(46,93,216,0.06)"/>
      </svg>
      
      <!-- Circles -->
      <svg class="gallery-shape gallery-circle-1" width="80" height="80" viewBox="0 0 80 80" fill="none">
        <circle cx="40" cy="40" r="35" stroke="rgba(28,48,163,0.1)" stroke-width="2" fill="none"/>
      </svg>
      <svg class="gallery-shape gallery-circle-2" width="60" height="60" viewBox="0 0 60 60" fill="none">
        <circle cx="30" cy="30" r="28" fill="rgba(46,93,216,0.05)"/>
      </svg>
      <svg class="gallery-shape gallery-circle-3" width="40" height="40" viewBox="0 0 40 40" fill="none">
        <circle cx="20" cy="20" r="18" stroke="rgba(28,48,163,0.08)" stroke-width="1.5" stroke-dasharray="4 3" fill="none"/>
      </svg>
      
      <!-- Waves -->
      <svg class="gallery-shape gallery-wave-1" width="180" height="50" viewBox="0 0 200 60" fill="none">
        <path d="M0 30C30 10 70 50 100 30C130 10 170 50 200 30" stroke="rgba(28,48,163,0.1)" stroke-width="2" fill="none"/>
      </svg>
      <svg class="gallery-shape gallery-wave-2" width="150" height="40" viewBox="0 0 150 50" fill="none">
        <path d="M0 25C25 5 50 45 75 25C100 5 125 45 150 25" stroke="rgba(46,93,216,0.08)" stroke-width="1.5" fill="none"/>
      </svg>
      
      <!-- Diamonds -->
      <svg class="gallery-shape gallery-diamond-1" width="50" height="50" viewBox="0 0 50 50" fill="none">
        <polygon points="25,0 50,25 25,50 0,25" fill="rgba(28,48,163,0.06)"/>
      </svg>
      <svg class="gallery-shape gallery-diamond-2" width="35" height="35" viewBox="0 0 35 35" fill="none">
        <polygon points="17.5,0 35,17.5 17.5,35 0,17.5" stroke="rgba(46,93,216,0.1)" stroke-width="1.5" fill="none"/>
      </svg>
      
      <!-- Stars -->
      <svg class="gallery-shape gallery-star-1" width="50" height="50" viewBox="0 0 60 60" fill="none">
        <path d="M30 0L33.5 23.5H57L38 38L44 60L30 46L16 60L22 38L3 23.5H26.5L30 0Z" fill="rgba(28,48,163,0.07)"/>
      </svg>
      <svg class="gallery-shape gallery-star-2" width="35" height="35" viewBox="0 0 40 40" fill="none">
        <path d="M20 0L22.5 15.5H38L25 25L29.5 40L20 30.5L10.5 40L15 25L2 15.5H17.5L20 0Z" stroke="rgba(46,93,216,0.1)" stroke-width="1" fill="none"/>
      </svg>
      
      <!-- Additional Hexagons -->
      <svg class="gallery-shape gallery-hexagon-4" width="65" height="56" viewBox="0 0 120 104" fill="none">
        <path d="M60 0L113.923 31V73L60 104L6.07696 73V31L60 0Z" stroke="rgba(28,48,163,0.1)" stroke-width="2" fill="none"/>
      </svg>
      <svg class="gallery-shape gallery-hexagon-5" width="45" height="39" viewBox="0 0 120 104" fill="none">
        <path d="M60 0L113.923 31V73L60 104L6.07696 73V31L60 0Z" fill="rgba(46,93,216,0.07)"/>
      </svg>
      
      <!-- Additional Circles -->
      <svg class="gallery-shape gallery-circle-4" width="55" height="55" viewBox="0 0 55 55" fill="none">
        <circle cx="27.5" cy="27.5" r="25" stroke="rgba(28,48,163,0.09)" stroke-width="2" fill="none"/>
      </svg>
      <svg class="gallery-shape gallery-circle-5" width="45" height="45" viewBox="0 0 45 45" fill="none">
        <circle cx="22.5" cy="22.5" r="20" fill="rgba(46,93,216,0.06)"/>
      </svg>
      
      <!-- Additional Wave -->
      <svg class="gallery-shape gallery-wave-3" width="160" height="45" viewBox="0 0 180 50" fill="none">
        <path d="M0 25C20 5 50 45 90 25C130 5 160 45 180 25" stroke="rgba(28,48,163,0.08)" stroke-width="2" fill="none"/>
      </svg>
      
      <!-- Additional Diamond -->
      <svg class="gallery-shape gallery-diamond-3" width="40" height="40" viewBox="0 0 40 40" fill="none">
        <polygon points="20,0 40,20 20,40 0,20" stroke="rgba(28,48,163,0.08)" stroke-width="1.5" fill="none"/>
      </svg>
      
      <!-- Additional Star -->
      <svg class="gallery-shape gallery-star-3" width="45" height="45" viewBox="0 0 50 50" fill="none">
        <path d="M25 0L28 19H47L32 31L37 50L25 38L13 50L18 31L3 19H22L25 0Z" fill="rgba(46,93,216,0.08)"/>
      </svg>
      
      <!-- Cross/Plus Shapes -->
      <svg class="gallery-shape gallery-cross-1" width="40" height="40" viewBox="0 0 40 40" fill="none">
        <path d="M20 0V40M0 20H40" stroke="rgba(28,48,163,0.1)" stroke-width="2"/>
      </svg>
      <svg class="gallery-shape gallery-cross-2" width="30" height="30" viewBox="0 0 30 30" fill="none">
        <path d="M15 0V30M0 15H30" stroke="rgba(46,93,216,0.08)" stroke-width="1.5"/>
      </svg>
      
      <!-- Dot Patterns -->
      <svg class="gallery-shape gallery-dots-1" width="60" height="60" viewBox="0 0 60 60" fill="none">
        <circle cx="10" cy="10" r="4" fill="rgba(28,48,163,0.1)"/>
        <circle cx="30" cy="10" r="4" fill="rgba(28,48,163,0.08)"/>
        <circle cx="50" cy="10" r="4" fill="rgba(28,48,163,0.06)"/>
        <circle cx="10" cy="30" r="4" fill="rgba(28,48,163,0.08)"/>
        <circle cx="30" cy="30" r="4" fill="rgba(28,48,163,0.1)"/>
        <circle cx="50" cy="30" r="4" fill="rgba(28,48,163,0.08)"/>
        <circle cx="10" cy="50" r="4" fill="rgba(28,48,163,0.06)"/>
        <circle cx="30" cy="50" r="4" fill="rgba(28,48,163,0.08)"/>
        <circle cx="50" cy="50" r="4" fill="rgba(28,48,163,0.1)"/>
      </svg>
      <svg class="gallery-shape gallery-dots-2" width="50" height="50" viewBox="0 0 50 50" fill="none">
        <circle cx="12.5" cy="12.5" r="3" fill="rgba(46,93,216,0.09)"/>
        <circle cx="37.5" cy="12.5" r="3" fill="rgba(46,93,216,0.07)"/>
        <circle cx="12.5" cy="37.5" r="3" fill="rgba(46,93,216,0.07)"/>
        <circle cx="37.5" cy="37.5" r="3" fill="rgba(46,93,216,0.09)"/>
        <circle cx="25" cy="25" r="5" fill="rgba(46,93,216,0.1)"/>
      </svg>
      
      <!-- Concentric Rings -->
      <svg class="gallery-shape gallery-ring-1" width="70" height="70" viewBox="0 0 70 70" fill="none">
        <circle cx="35" cy="35" r="30" stroke="rgba(28,48,163,0.08)" stroke-width="1.5" fill="none"/>
        <circle cx="35" cy="35" r="20" stroke="rgba(28,48,163,0.06)" stroke-width="1.5" fill="none"/>
        <circle cx="35" cy="35" r="10" stroke="rgba(28,48,163,0.04)" stroke-width="1.5" fill="none"/>
      </svg>
      <svg class="gallery-shape gallery-ring-2" width="55" height="55" viewBox="0 0 55 55" fill="none">
        <circle cx="27.5" cy="27.5" r="25" stroke="rgba(46,93,216,0.07)" stroke-width="1" fill="none"/>
        <circle cx="27.5" cy="27.5" r="17" stroke="rgba(46,93,216,0.05)" stroke-width="1" fill="none"/>
        <circle cx="27.5" cy="27.5" r="9" fill="rgba(46,93,216,0.06)"/>
      </svg>
    </div>
    
    <div class="cs_height_100 cs_height_lg_60"></div>
    <div class="container" style="position: relative; z-index: 2;">
      
      <!-- Gallery Section Intro -->
      <div class="text-center" style="margin-bottom: 60px;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 25px;">
          <svg width="60" height="30" viewBox="0 0 60 30" fill="none">
            <path d="M0 15H25" stroke="var(--craft-gold)" stroke-width="2"/>
            <circle cx="30" cy="15" r="5" fill="var(--craft-gold)"/>
            <path d="M35 15H60" stroke="var(--craft-gold)" stroke-width="2"/>
          </svg>
        </div>
        <h2 style="font-family: 'Playfair Display', serif; font-size: 42px; font-weight: 700; color: var(--primary-color); margin-bottom: 15px;">
          {{ gt('Our Artisan Collection') }}
        </h2>
        <p style="font-size: 18px; color: #1C30A3; font-style: italic; max-width: 600px; margin: 0 auto 30px;">
          {{ gt('Every stitch, every print, every detail — crafted with passion') }}
        </p>
        <svg width="150" height="30" viewBox="0 0 150 30" fill="none" style="margin-bottom: 20px;">
          <path d="M0 15C20 5 40 25 60 15C80 5 100 25 120 15L150 15" stroke="var(--craft-gold)" stroke-width="1.5" fill="none" stroke-dasharray="4 3"/>
          <circle cx="75" cy="15" r="4" fill="var(--craft-terracotta)"/>
        </svg>
      </div>
      
      <!-- <ul class="cs_design_filters">
        <li class="active" data-filter="*"><a href="#all">{{ gt('All Designs') }}</a></li>
        @php
          $uniqueTags = collect($designs)->pluck('tag')->unique()->sort();
        @endphp
        @foreach($uniqueTags as $tag)
        <li data-filter=".{{ str_replace(' ', '-', strtolower($tag)) }}">
          <a href="#{{ str_replace(' ', '-', strtolower($tag)) }}">{{ $tag }}</a>
        </li>
        @endforeach
      </ul> -->

      <div class="cs_design_grid">
        @foreach($designs as $design)
        <!-- Design Items -->
        <div class="cs_design_item {{ str_replace(' ', '-', strtolower($design->tag)) }}" style="box-shadow: 0 10px 20px #1C30A3;" data-id="{{ $design->id }}" data-src="{{ env('MAIN_URL') . 'images/' . $design->image }}" data-description="{{ $design->description }}" data-price="{{ $design->price }}" data-size="{{ $design->size }}" data-cloth="{{ $design->cloth_types }}">
          <div class="cs_design_thumb">
            <img src="{{ env('MAIN_URL') . 'images/' . $design->image }}" alt="{{ $design->title }}">
            <div class="cs_design_overlay">
              <span class="cs_design_tag">{{ $design->tag }}</span>
              <h3 class="cs_design_title">{{ $design->title }}</h3>
              <span class="cs_design_cta">{{ gt('View Details') }}</span>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      
      <div class="cs_pagination_wrap">
        {{ $designs->links('pagination::bootstrap-4') }}
      </div>
    </div>
    <div class="cs_height_140 cs_height_lg_80"></div>
  </section>
  <!-- End Design Gallery -->

  <!-- Start Lightbox Modal -->
  <div class="cs_design_lightbox" id="cs_design_lightbox">
    <div class="cs_design_lightbox_overlay" id="cs_lightbox_overlay"></div>
    <div class="cs_design_lightbox_content">
      <button class="cs_lightbox_close" id="cs_lightbox_close">
        <i class="fa-solid fa-xmark"></i>
      </button>
      
      <div class="cs_lightbox_image_section">
        <img id="cs_lightbox_img" src="" alt="Design">
      </div>
      
      <div class="cs_lightbox_info_section" style="background: linear-gradient(180deg, #fff 0%, var(--craft-cream) 100%);">
        <div class="cs_design_lightbox_info">
          <span id="cs_lightbox_tag" class="cs_design_tag" style=" color: white;"></span>
          <h2 id="cs_lightbox_title" class="cs_design_title" style="font-size: 32px; margin-bottom: 10px; font-family: 'Playfair Display', serif;"></h2>
          <div id="cs_lightbox_price" class="cs_design_price" style="font-size: 28px; font-weight: 800; color: #1C30A3; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
            $0.00 <span style="font-size: 14px; font-weight: 500; color: #888; text-decoration: line-through; opacity: 0.6;">{{ gt('Incl. GST') }}</span>
          </div>
          <p id="cs_lightbox_description" style="color: #555; font-size: 15px; line-height: 1.7; margin-bottom: 30px; padding: 0; border-left: 3px solid var(--craft-gold); padding-left: 15px;">
            {{ gt('Lovingly handcrafted by our skilled artisans. Each piece carries the warmth of human touch and the precision of traditional craftsmanship.') }}
          </p>
          
          <!-- Artisan Features -->
          <div class="cs_design_features" style="margin-bottom: 35px; padding: 25px; background: #fdfaf7; border-radius: 20px; border: 1px solid #f1e4d5; display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <span style="font-size: 20px; background: white; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">✋</span>
              <span style="font-weight: 600; font-size: 13px; color: #1C30A3;">{{ gt('Handmade') }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
              <span style="font-size: 20px; background: white; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">🌿</span>
              <span style="font-weight: 600; font-size: 13px; color: #1C30A3;">{{ gt('Organic') }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
              <span style="font-size: 20px; background: white; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">⭐</span>
              <span style="font-weight: 600; font-size: 13px; color: #1C30A3;">{{ gt('Premium') }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
              <span style="font-size: 20px; background: white; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">🎨</span>
              <span style="font-weight: 600; font-size: 13px; color: #1C30A3;">{{ gt('Unique') }}</span>
            </div>
          </div>

          <!-- Size & Cloth Type Selection -->
          <div class="cs_selection_options" style="margin-bottom: 25px;">
            <div id="cs_size_section" style="margin-bottom: 20px;">
              <label class="premium-form-label">{{ gt('Select Size') }}</label>
              <div id="cs_lightbox_sizes" style="display: flex; flex-wrap: wrap; gap: 10px;">
                <!-- Sizes will be populated here -->
              </div>
              <input type="hidden" id="selected_size" value="">
            </div>

            <div id="cs_cloth_section" style="margin-bottom: 20px;">
              <label class="premium-form-label">{{ gt('Cloth Type') }}</label>
              <select id="cs_lightbox_cloth" class="premium-form-input premium-form-select">
                <!-- Cloth types will be populated here -->
              </select>
            </div>
          </div>

          <!-- Quantity Selector -->
          <div class="cs_quantity_selector" style="margin-bottom: 30px;">
            <label class="premium-form-label">{{ gt('Quantity') }}</label>
            <div style="display: flex; align-items: center; gap: 15px;">
              <button type="button" id="qty_minus" class="cs_qty_btn" style="width: 45px; height: 45px;">-</button>
              <input type="number" id="cs_lightbox_qty" value="1" min="1" class="premium-form-input" style="width: 80px; text-align: center;">
              <button type="button" id="qty_plus" class="cs_qty_btn" style="width: 45px; height: 45px;">+</button>
            </div>
          </div>
          <!-- Keyboard Hint -->
         
        </div>
        
        <div class="cs_lightbox_actions" style="margin-top: 40px; padding-top: 25px; border-top: 1px solid #eee;">
          <button type="button" class="cs_buy_now_btn" id="cs_buy_now_btn" style="height: 60px; display: flex; align-items: center; justify-content: center; gap: 15px; font-size: 18px; box-shadow: 0 10px 30px rgba(28, 48, 163, 0.2);">
            <i class="fa-solid fa-cart-shopping"></i> {{ gt('Add to Your Collection') }}
          </button>
          <p style="text-align: center; font-size: 12px; color: #888; margin-top: 15px;">
            <i class="fa-solid fa-shield-halved"></i> {{ gt('Secure checkout with quality guarantee') }}
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
        for (let i = 0; i < 50; i++) {
          const particle = document.createElement('div');
          particle.style.cssText = `
            position: absolute;
            width: ${Math.random() * 4 + 2}px;
            height: ${Math.random() * 4 + 2}px;
            background: rgba(255, 255, 255, ${Math.random() * 0.5 + 0.2});
            border-radius: 50%;
            left: ${Math.random() * 100}%;
            top: ${Math.random() * 100}%;
            animation: float ${Math.random() * 10 + 10}s infinite ease-in-out;
            animation-delay: ${Math.random() * 5}s;
          `;
          heroParticles.appendChild(particle);
        }
        const style = document.createElement('style');
        style.textContent = `
          @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.3; }
            25% { transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) scale(1.2); opacity: 0.6; }
            50% { transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) scale(0.8); opacity: 0.4; }
            75% { transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) scale(1.1); opacity: 0.5; }
          }
        `;
        document.head.appendChild(style);
      }

      // Add enhanced animation keyframes
      const enhancedStyles = document.createElement('style');
      enhancedStyles.textContent = `
        @keyframes fadeInUp {
          from { opacity: 0; transform: translateY(40px) scale(0.95); }
          to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes lightboxFadeIn {
          from { opacity: 0; }
          to { opacity: 1; }
        }
        @keyframes lightboxFadeOut {
          from { opacity: 1; }
          to { opacity: 0; }
        }
      `;
      document.head.appendChild(enhancedStyles);

      // ========== ADD TO CART HANDLER ==========
      const buyBtn = document.getElementById('cs_buy_now_btn');
      const designItems = document.querySelectorAll('.cs_design_item');

      if (buyBtn) {
        // Quantity +/- handlers
        document.getElementById('qty_minus')?.addEventListener('click', function() {
          const input = document.getElementById('cs_lightbox_qty');
          const minVal = (appSetting && appSetting.min_quantity) ? appSetting.min_quantity : 1;
          if (parseInt(input.value) > minVal) input.value = parseInt(input.value) - 1;
        });
        document.getElementById('qty_plus')?.addEventListener('click', function() {
          const input = document.getElementById('cs_lightbox_qty');
          const maxVal = (appSetting && appSetting.max_quantity) ? appSetting.max_quantity : Infinity;
          if (parseInt(input.value) < maxVal) input.value = parseInt(input.value) + 1;
        });

        buyBtn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();

          // Find current item from design-gallery.js shared state
          const lightbox = document.getElementById('cs_design_lightbox');
          if (!lightbox || !lightbox.classList.contains('active')) return;

          // Get the currently displayed product info from the lightbox DOM
          const lightboxTitle = document.getElementById('cs_lightbox_title');
          const currentTitle = lightboxTitle ? lightboxTitle.textContent : '';

          // Find the matching design item by title
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

          // Disable button while processing
          buyBtn.disabled = true;
          buyBtn.innerHTML = '<span style="margin-right: 8px;"><i class="fa-solid fa-spinner fa-spin"></i></span> {{ gt("Adding...") }}';

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
                  buyBtn.innerHTML = '<span style="margin-right: 8px;">🛒</span> {{ gt("Add to Cart") }}';
                  return false;
                }
                if (appSetting.max_quantity && qty > appSetting.max_quantity) {
                  Swal.fire('{{ gt("Error") }}', '{{ gt("Maximum") }} ' + appSetting.max_quantity + ' {{ gt("quantity allowed") }}', 'error');
                  buyBtn.disabled = false;
                  buyBtn.innerHTML = '<span style="margin-right: 8px;">🛒</span> {{ gt("Add to Cart") }}';
                  return false;
                }
              }
            },
            success: function(res) {
              // Auto redirect to cart page
              window.location.href = "{{ route('cart.index') }}";
            },
            error: function(xhr) {
              buyBtn.disabled = false;
              buyBtn.innerHTML = '<span style="margin-right: 8px;">🛒</span> {{ gt("Add to Cart") }}';

              if (xhr.status === 401 || xhr.status === 419) {
                // Not logged in or session expired — redirect to login
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
