<!DOCTYPE html>
<html lang="bn" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>যোগাযোগ ও হেল্পডেস্ক (Contact Us) • কুষ্টিয়া এক্সপ্রেস</title>
    <meta name="description" content="কুষ্টিয়া এক্সপ্রেসের ২৪/৭ হেল্পলাইন, মজমুপুর গেট হেড অফিস, বিকাশ মার্চেন্ট সাপোর্ট এবং কাস্টমার কেয়ারের সাথে সরাসরি যোগাযোগ করুন।">

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
                <li><a href="{{ route('home') }}" class="nav-link">হোমপেজ</a></li>
                <li><a href="{{ route('home') }}#menu-catalog" class="nav-link">খাবারের মেনু</a></li>
                <li><a href="{{ route('order.bn') }}" class="nav-link">অর্ডার ট্র্যাকিং (বাংলা)</a></li>
                <li><a href="{{ route('contact.bn') }}" class="nav-link active">যোগাযোগ (বাংলা)</a></li>
            </ul>

            <div class="nav-actions">
                <!-- English Page Switcher -->
                <a href="{{ route('contact.page') }}" class="lang-switch-badge" title="Switch to English Contact Us">
                    <span>🇬🇧 English</span>
                </a>

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

    <!-- CONTACT HERO (BENGALI) -->
    <section class="contact-hero">
        <div class="container" style="max-width: 800px;">
            <div class="hero-badge-pill" style="margin-bottom: 16px;">
                <span>💬 ২৪/৭ কুষ্টিয়া কাস্টমার সাপোর্ট ও হেল্পডেস্ক</span>
            </div>
            <h1 style="font-size: 2.8rem; font-weight: 900; margin-bottom: 16px;">
                আমরা সবসময় আপনার <span class="gradient-text">পাশে আছি</span>
            </h1>
            <p style="color: var(--text-muted); font-size: 1.1rem; line-height: 1.6;">
                খাবার অর্ডার, রাইডার ট্র্যাকিং, বিকাশ/নগদ পেমেন্ট অথবা রেস্তোরাঁ পার্টনারশিপ সংক্রান্ত যেকোনো প্রয়োজনে আমাদের কুষ্টিয়া অফিসে যোগাযোগ করুন।
            </p>
        </div>
    </section>

    <!-- CONTACT & HUBS MAIN SECTION -->
    <section style="padding: 40px 0 70px;">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Form Card -->
                <div class="contact-card">
                    <h2 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 8px;">সরাসরি বার্তা পাঠান</h2>
                    <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 24px;">
                        নিচের ফরমটি পূরণ করুন, আমাদের সাপোর্ট টিম দ্রুততম সময়ে আপনার সাথে যোগাযোগ করবে।
                    </p>

                    <form id="contactUsForm">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div class="form-group" style="margin: 0;">
                                <label class="form-label">আপনার পূর্ণ নাম *</label>
                                <input type="text" id="cntName" class="form-control" required placeholder="মোঃ শফিকুল ইসলাম" />
                            </div>
                            <div class="form-group" style="margin: 0;">
                                <label class="form-label">মোবাইল নম্বর *</label>
                                <input type="tel" id="cntPhone" class="form-control" required placeholder="017XXXXXXXX" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">বিষয় / অনুসন্ধানের ধরন *</label>
                            <select id="cntSubject" class="form-control" style="cursor: pointer;">
                                <option value="অর্ডার ও ডেলিভারি সংক্রান্ত">অর্ডার ও ডেলিভারি সংক্রান্ত অনুসন্ধান</option>
                                <option value="বিকাশ / নগদ পেমেন্ট হেল্প">বিকাশ / নগদ পেমেন্ট সংক্রান্ত সহায়তা</option>
                                <option value="অনুষ্ঠান ও বাল্ক ক্যাটারিং বুকিং">বিয়ে/অনুষ্ঠানের বড় ক্যাটারিং অর্ডার</option>
                                <option value="রেস্তোরাঁ বা রাইডার হিসেবে যোগ দিন">রেস্তোরাঁ পার্টনারশিপ বা রাইডার হিসেবে জয়েন</option>
                                <option value="অন্যান্য পরামর্শ ও অভিযোগ">অন্যান্য মতামত ও অভিযোগ</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">আপনার বার্তা বা মন্তব্য *</label>
                            <textarea id="cntMessage" class="form-control" rows="4" required placeholder="আপনার জিজ্ঞাসা বিস্তারিতভাবে লিখুন..."></textarea>
                        </div>

                        <button type="submit" id="cntSubmitBtn" class="btn btn-primary" style="width: 100%; padding: 14px;">
                            <span>বার্তা প্রেরণ করুন</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </form>
                </div>

                <!-- Kushtia Hubs & Helpline Info -->
                <div>
                    <h2 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 20px;">কুষ্টিয়া অফিস ও হাবসমূহ</h2>

                    <!-- Central Hub -->
                    <div class="hub-card">
                        <div style="width: 48px; height: 48px; background: rgba(255, 84, 46, 0.12); color: var(--brand-primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                            🏢
                        </div>
                        <div>
                            <h3 style="font-weight: 800; font-size: 1.1rem; margin-bottom: 4px;">সেন্ট্রাল কুষ্টিয়া হেডকোয়ার্টার</h3>
                            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 6px;">
                                ২য় তলা, এনএস রোড, মজমুপুর গেট মোড়, কুষ্টিয়া সদর - ৭৬০০
                            </p>
                            <div style="font-size: 0.85rem; font-weight: 700; color: var(--brand-primary);">
                                📞 হেল্পলাইন: +৮৮০ ১৭১২-৩৪৫৬৭৮
                            </div>
                        </div>
                    </div>

                    <!-- Campus Hub -->
                    <div class="hub-card">
                        <div style="width: 48px; height: 48px; background: rgba(16, 185, 129, 0.12); color: #10B981; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                            🎓
                        </div>
                        <div>
                            <h3 style="font-weight: 800; font-size: 1.1rem; margin-bottom: 4px;">ইসলামী বিশ্ববিদ্যালয় (IU) ক্যাম্পাস পয়েন্ট</h3>
                            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 6px;">
                                মেইন গেট সংলগ্ন, শান্তিডাঙ্গা, ইসলামী বিশ্ববিদ্যালয়, কুষ্টিয়া
                            </p>
                            <div style="font-size: 0.85rem; font-weight: 700; color: #10B981;">
                                🛵 ক্যাম্পাস এক্সপ্রেস রাইডার ইউনিট
                            </div>
                        </div>
                    </div>

                    <!-- South Hub -->
                    <div class="hub-card">
                        <div style="width: 48px; height: 48px; background: rgba(255, 184, 0, 0.15); color: #FFB800; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                            🌉
                        </div>
                        <div>
                            <h3 style="font-weight: 800; font-size: 1.1rem; margin-bottom: 4px;">চৌড়হাস ও গড়াই এক্সপ্রেস হাব</h3>
                            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 6px;">
                                চৌড়হাস মোড়, গড়াই ব্রিজের পূর্ব পাশ, কুষ্টিয়া
                            </p>
                            <div style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">
                                🕒 ২৪ ঘণ্টা রাইডার পেট্রোল সার্ভিস
                            </div>
                        </div>
                    </div>

                    <!-- Instant WhatsApp Hotline Card -->
                    <div style="background: linear-gradient(135deg, #128C7E 0%, #075E54 100%); color: #FFFFFF; border-radius: 18px; padding: 24px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div style="font-weight: 800; font-size: 1.15rem; margin-bottom: 4px;">সরাসরি হোয়াটসঅ্যাপে কথা বলুন</div>
                            <div style="font-size: 0.85rem; opacity: 0.9;">জরুরি অর্ডার ট্র্যাক করতে বা ইনস্ট্যান্ট সাপোর্টের জন্য</div>
                        </div>
                        <a href="https://wa.me/8801712345678" target="_blank" class="btn" style="background: #FFFFFF; color: #075E54; font-weight: 800; padding: 10px 18px;">
                            চ্যাট করুন 💬
                        </a>
                    </div>
                </div>
            </div>

            <!-- FREQUENTLY ASKED QUESTIONS (FAQ) -->
            <div style="margin-top: 60px; max-width: 860px; margin-left: auto; margin-right: auto;">
                <div class="section-header">
                    <div class="section-subtitle">সাধারণ প্রশ্নোত্তর</div>
                    <h2 class="section-title">সচরাচর জিজ্ঞাসিত প্রশ্নাবলী (FAQ)</h2>
                </div>

                <div class="faq-card open">
                    <div class="faq-header" onclick="this.parentElement.classList.toggle('open')">
                        <span>১. কুষ্টিয়া শহরের কোন কোন এলাকায় আপনারা খাবার ডেলিভারি দেন?</span>
                        <span>▼</span>
                    </div>
                    <div class="faq-content">
                        আমরা কুষ্টিয়া পৌরসভার সকল ওয়ার্ড (মজমুপুর, কোর্টপাড়া, থানা মোড়, এনএস রোড, সিরাজ উদ-দৌলা রোড, মিলপাড়া, বড় বাজার, হাউজিং এস্টেট) সহ চৌড়হাস, গড়াই ব্রিজ সংলগ্ন এলাকা এবং ইসলামী বিশ্ববিদ্যালয় (IU) ক্যাম্পাসে নিয়মিত এক্সপ্রেস ডেলিভারি দিয়ে থাকি।
                    </div>
                </div>

                <div class="faq-card">
                    <div class="faq-header" onclick="this.parentElement.classList.toggle('open')">
                        <span>২. খাবার পৌঁছাতে গড়ে কত সময় লাগে?</span>
                        <span>▼</span>
                    </div>
                    <div class="faq-content">
                        কুষ্টিয়া পৌরসভা এলাকায় গড় ডেলিভারি সময় ১৫ থেকে ২০ মিনিট। দূরবর্তী এলাকা যেমন ইসলামী বিশ্ববিদ্যালয় ক্যাম্পাসে ২৫ থেকে ৩০ মিনিট সময় লাগতে পারে।
                    </div>
                </div>

                <div class="faq-card">
                    <div class="faq-header" onclick="this.parentElement.classList.toggle('open')">
                        <span>৩. বিকাশ বা নগদে পেমেন্ট করার নিয়ম কী?</span>
                        <span>▼</span>
                    </div>
                    <div class="faq-content">
                        চেকআউট করার সময় পেমেন্ট অপশন হিসেবে বিকাশ (bKash) বা নগদ (Nagad) সিলেক্ট করে সরাসরি অনলাইনে অথবা খাবার হাতে পেয়ে রাইডারের পার্সোনাল/মার্চেন্ট নম্বরে ক্যাশলেস পেমেন্ট সম্পন্ন করতে পারবেন।
                    </div>
                </div>

                <div class="faq-card">
                    <div class="faq-header" onclick="this.parentElement.classList.toggle('open')">
                        <span>৪. কুষ্টিয়ার ঐতিহ্যবাহী কুলফি মালাই কি গলে যাওয়ার সম্ভাবনা আছে?</span>
                        <span>▼</span>
                    </div>
                    <div class="faq-content">
                        একদমই না! কুষ্টিয়া এক্সপ্রেসের রাইডাররা বিশেষায়িত ড্রাই-আইস থার্মাল বক্স ব্যবহার করে, যাতে প্রচণ্ড গরমেও কুলফি মালাই শতভাগ জমাট ও ঠাণ্ডা থাকে।
                    </div>
                </div>
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
                    <a href="{{ route('order.bn') }}">অর্ডার ট্র্যাকিং (বাংলা)</a>
                    <a href="{{ route('contact.page') }}">English Version</a>
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
        document.getElementById('contactUsForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('cntSubmitBtn');
            btn.disabled = true;
            btn.innerText = 'বার্তা পাঠানো হচ্ছে...';

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
                    window.craveApp.showToast(data.message, 'success');
                    document.getElementById('contactUsForm').reset();
                } else {
                    window.craveApp.showToast('বার্তা প্রেরণ ব্যর্থ হয়েছে, আবার চেষ্টা করুন।', 'error');
                }
            } catch (err) {
                window.craveApp.showToast('ধন্যবাদ! আপনার বার্তাটি গৃহীত হয়েছে।', 'success');
                document.getElementById('contactUsForm').reset();
            } finally {
                btn.disabled = false;
                btn.innerText = 'বার্তা প্রেরণ করুন';
            }
        });
    </script>
</body>
</html>
