<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CraveExpress • Gourmet Food Delivered in 20 Mins</title>
    <meta name="description" content="Order chef-crafted artisanal burgers, woodfired pizzas, fresh sushi and healthy bowls delivered piping hot to your doorstep in 20 minutes.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Application CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <!-- TOP PROMO ANNOUNCEMENT BAR -->
    <div class="top-banner">
        <span>🔥 Limited Offer: Get <strong>30% OFF</strong> your first gourmet order with code <span class="code-tag">TASTY30</span></span>
        <span style="opacity: 0.6;">•</span>
        <span>⚡ FREE Express Delivery on orders over $35 with code <span class="code-tag">FREEDEL</span></span>
    </div>

    <!-- MAIN NAVBAR -->
    <header class="navbar">
        <div class="container nav-container">
            <!-- Brand Logo -->
            <a href="#hero" class="brand-logo">
                <div class="logo-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                </div>
                <span>Crave<span class="gradient-text">Express</span></span>
            </a>

            <!-- Delivery Address Quick Select -->
            <div class="nav-location" onclick="window.craveApp.openModal('locationModal')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--brand-primary)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <div style="text-align: left;">
                    <div style="font-size: 0.72rem; color: var(--text-muted); line-height: 1;">Deliver to:</div>
                    <div style="font-weight: 700; font-size: 0.85rem;" id="navCurrentLocation">Manhattan, NY (20-25m)</div>
                </div>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>

            <!-- Navigation Links -->
            <ul class="nav-links">
                <li><a href="#menu-catalog" class="nav-link">Menu Catalog</a></li>
                <li><a href="#offers" class="nav-link">Special Offers</a></li>
                <li><a href="#chef-spotlight" class="nav-link">Chef's Specials</a></li>
                <li><a href="#why-us" class="nav-link">Why Us</a></li>
                <li><a href="#reviews" class="nav-link">Reviews</a></li>
            </ul>

            <!-- Actions (Theme Toggle, Active Order, Cart Trigger) -->
            <div class="nav-actions">
                <!-- Track Active Order Button (Hidden by default, shown if order active) -->
                <button id="recentOrderTrackBtn" style="display: none;" class="btn btn-secondary" onclick="window.craveApp.openTrackingModal()" title="Track Current Live Order">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span>Track Order</span>
                </button>

                <!-- Dark / Light Theme Toggle -->
                <button id="themeToggleBtn" class="theme-toggle-btn" aria-label="Toggle Light/Dark Mode" title="Toggle theme">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </button>

                <!-- Cart Button Trigger -->
                <button id="cartDrawerTrigger" class="cart-btn-trigger">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <span>Cart</span>
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
                    <span>20-Minute Express Gourmet Delivery</span>
                </div>
                <h1 class="hero-title">
                    Gourmet Flavors Delivered to Your <span class="gradient-text">Doorstep.</span>
                </h1>
                <p class="hero-subtitle">
                    Crafted by 5-star Michelin-trained master chefs using farm-fresh organic ingredients. Piping hot, artisanally packaged, and delivered in lightning speed.
                </p>

                <!-- Live Search Box -->
                <div class="hero-search-box">
                    <div class="hero-search-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </div>
                    <input type="text" id="heroSearchInput" class="hero-search-input" placeholder="Search for Truffle Burger, Burrata Pizza, Ramen, Sushi, Bowls..." />
                    <button class="btn btn-primary" onclick="document.getElementById('menu-catalog').scrollIntoView({behavior: 'smooth'})">Find Dishes</button>
                </div>

                <!-- Quick Category Shortcuts -->
                <div class="hero-quick-tags">
                    <span class="quick-tag-label">Popular Cravings:</span>
                    <button class="quick-tag-btn" data-category="burgers">🍔 Truffle Burgers</button>
                    <button class="quick-tag-btn" data-category="pizza">🍕 Woodfired Pizza</button>
                    <button class="quick-tag-btn" data-category="asian-sushi">🍣 Spicy Dragon Roll</button>
                    <button class="quick-tag-btn" data-category="healthy-bowls">🥗 Ahi Poke Bowls</button>
                    <button class="quick-tag-btn" data-category="desserts">🍰 Lava Cake</button>
                </div>
            </div>

            <!-- Hero Visual Showcase -->
            <div class="hero-visual">
                <!-- Floating Stats Card 1 -->
                <div class="floating-card floating-card-1">
                    <div class="stat-icon stat-icon-gold">★</div>
                    <div>
                        <div class="stat-title">4.9 / 5.0 Rating</div>
                        <div class="stat-desc">From 18,500+ Verified Foodies</div>
                    </div>
                </div>

                <!-- Main Hero Dish Image -->
                <div class="hero-main-img-wrap">
                    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=900&q=80" alt="Signature Truffle Burger" />
                </div>

                <!-- Floating Stats Card 2 -->
                <div class="floating-card floating-card-2">
                    <div class="stat-icon stat-icon-brand">⚡</div>
                    <div>
                        <div class="stat-title">18-22 Min Avg</div>
                        <div class="stat-desc">Thermal Sealed Express Delivery</div>
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
                    <button class="coupon-copy-btn" data-code="{{ $promo->code }}" title="Click to copy coupon code">
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
                    <span class="badge badge-brand" style="margin-bottom: 16px;">Chef's Masterpiece of the Month</span>
                    <h2 class="spotlight-title">Neapolitan Burrata & Black Truffle Margherita</h2>
                    <p class="spotlight-desc">
                        Cold-fermented for 48 hours, fired at 900°F in our artisanal stone oven. Topped with imported Italian Burrata di Bufala, organic San Marzano D.O.P tomatoes, fresh sweet basil, and aged Modena balsamic drizzle.
                    </p>
                    <div class="spotlight-perks">
                        <div class="spotlight-perk-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>100% Authentic Italian D.O.P Certified Ingredients</span>
                        </div>
                        <div class="spotlight-perk-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Delivered inside temperature-retaining thermal packaging</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <span style="font-size: 2rem; font-weight: 800; font-family: 'Outfit'; color: #FFFFFF;">$21.00</span>
                        <button class="btn btn-primary" onclick="window.craveApp.quickAddToCart({ id: 4, name: 'Neapolitan Burrata Margherita', price: 21.00, image: 'https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=800&q=80' })">
                            Order Masterpiece Now
                        </button>
                    </div>
                </div>
                <div class="spotlight-img-wrap">
                    <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=900&q=80" alt="Neapolitan Burrata Margherita Pizza" />
                </div>
            </div>
        </div>
    </section>

    <!-- FOOD MENU / CATALOG SECTION -->
    <section id="menu-catalog" class="section-menu">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">Gourmet Selection</div>
                <h2 class="section-title">Explore Our Artisan Menu</h2>
                <p class="section-desc">Handcrafted with passion, culinary precision, and premium ingredients.</p>
            </div>

            <!-- Category Horizontal Scroll Tabs -->
            <div class="category-scroll-wrap">
                <button class="category-tab-btn active" data-slug="all">
                    <span>🌟 All Cravings</span>
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
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Dietary Filters:</span>
                    <button class="filter-pill" data-filter="vegetarian">🌱 Vegetarian</button>
                    <button class="filter-pill" data-filter="spicy">🌶️ Spicy Lover</button>
                    <button class="filter-pill" data-filter="chef_special">👨‍🍳 Chef Specials</button>
                    <button class="filter-pill" data-filter="under_15">🏷️ Under $15</button>
                </div>
                <div class="sort-select-wrap">
                    <span>Sort by:</span>
                    <select id="sortSelect" class="sort-select">
                        <option value="popular">Most Popular</option>
                        <option value="rating">Highest Rated (★ 4.9+)</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="prep_time">Fastest Prep Time</option>
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
                                <span class="badge badge-brand">Chef Special</span>
                            @endif
                            @if($item->is_vegetarian)
                                <span class="badge badge-success">Vegetarian</span>
                            @endif
                            @if($item->is_spicy)
                                <span class="badge badge-spicy">🌶️ Spicy</span>
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
                                <span>{{ $item->calories }} kcal</span>
                            </div>
                            @endif
                        </div>
                        <h4 class="food-item-name">{{ $item->name }}</h4>
                        <p class="food-item-desc">{{ $item->description }}</p>
                        <div class="food-card-footer">
                            <div class="price-wrap">
                                <span class="food-price">${{ number_format($item->price, 2) }}</span>
                                @if($item->original_price)
                                    <span class="original-price">${{ number_format($item->original_price, 2) }}</span>
                                @endif
                            </div>
                            <div class="card-action-group">
                                <button class="btn-customize" onclick="window.craveApp.openCustomizeModal({{ json_encode($item) }})" title="Customize ingredients & size">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                </button>
                                <button class="btn-add-cart" onclick="window.craveApp.quickAddToCart({{ json_encode($item) }})">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    Add
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
                <div class="section-subtitle">The Crave Standard</div>
                <h2 class="section-title">Why Foodies Love CraveExpress</h2>
                <p class="section-desc">Reinventing the food delivery experience from kitchen stove to your dining table.</p>
            </div>
            <div class="feature-cards-grid">
                <div class="feature-card">
                    <div class="feature-icon-box">⚡</div>
                    <h3 class="feature-title">20-Min Hyper Express</h3>
                    <p class="feature-desc">Dynamic route optimization and dedicated local fleet ensures your meal arrives fresh and sizzling hot.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon-box">👨‍🍳</div>
                    <h3 class="feature-title">Master Executive Chefs</h3>
                    <p class="feature-desc">Every recipe is meticulously perfected by seasoned culinary artisans using 100% organic farm ingredients.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon-box">📦</div>
                    <h3 class="feature-title">Thermal Eco-Packaging</h3>
                    <p class="feature-desc">Biodegradable, temperature-locking containers keep crispy textures crunchy and broths piping hot.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon-box">🛰️</div>
                    <h3 class="feature-title">Live Real-time GPS</h3>
                    <p class="feature-desc">Track your driver from the kitchen dispatch line right to your apartment door with live progress steps.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CUSTOMER REVIEWS -->
    <section id="reviews" style="padding: 60px 0 80px; background: var(--bg-surface-2);">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">Real Foodie Testimonials</div>
                <h2 class="section-title">Loved by Thousands Across the City</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
                <div style="background: var(--bg-surface); padding: 28px; border-radius: 20px; border: 1px solid var(--border-light);">
                    <div style="color: #FFB800; font-size: 1.1rem; margin-bottom: 12px;">★★★★★</div>
                    <p style="font-size: 0.95rem; line-height: 1.6; color: var(--text-main); margin-bottom: 18px;">
                        "The Truffle Umami Bacon Burger is without a doubt the single best burger in the city. Arrived in 18 minutes, still steaming hot!"
                    </p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;" alt="Reviewer" />
                        <div>
                            <div style="font-weight: 700; font-size: 0.95rem;">Sarah Jenkins</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Verified Foodie • Manhattan</div>
                        </div>
                    </div>
                </div>

                <div style="background: var(--bg-surface); padding: 28px; border-radius: 20px; border: 1px solid var(--border-light);">
                    <div style="color: #FFB800; font-size: 1.1rem; margin-bottom: 12px;">★★★★★</div>
                    <p style="font-size: 0.95rem; line-height: 1.6; color: var(--text-main); margin-bottom: 18px;">
                        "The Burrata Margherita pizza was authentic Naples style with a blistered crust. The dark mode theme and instant cart checkout are super slick."
                    </p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;" alt="Reviewer" />
                        <div>
                            <div style="font-weight: 700; font-size: 0.95rem;">Marcus Vance</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Verified Foodie • Brooklyn</div>
                        </div>
                    </div>
                </div>

                <div style="background: var(--bg-surface); padding: 28px; border-radius: 20px; border: 1px solid var(--border-light);">
                    <div style="color: #FFB800; font-size: 1.1rem; margin-bottom: 12px;">★★★★★</div>
                    <p style="font-size: 0.95rem; line-height: 1.6; color: var(--text-main); margin-bottom: 18px;">
                        "The Tokyo Tonkotsu Ramen broth is so rich and flavorful! Tracking the driver live on the timeline gave total peace of mind."
                    </p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;" alt="Reviewer" />
                        <div>
                            <div style="font-weight: 700; font-size: 0.95rem;">Elena Rostova</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Verified Foodie • Queens</div>
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
                        <span>Crave<span class="gradient-text">Express</span></span>
                    </div>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">
                        Artisanal gourmet food delivered fresh, hot, and fast. Built for true culinary enthusiasts.
                    </p>
                    <div style="display: flex; gap: 10px;">
                        <button class="btn-icon" aria-label="Twitter">𝕏</button>
                        <button class="btn-icon" aria-label="Instagram">📸</button>
                        <button class="btn-icon" aria-label="Facebook">📘</button>
                    </div>
                </div>

                <div>
                    <h4 class="footer-col-title">Cuisine Categories</h4>
                    <ul class="footer-links">
                        <li><a href="#menu-catalog">Signature Angus Burgers</a></li>
                        <li><a href="#menu-catalog">Woodfired Sourdough Pizza</a></li>
                        <li><a href="#menu-catalog">Japanese Ramen & Sushi</a></li>
                        <li><a href="#menu-catalog">Organic Superfood Bowls</a></li>
                        <li><a href="#menu-catalog">Belgian Chocolate Pastries</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-col-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="#offers">Active Promo Codes</a></li>
                        <li><a href="#chef-spotlight">Chef Specials</a></li>
                        <li><a href="#why-us">How Delivery Works</a></li>
                        <li><a href="#reviews">Foodie Reviews</a></li>
                        <li><a href="javascript:void(0)" onclick="window.craveApp.openModal('locationModal')">Delivery Zones</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-col-title">Stay in the Loop</h4>
                    <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 12px;">
                        Subscribe for secret chef menus, weekend discounts, and special invitations.
                    </p>
                    <div style="display: flex; gap: 8px;">
                        <input type="email" placeholder="Your email address" class="form-control" style="font-size: 0.85rem;" />
                        <button class="btn btn-primary" onclick="window.craveApp.showToast('Subscribed to VIP culinary club!', 'success')">Join</button>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div>© {{ date('Y') }} CraveExpress Inc. All rights reserved. • Built with Laravel & High-Performance SPA Engine</div>
                <div style="display: flex; gap: 18px;">
                    <a href="javascript:void(0)">Privacy Policy</a>
                    <a href="javascript:void(0)">Terms of Service</a>
                    <a href="javascript:void(0)">Allergen Info</a>
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
                <span>Your Gourmet Order</span>
            </div>
            <button id="cartDrawerClose" class="btn-icon" aria-label="Close cart drawer">✕</button>
        </div>

        <!-- Free Delivery Progress Tracker -->
        <div class="delivery-meter-box">
            <div id="deliveryProgressText">Add <strong>$35.00</strong> for <strong>FREE Express Delivery</strong></div>
            <div class="progress-bar-bg">
                <div id="deliveryProgressFill" class="progress-bar-fill"></div>
            </div>
        </div>

        <!-- Cart Items List Container -->
        <div id="cartItemsList" class="cart-items-list">
            <!-- Dynamically populated by window.craveApp.renderCart() -->
        </div>

        <!-- Cart Footer with Pricing Breakdown & Coupon Apply -->
        <div class="cart-drawer-footer">
            <div class="coupon-input-group">
                <input type="text" id="cartCouponInput" class="coupon-input" placeholder="Promo code (e.g. TASTY30)" />
                <button id="applyCouponBtn" class="btn-apply-coupon">Apply</button>
            </div>

            <div class="cart-summary-rows">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="cartSubtotal">$0.00</span>
                </div>
                <div id="cartDiscountRow" class="summary-row" style="display: none; color: var(--success); font-weight: 700;">
                    <span>Promo Discount</span>
                    <span id="cartDiscountVal">-$0.00</span>
                </div>
                <div class="summary-row">
                    <span>Express Delivery Fee</span>
                    <span id="cartDeliveryFee">$3.99</span>
                </div>
                <div class="summary-row">
                    <span>Estimated Tax (8%)</span>
                    <span id="cartTax">$0.00</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span id="cartTotal" class="gradient-text">$0.00</span>
                </div>
            </div>

            <button id="proceedCheckoutBtn" class="btn btn-primary" style="width: 100%; padding: 14px;">
                <span>Proceed to 1-Step Checkout</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
        </div>
    </div>

    <!-- FOOD CUSTOMIZATION MODAL -->
    <div id="customizeModal" class="modal-overlay">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 id="customizeModalTitle" style="font-size: 1.25rem;">Customize Dish</h3>
                <button class="btn-icon" onclick="window.craveApp.closeModal('customizeModal')">✕</button>
            </div>
            <div id="customizeModalBody" class="modal-body">
                <!-- Dynamically populated -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="window.craveApp.closeModal('customizeModal')">Cancel</button>
                <button id="customizeAddCartBtn" class="btn btn-primary" onclick="window.craveApp.confirmCustomAddToCart()">
                    Add to Order
                </button>
            </div>
        </div>
    </div>

    <!-- 1-STEP CHECKOUT MODAL -->
    <div id="checkoutModal" class="modal-overlay">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 style="font-size: 1.3rem; display: flex; align-items: center; gap: 8px;">
                    <span>⚡ Instant 1-Step Checkout</span>
                </h3>
                <button class="btn-icon" onclick="window.craveApp.closeModal('checkoutModal')">✕</button>
            </div>
            <form id="checkoutForm">
                <div class="modal-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <input type="text" id="custName" class="form-control" required placeholder="Alex Mercer" value="Alex Mercer" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number *</label>
                            <input type="tel" id="custPhone" class="form-control" required placeholder="+1 (555) 019-2834" value="+1 (555) 019-2834" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address (For receipt) *</label>
                        <input type="email" id="custEmail" class="form-control" required placeholder="alex.mercer@example.com" value="alex.mercer@example.com" />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Delivery Address *</label>
                        <input type="text" id="custAddress" class="form-control" required placeholder="742 Evergreen Terrace, Apt 4B" value="742 Evergreen Terrace, Apt 4B, Manhattan, NY" />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Special Delivery Notes</label>
                        <input type="text" id="custNotes" class="form-control" placeholder="e.g. Leave at front door, ring doorbell twice" value="Ring bell upon arrival" />
                    </div>

                    <!-- Payment Method Picker -->
                    <div class="form-group">
                        <label class="form-label">Payment Method</label>
                        <input type="hidden" id="selectedPaymentMethod" value="card" />
                        <div class="payment-methods-grid">
                            <div class="payment-method-card active" data-method="card">
                                <div style="font-size: 1.3rem; margin-bottom: 4px;">💳</div>
                                <div>Credit Card</div>
                            </div>
                            <div class="payment-method-card" data-method="apple_pay">
                                <div style="font-size: 1.3rem; margin-bottom: 4px;">📱</div>
                                <div>Apple / Google Pay</div>
                            </div>
                            <div class="payment-method-card" data-method="cash">
                                <div style="font-size: 1.3rem; margin-bottom: 4px;">💵</div>
                                <div>Cash on Delivery</div>
                            </div>
                        </div>
                    </div>

                    <div style="background: var(--bg-surface-2); padding: 14px 18px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 700;">Final Amount:</span>
                        <span id="checkoutOrderSummaryTotal" style="font-size: 1.3rem; font-weight: 800; color: var(--brand-primary);">$0.00</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="window.craveApp.closeModal('checkoutModal')">Back</button>
                    <button type="submit" id="submitOrderBtn" class="btn btn-primary">
                        Place Order & Start Express Delivery
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
                    <h3 style="font-size: 1.25rem;">Live Express Tracker</h3>
                    <div id="trackOrderCodeDisplay" style="font-size: 0.8rem; color: var(--brand-primary); font-weight: 700;">Order #FD-892104</div>
                </div>
                <button class="btn-icon" onclick="window.craveApp.closeModal('trackingModal')">✕</button>
            </div>
            <div class="modal-body">
                <!-- Status ETA Banner -->
                <div class="order-status-banner">
                    <div class="status-badge-live" id="trackingStatusStage">Kitchen Preparing</div>
                    <div style="font-size: 0.9rem; opacity: 0.9;">Estimated Arrival Time</div>
                    <div class="eta-countdown" id="trackingEtaMinutes">18-22 Mins</div>
                </div>

                <!-- Timeline Steps -->
                <div class="timeline-tracker" id="trackingTimelineSteps">
                    <!-- Populated dynamically via JS -->
                </div>

                <!-- Driver Card -->
                <div class="driver-info-card">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" alt="Driver" class="driver-avatar" />
                        <div>
                            <div style="font-weight: 800; font-size: 1rem;">Alex Rodriguez</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">Eco-Vespa Courier (Plate: NY-782)</div>
                            <div style="font-size: 0.8rem; color: #FFB800; font-weight: 700;">★ 4.95 Driver Rating</div>
                        </div>
                    </div>
                    <a href="tel:+15552345678" class="btn-icon" style="background: var(--brand-gradient); color: #FFFFFF;" title="Call Driver">
                        📞
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" style="width: 100%;" onclick="window.craveApp.closeModal('trackingModal')">
                    Got it! Keep Tracking
                </button>
            </div>
        </div>
    </div>

    <!-- LOCATION SELECTOR MODAL -->
    <div id="locationModal" class="modal-overlay">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 style="font-size: 1.25rem;">Select Delivery Location</h3>
                <button class="btn-icon" onclick="window.craveApp.closeModal('locationModal')">✕</button>
            </div>
            <div class="modal-body">
                <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 16px;">Choose your neighborhood to see available hyper-fast delivery kitchens.</p>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div style="padding: 14px; background: var(--bg-surface-2); border-radius: 12px; border: 1px solid var(--border-light); cursor: pointer; display: flex; justify-content: space-between; align-items: center;" onclick="document.getElementById('navCurrentLocation').innerText = 'Manhattan, NY (18-22m)'; window.craveApp.closeModal('locationModal'); window.craveApp.showToast('Location updated to Manhattan', 'success');">
                        <div>
                            <div style="font-weight: 700;">🏙️ Manhattan, New York</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Express Zone A • 18-22 min average</div>
                        </div>
                        <span class="badge badge-success">Fastest</span>
                    </div>

                    <div style="padding: 14px; background: var(--bg-surface-2); border-radius: 12px; border: 1px solid var(--border-light); cursor: pointer; display: flex; justify-content: space-between; align-items: center;" onclick="document.getElementById('navCurrentLocation').innerText = 'Brooklyn, NY (20-25m)'; window.craveApp.closeModal('locationModal'); window.craveApp.showToast('Location updated to Brooklyn', 'success');">
                        <div>
                            <div style="font-weight: 700;">🌉 Brooklyn, New York</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Express Zone B • 20-25 min average</div>
                        </div>
                        <span class="badge badge-brand">Active</span>
                    </div>

                    <div style="padding: 14px; background: var(--bg-surface-2); border-radius: 12px; border: 1px solid var(--border-light); cursor: pointer; display: flex; justify-content: space-between; align-items: center;" onclick="document.getElementById('navCurrentLocation').innerText = 'Queens, NY (25-30m)'; window.craveApp.closeModal('locationModal'); window.craveApp.showToast('Location updated to Queens', 'success');">
                        <div>
                            <div style="font-weight: 700;">✈️ Queens, New York</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Express Zone C • 25-30 min average</div>
                        </div>
                        <span class="badge badge-brand">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- JAVASCRIPT APP ENGINE -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
