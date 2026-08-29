<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order Tracking & History • KushtiaExpress</title>
    <meta name="description" content="Track your active food order live on GPS timeline and view past order history on KushtiaExpress.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Hind+Siliguri:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .order-page-hero {
            padding: 50px 0 40px;
            background: linear-gradient(180deg, var(--bg-surface-2) 0%, var(--bg-body) 100%);
            border-bottom: 1px solid var(--border-light);
        }
        .tracking-card-container {
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            border-radius: 24px;
            padding: 32px;
            box-shadow: var(--shadow-lg);
            margin-top: 30px;
        }
        .recent-order-item {
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            border-radius: 18px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: var(--transition-smooth);
            margin-bottom: 16px;
        }
        .recent-order-item:hover {
            transform: translateY(-3px);
            border-color: var(--brand-primary);
            box-shadow: var(--shadow-md);
        }
        .lang-switch-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            background: var(--bg-surface-2);
            border: 1px solid var(--border-light);
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--text-main);
            transition: var(--transition-smooth);
        }
        .lang-switch-badge:hover {
            border-color: var(--brand-primary);
            color: var(--brand-primary);
        }
    </style>
</head>
<body>

    <!-- MAIN NAVBAR -->
    <header class="navbar">
        <div class="container nav-container">
            <a href="{{ route('home') }}" class="brand-logo">
                <div class="logo-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                </div>
                <span>Kushtia<span class="gradient-text">Express</span></span>
            </a>

            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li><a href="{{ route('home') }}#menu-catalog" class="nav-link">Menu</a></li>
                <li><a href="{{ route('order.page') }}" class="nav-link active">Orders</a></li>
                <li><a href="{{ route('contact.page') }}" class="nav-link">Contact Us</a></li>
            </ul>

            <div class="nav-actions">
                <!-- Global Language Switcher Button (বাংলা ↔ English) -->
                <button type="button" class="lang-toggle-btn" title="Switch Language / ভাষা পরিবর্তন">
                    <span class="lang-flag">🇬🇧</span>
                    <span class="lang-text">English</span>
                    <span style="font-size:0.75rem; color:var(--text-muted);">| বাংলা</span>
                </button>

                <!-- Guest Auth Button (Sign Up / Login) -->
                <button class="auth-nav-btn auth-guest-view" onclick="window.craveApp.openAuthModal('register')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span data-i18n="nav.auth">Sign In / Register</span>
                </button>

                <!-- Authenticated User Dropdown -->
                <div class="auth-user-dropdown-wrap auth-user-view" style="display: none;">
                    <div class="auth-user-pill" onclick="window.craveApp.toggleUserDropdown()">
                        <div class="auth-user-avatar auth-user-initial">U</div>
                        <span class="auth-user-name">Customer</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                    <div id="authUserDropdownMenu" class="auth-dropdown-menu">
                        <div style="padding: 6px 12px; border-bottom: 1px solid var(--border-light); margin-bottom: 4px;">
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Logged in as</div>
                            <div style="font-weight: 800; font-size: 0.9rem;" class="auth-user-name">Customer</div>
                        </div>
                        <a href="{{ route('order.page') }}" class="auth-dropdown-item">
                            <span>📦 My Orders</span>
                        </a>
                        <a href="{{ route('contact.page') }}" class="auth-dropdown-item">
                            <span>💬 Support & Helpdesk</span>
                        </a>
                        <button class="auth-dropdown-item" style="color: var(--danger);" onclick="window.craveApp.handleLogout()">
                            <span>🚪 Logout</span>
                        </button>
                    </div>
                </div>

                <button id="themeToggleBtn" class="theme-toggle-btn" aria-label="Toggle Theme">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </button>

                <button id="cartDrawerTrigger" class="cart-btn-trigger">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <span data-i18n="nav.cart">Cart</span>
                    <span id="navCartCount" class="cart-badge-count" style="display: none;">0</span>
                </button>
            </div>
        </div>
    </header>

    <!-- ORDER PAGE HERO (ENGLISH) -->
    <section class="order-page-hero">
        <div class="container" style="text-align: center; max-width: 760px;">
            <div class="hero-badge-pill" style="margin-bottom: 16px;">
                <span>🛰️ Kushtia Express Live Tracker</span>
            </div>
            <h1 style="font-size: 2.6rem; font-weight: 900; margin-bottom: 14px;">
                Track Your <span class="gradient-text">Food Order</span>
            </h1>
            <p style="color: var(--text-muted); font-size: 1.05rem; margin-bottom: 28px;">
                Enter your order code below to track preparation progress and rider GPS status in real time.
            </p>

            <!-- Order Lookup Box -->
            <div style="display: flex; gap: 10px; background: var(--bg-surface); padding: 8px; border-radius: 16px; border: 2px solid var(--border-light); box-shadow: var(--shadow-md);">
                <input type="text" id="orderSearchCodeInput" class="form-control" style="font-size: 1.05rem; text-transform: uppercase; font-weight: 700; border: none;" placeholder="Enter Order Code (e.g. KUS-LJ0DG5)" value="{{ $initialOrder ? $initialOrder->order_code : '' }}" />
                <button class="btn btn-primary" onclick="lookupOrder()">
                    <span>Track Order</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </div>
        </div>
    </section>

    <!-- LIVE TRACKING SHOWCASE CONTAINER -->
    <section style="padding: 40px 0 60px;">
        <div class="container">
            <div id="liveTrackingResultSection" class="tracking-card-container" style="display: {{ $initialOrder ? 'block' : 'none' }};">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-light); padding-bottom: 20px; margin-bottom: 24px;">
                    <div>
                        <span class="badge badge-brand" style="margin-bottom: 6px;">Live Order Tracking</span>
                        <h2 id="displayedOrderCode" style="font-size: 1.8rem; font-weight: 800;">Order #{{ $initialOrder ? $initialOrder->order_code : 'KUS-89210' }}</h2>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 0.85rem; color: var(--text-muted);">Estimated Arrival</div>
                        <div id="displayedEtaTime" style="font-size: 1.4rem; font-weight: 800; color: var(--brand-primary);">15-20 Mins</div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 36px;">
                    <!-- Timeline Steps -->
                    <div>
                        <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 20px;">Delivery Progression Timeline</h3>
                        <div class="timeline-tracker" id="orderPageTimeline">
                            <div class="timeline-step completed">
                                <div class="step-dot"></div>
                                <div class="step-title">Order Received & Confirmed</div>
                                <div class="step-desc">Kushtia Central Kitchen printed your ticket • Just now</div>
                            </div>
                            <div class="timeline-step active">
                                <div class="step-dot"></div>
                                <div class="step-title">In the Kitchen (Chef Preparing)</div>
                                <div class="step-desc">Master Chef preparing your meal fresh with organic ingredients</div>
                            </div>
                            <div class="timeline-step">
                                <div class="step-dot"></div>
                                <div class="step-title">Rider En Route with Thermal Box</div>
                                <div class="step-desc">Courier Md. Tanvir Hossain is on his way to your address</div>
                            </div>
                            <div class="timeline-step">
                                <div class="step-dot"></div>
                                <div class="step-title">Delivered & Handed Over</div>
                                <div class="step-desc">Delivered fresh and piping hot right to your doorstep</div>
                            </div>
                        </div>
                    </div>

                    <!-- Rider & Receipt Details -->
                    <div>
                        <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 16px;">Assigned Express Rider</h3>
                        <div class="driver-info-card" style="margin-bottom: 24px;">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" alt="Rider" class="driver-avatar" />
                                <div>
                                    <div style="font-weight: 800; font-size: 1.05rem;">Md. Tanvir Hossain</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">Hero Hunk 150 (Kushtia-H-11-8765)</div>
                                    <div style="font-size: 0.8rem; color: #FFB800; font-weight: 700;">★ 4.96 Driver Rating</div>
                                </div>
                            </div>
                            <a href="tel:+8801712345678" class="btn-icon" style="background: var(--brand-gradient); color: #FFFFFF;" title="Call Rider">
                                📞
                            </a>
                        </div>

                        <div style="background: var(--bg-surface-2); border-radius: 16px; padding: 20px; border: 1px solid var(--border-light);">
                            <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 12px;">Quality Assurance</h4>
                            <ul style="font-size: 0.85rem; color: var(--text-muted); display: flex; flex-direction: column; gap: 8px; list-style: none;">
                                <li>✓ 100% Thermal Insulated Packaging</li>
                                <li>✓ Free Kulfi Voucher if delayed past 30 minutes</li>
                                <li>✓ Direct direct live communication with rider</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RECENT ORDERS SECTION -->
            <div style="margin-top: 50px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <div>
                        <h2 style="font-size: 1.8rem; font-weight: 800;">Recent Orders</h2>
                        <p style="color: var(--text-muted); font-size: 0.95rem;">Review your recently placed culinary orders.</p>
                    </div>
                    <a href="{{ route('home') }}#menu-catalog" class="btn btn-secondary">Explore Menu & Order</a>
                </div>

                @if(isset($recentOrders) && $recentOrders->count() > 0)
                    @foreach($recentOrders as $ord)
                    <div class="recent-order-item">
                        <div style="display: flex; align-items: center; gap: 18px;">
                            <div style="width: 52px; height: 52px; background: rgba(255, 84, 46, 0.1); color: var(--brand-primary); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800;">
                                🍲
                            </div>
                            <div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="font-weight: 800; font-size: 1.1rem;">Order #{{ $ord->order_code }}</span>
                                    <span class="badge badge-success">{{ strtoupper($ord->status) }}</span>
                                </div>
                                <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">
                                    {{ $ord->created_at->format('d M, Y - h:i A') }} • Payment: {{ strtoupper($ord->payment_method) }} • Address: {{ Str::limit($ord->delivery_address, 35) }}
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="text-align: right;">
                                <div style="font-weight: 900; font-size: 1.3rem; color: var(--text-main);">৳{{ number_format($ord->total, 0) }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ count($ord->items ?? []) }} Items</div>
                            </div>
                            <button class="btn btn-primary" onclick="trackSpecificOrder('{{ $ord->order_code }}')">
                                Track Order
                            </button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 50px 20px; background: var(--bg-surface); border-radius: 20px; border: 1px solid var(--border-light);">
                        <div style="font-size: 3rem; margin-bottom: 12px;">📦</div>
                        <h3 style="font-size: 1.3rem; margin-bottom: 8px;">No Recent Orders Found</h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 20px;">Browse our chef catalog and satisfy your cravings!</p>
                        <a href="{{ route('home') }}#menu-catalog" class="btn btn-primary">Browse Menu</a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-bottom" style="border: none; padding: 0;">
                <div>© {{ date('Y') }} KushtiaExpress • All rights reserved • Kushtia, Bangladesh</div>
                <div style="display: flex; gap: 18px;">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('contact.page') }}">Contact Us</a>
                    <a href="{{ route('order.bn') }}">বাংলা সংস্করণ</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- SLIDE-OVER CART DRAWER -->
    <div id="cartOverlay" class="modal-overlay" style="z-index: 1040;"></div>
    <div id="cartDrawer" class="cart-drawer">
        <div class="drawer-header">
            <div class="drawer-title">
                <span>Your Food Cart</span>
            </div>
            <button id="cartDrawerClose" class="btn-icon">✕</button>
        </div>
        <div class="delivery-meter-box">
            <div id="deliveryProgressText">Add <strong>৳400</strong> more for <strong>FREE Delivery</strong></div>
            <div class="progress-bar-bg"><div id="deliveryProgressFill" class="progress-bar-fill"></div></div>
        </div>
        <div id="cartItemsList" class="cart-items-list"></div>
        <div class="cart-drawer-footer">
            <div class="cart-summary-rows">
                <div class="summary-row"><span>Subtotal</span><span id="cartSubtotal">৳0</span></div>
                <div class="summary-row"><span>Delivery Fee</span><span id="cartDeliveryFee">৳40</span></div>
                <div class="summary-row total"><span>Total</span><span id="cartTotal" class="gradient-text">৳0</span></div>
            </div>
            <button id="proceedCheckoutBtn" class="btn btn-primary" style="width: 100%; padding: 14px;" onclick="window.location.href='{{ route('home') }}'">
                Go to Menu & Order
            </button>
        </div>
    </div>

    <!-- CUSTOMER SIGN UP & LOGIN MODAL -->
    <div id="authModal" class="modal-overlay">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 style="font-size: 1.3rem; font-weight: 800;">Customer Account • KushtiaExpress</h3>
                <button class="btn-icon" onclick="window.craveApp.closeModal('authModal')">✕</button>
            </div>
            <div class="modal-body">
                <!-- Auth Tabs (Sign Up vs Login) -->
                <div class="auth-tabs">
                    <button type="button" id="tabBtnRegister" class="auth-tab-btn active" onclick="window.craveApp.switchAuthTab('register')">
                        Sign Up
                    </button>
                    <button type="button" id="tabBtnLogin" class="auth-tab-btn" onclick="window.craveApp.switchAuthTab('login')">
                        Sign In
                    </button>
                </div>

                <!-- SIGN UP FORM -->
                <form id="authRegisterForm" onsubmit="window.craveApp.handleRegister(event)">
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" id="regName" class="form-control" required placeholder="John Doe" />
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">Mobile Number *</label>
                            <input type="tel" id="regPhone" class="form-control" required placeholder="017XXXXXXXX" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address *</label>
                            <input type="email" id="regEmail" class="form-control" required placeholder="name@example.com" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kushtia Delivery Zone</label>
                        <select id="regZone" class="form-control">
                            <option value="মজমুপুর গেট ও এনএস রোড">📍 Mojompur Gate & NS Road (Central)</option>
                            <option value="কোর্টপাড়া ও থানা মোড়">📍 Court Para & Thana Mor</option>
                            <option value="ইসলামী বিশ্ববিদ্যালয় ক্যাম্পাস">🎓 Islamic University (IU) Campus</option>
                            <option value="চৌড়হাস মোড় ও গড়াই সেতু">🌉 Chourhas & Gorai Bridge</option>
                            <option value="হাউজিং এস্টেট ও পুলিশ লাইনস">🏘️ Housing Estate & Police Lines</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Address (Optional)</label>
                        <input type="text" id="regAddress" class="form-control" placeholder="House #12, Road #3, Mojompur" />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password (Min. 6 Characters) *</label>
                        <input type="password" id="regPassword" class="form-control" required minlength="6" placeholder="••••••••" />
                    </div>

                    <button type="submit" id="authRegisterSubmitBtn" class="btn btn-primary" style="width: 100%; padding: 14px; margin-top: 10px;">
                        Complete Registration
                    </button>
                </form>

                <!-- LOGIN FORM -->
                <form id="authLoginForm" style="display: none;" onsubmit="window.craveApp.handleLogin(event)">
                    <div class="form-group">
                        <label class="form-label">Mobile Number or Email *</label>
                        <input type="text" id="loginId" class="form-control" required placeholder="017XXXXXXXX or email@domain.com" />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password *</label>
                        <input type="password" id="loginPassword" class="form-control" required placeholder="••••••••" />
                    </div>

                    <button type="submit" id="authLoginSubmitBtn" class="btn btn-primary" style="width: 100%; padding: 14px; margin-top: 10px;">
                        Sign In
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

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        async function lookupOrder() {
            const input = document.getElementById('orderSearchCodeInput');
            const code = input.value.trim().toUpperCase();
            if (!code) {
                window.craveApp.showToast('Please enter a valid order code', 'error');
                return;
            }
            trackSpecificOrder(code);
        }

        async function trackSpecificOrder(code) {
            try {
                const res = await fetch(`/api/orders/${code}/track`);
                const data = await res.json();
                if (res.ok && data.status === 'success') {
                    document.getElementById('liveTrackingResultSection').style.display = 'block';
                    document.getElementById('displayedOrderCode').innerText = `Order #${data.order.order_code}`;
                    document.getElementById('displayedEtaTime').innerText = `${data.tracking.estimated_minutes_left} Mins`;
                    document.getElementById('liveTrackingResultSection').scrollIntoView({ behavior: 'smooth' });
                    window.craveApp.showToast(`Found Order #${code}!`, 'success');
                } else {
                    window.craveApp.showToast('No order found with this code.', 'error');
                }
            } catch (e) {
                window.craveApp.showToast('Server connection issue, please try again.', 'error');
            }
        }
    </script>
</body>
</html>
