<!DOCTYPE html>
<html lang="bn" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KushtiaExpress • কুষ্টিয়ার সেরা খাবার ডেলিভারি ২০ মিনিটে</title>
    <meta name="description" content="কুষ্টিয়ার বিখ্যাত কুলফি মালাই, শাহী কাচ্চি, গড়াই নদীর ইলিশ এবং মুখরোচক খাবার ঘরে বসেই অর্ডার করুন। মাত্র ২০ মিনিটে হোম ডেলিভারি।">

    <!-- Google Fonts (Hind Siliguri + Outfit + Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Application CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body, button, input, select, textarea {
            font-family: 'Hind Siliguri', 'Plus Jakarta Sans', sans-serif;
        }
        h1, h2, h3, h4, h5, h6, .brand-logo, .food-price {
            font-family: 'Outfit', 'Hind Siliguri', sans-serif;
        }
    </style>
</head>
<body>

    <!-- TOP PROMO ANNOUNCEMENT BAR -->
    <div class="top-banner">
        <span>🔥 কুষ্টিয়া স্পেশাল অফার: প্রথম অর্ডারে <strong>৳৫০ ছাড়</strong> পেতে কোড ব্যবহার করুন <span class="code-tag">KUSHTIA50</span></span>
        <span style="opacity: 0.6;">•</span>
        <span>⚡ ৳৪০০ অর্ডারে কুষ্টিয়া পৌরসভা এলাকায় <strong>ফ্রি ডেলিভারি</strong> কোড <span class="code-tag">GORAI</span></span>
    </div>

    <!-- MAIN NAVBAR -->
    <header class="navbar">
        <div class="container nav-container">
            <!-- Brand Logo -->
            <a href="#hero" class="brand-logo">
                <div class="logo-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                </div>
                <span>Kushtia<span class="gradient-text">Express</span></span>
            </a>

            <!-- Delivery Address Quick Select -->
            <div class="nav-location" onclick="window.craveApp.openModal('locationModal')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--brand-primary)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div style="text-align: left;">
                    <div style="font-size: 0.72rem; color: var(--text-muted); line-height: 1;">ডেলিভারি লোকেশন:</div>
                    <div style="font-weight: 700; font-size: 0.85rem;" id="navCurrentLocation">মজমুপুর গেট, কুষ্টিয়া (১৫-২০মি)</div>
                </div>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>

            <!-- Navigation Links -->
            <ul class="nav-links">
                <li><a href="#menu-catalog" class="nav-link" data-i18n="nav.menu">খাবারের মেনু</a></li>
                <li><a href="#offers" class="nav-link" data-en="Special Offers" data-bn="অফার">অফার</a></li>
                <li><a href="#chef-spotlight" class="nav-link" data-en="Kushtia Specials" data-bn="কুষ্টিয়ার স্পেশাল">কুষ্টিয়ার স্পেশাল</a></li>
                <li><a href="{{ route('order.bn') }}" class="nav-link" data-i18n="nav.orders">অর্ডার ট্র্যাকিং</a></li>
                <li><a href="{{ route('contact.bn') }}" class="nav-link" data-i18n="nav.contact">যোগাযোগ</a></li>
            </ul>

            <!-- Actions (Language Switcher, Auth, Theme Toggle, Active Order, Cart Trigger) -->
            <div class="nav-actions">
                <!-- Global Language Switcher Button (বাংলা ↔ English) -->
                <button type="button" class="lang-toggle-btn" onclick="window.craveApp.toggleLanguage()" title="ভাষা পরিবর্তন করুন / Switch Language">
                    <span class="lang-flag">🇧🇩</span>
                    <span class="lang-text">বাংলা</span>
                    <span style="font-size:0.75rem; color:var(--text-muted);">| EN</span>
                </button>

                <!-- Guest Auth Button (Sign Up / Login) -->
                <button class="auth-nav-btn auth-guest-view" onclick="window.craveApp.openAuthModal('register')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span data-i18n="nav.auth">সাইন আপ / লগইন</span>
                </button>

                <!-- Authenticated User Dropdown -->
                <div class="auth-user-dropdown-wrap auth-user-view" style="display: none;">
                    <div class="auth-user-pill" onclick="window.craveApp.toggleUserDropdown()">
                        <div class="auth-user-avatar auth-user-initial">U</div>
                        <span class="auth-user-name">কাস্টমার</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                    <div id="authUserDropdownMenu" class="auth-dropdown-menu">
                        <div style="padding: 6px 12px; border-bottom: 1px solid var(--border-light); margin-bottom: 4px;">
                            <div style="font-size: 0.75rem; color: var(--text-muted);" data-en="Logged in Account" data-bn="লগইন করা অ্যাকাউন্ট">লগইন করা অ্যাকাউন্ট</div>
                            <div style="font-weight: 800; font-size: 0.9rem;" class="auth-user-name">কাস্টমার</div>
                        </div>
                        <a href="{{ route('order.bn') }}" class="auth-dropdown-item">
                            <span data-en="📦 My Orders" data-bn="📦 আমার অর্ডারসমূহ">📦 আমার অর্ডারসমূহ</span>
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="auth-dropdown-item" style="color: var(--brand-primary); font-weight: 700;">
                            <span>⚙️ অ্যাডমিন প্যানেল (Admin)</span>
                        </a>
                        <a href="{{ route('contact.bn') }}" class="auth-dropdown-item">
                            <span data-en="💬 Help & Support" data-bn="💬 হেল্পডেস্ক ও সহায়তা">💬 হেল্পডেস্ক ও সহায়তা</span>
                        </a>
                        <button class="auth-dropdown-item" style="color: var(--danger);" onclick="window.craveApp.handleLogout()">
                            <span data-en="🚪 Logout" data-bn="🚪 লগআউট (Logout)">🚪 লগআউট (Logout)</span>
                        </button>
                    </div>
                </div>

                <!-- Track Active Order Button -->
                <button id="recentOrderTrackBtn" style="display: none;" class="btn btn-secondary" onclick="window.craveApp.openTrackingModal()" title="Track Current Live Order">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span data-i18n="nav.track_order">অর্ডার ট্র্যাকিং</span>
                </button>

                <!-- Dark / Light Theme Toggle -->
                <button id="themeToggleBtn" class="theme-toggle-btn" aria-label="Toggle Light/Dark Mode" title="Toggle theme">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </button>

                <!-- Cart Button Trigger -->
                <button id="cartDrawerTrigger" class="cart-btn-trigger">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <span data-i18n="nav.cart">কার্ট</span>
                    <span id="navCartCount" class="cart-badge-count" style="display: none;">0</span>
                </button>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section id="hero" class="hero-section">
        <div class="hero-backdrop-glow"></div>
        <div class="container hero-grid">
            <div class="hero-content">
                <div class="hero-badge-pill">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    <span data-en="⚡ Fastest 20-Min Express Food Delivery in Kushtia" data-bn="কুষ্টিয়া শহরে মাত্র ২০ মিনিটে দ্রুততম ফুড ডেলিভারি">কুষ্টিয়া শহরে মাত্র ২০ মিনিটে দ্রুততম ফুড ডেলিভারি</span>
                </div>
                <h1 class="hero-title" data-en="Authentic Taste of Kushtia <br/><span class='gradient-text'>At Your Doorstep.</span>" data-bn="কুষ্টিয়ার সেরা ঐতিহ্যবাহী স্বাদ আপনার <span class='gradient-text'>দরজায়।</span>">
                    কুষ্টিয়ার সেরা ঐতিহ্যবাহী স্বাদ আপনার <span class="gradient-text">দরজায়।</span>
                </h1>
                <p class="hero-subtitle" data-en="From famous Kulfi Malai, Shahi Kacchi Biryani, fresh Gorai Ilish to crispy burgers— getting piping hot food delivered in minutes!" data-bn="বিখ্যাত কুলফি মালাই, শাহী কাচ্চি বিরিয়ানি, গড়াই নদীর টাটকা ইলিশ থেকে ক্রিস্পি বার্গার— কুষ্টিয়ার সেরা রেস্তোরাঁ থেকে গরম গরম খাবার পৌঁছে দিচ্ছি চোখের পলকে!">
                    বিখ্যাত কুলফি মালাই, শাহী কাচ্চি বিরিয়ানি, গড়াই নদীর টাটকা ইলিশ থেকে ক্রিস্পি বার্গার— কুষ্টিয়ার সেরা রেস্তোরাঁ থেকে গরম গরম খাবার পৌঁছে দিচ্ছি চোখের পলকে!
                </p>

                <!-- Live Search Box -->
                <div class="hero-search-box">
                    <div class="hero-search-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </div>
                    <input type="text" id="heroSearchInput" class="hero-search-input" placeholder="কুলফি মালাই, কাচ্চি বিরিয়ানি, কালা ভুনা, বার্গার, ইলিশ মাছ খুঁজুন..." data-placeholder-en="Search dishes (e.g. Kulfi, Biryani, Ilish, Burger)..." data-placeholder-bn="কুলফি মালাই, কাচ্চি বিরিয়ানি, কালা ভুনা, বার্গার, ইলিশ মাছ খুঁজুন..." />
                    <button class="btn btn-primary" onclick="document.getElementById('menu-catalog').scrollIntoView({behavior: 'smooth'})" data-en="Search Food" data-bn="খাবার খুঁজুন">খাবার খুঁজুন</button>
                </div>

                <!-- Quick Category Shortcuts -->
                <div class="hero-quick-tags">
                    <span class="quick-tag-label" data-en="Popular Items:" data-bn="জনপ্রিয় খাবার:">জনপ্রিয় খাবার:</span>
                    <button class="quick-tag-btn" data-category="kushtia-heritage" data-en="🍨 Royal Kulfi Malai" data-bn="🍨 কুষ্টিয়ার কুলফি মালাই">🍨 কুষ্টিয়ার কুলফি মালাই</button>
                    <button class="quick-tag-btn" data-category="biryani-polao" data-en="🍛 Shahi Kacchi Biryani" data-bn="🍛 শাহী কাচ্চি বিরিয়ানি">🍛 শাহী কাচ্চি বিরিয়ানি</button>
                    <button class="quick-tag-btn" data-category="bengali-curry-fish" data-en="🐟 Fresh Gorai Ilish" data-bn="🐟 গড়াই নদীর ইলিশ">🐟 গড়াই নদীর ইলিশ</button>
                    <button class="quick-tag-btn" data-category="bengali-curry-fish" data-en="🥩 Beef Kala Bhuna" data-bn="🥩 গরুর কালা ভুনা">🥩 গরুর কালা ভুনা</button>
                    <button class="quick-tag-btn" data-category="street-snacks" data-en="🧆 Special Doi Fuchka" data-bn="🧆 স্পেশাল দই ফুচকা">🧆 স্পেশাল দই ফুচকা</button>
                </div>
            </div>

            <!-- Hero Visual Showcase -->
            <div class="hero-visual">
                <!-- Floating Stats Card 1 -->
                <div class="floating-card floating-card-1">
                    <div class="stat-icon stat-icon-gold">★</div>
                    <div>
                        <div class="stat-title">৪.৯ রেটিং (কুষ্টিয়া)</div>
                        <div class="stat-desc">১২,৫০০+ সন্তুষ্ট ভোজনরসিক</div>
                    </div>
                </div>

                <!-- Main Hero Dish Image -->
                <div class="hero-main-img-wrap">
                    <img src="https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=900&q=80" alt="Kushtia Shahi Kachi Biryani" />
                </div>

                <!-- Floating Stats Card 2 -->
                <div class="floating-card floating-card-2">
                    <div class="stat-icon stat-icon-brand">⚡</div>
                    <div>
                        <div class="stat-title">১৫-২০ মিনিট গড় সময়</div>
                        <div class="stat-desc">থার্মাল হট বক্স ডেলিভারি</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PROMO CODES / OFFERS SECTION -->
    <section id="offers" class="section-promos">
        <div class="container">
            <div class="promo-grid">
                @foreach($promoCodes as $promo)
                <div class="promo-card">
                    <div>
                        <div class="promo-title">{{ $promo->title }}</div>
                        <div class="promo-desc">{{ $promo->description }}</div>
                    </div>
                    <button class="coupon-copy-btn" data-code="{{ $promo->code }}" title="ক্লিক করে কোড কপি করুন">
                        <span>{{ $promo->code }}</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CHEF'S SPECIAL SPOTLIGHT BANNER -->
    <section id="chef-spotlight" class="section-chef-spotlight">
        <div class="container">
            <div class="spotlight-banner">
                <div>
                    <span class="badge badge-brand" style="margin-bottom: 16px;">কুষ্টিয়ার সেরা ঐতিহ্যবাহী আইটেম</span>
                    <h2 class="spotlight-title">কুষ্টিয়ার বিখ্যাত রয়্যাল শাহী কুলফি মালাই</h2>
                    <p class="spotlight-desc">
                        শতবর্ষের প্রাচীন রেসিপিতে খাঁটি ঘন দুধের ক্ষীর, জাফরান, পেস্তা ও কাজুবাদামের কুচি মিশিয়ে তৈরি। কুষ্টিয়া শহরের সবচেয়ে জনপ্রিয় মিষ্টান্ন যা একবার খেলে বারবার খেতে মন চাইবে!
                    </p>
                    <div class="spotlight-perks">
                        <div class="spotlight-perk-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>১০০% খাঁটি গাভীর দুধ ও নো-প্রিজারভেটিভ গ্যারান্টি</span>
                        </div>
                        <div class="spotlight-perk-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>ড্রাই আইস কন্টেইনারে সম্পূর্ণ গলনমুক্ত ডেলিভারি</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <span style="font-size: 2rem; font-weight: 800; font-family: 'Outfit'; color: #FFFFFF;">৳১২০</span>
                        <button class="btn btn-primary" onclick="window.craveApp.quickAddToCart({ id: 1, name: 'Kushtia Famous Royal Shahi Kulfi Malai', price: 120, image: 'https://images.unsplash.com/photo-1587314168485-3236d6710814?auto=format&fit=crop&w=800&q=80' })">
                            এখনই কুলফি অর্ডার করুন
                        </button>
                    </div>
                </div>
                <div class="spotlight-img-wrap">
                    <img src="https://images.unsplash.com/photo-1587314168485-3236d6710814?auto=format&fit=crop&w=900&q=80" alt="Kushtia Famous Kulfi Malai" />
                </div>
            </div>
        </div>
    </section>

    <!-- FOOD MENU / CATALOG SECTION -->
    <section id="menu-catalog" class="section-menu">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">কুষ্টিয়ার সেরা মেনু</div>
                <h2 class="section-title">পছন্দের সুস্বাদু খাবার বেছে নিন</h2>
                <p class="section-desc">টাটকা ও স্বাস্থ্যকর উপায়ে প্রস্তুত করা খাবার, সঠিক সময়ে ডেলিভারি।</p>
            </div>

            <!-- Category Horizontal Scroll Tabs -->
            <div class="category-scroll-wrap">
                <button class="category-tab-btn active" data-slug="all">
                    <span>🌟 সকল খাবার (All)</span>
                    <span class="cat-count">{{ $allFoodItems->count() }}</span>
                </button>
                @foreach($categories as $cat)
                <button class="category-tab-btn" data-slug="{{ $cat->slug }}">
                    <span>{{ $cat->name }}</span>
                    <span class="cat-count">{{ $cat->food_items_count }}</span>
                </button>
                @endforeach
            </div>

            <!-- Filters and Sorting Control Bar -->
            <div class="filter-bar">
                <div class="filter-pills">
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">ফিল্টার:</span>
                    <button class="filter-pill" data-filter="vegetarian">🌱 নিরামিষ (Veg)</button>
                    <button class="filter-pill" data-filter="spicy">🌶️ স্পাইসি / ঝাল</button>
                    <button class="filter-pill" data-filter="chef_special">👨‍🍳 কুষ্টিয়া স্পেশাল</button>
                </div>
                <div class="sort-select-wrap">
                    <span>সাজান:</span>
                    <select id="sortSelect" class="sort-select">
                        <option value="popular">জনপ্রিয়তার ভিত্তিতে</option>
                        <option value="rating">সর্বোচ্চ রেটিং (★ 4.9+)</option>
                        <option value="price_low">কম দাম থেকে বেশি</option>
                        <option value="price_high">বেশি দাম থেকে কম</option>
                        <option value="prep_time">দ্রুততম সময়ে প্রস্তুত</option>
                    </select>
                </div>
            </div>

            <!-- Food Items Grid -->
            <div id="foodItemsGrid" class="food-grid">
                @foreach($allFoodItems as $item)
                <div class="food-card" data-id="{{ $item->id }}">
                    <div class="food-card-img-wrap">
                        <img src="{{ $item->image }}" alt="{{ $item->name }}" loading="lazy" />
                        <div class="food-card-badges">
                            @if($item->is_chef_special)
                                <span class="badge badge-brand">কুষ্টিয়া স্পেশাল</span>
                            @endif
                            @if($item->is_vegetarian)
                                <span class="badge badge-success">নিরামিষ / Veg</span>
                            @endif
                            @if($item->is_spicy)
                                <span class="badge badge-spicy">🌶️ ঝাল</span>
                            @endif
                        </div>
                        <div class="food-rating-badge">
                            ★ <span>{{ number_format($item->rating, 1) }}</span> ({{ $item->reviews_count }})
                        </div>
                    </div>
                    <div class="food-card-body">
                        <div class="food-meta-row">
                            <div class="food-meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <span>{{ $item->prep_time }}</span>
                            </div>
                            @if($item->calories)
                            <div class="food-meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2c1.5 3 4 5 4 9 0 4.4-3.6 8-8 8s-8-3.6-8-8c0-4 2.5-6 4-9 1.5 3 2.5 4 4 4s2.5-1 4-4z"></path></svg>
                                <span>{{ $item->calories }} ক্যালোরি</span>
                            </div>
                            @endif
                        </div>
                        <h4 class="food-item-name">{{ $item->name }}</h4>
                        <p class="food-item-desc">{{ $item->description }}</p>
                        <div class="food-card-footer">
                            <div class="price-wrap">
                                <span class="food-price">৳{{ number_format($item->price, 0) }}</span>
                                @if($item->original_price)
                                    <span class="original-price">৳{{ number_format($item->original_price, 0) }}</span>
                                @endif
                            </div>
                            <div class="card-action-group">
                                <button class="btn-customize" onclick="window.craveApp.openCustomizeModal({{ json_encode($item) }})" title="কাস্টমাইজ ও অপশন">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                </button>
                                <button class="btn-add-cart" onclick="window.craveApp.quickAddToCart({{ json_encode($item) }})">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    অর্ডার
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE US / FEATURES -->
    <section id="why-us" class="section-features">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">আমাদের বিশেষত্ব</div>
                <h2 class="section-title">কেন কুষ্টিয়া এক্সপ্রেস সেরা?</h2>
                <p class="section-desc">কুষ্টিয়া শহরের প্রতিটি অলিগলিতে বিশ্বস্ততার সাথে খাবার পৌঁছানো আমাদের অঙ্গীকার।</p>
            </div>
            <div class="feature-cards-grid">
                <div class="feature-card">
                    <div class="feature-icon-box">⚡</div>
                    <h3 class="feature-title">১৫-২০ মিনিটে এক্সপ্রেস ডেলিভারি</h3>
                    <p class="feature-desc">কুষ্টিয়া শহরের নিজস্ব বাইকার ও রাইডার টিমের মাধ্যমে দ্রুততম সময়ে খাবার পৌঁছে দেওয়া হয়।</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon-box">🍱</div>
                    <h3 class="feature-title">কুষ্টিয়ার ঐতিহ্যবাহী সেরা স্বাদ</h3>
                    <p class="feature-desc">বিখ্যাত কুলফি মালাই, গড়াইয়ের ইলিশ ও খাঁটি স্বাদের সেরা কাচ্চি বিরিয়ানি এক ক্লিকেই।</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon-box">📱</div>
                    <h3 class="feature-title">সহজ বিকাশ ও নগদ পেমেন্ট</h3>
                    <p class="feature-desc">বিকাশ (bKash), নগদ (Nagad) অথবা খাবার হাতে পেয়ে ক্যাশ অন ডেলিভারিতে পেমেন্ট করুন।</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon-box">🏍️</div>
                    <h3 class="feature-title">লাইভ রাইডার ট্র্যাকিং</h3>
                    <p class="feature-desc">রেস্তোরাঁর রান্নাঘর থেকে আপনার বাসা পর্যন্ত রাইডারের প্রতিটি পদক্ষেপ লাইভ ম্যাপে দেখুন।</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CUSTOMER REVIEWS -->
    <section id="reviews" style="padding: 60px 0 80px; background: var(--bg-surface-2);">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">কুষ্টিয়ার ভোজনরসিকদের মতামত</div>
                <h2 class="section-title">হাজারো সন্তুষ্ট গ্রাহকের প্রশংসা</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
                <div style="background: var(--bg-surface); padding: 28px; border-radius: 20px; border: 1px solid var(--border-light);">
                    <div style="color: #FFB800; font-size: 1.1rem; margin-bottom: 12px;">★★★★★</div>
                    <p style="font-size: 0.95rem; line-height: 1.6; color: var(--text-main); margin-bottom: 18px;">
                        "কুষ্টিয়ার ঐতিহ্যবাহী কুলফি মালাই এত ফ্রেশ ও ঠাণ্ডা অবস্থায় হোম ডেলিভারি পাব ভাবিনি! মাত্র ১৮ মিনিটে মজমুপুর গেটে ডেলিভারি পেয়েছি।"
                    </p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;" alt="Reviewer" />
                        <div>
                            <div style="font-weight: 700; font-size: 0.95rem;">নুসরাত জাহান</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">মজমুপুর গেট, কুষ্টিয়া</div>
                        </div>
                    </div>
                </div>

                <div style="background: var(--bg-surface); padding: 28px; border-radius: 20px; border: 1px solid var(--border-light);">
                    <div style="color: #FFB800; font-size: 1.1rem; margin-bottom: 12px;">★★★★★</div>
                    <p style="font-size: 0.95rem; line-height: 1.6; color: var(--text-main); margin-bottom: 18px;">
                        "কাচ্চি বিরিয়ানির সাথে বোরহানি আর গরুর কালা ভুনা একদম মুখে লেগে থাকার মতো। বিকাশ পেমেন্ট আর লাইভ ট্র্যাকিং সিস্টেম দারুণ!"
                    </p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;" alt="Reviewer" />
                        <div>
                            <div style="font-weight: 700; font-size: 0.95rem;">তানভীর আহমেদ</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">কোর্টপাড়া, কুষ্টিয়া</div>
                        </div>
                    </div>
                </div>

                <div style="background: var(--bg-surface); padding: 28px; border-radius: 20px; border: 1px solid var(--border-light);">
                    <div style="color: #FFB800; font-size: 1.1rem; margin-bottom: 12px;">★★★★★</div>
                    <p style="font-size: 0.95rem; line-height: 1.6; color: var(--text-main); margin-bottom: 18px;">
                        "ইসলামী বিশ্ববিদ্যালয় ক্যাম্পাসে বসে এত সহজে কুষ্টিয়া শহরের সেরা রেস্তোরাঁর খাবার পেয়ে যাব ভাবিনি। কুষ্টিয়া এক্সপ্রেসকে ধন্যবাদ।"
                    </p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;" alt="Reviewer" />
                        <div>
                            <div style="font-weight: 700; font-size: 0.95rem;">সাদিয়া রহমান</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">ইসলামী বিশ্ববিদ্যালয়, কুষ্টিয়া</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="brand-logo" style="margin-bottom: 14px;">
                        <div class="logo-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path></svg>
                        </div>
                        <span>Kushtia<span class="gradient-text">Express</span></span>
                    </div>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">
                        কুষ্টিয়া শহরের সেরা রেস্তোরাঁ ও মিষ্টির দোকান থেকে তাজা ও গরম খাবার হোম ডেলিভারি সেবা।
                    </p>
                    <div style="display: flex; gap: 10px;">
                        <button class="btn-icon" aria-label="Facebook">📘</button>
                        <button class="btn-icon" aria-label="WhatsApp">💬</button>
                        <button class="btn-icon" aria-label="YouTube">▶️</button>
                    </div>
                </div>

                <div>
                    <h4 class="footer-col-title">কুষ্টিয়ার স্পেশাল খাবার</h4>
                    <ul class="footer-links">
                        <li><a href="#menu-catalog">বিখ্যাত কুলফি মালাই ও খাজা</a></li>
                        <li><a href="#menu-catalog">শাহী দম কাচ্চি বিরিয়ানি</a></li>
                        <li><a href="#menu-catalog">পদ্মা ও গড়াই নদীর ইলিশ</a></li>
                        <li><a href="#menu-catalog">ঐতিহ্যবাহী গরুর কালা ভুনা</a></li>
                        <li><a href="#menu-catalog">স্পেশাল দই ফুচকা ও চটপটি</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-col-title">কুষ্টিয়া ডেলিভারি জোন</h4>
                    <ul class="footer-links">
                        <li><a href="javascript:void(0)">মজমুপুর গেট ও এন এস রোড</a></li>
                        <li><a href="javascript:void(0)">কোর্টপাড়া ও থানা মোড়</a></li>
                        <li><a href="javascript:void(0)">চৌড়হাস ও গড়াই ব্রিজ এলাকা</a></li>
                        <li><a href="javascript:void(0)">ইসলামী বিশ্ববিদ্যালয় (IU) ক্যাম্পাস</a></li>
                        <li><a href="javascript:void(0)">হাউজিং ও পুলিশ লাইনস</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-col-title">যোগাযোগ ও হেল্পলাইন</h4>
                    <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 8px;">
                        📍 এনএস রোড, মজমুপুর গেট, কুষ্টিয়া সদর, বাংলাদেশ
                    </p>
                    <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 14px;">
                        📞 হেল্পলাইন: +৮৮০ ১৭১২-৩৪৫৬৭৮
                    </p>
                    <div style="display: flex; gap: 8px;">
                        <input type="text" placeholder="আপনার ফোন নম্বর" class="form-control" style="font-size: 0.85rem;" />
                        <button class="btn btn-primary" onclick="window.craveApp.showToast('ধন্যবাদ! শীঘ্রই আমাদের টিম যোগাযোগ করবে।', 'success')">যুক্ত হন</button>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div>© {{ date('Y') }} KushtiaExpress • সর্বস্বত্ব সংরক্ষিত • কুষ্টিয়া, বাংলাদেশ</div>
                <div style="display: flex; gap: 18px;">
                    <a href="javascript:void(0)">বিকাশ পেমেন্ট</a>
                    <a href="javascript:void(0)">নগদ পেমেন্ট</a>
                    <a href="javascript:void(0)">প্রাইভেসি পলিসি</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- SLIDE-OVER CART DRAWER -->
    <div id="cartOverlay" class="modal-overlay" style="z-index: 1040;"></div>
    <div id="cartDrawer" class="cart-drawer">
        <div class="drawer-header">
            <div class="drawer-title">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--brand-primary)" stroke-width="2.2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                <span>আপনার খাবারের কার্ট</span>
            </div>
            <button id="cartDrawerClose" class="btn-icon" aria-label="Close cart drawer">✕</button>
        </div>

        <!-- Free Delivery Progress Tracker -->
        <div class="delivery-meter-box">
            <div id="deliveryProgressText">আর মাত্র <strong>৳৪০০</strong> অর্ডারে পাচ্ছেন <strong>ফ্রি হোম ডেলিভারি</strong></div>
            <div class="progress-bar-bg">
                <div id="deliveryProgressFill" class="progress-bar-fill"></div>
            </div>
        </div>

        <!-- Cart Items List Container -->
        <div id="cartItemsList" class="cart-items-list">
            <!-- Populated via JS -->
        </div>

        <!-- Cart Footer with Pricing Breakdown & Coupon Apply -->
        <div class="cart-drawer-footer">
            <div class="coupon-input-group">
                <input type="text" id="cartCouponInput" class="coupon-input" placeholder="কুপন কোড (যেমন: KUSHTIA50)" />
                <button id="applyCouponBtn" class="btn-apply-coupon">প্রয়োগ</button>
            </div>

            <div class="cart-summary-rows">
                <div class="summary-row">
                    <span>খাবারের মোট মূল্য</span>
                    <span id="cartSubtotal">৳০</span>
                </div>
                <div id="cartDiscountRow" class="summary-row" style="display: none; color: var(--success); font-weight: 700;">
                    <span>কুপন ছাড় (Discount)</span>
                    <span id="cartDiscountVal">-৳০</span>
                </div>
                <div class="summary-row">
                    <span>কুষ্টিয়া এক্সপ্রেস ডেলিভারি চার্জ</span>
                    <span id="cartDeliveryFee">৳৪০</span>
                </div>
                <div class="summary-row">
                    <span>ভ্যাট (৫% VAT)</span>
                    <span id="cartTax">৳০</span>
                </div>
                <div class="summary-row total">
                    <span>সর্বমোট প্রদেয়</span>
                    <span id="cartTotal" class="gradient-text">৳০</span>
                </div>
            </div>

            <button id="proceedCheckoutBtn" class="btn btn-primary" style="width: 100%; padding: 14px;">
                <span>অর্ডার কনফার্ম করতে এগিয়ে যান</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
        </div>
    </div>

    <!-- FOOD CUSTOMIZATION MODAL -->
    <div id="customizeModal" class="modal-overlay">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 id="customizeModalTitle" style="font-size: 1.25rem;">খাবার কাস্টমাইজ করুন</h3>
                <button class="btn-icon" onclick="window.craveApp.closeModal('customizeModal')">✕</button>
            </div>
            <div id="customizeModalBody" class="modal-body">
                <!-- Dynamically populated -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="window.craveApp.closeModal('customizeModal')">বাতিল</button>
                <button id="customizeAddCartBtn" class="btn btn-primary" onclick="window.craveApp.confirmCustomAddToCart()">
                    কার্টে যোগ করুন
                </button>
            </div>
        </div>
    </div>

    <!-- 1-STEP CHECKOUT MODAL -->
    <div id="checkoutModal" class="modal-overlay">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 style="font-size: 1.3rem; display: flex; align-items: center; gap: 8px;">
                    <span>⚡ দ্রুততম চেকআউট (কুষ্টিয়া ডেলিভারি)</span>
                </h3>
                <button class="btn-icon" onclick="window.craveApp.closeModal('checkoutModal')">✕</button>
            </div>
            <form id="checkoutForm">
                <div class="modal-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">আপনার নাম *</label>
                            <input type="text" id="custName" class="form-control" required placeholder="মোঃ রফিকুল ইসলাম" value="মোঃ রফিকুল ইসলাম" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">মোবাইল নম্বর *</label>
                            <input type="tel" id="custPhone" class="form-control" required placeholder="017XXXXXXXX" value="01712345678" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">কুষ্টিয়ার সম্পূর্ণ ঠিকানা (বাসা/রোড/এলাকা) *</label>
                        <input type="text" id="custAddress" class="form-control" required placeholder="বাড়ি # ১২, ব্লক বি, মজমুপুর গেট, কুষ্টিয়া" value="বাড়ি # ১২, রোড # ৩, মজমুপুর গেট, কুষ্টিয়া" />
                    </div>

                    <div class="form-group">
                        <label class="form-label">রাইডারের জন্য বিশেষ নির্দেশনা (ঐচ্ছিক)</label>
                        <input type="text" id="custNotes" class="form-control" placeholder="যেমন: কলিংবেল বাজাবেন, গেটের সামনে এসে কল দিবেন..." value="গেটের সামনে এসে ফোন দিবেন" />
                    </div>

                    <!-- Payment Method Picker for Bangladesh -->
                    <div class="form-group">
                        <label class="form-label">পেমেন্ট পদ্ধতি নির্বাচন করুন</label>
                        <input type="hidden" id="selectedPaymentMethod" value="bkash" />
                        <div class="payment-methods-grid">
                            <div class="payment-method-card active" data-method="bkash">
                                <div style="font-size: 1.3rem; margin-bottom: 4px;">🟣</div>
                                <div>বিকাশ (bKash)</div>
                            </div>
                            <div class="payment-method-card" data-method="nagad">
                                <div style="font-size: 1.3rem; margin-bottom: 4px;">🟠</div>
                                <div>নগদ (Nagad)</div>
                            </div>
                            <div class="payment-method-card" data-method="cash">
                                <div style="font-size: 1.3rem; margin-bottom: 4px;">💵</div>
                                <div>ক্যাশ অন ডেলিভারি</div>
                            </div>
                        </div>
                    </div>

                    <div style="background: var(--bg-surface-2); padding: 14px 18px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 700;">সর্বমোট প্রদেয় মূল্য:</span>
                        <span id="checkoutOrderSummaryTotal" style="font-size: 1.3rem; font-weight: 800; color: var(--brand-primary);">৳০</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="window.craveApp.closeModal('checkoutModal')">ফিরে যান</button>
                    <button type="submit" id="submitOrderBtn" class="btn btn-primary">
                        অর্ডার কনফার্ম করুন (Confirm Order)
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- LIVE ORDER TRACKING MODAL -->
    <div id="trackingModal" class="modal-overlay">
        <div class="modal-dialog">
            <div class="modal-header">
                <div>
                    <h3 style="font-size: 1.25rem;">কুষ্টিয়া লাইভ ডেলিভারি ট্র্যাকার</h3>
                    <div id="trackOrderCodeDisplay" style="font-size: 0.8rem; color: var(--brand-primary); font-weight: 700;">অর্ডার #KUS-938210</div>
                </div>
                <button class="btn-icon" onclick="window.craveApp.closeModal('trackingModal')">✕</button>
            </div>
            <div class="modal-body">
                <!-- Status ETA Banner -->
                <div class="order-status-banner">
                    <div class="status-badge-live" id="trackingStatusStage">রান্না চলছে (In Kitchen)</div>
                    <div style="font-size: 0.9rem; opacity: 0.9;">পৌঁছানোর আনুমানিক সময়</div>
                    <div class="eta-countdown" id="trackingEtaMinutes">১৫-২০ মিনিট</div>
                </div>

                <!-- Timeline Steps -->
                <div class="timeline-tracker" id="trackingTimelineSteps">
                    <!-- Populated dynamically via JS -->
                </div>

                <!-- Driver Card -->
                <div class="driver-info-card">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" alt="Rider" class="driver-avatar" />
                        <div>
                            <div style="font-weight: 800; font-size: 1rem;">মোঃ তানভীর হোসেন (তানভীর)</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">হিরো হাংক ১৫০ (কুষ্টিয়া-হ-১১-৮৭৬৫)</div>
                            <div style="font-size: 0.8rem; color: #FFB800; font-weight: 700;">★ ৪.৯৬ রাইডার রেটিং</div>
                        </div>
                    </div>
                    <a href="tel:+8801712345678" class="btn-icon" style="background: var(--brand-gradient); color: #FFFFFF;" title="রাইডারকে কল করুন">
                        📞
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" style="width: 100%;" onclick="window.craveApp.closeModal('trackingModal')">
                    ট্র্যাকিং চালু রাখুন
                </button>
            </div>
        </div>
    </div>

    <!-- LOCATION SELECTOR MODAL -->
    <div id="locationModal" class="modal-overlay">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 style="font-size: 1.25rem;">কুষ্টিয়া ডেলিভারি এলাকা নির্বাচন করুন</h3>
                <button class="btn-icon" onclick="window.craveApp.closeModal('locationModal')">✕</button>
            </div>
            <div class="modal-body">
                <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 16px;">আপনার এলাকা নির্বাচন করলে নিকটস্থ রেস্তোরাঁ ও এক্সপ্রেস ডেলিভারি সময় দেখাবে।</p>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div style="padding: 14px; background: var(--bg-surface-2); border-radius: 12px; border: 1px solid var(--border-light); cursor: pointer; display: flex; justify-content: space-between; align-items: center;" onclick="document.getElementById('navCurrentLocation').innerText = 'মজমুপুর গেট ও এন এস রোড (১৫-২০মি)'; window.craveApp.closeModal('locationModal'); window.craveApp.showToast('লোকেশন: মজমুপুর গেট ও এন এস রোড সেট করা হয়েছে', 'success');">
                        <div>
                            <div style="font-weight: 700;">📍 মজমুপুর গেট ও এন এস রোড</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">সেন্ট্রাল কুষ্টিয়া জোন • ১৫-২০ মিনিট ডেলিভারি</div>
                        </div>
                        <span class="badge badge-success">দ্রুততম</span>
                    </div>

                    <div style="padding: 14px; background: var(--bg-surface-2); border-radius: 12px; border: 1px solid var(--border-light); cursor: pointer; display: flex; justify-content: space-between; align-items: center;" onclick="document.getElementById('navCurrentLocation').innerText = 'কোর্টপাড়া ও থানা মোড় (১৫-২০মি)'; window.craveApp.closeModal('locationModal'); window.craveApp.showToast('লোকেশন: কোর্টপাড়া ও থানা মোড় সেট করা হয়েছে', 'success');">
                        <div>
                            <div style="font-weight: 700;">📍 কোর্টপাড়া ও থানা মোড়</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">কুষ্টিয়া সদর • ১৫-২০ মিনিট ডেলিভারি</div>
                        </div>
                        <span class="badge badge-brand">সক্রিয়</span>
                    </div>

                    <div style="padding: 14px; background: var(--bg-surface-2); border-radius: 12px; border: 1px solid var(--border-light); cursor: pointer; display: flex; justify-content: space-between; align-items: center;" onclick="document.getElementById('navCurrentLocation').innerText = 'ইসলামী বিশ্ববিদ্যালয় ক্যাম্পাস (২৫-৩০মি)'; window.craveApp.closeModal('locationModal'); window.craveApp.showToast('লোকেশন: ইসলামী বিশ্ববিদ্যালয় (IU) ক্যাম্পাস সেট করা হয়েছে', 'success');">
                        <div>
                            <div style="font-weight: 700;">🎓 ইসলামী বিশ্ববিদ্যালয় (IU) ক্যাম্পাস</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">শান্তিডাঙ্গা, কুষ্টিয়া • ২৫-৩০ মিনিট এক্সপ্রেস ডেলিভারি</div>
                        </div>
                        <span class="badge badge-brand">ক্যাম্পাস জোন</span>
                    </div>

                    <div style="padding: 14px; background: var(--bg-surface-2); border-radius: 12px; border: 1px solid var(--border-light); cursor: pointer; display: flex; justify-content: space-between; align-items: center;" onclick="document.getElementById('navCurrentLocation').innerText = 'চৌড়হাস ও গড়াই ব্রিজ (১৮-২২মি)'; window.craveApp.closeModal('locationModal'); window.craveApp.showToast('লোকেশন: চৌড়হাস ও গড়াই ব্রিজ সেট করা হয়েছে', 'success');">
                        <div>
                            <div style="font-weight: 700;">🌉 চৌড়হাস মোড় ও গড়াই ব্রিজ</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">হাইওয়ে জোন • ১৮-২২ মিনিট ডেলিভারি</div>
                        </div>
                        <span class="badge badge-brand">সক্রিয়</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CUSTOMER SIGN UP & LOGIN MODAL -->
    <div id="authModal" class="modal-overlay">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 style="font-size: 1.3rem; font-weight: 800;">কাস্টমার অ্যাকাউন্ট • KushtiaExpress</h3>
                <button class="btn-icon" onclick="window.craveApp.closeModal('authModal')">✕</button>
            </div>
            <div class="modal-body">
                <!-- Auth Tabs (Sign Up vs Login) -->
                <div class="auth-tabs">
                    <button type="button" id="tabBtnRegister" class="auth-tab-btn active" onclick="window.craveApp.switchAuthTab('register')">
                        নতুন সাইন আপ (Sign Up)
                    </button>
                    <button type="button" id="tabBtnLogin" class="auth-tab-btn" onclick="window.craveApp.switchAuthTab('login')">
                        লগইন (Sign In)
                    </button>
                </div>

                <!-- SIGN UP FORM -->
                <form id="authRegisterForm" onsubmit="window.craveApp.handleRegister(event)">
                    <div class="form-group">
                        <label class="form-label">আপনার পূর্ণ নাম *</label>
                        <input type="text" id="regName" class="form-control" required placeholder="মোঃ শফিকুল ইসলাম" />
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">মোবাইল নম্বর *</label>
                            <input type="tel" id="regPhone" class="form-control" required placeholder="017XXXXXXXX" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">ইমেইল ঠিকানা *</label>
                            <input type="email" id="regEmail" class="form-control" required placeholder="name@example.com" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">কুষ্টিয়া ডেলিভারি জোন</label>
                        <select id="regZone" class="form-control">
                            <option value="মজমুপুর গেট ও এনএস রোড">📍 মজমুপুর গেট ও এনএস রোড (সেন্ট্রাল)</option>
                            <option value="কোর্টপাড়া ও থানা মোড়">📍 কোর্টপাড়া ও থানা মোড়</option>
                            <option value="ইসলামী বিশ্ববিদ্যালয় ক্যাম্পাস">🎓 ইসলামী বিশ্ববিদ্যালয় (IU) ক্যাম্পাস</option>
                            <option value="চৌড়হাস মোড় ও গড়াই সেতু">🌉 চৌড়হাস মোড় ও গড়াই সেতু</option>
                            <option value="হাউজিং এস্টেট ও পুলিশ লাইনস">🏘️ হাউজিং এস্টেট ও পুলিশ লাইনস</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">বাসা/ঠিকানা (ঐচ্ছিক)</label>
                        <input type="text" id="regAddress" class="form-control" placeholder="বাসা #১২, রোড #৩, মজমুপুর" />
                    </div>

                    <div class="form-group">
                        <label class="form-label">পাসওয়ার্ড (কমপক্ষে ৬ অক্ষর) *</label>
                        <input type="password" id="regPassword" class="form-control" required minlength="6" placeholder="••••••••" />
                    </div>

                    <button type="submit" id="authRegisterSubmitBtn" class="btn btn-primary" style="width: 100%; padding: 14px; margin-top: 10px;">
                        সাইন আপ সম্পন্ন করুন
                    </button>
                </form>

                <!-- LOGIN FORM -->
                <form id="authLoginForm" style="display: none;" onsubmit="window.craveApp.handleLogin(event)">
                    <div class="form-group">
                        <label class="form-label">মোবাইল নম্বর অথবা ইমেইল *</label>
                        <input type="text" id="loginId" class="form-control" required placeholder="017XXXXXXXX অথবা email@domain.com" />
                    </div>

                    <div class="form-group">
                        <label class="form-label">পাসওয়ার্ড *</label>
                        <input type="password" id="loginPassword" class="form-control" required placeholder="••••••••" />
                    </div>

                    <button type="submit" id="authLoginSubmitBtn" class="btn btn-primary" style="width: 100%; padding: 14px; margin-top: 10px;">
                        লগইন করুন
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- FLOATING QUICK LANGUAGE SWITCHER -->
    <button type="button" class="lang-floating-switcher" onclick="window.craveApp.toggleLanguage()" title="Switch Language / ভাষা পরিবর্তন">
        <span class="lang-flag">🌐</span>
        <span class="lang-text">বাংলা / English</span>
    </button>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- JAVASCRIPT APP ENGINE -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
