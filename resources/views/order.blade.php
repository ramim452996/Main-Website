<!DOCTYPE html>
<html lang="bn" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>অর্ডার ট্র্যাকিং ও হিস্ট্রি • KushtiaExpress</title>
    <meta name="description" content="কুষ্টিয়া এক্সপ্রেসের মাধ্যমে আপনার বর্তমান অর্ডারের লাইভ লোকেশন ট্র্যাক করুন এবং পূর্বের অর্ডার হিস্ট্রি দেখুন।">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body, button, input, select, textarea {
            font-family: 'Hind Siliguri', 'Plus Jakarta Sans', sans-serif;
        }
        h1, h2, h3, h4, h5, h6, .brand-logo, .food-price {
            font-family: 'Outfit', 'Hind Siliguri', sans-serif;
        }
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
                <li><a href="{{ route('home') }}" class="nav-link">হোম (Home)</a></li>
                <li><a href="{{ route('home') }}#menu-catalog" class="nav-link">মেনু (Menu)</a></li>
                <li><a href="{{ route('order.page') }}" class="nav-link active">অর্ডার ট্র্যাকিং (Orders)</a></li>
                <li><a href="{{ route('contact.page') }}" class="nav-link">যোগাযোগ (Contact)</a></li>
            </ul>

            <div class="nav-actions">
                <button id="themeToggleBtn" class="theme-toggle-btn" aria-label="Toggle Theme">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </button>

                <button id="cartDrawerTrigger" class="cart-btn-trigger">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <span>কার্ট</span>
                    <span id="navCartCount" class="cart-badge-count" style="display: none;">0</span>
                </button>
            </div>
        </div>
    </header>

    <!-- ORDER PAGE HERO -->
    <section class="order-page-hero">
        <div class="container" style="text-align: center; max-width: 760px;">
            <div class="hero-badge-pill" style="margin-bottom: 16px;">
                <span>🛰️ কুষ্টিয়া লাইভ অর্ডার ট্র্যাকার হাব</span>
            </div>
            <h1 style="font-size: 2.6rem; font-weight: 900; margin-bottom: 14px;">
                আপনার অর্ডার <span class="gradient-text">ট্র্যাক করুন</span>
            </h1>
            <p style="color: var(--text-muted); font-size: 1.05rem; margin-bottom: 28px;">
                অর্ডার কোড দিয়ে সার্চ করুন এবং দেখুন আপনার খাবার কোন পর্যায়ে আছে এবং রাইডার কত দূরে রয়েছে।
            </p>

            <!-- Order Lookup Box -->
            <div style="display: flex; gap: 10px; background: var(--bg-surface); padding: 8px; border-radius: 16px; border: 2px solid var(--border-light); box-shadow: var(--shadow-md);">
                <input type="text" id="orderSearchCodeInput" class="form-control" style="font-size: 1.05rem; text-transform: uppercase; font-weight: 700; border: none;" placeholder="অর্ডার কোড লিখুন (যেমন: KUS-LJ0DG5)" value="{{ $initialOrder ? $initialOrder->order_code : '' }}" />
                <button class="btn btn-primary" onclick="lookupOrder()">
                    <span>ট্র্যাক করুন</span>
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
                        <span class="badge badge-brand" style="margin-bottom: 6px;">সক্রিয় লাইভ ট্র্যাকিং</span>
                        <h2 id="displayedOrderCode" style="font-size: 1.8rem; font-weight: 800;">অর্ডার #{{ $initialOrder ? $initialOrder->order_code : 'KUS-89210' }}</h2>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 0.85rem; color: var(--text-muted);">পৌঁছানোর সময়</div>
                        <div id="displayedEtaTime" style="font-size: 1.4rem; font-weight: 800; color: var(--brand-primary);">১৫-২০ মিনিট</div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 36px;">
                    <!-- Timeline Steps -->
                    <div>
                        <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 20px;">ডেলিভারির অগ্রগতি (Live Timeline)</h3>
                        <div class="timeline-tracker" id="orderPageTimeline">
                            <div class="timeline-step completed">
                                <div class="step-dot"></div>
                                <div class="step-title">অর্ডার গৃহীত হয়েছে ও বিকাশ পেমেন্ট সম্পন্ন</div>
                                <div class="step-desc">কুষ্টিয়া সেন্ট্রাল কিচেন টিকিট প্রস্তুত করেছে • এইমাত্র</div>
                            </div>
                            <div class="timeline-step active">
                                <div class="step-dot"></div>
                                <div class="step-title">শেফ রান্না প্রস্তুত করছেন (In Kitchen)</div>
                                <div class="step-desc">গরম গরম তাজা খাবার বিশেষ থার্মাল বক্সে প্যাক করা হচ্ছে</div>
                            </div>
                            <div class="timeline-step">
                                <div class="step-dot"></div>
                                <div class="step-title">রাইডার ডেলিভারির পথে (Rider en Route)</div>
                                <div class="step-desc">বাইকার মোঃ তানভীর হোসেন আপনার ঠিকানায় রওনা হচ্ছেন</div>
                            </div>
                            <div class="timeline-step">
                                <div class="step-dot"></div>
                                <div class="step-title">ডেলিভারি সম্পন্ন (Handed Over)</div>
                                <div class="step-desc">আপনার দোরগোড়ায় খাবার সফলভাবে পৌঁছে দেওয়া হয়েছে</div>
                            </div>
                        </div>
                    </div>

                    <!-- Rider & Receipt Details -->
                    <div>
                        <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 16px;">রাইডারের তথ্য ও হেল্পলাইন</h3>
                        <div class="driver-info-card" style="margin-bottom: 24px;">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" alt="Rider" class="driver-avatar" />
                                <div>
                                    <div style="font-weight: 800; font-size: 1.05rem;">মোঃ তানভীর হোসেন (তানভীর)</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">হিরো হাংক ১৫০ • কুষ্টিয়া-হ-১১-৮৭৬৫</div>
                                    <div style="font-size: 0.8rem; color: #FFB800; font-weight: 700;">★ ৪.৯৬ রাইডার রেটিং</div>
                                </div>
                            </div>
                            <a href="tel:+8801712345678" class="btn-icon" style="background: var(--brand-gradient); color: #FFFFFF;" title="রাইডারকে কল করুন">
                                📞
                            </a>
                        </div>

                        <div style="background: var(--bg-surface-2); border-radius: 16px; padding: 20px; border: 1px solid var(--border-light);">
                            <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 12px;">নিরাপদ ডেলিভারি প্রতিশ্রুতি</h4>
                            <ul style="font-size: 0.85rem; color: var(--text-muted); display: flex; flex-direction: column; gap: 8px; list-style: none;">
                                <li>✓ ১০০% গরম ও অক্ষত সিলযুক্ত প্যাকেজিং</li>
                                <li>✓ ৩০ মিনিটের বেশি বিলম্ব হলে ফ্রি কুলফি রিফান্ড</li>
                                <li>✓ রাইডারের সাথে সরাসরি লাইভ ফোনে যোগাযোগ</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RECENT ORDERS SECTION -->
            <div style="margin-top: 50px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <div>
                        <h2 style="font-size: 1.8rem; font-weight: 800;">সাম্প্রতিক অর্ডারসমূহ (Recent Orders)</h2>
                        <p style="color: var(--text-muted); font-size: 0.95rem;">কুষ্টিয়া এক্সপ্রেস থেকে ইতিপূর্বে দেওয়া অর্ডারগুলোর তালিকা।</p>
                    </div>
                    <a href="{{ route('home') }}#menu-catalog" class="btn btn-secondary">নতুন খাবার অর্ডার করুন</a>
                </div>

                @if($recentOrders->count() > 0)
                    @foreach($recentOrders as $ord)
                    <div class="recent-order-item">
                        <div style="display: flex; align-items: center; gap: 18px;">
                            <div style="width: 52px; height: 52px; background: rgba(255, 84, 46, 0.1); color: var(--brand-primary); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800;">
                                🍲
                            </div>
                            <div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="font-weight: 800; font-size: 1.1rem;">অর্ডার #{{ $ord->order_code }}</span>
                                    <span class="badge badge-success">{{ strtoupper($ord->status) }}</span>
                                </div>
                                <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">
                                    {{ $ord->created_at->format('d M, Y - h:i A') }} • পেমেন্ট: {{ strtoupper($ord->payment_method) }} • ঠিকানা: {{ Str::limit($ord->delivery_address, 35) }}
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="text-align: right;">
                                <div style="font-weight: 900; font-size: 1.3rem; color: var(--text-main);">৳{{ number_format($ord->total, 0) }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ count($ord->items ?? []) }} টি আইটেম</div>
                            </div>
                            <button class="btn btn-primary" onclick="trackSpecificOrder('{{ $ord->order_code }}')">
                                ট্র্যাক করুন
                            </button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 50px 20px; background: var(--bg-surface); border-radius: 20px; border: 1px solid var(--border-light);">
                        <div style="font-size: 3rem; margin-bottom: 12px;">📦</div>
                        <h3 style="font-size: 1.3rem; margin-bottom: 8px;">কোনো পূর্ববর্তী অর্ডার পাওয়া যায়নি</h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 20px;">কুষ্টিয়ার সেরা খাবার অর্ডার করতে মেনু ভিজিট করুন।</p>
                        <a href="{{ route('home') }}#menu-catalog" class="btn btn-primary">এখনই অর্ডার করুন</a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-bottom" style="border: none; padding: 0;">
                <div>© {{ date('Y') }} KushtiaExpress • সর্বস্বত্ব সংরক্ষিত • কুষ্টিয়া, বাংলাদেশ</div>
                <div style="display: flex; gap: 18px;">
                    <a href="{{ route('home') }}">হোমপেজ</a>
                    <a href="{{ route('contact.page') }}">কন্টাক্ট পেইজ</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- SLIDE-OVER CART DRAWER -->
    <div id="cartOverlay" class="modal-overlay" style="z-index: 1040;"></div>
    <div id="cartDrawer" class="cart-drawer">
        <div class="drawer-header">
            <div class="drawer-title">
                <span>আপনার খাবারের কার্ট</span>
            </div>
            <button id="cartDrawerClose" class="btn-icon">✕</button>
        </div>
        <div class="delivery-meter-box">
            <div id="deliveryProgressText">আর মাত্র <strong>৳৪০০</strong> অর্ডারে পাচ্ছেন <strong>ফ্রি হোম ডেলিভারি</strong></div>
            <div class="progress-bar-bg"><div id="deliveryProgressFill" class="progress-bar-fill"></div></div>
        </div>
        <div id="cartItemsList" class="cart-items-list"></div>
        <div class="cart-drawer-footer">
            <div class="cart-summary-rows">
                <div class="summary-row"><span>মোট মূল্য</span><span id="cartSubtotal">৳০</span></div>
                <div class="summary-row"><span>ডেলিভারি চার্জ</span><span id="cartDeliveryFee">৳৪০</span></div>
                <div class="summary-row total"><span>সর্বমোট</span><span id="cartTotal" class="gradient-text">৳০</span></div>
            </div>
            <button id="proceedCheckoutBtn" class="btn btn-primary" style="width: 100%; padding: 14px;" onclick="window.location.href='{{ route('home') }}'">
                অর্ডার করতে মেনুতে যান
            </button>
        </div>
    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        async function lookupOrder() {
            const input = document.getElementById('orderSearchCodeInput');
            const code = input.value.trim().toUpperCase();
            if (!code) {
                window.craveApp.showToast('দয়া করে সঠিক অর্ডার কোড লিখুন', 'error');
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
                    document.getElementById('displayedOrderCode').innerText = `অর্ডার #${data.order.order_code}`;
                    document.getElementById('displayedEtaTime').innerText = `${data.tracking.estimated_minutes_left} মিনিট`;
                    document.getElementById('liveTrackingResultSection').scrollIntoView({ behavior: 'smooth' });
                    window.craveApp.showToast(`অর্ডার #${code} খুঁজে পাওয়া গেছে!`, 'success');
                } else {
                    window.craveApp.showToast('এই কোডে কোনো অর্ডার খুঁজে পাওয়া যায়নি।', 'error');
                }
            } catch (e) {
                window.craveApp.showToast('সার্ভারে সমস্যা হচ্ছে, অনুগ্রহ করে কিছুক্ষণ পর চেষ্টা করুন।', 'error');
            }
        }
    </script>
</body>
</html>
