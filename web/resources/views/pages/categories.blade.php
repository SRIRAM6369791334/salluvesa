@extends('layouts.app')
@section('content')
  <section class="premium-hero-section position-relative overflow-hidden"><div class="hero-particles" id="heroParticles"></div><div class="hero-gradient-overlay"></div><div class="container position-relative text-center" style="z-index:2"><div class="hero-content"><div class="hero-badge"><span class="badge-icon">🏷️</span><span>{{ gt('Browse') }}</span></div><h1 class="premium-hero-title">{{ gt('Categories') }}</h1><p class="hero-subtitle">{{ gt('Explore styles for every occasion') }}</p></div></div><div class="hero-wave"><svg viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="wave-fill"></path><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="wave-fill"></path><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="wave-fill"></path></svg></div></section>

  <!-- Start Categories Gallery -->
  <section class="premium-contact-section">
    <div class="animated-gradient-bg"></div>
    <div class="cs_height_140 cs_height_lg_80"></div>
    <div class="container-fluid">
      <div class="cs_categories_gallery">
        @foreach($categories as $category)
        <div class="cs_category_card" data-category="{{ strtolower($category->category_name) }}">
          <div class="cs_category_image">
            <img src="{{ $category->category_image ? asset($category->category_image) : 'img/product1.png' }}" alt="{{ $category->category_name }}" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">{{ $category->category_name }}</h3>
              <span class="cs_category_count">{{ $subCategories->get($category->id, collect())->count() }} {{ gt('Printing Techniques') }}</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            @foreach($subCategories->get($category->id, collect()) as $subCategory)
            <div class="cs_subcategory_item">
              <img src="{{ $subCategory->subcategory_image ? asset($subCategory->subcategory_image) : 'img/product1.png' }}" alt="{{ $subCategory->subcategory_name }}">
              <span>{{ $subCategory->subcategory_name }}</span>
            </div>
            @endforeach
          </div>
        </div>
        @endforeach

        <!-- Maternity Wear Category -->
        {{--<div class="cs_category_card" data-category="maternity">
          <div class="cs_category_image">
            <img src="img/women2.jpg" alt="Maternity Wear" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Maternity Wear</h3>
              <span class="cs_category_count">42+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product17.png" alt="Maternity POLO T – SHIRTS">
              <span>POLO T – SHIRTS</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product18.png" alt="Maternity Tops">
              <span>Tops</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product19.png" alt="Maternity TANK TOPS">
              <span>TANK TOPS</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product20.png" alt="Nursing Wear">
              <span>Nursing Wear</span>
            </div>
          </div>
        </div>
        
        <!-- Lingerie and Sleepwear Category -->
        <div class="cs_category_card" data-category="lingerie">
          <div class="cs_category_image">
            <img src="img/product5.png" alt="Lingerie and Sleepwear" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Lingerie and Sleepwear</h3>
              <span class="cs_category_count">67+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product9.png" alt="Bras">
              <span>Bras</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product10.png" alt="Panties">
              <span>Panties</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product11.png" alt="Sleepwear">
              <span>Sleepwear</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product12.png" alt="Lingerie Sets">
              <span>Lingerie Sets</span>
            </div>
          </div>
        </div> --}}


        <!-- Formal Wear Category -->
       {{--<div class="cs_category_card" data-category="formal">
          <div class="cs_category_image">
            <img src="img/product11.png" alt="Formal Wear" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Formal Wear</h3>
              <span class="cs_category_count">78+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product21.png" alt="Blazers">
              <span>Blazers</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product22.png" alt="Dress TANK TOPS">
              <span>Dress TANK TOPS</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product23.png" alt="Dress TANK TOPS">
              <span>Dress TANK TOPS</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product24.png" alt="Ties">
              <span>Ties</span>
            </div>
          </div>
        </div>

        <!-- Plus Size Clothing Category -->
        <div class="cs_category_card" data-category="plus-size">
          <div class="cs_category_image">
            <img src="img/product12.png" alt="Plus Size Clothing" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Plus Size Clothing</h3>
              <span class="cs_category_count">156+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product25.png" alt="Plus Size Tops">
              <span>Tops</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product26.png" alt="Plus Size Jeans">
              <span>Jeans</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product27.png" alt="Plus Size POLO T – SHIRTS">
              <span>POLO T – SHIRTS</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product28.png" alt="Plus Size Mens">
              <span>Mens</span>
            </div>
          </div>
        </div>

        <!-- Casual Wear Category -->
        <div class="cs_category_card" data-category="casual">
          <div class="cs_category_image">
            <img src="img/men2.jpg" alt="Casual Wear" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Casual Wear</h3>
              <span class="cs_category_count">203+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product1.png" alt="Casual T-SHIRT">
              <span>T-SHIRT</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product2.png" alt="Casual TANK TOPS">
              <span>TANK TOPS</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product3.png" alt="Casual TANK TOPS">
              <span>TANK TOPS</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product4.png" alt="Casual SHIRTS">
              <span>SHIRTS</span>
            </div>
          </div>
        </div>

        <!-- Sustainable Fashion Category -->
        <div class="cs_category_card" data-category="sustainable">
          <div class="cs_category_image">
            <img src="img/product6.png" alt="Sustainable Fashion" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Sustainable Fashion</h3>
              <span class="cs_category_count">89+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product7.png" alt="Organic Cotton">
              <span>Organic Cotton</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product8.png" alt="Recycled Materials">
              <span>Recycled Materials</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product9.png" alt="Fair Trade">
              <span>Fair Trade</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product10.png" alt="Eco-Friendly">
              <span>Eco-Friendly</span>
            </div>
          </div>
        </div>

        <!-- Outerwear Category -->
        <div class="cs_category_card" data-category="outerwear">
          <div class="cs_category_image">
            <img src="img/product13.png" alt="Outerwear" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Outerwear (Jackets, Coats)</h3>
              <span class="cs_category_count">124+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product14.png" alt="Jackets">
              <span>Jackets</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product15.png" alt="Coats">
              <span>Coats</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product16.png" alt="Blazers">
              <span>Blazers</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product17.png" alt="Hoodies">
              <span>Hoodies</span>
            </div>
          </div>
        </div>

        <!-- Vintage/Second-hand Clothing Category -->
        <div class="cs_category_card" data-category="vintage">
          <div class="cs_category_image">
            <img src="img/product18.png" alt="Vintage Clothing" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Vintage / Second-hand Clothing</h3>
              <span class="cs_category_count">67+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product19.png" alt="Vintage POLO T – SHIRTS">
              <span>Vintage POLO T – SHIRTS</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product20.png" alt="Retro Tops">
              <span>Retro Tops</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product21.png" alt="Thrifted Jeans">
              <span>Thrifted Jeans</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product22.png" alt="Pre-owned Accessories">
              <span>Pre-owned Accessories</span>
            </div>
          </div>
        </div>

        <!-- Swimwear Category -->
        <div class="cs_category_card" data-category="swimwear">
          <div class="cs_category_image">
            <img src="img/product23.png" alt="Swimwear" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Swimwear</h3>
              <span class="cs_category_count">54+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product24.png" alt="Bikinis">
              <span>Bikinis</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product25.png" alt="One-Piece">
              <span>One-Piece</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product26.png" alt="Swim Shorts">
              <span>Swim Shorts</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product27.png" alt="Cover-ups">
              <span>Cover-ups</span>
            </div>
          </div>
        </div>

        

        <!-- Sports Apparel Category -->
        <div class="cs_category_card" data-category="sports">
          <div class="cs_category_image">
            <img src="img/product14.png" alt="Sports Apparel" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Sports Apparel</h3>
              <span class="cs_category_count">98+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product15.png" alt="Running Gear">
              <span>Running Gear</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product16.png" alt="Gym Wear">
              <span>Gym Wear</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product17.png" alt="Team Sports">
              <span>Team Sports</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product18.png" alt="Sports Accessories">
              <span>Sports Accessories</span>
            </div>
          </div>
        </div>

        <!-- Workwear Category -->
        <div class="cs_category_card" data-category="workwear">
          <div class="cs_category_image">
            <img src="img/product19.png" alt="Workwear" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Workwear</h3>
              <span class="cs_category_count">76+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product20.png" alt="Uniforms">
              <span>Uniforms</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product21.png" alt="Scrubs">
              <span>Scrubs</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product22.png" alt="Safety Gear">
              <span>Safety Gear</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product23.png" alt="Corporate Wear">
              <span>Corporate Wear</span>
            </div>
          </div>
        </div>

        <!-- Designer Clothing Category -->
        <div class="cs_category_card" data-category="designer">
          <div class="cs_category_image">
            <img src="img/product24.png" alt="Designer Clothing" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Designer Clothing</h3>
              <span class="cs_category_count">45+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product25.png" alt="Designer POLO T – SHIRTS">
              <span>POLO T – SHIRTS</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product26.png" alt="Designer Suits">
              <span>Suits</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product27.png" alt="Luxury Accessories">
              <span>Luxury Accessories</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product28.png" alt="High-End SHIRTS">
              <span>High-End SHIRTS</span>
            </div>
          </div>
        </div>

        <!-- Seasonal Collections Category -->
        <div class="cs_category_card" data-category="seasonal">
          <div class="cs_category_image">
            <img src="img/product5.png" alt="Seasonal Collections" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Seasonal Collections</h3>
              <span class="cs_category_count">134+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product6.png" alt="Spring Collection">
              <span>Spring</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product7.png" alt="Summer Collection">
              <span>Summer</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product8.png" alt="Fall Collection">
              <span>Fall</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product9.png" alt="Winter Collection">
              <span>Winter</span>
            </div>
          </div>
        </div>

        <!-- Costumes and Cosplay Category -->
        <div class="cs_category_card" data-category="costumes">
          <div class="cs_category_image">
            <img src="img/product10.png" alt="Costumes and Cosplay" loading="lazy">
            <div class="cs_category_overlay">
              <h3 class="cs_category_title">Costumes and Cosplay</h3>
              <span class="cs_category_count">89+ Items</span>
            </div>
            <div class="cs_category_expand">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
          <div class="cs_subcategories">
            <div class="cs_subcategory_item">
              <img src="img/product11.png" alt="Halloween Costumes">
              <span>Halloween</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product12.png" alt="Anime Cosplay">
              <span>Anime Cosplay</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product13.png" alt="Superhero Costumes">
              <span>Superhero</span>
            </div>
            <div class="cs_subcategory_item">
              <img src="img/product14.png" alt="Themed Parties">
              <span>Themed Parties</span>
            </div>
          </div>
        </div>--}}
      </div> 
    </div>
    <div class="cs_height_140 cs_height_lg_80"></div>
  </section>
  <!-- End Categories Gallery -->
  <style>.premium-hero-section{min-height:400px;display:flex;align-items:center;background:linear-gradient(135deg,#1C30A3 0%,#2541C8 50%,#3B5FE0 100%);position:relative;padding:120px 0 180px}.hero-particles{position:absolute;top:0;left:0;width:100%;height:100%;overflow:hidden;z-index:1}.hero-gradient-overlay{position:absolute;top:0;left:0;width:100%;height:100%;background:radial-gradient(circle at 20% 50%,rgba(102,126,234,.3) 0%,transparent 50%),radial-gradient(circle at 80% 80%,rgba(240,147,251,.3) 0%,transparent 50%);z-index:1}.hero-content{position:relative;z-index:2}.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.2);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.3);padding:10px 24px;border-radius:50px;color:white;font-size:14px;font-weight:500;margin-bottom:30px}.premium-hero-title{font-size:56px;font-weight:900;font-family:'Merriweather',serif;color:white;margin:0 0 20px 0;line-height:1.2}.hero-subtitle{font-size:18px;color:rgba(255,255,255,.9);margin:0;max-width:600px;margin-left:auto;margin-right:auto}.hero-wave{position:absolute;bottom:0;left:0;width:100%;overflow:hidden;line-height:0;transform:rotate(180deg)}.hero-wave svg{position:relative;display:block;width:calc(100% + 1.3px);height:80px}.wave-fill{fill:#fff}.cs_height_100{height:100px}.cs_height_140{height:140px}@media(max-width:991px){.cs_height_lg_60{height:60px!important}.cs_height_lg_80{height:80px!important}}</style>
  <script>document.addEventListener('DOMContentLoaded',function(){const e=document.getElementById('heroParticles');if(e){for(let t=0;t<50;t++){const o=document.createElement('div');o.style.cssText=`position:absolute;width:${Math.random()*4+2}px;height:${Math.random()*4+2}px;background:rgba(255,255,255,${Math.random()*.5+.2});border-radius:50%;left:${Math.random()*100}%;top:${Math.random()*100}%;animation:float ${Math.random()*10+10}s infinite ease-in-out;animation-delay:${Math.random()*5}s`,e.appendChild(o)}const t=document.createElement('style');t.textContent=`@keyframes float{0%,100%{transform:translate(0,0) scale(1);opacity:.3}25%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(1.2);opacity:.6}50%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(.8);opacity:.4}75%{transform:translate(${Math.random()*100-50}px,${Math.random()*100-50}px) scale(1.1);opacity:.5}}`,document.head.appendChild(t)}});</script>
@endsection
