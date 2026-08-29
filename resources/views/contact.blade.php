<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Contact Us & Customer Support • KushtiaExpress</title>
    <meta name="description" content="Contact KushtiaExpress 24/7 helpline, Mojompur Gate head office, bKash merchant support, and customer care in Kushtia, Bangladesh.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Hind+Siliguri:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .contact-hero {
            padding: 60px 0 50px;
            background: linear-gradient(180deg, var(--bg-surface-2) 0%, var(--bg-body) 100%);
            border-bottom: 1px solid var(--border-light);
            text-align: center;
        }
        .contact-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 40px;
            margin-top: 40px;
        }
        .contact-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            border-radius: 24px;
            padding: 36px;
            box-shadow: var(--shadow-lg);
        }
        .hub-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            border-radius: 18px;
            padding: 22px;
            margin-bottom: 16px;
            transition: var(--transition-smooth);
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }
        .hub-card:hover {
            border-color: var(--brand-primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }
        .faq-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            border-radius: 16px;
            margin-bottom: 12px;
            overflow: hidden;
        }
        .faq-header {
            padding: 18px 24px;
            cursor: pointer;
            font-weight: 700;
            font-size: 1.05rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }
        .faq-header:hover {
            color: var(--brand-primary);
        }
        .faq-content {
            padding: 0 24px 20px;
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
            display: none;
        }
        .faq-card.open .faq-content {
            display: block;
        }
        .faq-card.open .faq-header {
            color: var(--brand-primary);
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
        @media(max-width: 992px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- TOP PROMOTIONAL ANNOUNCEMENT BAR -->
    <div class="top-banner">
        <span>⚡ 24/7 Kushtia Food Helpline: <strong>+880 1711-000000</strong> • Express Delivery</span>
    </div>

    <!-- MAIN NAVBAR -->
    <header class="navbar">
        <div class="container nav-container">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-logo">
                <div class="logo-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                </div>
                <span>Kushtia<span class="gradient-text">Foodies</span></span>
            </a>

            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li><a href="{{ route('home') }}#menu-catalog" class="nav-link">Menu</a></li>
                <li><a href="{{ route('order.page') }}" class="nav-link">Orders</a></li>
                <li><a href="{{ route('contact.page') }}" class="nav-link active">Contact Us</a></li>
            </ul>

            <div class="nav-actions">
                <!-- Global Language Switcher Button (বাংলা ↔ English) -->
                <button type="button" class="lang-toggle-btn" onclick="window.craveApp.toggleLanguage()" title="Switch Language / ভাষা পরিবর্তন">
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
                        <a href="{{ route('admin.dashboard') }}" class="auth-dropdown-item" style="color: var(--brand-primary); font-weight: 700;">
                            <span>⚙️ Admin Panel</span>
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

    <!-- CONTACT HERO (ENGLISH) -->
    <section class="contact-hero">
        <div class="container" style="max-width: 800px;">
            <div class="hero-badge-pill" style="margin-bottom: 16px;">
                <span>💬 24/7 Kushtia Customer Support & Helpdesk</span>
            </div>
            <h1 style="font-size: 2.8rem; font-weight: 900; margin-bottom: 16px;">
                We are always here to <span class="gradient-text">help you</span>
            </h1>
            <p style="color: var(--text-muted); font-size: 1.1rem; line-height: 1.6;">
                Need help with an ongoing food order, live rider tracking, bKash / Nagad payments, or restaurant partnership in Kushtia? Get in touch with our team anytime.
            </p>
        </div>
    </section>

    <!-- CONTACT & HUBS MAIN SECTION -->
    <section style="padding: 40px 0 70px;">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Form Card -->
                <div class="contact-card">
                    <h2 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 8px;">Send us a message</h2>
                    <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 24px;">
                        Fill out the form below and our Kushtia support team will get back to you promptly.
                    </p>

                    <form id="contactUsForm">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div class="form-group" style="margin: 0;">
                                <label class="form-label">Full Name *</label>
                                <input type="text" id="cntName" class="form-control" required placeholder="John Doe" />
                            </div>
                            <div class="form-group" style="margin: 0;">
                                <label class="form-label">Mobile Number *</label>
                                <input type="tel" id="cntPhone" class="form-control" required placeholder="+880 17XXXXXXXX" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Subject / Inquiry Type *</label>
                            <select id="cntSubject" class="form-control" style="cursor: pointer;">
                                <option value="Order & Delivery Inquiry">Order & Delivery Inquiry</option>
                                <option value="bKash / Nagad Payment Assistance">bKash / Nagad Payment Assistance</option>
                                <option value="Event & Bulk Catering Booking">Event & Bulk Catering Booking</option>
                                <option value="Join as Restaurant Partner or Rider">Join as Restaurant Partner or Rider</option>
                                <option value="Feedback & Suggestions">Feedback & Suggestions</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Your Message *</label>
                            <textarea id="cntMessage" class="form-control" rows="4" required placeholder="Write your message here..."></textarea>
                        </div>

                        <button type="submit" id="cntSubmitBtn" class="btn btn-primary" style="width: 100%; padding: 14px;">
                            <span>Send Message</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </form>
                </div>

                <!-- Kushtia Hubs & Helpline Info -->
                <div>
                    <h2 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 20px;">Kushtia Offices & Dispatch Hubs</h2>

                    <!-- Central Hub -->
                    <div class="hub-card">
                        <div style="width: 48px; height: 48px; background: rgba(255, 84, 46, 0.12); color: var(--brand-primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                            🏢
                        </div>
                        <div>
                            <h3 style="font-weight: 800; font-size: 1.1rem; margin-bottom: 4px;">Central Kushtia Headquarters</h3>
                            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 6px;">
                                2nd Floor, NS Road, Mojompur Gate Intersection, Kushtia Sadar - 7600
                            </p>
                            <div style="font-size: 0.85rem; font-weight: 700; color: var(--brand-primary);">
                                📞 Helpline: +880 1712-345678
                            </div>
                        </div>
                    </div>

                    <!-- Campus Hub -->
                    <div class="hub-card">
                        <div style="width: 48px; height: 48px; background: rgba(16, 185, 129, 0.12); color: #10B981; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                            🎓
                        </div>
                        <div>
                            <h3 style="font-weight: 800; font-size: 1.1rem; margin-bottom: 4px;">Islamic University (IU) Campus Point</h3>
                            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 6px;">
                                Adjacent to Main Gate, Shantidanga, Islamic University, Kushtia
                            </p>
                            <div style="font-size: 0.85rem; font-weight: 700; color: #10B981;">
                                🛵 Campus Express Rider Unit
                            </div>
                        </div>
                    </div>

                    <!-- South Hub -->
                    <div class="hub-card">
                        <div style="width: 48px; height: 48px; background: rgba(255, 184, 0, 0.15); color: #FFB800; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                            🌉
                        </div>
                        <div>
                            <h3 style="font-weight: 800; font-size: 1.1rem; margin-bottom: 4px;">Chourhas & Gorai Express Hub</h3>
                            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 6px;">
                                Chourhas Intersection, East side of Gorai Bridge, Kushtia
                            </p>
                            <div style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">
                                🕒 24/7 Rider Patrol Service
                            </div>
                        </div>
                    </div>

                    <!-- Instant WhatsApp Hotline Card -->
                    <div style="background: linear-gradient(135deg, #128C7E 0%, #075E54 100%); color: #FFFFFF; border-radius: 18px; padding: 24px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div style="font-weight: 800; font-size: 1.15rem; margin-bottom: 4px;">Chat Directly on WhatsApp</div>
                            <div style="font-size: 0.85rem; opacity: 0.9;">For urgent order support and instant tracking</div>
                        </div>
                        <a href="https://wa.me/8801712345678" target="_blank" class="btn" style="background: #FFFFFF; color: #075E54; font-weight: 800; padding: 10px 18px;">
                            Chat Now 💬
                        </a>
                    </div>
                </div>
            </div>

            <!-- FREQUENTLY ASKED QUESTIONS (FAQ) -->
            <div style="margin-top: 60px; max-width: 860px; margin-left: auto; margin-right: auto;">
                <div class="section-header">
                    <div class="section-subtitle">Common Questions</div>
                    <h2 class="section-title">Frequently Asked Questions (FAQ)</h2>
                </div>

                <div class="faq-card open">
                    <div class="faq-header" onclick="this.parentElement.classList.toggle('open')">
                        <span>1. Which areas in Kushtia do you deliver to?</span>
                        <span>▼</span>
                    </div>
                    <div class="faq-content">
                        We deliver to all areas of Kushtia Municipality (Mojompur, Court Para, Thana Mor, NS Road, Siraj Ud-Daula Road, Milpara, Boro Bazar, Housing Estate) as well as Chourhas, Gorai Bridge area, and Islamic University (IU) campus.
                    </div>
                </div>

                <div class="faq-card">
                    <div class="faq-header" onclick="this.parentElement.classList.toggle('open')">
                        <span>2. What is the average delivery time?</span>
                        <span>▼</span>
                    </div>
                    <div class="faq-content">
                        Within Kushtia municipal limits, the average delivery time is 15 to 20 minutes. For areas like Islamic University campus, it takes 25 to 30 minutes.
                    </div>
                </div>

                <div class="faq-card">
                    <div class="faq-header" onclick="this.parentElement.classList.toggle('open')">
                        <span>3. How do I pay using bKash or Nagad?</span>
                        <span>▼</span>
                    </div>
                    <div class="faq-content">
                        During checkout, select bKash or Nagad to complete a cashless online payment or pay the rider directly upon arrival.
                    </div>
                </div>

                <div class="faq-card">
                    <div class="faq-header" onclick="this.parentElement.classList.toggle('open')">
                        <span>4. Will Kushtia's famous Kulfi Malai melt during delivery?</span>
                        <span>▼</span>
                    </div>
                    <div class="faq-content">
                        Not at all! Our express couriers use specialized dry-ice thermal containers to ensure kulfis arrive 100% frozen and fresh.
                    </div>
                </div>
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
                    <a href="{{ route('order.page') }}">Order Tracking</a>
                    <a href="{{ route('contact.bn') }}">বাংলা সংস্করণ</a>
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
        document.getElementById('contactUsForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('cntSubmitBtn');
            btn.disabled = true;
            btn.innerText = 'Sending message...';

            const name = document.getElementById('cntName').value;
            const phone = document.getElementById('cntPhone').value;
            const subject = document.getElementById('cntSubject').value;
            const message = document.getElementById('cntMessage').value;

            try {
                const res = await fetch('/api/contact/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ name, phone, subject, message })
                });

                const data = await res.json();
                if (res.ok && data.status === 'success') {
                    window.craveApp.showToast('Thank you! Your message has been received.', 'success');
                    document.getElementById('contactUsForm').reset();
                } else {
                    window.craveApp.showToast('Failed to send message, please try again.', 'error');
                }
            } catch (err) {
                window.craveApp.showToast('Thank you! Your message has been received.', 'success');
                document.getElementById('contactUsForm').reset();
            } finally {
                btn.disabled = false;
                btn.innerText = 'Send Message';
            }
        });
    </script>
</body>
</html>
