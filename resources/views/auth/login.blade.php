<!DOCTYPE html>
<html lang="bn" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>কাস্টমার লগইন (Customer Sign In) • KushtiaExpress</title>
    <meta name="description" content="কুষ্টিয়া এক্সপ্রেস কাস্টমার অ্যাকাউন্টে লগইন করুন এবং আপনার পূর্বের অর্ডার ও ট্র্যাকিং স্ট্যাটাস দেখুন।">

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
            max-width: 540px;
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
                    <span style="color: #FFFFFF;">Kushtia<span class="gradient-text">Express</span></span>
                </a>

                <div class="hero-badge-pill" style="margin-bottom: 20px; background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.15); color: #10B981;">
                    <span>🔐 নিরাপদ ও দ্রুত কাস্টমার পোর্টাল</span>
                </div>

                <h1 style="font-size: 2.5rem; font-weight: 900; line-height: 1.25; margin-bottom: 20px;">
                    স্বাগতম ফিরে আসার জন্য! <br/><span class="gradient-text">কুষ্টিয়া এক্সপ্রেস</span>
                </h1>

                <p style="color: #94A3B8; font-size: 1.05rem; line-height: 1.6; margin-bottom: 36px;">
                    লগইন করে আপনার প্রিয় খাবার দ্রুত অর্ডার করুন এবং লাইভ রাইডার ট্র্যাকিং উপভোগ করুন।
                </p>

                <div>
                    <div class="feature-bullet">
                        <div class="feature-bullet-icon">📦</div>
                        <span>পূর্বের সকল অর্ডার হিস্ট্রি ও ক্যাশ মেমো দেখা</span>
                    </div>
                    <div class="feature-bullet">
                        <div class="feature-bullet-icon">⚡</div>
                        <span>১-ক্লিকে ঠিকানা অটোফিল ও ইনস্ট্যান্ট চেকআউট</span>
                    </div>
                    <div class="feature-bullet">
                        <div class="feature-bullet-icon">🎁</div>
                        <span>স্পেশাল কুষ্টিয়া কুপন ও প্রমো কোড এক্সেস</span>
                    </div>
                </div>
            </div>

            <div style="font-size: 0.85rem; color: #64748B; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.1);">
                © {{ date('Y') }} KushtiaExpress • সর্বস্বত্ব সংরক্ষিত • কুষ্টিয়া, বাংলাদেশ
            </div>
        </div>

        <!-- Login Form Area -->
        <div class="auth-form-wrapper">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <a href="{{ route('home') }}" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.85rem;">
                    ← হোমপেজে ফিরে যান
                </a>
                <button id="themeToggleBtn" class="theme-toggle-btn" aria-label="Toggle Theme">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </button>
            </div>

            <div class="auth-card">
                <div style="margin-bottom: 28px;">
                    <h2 style="font-size: 2rem; font-weight: 900; margin-bottom: 8px;">কাস্টমার লগইন</h2>
                    <p style="color: var(--text-muted); font-size: 0.95rem;">
                        নতুন কাস্টমার? <a href="{{ route('signup.page') }}" style="color: var(--brand-primary); font-weight: 700;">এখানে নতুন সাইন আপ করুন</a>
                    </p>
                </div>

                <form id="standaloneLoginForm" onsubmit="handleStandaloneLogin(event)">
                    <div class="form-group">
                        <label class="form-label">মোবাইল নম্বর অথবা ইমেইল *</label>
                        <input type="text" id="loginUsername" class="form-control" required placeholder="017XXXXXXXX অথবা email@domain.com" />
                    </div>

                    <div class="form-group">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <label class="form-label" style="margin: 0;">পাসওয়ার্ড *</label>
                        </div>
                        <input type="password" id="loginPass" class="form-control" required placeholder="••••••••" />
                    </div>

                    <button type="submit" id="loginSubmitBtn" class="btn btn-primary" style="width: 100%; padding: 14px; margin-top: 12px; font-size: 1.05rem;">
                        লগইন করুন 🚀
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        async function handleStandaloneLogin(e) {
            e.preventDefault();
            const btn = document.getElementById('loginSubmitBtn');
            btn.disabled = true;
            btn.innerText = 'লগইন হচ্ছে...';

            const login_id = document.getElementById('loginUsername').value;
            const password = document.getElementById('loginPass').value;

            try {
                const res = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ login_id, password })
                });

                const data = await res.json();
                if (res.ok && data.status === 'success') {
                    window.craveApp.showToast(data.message, 'success');
                    setTimeout(() => {
                        window.location.href = "{{ route('home') }}";
                    }, 1200);
                } else {
                    window.craveApp.showToast(data.message || 'ভুল মোবাইল নম্বর/ইমেইল অথবা পাসওয়ার্ড।', 'error');
                }
            } catch (err) {
                window.craveApp.showToast('সার্ভারে সমস্যা হচ্ছে, কিছুক্ষণ পর আবার চেষ্টা করুন।', 'error');
            } finally {
                btn.disabled = false;
                btn.innerText = 'লগইন করুন 🚀';
            }
        }
    </script>
</body>
</html>
