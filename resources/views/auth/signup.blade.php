<!DOCTYPE html>
<html lang="bn" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>কাস্টমার সাইন আপ (Customer Sign Up) • KushtiaExpress</title>
    <meta name="description" content="কুষ্টিয়া এক্সপ্রেসের নতুন কাস্টমার অ্যাকাউন্ট খুলুন এবং উপভোগ করুন দ্রুততম হোম ডেলিভারি ও বিশেষ ছাড়।">

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
        .auth-page-container {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            background: var(--bg-body);
        }
        .auth-sidebar-showcase {
            background: linear-gradient(135deg, #131826 0%, #1E2538 100%);
            color: #FFFFFF;
            padding: 60px 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .auth-sidebar-showcase::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 84, 46, 0.25) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            pointer-events: none;
        }
        .auth-form-wrapper {
            padding: 60px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-width: 580px;
            width: 100%;
            margin: 0 auto;
        }
        .auth-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            border-radius: 24px;
            padding: 40px;
            box-shadow: var(--shadow-xl);
        }
        .feature-bullet {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            font-size: 0.95rem;
            font-weight: 600;
        }
        .feature-bullet-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255, 84, 46, 0.2);
            color: var(--brand-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        @media(max-width: 900px) {
            .auth-page-container {
                grid-template-columns: 1fr;
            }
            .auth-sidebar-showcase {
                display: none;
            }
            .auth-form-wrapper {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="auth-page-container">
        <!-- Sidebar Showcase -->
        <div class="auth-sidebar-showcase">
            <div>
                <a href="{{ route('home') }}" class="brand-logo" style="margin-bottom: 40px; display: inline-flex;">
                    <div class="logo-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                    </div>
                    <span style="color: #FFFFFF;">Kushtia<span class="gradient-text">Foodies</span></span>
                </a>

                <div class="hero-badge-pill" style="margin-bottom: 20px; background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.15); color: #FFB800;">
                    <span>✨ কুষ্টিয়ার ১ নম্বর ফুড ডেলিভারি নেটওয়ার্ক</span>
                </div>

                <h1 style="font-size: 2.5rem; font-weight: 900; line-height: 1.25; margin-bottom: 20px;">
                    কুষ্টিয়ার খাঁটি স্বাদ <br/><span class="gradient-text">আপনার দোরগোড়ায়</span>
                </h1>

                <p style="color: #94A3B8; font-size: 1.05rem; line-height: 1.6; margin-bottom: 36px;">
                    অ্যাকাউন্ট তৈরি করলেই পাচ্ছেন প্রথম অর্ডারে ৳৫০ ডিসকাউন্ট ও ফ্রি ডেলিভারি অফার।
                </p>

                <div>
                    <div class="feature-bullet">
                        <div class="feature-bullet-icon">🍨</div>
                        <span>কুষ্টিয়ার বিখ্যাত রয়্যাল শাহী কুলফি মালাই ও খাজা</span>
                    </div>
                    <div class="feature-bullet">
                        <div class="feature-bullet-icon">🍲</div>
                        <span>শাহী কাচ্চি বিরিয়ানি, গড়াইয়ের ইলিশ ও কালা ভুনা</span>
                    </div>
                    <div class="feature-bullet">
                        <div class="feature-bullet-icon">⚡</div>
                        <span>১৫-২০ মিনিটে দ্রুততম এক্সপ্রেস বাইক ডেলিভারি</span>
                    </div>
                    <div class="feature-bullet">
                        <div class="feature-bullet-icon">📱</div>
                        <span>বিকাশ ও নগদ ক্যাশলেস ইনস্ট্যান্ট পেমেন্ট</span>
                    </div>
                </div>
            </div>

            <div style="font-size: 0.85rem; color: #64748B; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.1);">
                © {{ date('Y') }} KushtiaExpress • সর্বস্বত্ব সংরক্ষিত • কুষ্টিয়া, বাংলাদেশ
            </div>
        </div>

        <!-- Sign Up Form Area -->
        <div class="auth-form-wrapper">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 10px;">
                <a href="{{ route('home') }}" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.85rem;" data-en="← Back to Home" data-bn="← হোমপেজে ফিরে যান">
                    ← হোমপেজে ফিরে যান
                </a>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <!-- Global Language Switcher -->
                    <button type="button" class="lang-toggle-btn" onclick="window.craveApp.toggleLanguage()" title="Switch Language / ভাষা পরিবর্তন">
                        <span class="lang-flag">🇧🇩</span>
                        <span class="lang-text">বাংলা</span>
                        <span style="font-size:0.75rem; color:var(--text-muted);">| EN</span>
                    </button>
                    <button id="themeToggleBtn" class="theme-toggle-btn" aria-label="Toggle Theme">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                    </button>
                </div>
            </div>

            <div class="auth-card">
                <div style="margin-bottom: 24px;">
                    <h2 style="font-size: 2rem; font-weight: 900; margin-bottom: 8px;" data-en="Create New Account" data-bn="নতুন অ্যাকাউন্ট তৈরি করুন">নতুন অ্যাকাউন্ট তৈরি করুন</h2>
                    <p style="color: var(--text-muted); font-size: 0.95rem;">
                        <span data-en="Already have an account?" data-bn="ইতোমধ্যে অ্যাকাউন্ট আছে?">ইতোমধ্যে অ্যাকাউন্ট আছে?</span> 
                        <a href="{{ route('login.page') }}" style="color: var(--brand-primary); font-weight: 700;" data-en="Log in here" data-bn="এখানে লগইন করুন">এখানে লগইন করুন</a>
                    </p>
                </div>

                <form id="standaloneSignupForm" onsubmit="handleStandaloneSignup(event)">
                    <div class="form-group">
                        <label class="form-label">আপনার পূর্ণ নাম *</label>
                        <input type="text" id="signupName" class="form-control" required placeholder="মোঃ শফিকুল ইসলাম" />
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">মোবাইল নম্বর *</label>
                            <input type="tel" id="signupPhone" class="form-control" required placeholder="017XXXXXXXX" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">ইমেইল ঠিকানা *</label>
                            <input type="email" id="signupEmail" class="form-control" required placeholder="name@example.com" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">কুষ্টিয়া ডেলিভারি জোন</label>
                        <select id="signupZone" class="form-control" style="cursor: pointer;">
                            <option value="মজমুপুর গেট ও এনএস রোড">📍 মজমুপুর গেট ও এনএস রোড (সেন্ট্রাল)</option>
                            <option value="কোর্টপাড়া ও থানা মোড়">📍 কোর্টপাড়া ও থানা মোড়</option>
                            <option value="ইসলামী বিশ্ববিদ্যালয় ক্যাম্পাস">🎓 ইসলামী বিশ্ববিদ্যালয় (IU) ক্যাম্পাস</option>
                            <option value="চৌড়হাস মোড় ও গড়াই সেতু">🌉 চৌড়হাস মোড় ও গড়াই সেতু</option>
                            <option value="হাউজিং এস্টেট ও পুলিশ লাইনস">🏘️ হাউজিং এস্টেট ও পুলিশ লাইনস</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">বাসা/ঠিকানা (ঐচ্ছিক)</label>
                        <input type="text" id="signupAddress" class="form-control" placeholder="বাসা #১২, রোড #৩, মজমুপুর, কুষ্টিয়া" />
                    </div>

                    <div class="form-group">
                        <label class="form-label">পাসওয়ার্ড (কমপক্ষে ৬ অক্ষর) *</label>
                        <input type="password" id="signupPassword" class="form-control" required minlength="6" placeholder="••••••••" />
                    </div>

                    <button type="submit" id="signupBtn" class="btn btn-primary" style="width: 100%; padding: 14px; margin-top: 12px; font-size: 1.05rem;">
                        সাইন আপ সম্পন্ন করুন 🚀
                    </button>
                </form>

                <div style="text-align: center; margin-top: 20px; font-size: 0.8rem; color: var(--text-muted);">
                    সাইন আপ করার মাধ্যমে আপনি কুষ্টিয়া এক্সপ্রেসের <a href="{{ route('contact.bn') }}" style="color: var(--brand-primary);">শর্তাবলী ও প্রাইভেসিতে</a> সম্মত হচ্ছেন।
                </div>
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
        async function handleStandaloneSignup(e) {
            e.preventDefault();
            const btn = document.getElementById('signupBtn');
            btn.disabled = true;
            btn.innerText = 'অ্যাকাউন্ট তৈরি হচ্ছে...';

            const name = document.getElementById('signupName').value;
            const email = document.getElementById('signupEmail').value;
            const phone = document.getElementById('signupPhone').value;
            const delivery_zone = document.getElementById('signupZone').value;
            const address = document.getElementById('signupAddress').value;
            const password = document.getElementById('signupPassword').value;

            try {
                const res = await fetch('/api/auth/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ name, email, phone, delivery_zone, address, password })
                });

                const data = await res.json();
                if (res.ok && data.status === 'success') {
                    window.craveApp.showToast(data.message, 'success');
                    setTimeout(() => {
                        window.location.href = "{{ route('home') }}";
                    }, 1200);
                } else {
                    window.craveApp.showToast(data.message || 'নিবন্ধন ব্যর্থ হয়েছে। তথ্য যাচাই করুন।', 'error');
                }
            } catch (err) {
                window.craveApp.showToast('সার্ভারে সমস্যা হচ্ছে, কিছুক্ষণ পর আবার চেষ্টা করুন।', 'error');
            } finally {
                btn.disabled = false;
                btn.innerText = 'সাইন আপ সম্পন্ন করুন 🚀';
            }
        }
    </script>
</body>
</html>
