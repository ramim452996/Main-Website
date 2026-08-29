<!DOCTYPE html>
<html lang="bn" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>অ্যাডমিন কন্ট্রোল প্যানেল (Admin Panel) • KushtiaExpress</title>
    <meta name="description" content="কুষ্টিয়া এক্সপ্রেসের প্রশাসনিক ড্যাশবোর্ড - সকল অর্ডার, কাস্টমার, মেনু এবং আয়ের হিসাব দেখুন।">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body, button, input, select, textarea {
            font-family: 'Hind Siliguri', 'Plus Jakarta Sans', sans-serif;
        }
        h1, h2, h3, h4, h5, h6, .brand-logo, .stat-value {
            font-family: 'Outfit', 'Hind Siliguri', sans-serif;
        }
        .admin-layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
            background: var(--bg-body);
        }
        .admin-sidebar {
            background: var(--bg-surface);
            border-right: 1px solid var(--border-light);
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-muted);
            cursor: pointer;
            transition: var(--transition-smooth);
            margin-bottom: 6px;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }
        .admin-nav-item:hover {
            background: var(--bg-surface-2);
            color: var(--brand-primary);
        }
        .admin-nav-item.active {
            background: var(--brand-gradient);
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(255, 84, 46, 0.3);
        }
        .admin-main-content {
            padding: 32px 40px;
            overflow-y: auto;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }
        .admin-stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        .admin-stat-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            border-radius: 18px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 18px;
            transition: var(--transition-smooth);
        }
        .admin-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: var(--brand-primary);
        }
        .stat-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .admin-table-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            border-radius: 20px;
            padding: 24px;
            box-shadow: var(--shadow-md);
            margin-bottom: 32px;
        }
        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 16px;
        }
        .admin-table th {
            text-align: left;
            padding: 14px 16px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border-light);
            background: var(--bg-surface-2);
        }
        .admin-table th:first-child { border-top-left-radius: 12px; }
        .admin-table th:last-child { border-top-right-radius: 12px; }
        .admin-table td {
            padding: 16px;
            font-size: 0.92rem;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }
        .admin-table tr:hover td {
            background: var(--bg-surface-2);
        }
        .status-select {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            border: 1px solid var(--border-light);
            background: var(--bg-surface);
            color: var(--text-main);
            cursor: pointer;
        }
        .tab-section-content {
            display: none;
        }
        .tab-section-content.active {
            display: block;
        }
        @media(max-width: 992px) {
            .admin-layout {
                grid-template-columns: 1fr;
            }
            .admin-sidebar {
                position: relative;
                height: auto;
            }
            .admin-main-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="admin-layout">
        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar">
            <div>
                <a href="{{ route('home') }}" class="brand-logo" style="margin-bottom: 30px; display: inline-flex;">
                    <div class="logo-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                    </div>
                    <span>Kushtia<span class="gradient-text">Admin</span></span>
                </a>

                <div style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 12px; padding-left: 12px;">
                    ম্যানেজমেন্ট ও কন্ট্রোল
                </div>

                <nav>
                    <button class="admin-nav-item active" onclick="switchAdminTab('orders', this)">
                        <span>📦</span> <span>অর্ডারসমূহ (Orders)</span>
                    </button>
                    <button class="admin-nav-item" onclick="switchAdminTab('customers', this)">
                        <span>👥</span> <span>কাস্টমার তালিকা (Customers)</span>
                    </button>
                    <button class="admin-nav-item" onclick="switchAdminTab('menu', this)">
                        <span>🍽️</span> <span>খাবারের মেনু (Menu Items)</span>
                    </button>
                    <button class="admin-nav-item" onclick="switchAdminTab('analytics', this)">
                        <span>📊</span> <span>আয় ও রিপোর্ট (Analytics)</span>
                    </button>
                </nav>
            </div>

            <div>
                <div style="padding: 16px; background: var(--bg-surface-2); border-radius: 14px; margin-bottom: 16px;">
                    <div style="font-size: 0.75rem; color: var(--text-muted);">লগইন করা অ্যাডমিন</div>
                    <div style="font-weight: 800; font-size: 0.95rem; color: var(--brand-primary);">Super Admin</div>
                    <div style="font-size: 0.75rem; color: #10B981; font-weight: 700;">● সিস্টেম অনলাইন</div>
                </div>

                <a href="{{ route('home') }}" class="btn btn-secondary" style="width: 100%; justify-content: center; font-size: 0.85rem;">
                    ← মূল ওয়েবসাইটে যান
                </a>
            </div>
        </aside>

        <!-- Main Dashboard Workspace -->
        <main class="admin-main-content">
            <!-- Header Bar -->
            <div class="admin-header">
                <div>
                    <h1 style="font-size: 2rem; font-weight: 900; margin-bottom: 4px;">অ্যাডমিন কন্ট্রোল সেন্টার</h1>
                    <p style="color: var(--text-muted); font-size: 0.95rem;">কুষ্টিয়া এক্সপ্রেসের সকল ডেলিভারি, কাস্টমার সাইন-আপ ও আয়ের লাইভ পরিসংখ্যান।</p>
                </div>

                <div style="display: flex; align-items: center; gap: 12px;">
                    <!-- Global Language Switcher -->
                    <button type="button" class="lang-toggle-btn" onclick="window.craveApp.toggleLanguage()" title="Switch Language / ভাষা পরিবর্তন">
                        <span class="lang-flag">🇧🇩</span>
                        <span class="lang-text">বাংলা</span>
                        <span style="font-size:0.75rem; color:var(--text-muted);">| EN</span>
                    </button>

                    <!-- Theme Toggle -->
                    <button id="themeToggleBtn" class="theme-toggle-btn" aria-label="Toggle Theme">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                    </button>

                    <!-- Refresh Button -->
                    <button class="btn btn-primary" onclick="location.reload()" title="রিফ্রেশ করুন">
                        🔄 রিফ্রেশ
                    </button>
                </div>
            </div>

            <!-- KPI Summary Cards -->
            <div class="admin-stat-grid">
                <div class="admin-stat-card">
                    <div class="stat-icon-wrap" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">৳</div>
                    <div>
                        <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700;">সর্বমোট বিক্রি (Revenue)</div>
                        <div class="stat-value" style="font-size: 1.8rem; font-weight: 900; color: #10B981;">৳{{ number_format($totalRevenue, 0) }}</div>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon-wrap" style="background: rgba(255, 84, 46, 0.15); color: var(--brand-primary);">📦</div>
                    <div>
                        <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700;">মোট অর্ডার (Total Orders)</div>
                        <div class="stat-value" style="font-size: 1.8rem; font-weight: 900;">{{ $totalOrders }} টি</div>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon-wrap" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B;">🛵</div>
                    <div>
                        <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700;">লাইভ ডেলিভারি (Active)</div>
                        <div class="stat-value" style="font-size: 1.8rem; font-weight: 900; color: #F59E0B;">{{ $activeOrders }} টি</div>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon-wrap" style="background: rgba(59, 130, 246, 0.15); color: #3B82F6;">👥</div>
                    <div>
                        <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700;">রেজিস্টার্ড কাস্টমার</div>
                        <div class="stat-value" style="font-size: 1.8rem; font-weight: 900;">{{ $totalCustomers }} জন</div>
                    </div>
                </div>
            </div>

            <!-- TAB 1: ORDERS MANAGEMENT -->
            <section id="tab-orders" class="tab-section-content active">
                <div class="admin-table-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
                        <div>
                            <h3 style="font-size: 1.3rem; font-weight: 800;">📦 কাস্টমার অর্ডার তালিকা ও ডেলিভারি স্ট্যাটাস</h3>
                            <p style="color: var(--text-muted); font-size: 0.85rem;">স্ট্যাটাস পরিবর্তন করলেই গ্রাহকের কাছে লাইভ ট্র্যাকিং আপডেট হবে।</p>
                        </div>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>অর্ডার কোড</th>
                                    <th>গ্রাহকের নাম ও ফোন</th>
                                    <th>ডেলিভারি ঠিকানা</th>
                                    <th>আইটেম বিবরণ</th>
                                    <th>সর্বমোট মূল্য</th>
                                    <th>পেমেন্ট</th>
                                    <th>বর্তমান স্ট্যাটাস</th>
                                    <th>অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <span class="badge badge-brand" style="font-family: monospace; font-size: 0.85rem;">
                                            #{{ $order->order_code }}
                                        </span>
                                        <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 4px;">
                                            {{ $order->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700;">{{ $order->customer_name }}</div>
                                        <div style="font-size: 0.8rem; color: var(--brand-primary); font-weight: 600;">
                                            📞 <a href="tel:{{ $order->customer_phone }}" style="color: inherit;">{{ $order->customer_phone }}</a>
                                        </div>
                                    </td>
                                    <td style="max-width: 200px; font-size: 0.85rem;">
                                        📍 {{ $order->delivery_address }}
                                    </td>
                                    <td style="font-size: 0.85rem;">
                                        @if(is_array($order->items))
                                            @foreach($order->items as $itm)
                                                <div>• {{ $itm['quantity'] ?? 1 }}x {{ $itm['name'] ?? 'Dish' }}</div>
                                            @endforeach
                                        @else
                                            <span>{{ is_string($order->items) ? Str::limit($order->items, 40) : 'খাবারের তালিকা' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span style="font-weight: 800; color: var(--text-main); font-size: 1.05rem;">
                                            ৳{{ number_format($order->total, 0) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge" style="text-transform: uppercase; background: var(--bg-surface-2);">
                                            {{ $order->payment_method }}
                                        </span>
                                    </td>
                                    <td>
                                        <select class="status-select" onchange="updateOrderStatus({{ $order->id }}, this.value)">
                                            <option value="received" {{ $order->status === 'received' ? 'selected' : '' }}>📥 অর্ডারের প্রস্তুতি (Received)</option>
                                            <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>🍳 রান্না চলছে (Preparing)</option>
                                            <option value="on_the_way" {{ $order->status === 'on_the_way' ? 'selected' : '' }}>🛵 রাইডার পথে আছে (On The Way)</option>
                                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>✅ ডেলিভারি সম্পন্ন (Delivered)</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>✕ বাতিল (Cancelled)</option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="{{ route('order.bn') }}?code={{ $order->order_code }}" target="_blank" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.8rem;" title="লাইভ ট্র্যাকিং পেজ দেখুন">
                                            👁️ ট্র্যাক
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                        এখনও কোনো অর্ডার পাওয়া যায়নি।
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- TAB 2: CUSTOMERS DIRECTORY -->
            <section id="tab-customers" class="tab-section-content">
                <div class="admin-table-card">
                    <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 4px;">👥 নিবন্ধিত গ্রাহক তালিকা (Customer Accounts)</h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 16px;">ওয়েবসাইট থেকে সাইন আপ করা সকল গ্রাহকদের সংরক্ষিত তথ্য ও ফোন নম্বর।</p>

                    <div style="overflow-x: auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>গ্রাহকের নাম (Name)</th>
                                    <th>মোবাইল নম্বর (Phone)</th>
                                    <th>ইমেইল (Email)</th>
                                    <th>কুষ্টিয়া জোন (Zone)</th>
                                    <th>সংরক্ষিত ঠিকানা (Address)</th>
                                    <th>নিবন্ধনের সময়</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $cust)
                                <tr>
                                    <td><strong>#{{ $cust->id }}</strong></td>
                                    <td>
                                        <div style="font-weight: 700;">{{ $cust->name }}</div>
                                    </td>
                                    <td>
                                        <span style="color: var(--brand-primary); font-weight: 700;">{{ $cust->phone }}</span>
                                    </td>
                                    <td>{{ $cust->email }}</td>
                                    <td>
                                        <span class="badge badge-brand">{{ $cust->delivery_zone ?: 'মজমুপুর সেন্ট্রাল' }}</span>
                                    </td>
                                    <td>{{ $cust->address ?: 'N/A' }}</td>
                                    <td style="font-size: 0.85rem; color: var(--text-muted);">
                                        {{ $cust->created_at ? $cust->created_at->format('d M Y, h:i A') : 'N/A' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                        কোনো নিবন্ধিত কাস্টমার অ্যাকাউন্ট নেই।
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- TAB 3: MENU ITEMS CATALOG -->
            <section id="tab-menu" class="tab-section-content">
                <div class="admin-table-card">
                    <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 4px;">🍽️ খাবারের মেনু ও রেস্তোরাঁ ক্যাটালগ</h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 16px;">কুষ্টিয়া এক্সপ্রেসের সকল সক্রিয় খাবার ও মিষ্টান্ন সামগ্রী।</p>

                    <div style="overflow-x: auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ছবি</th>
                                    <th>খাবারের নাম</th>
                                    <th>ক্যাটাগরি</th>
                                    <th>মূল্য</th>
                                    <th>রেটিং</th>
                                    <th>প্রস্তুতি সময়</th>
                                    <th>স্ট্যাটাস</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($menuItems as $item)
                                <tr>
                                    <td>
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" style="width: 50px; height: 50px; border-radius: 10px; object-fit: cover;" />
                                    </td>
                                    <td>
                                        <div style="font-weight: 700;">{{ $item->name }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ Str::limit($item->description, 50) }}</div>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: var(--bg-surface-2);">
                                            {{ $item->category->name ?? 'Special' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-weight: 800; color: var(--text-main);">৳{{ number_format($item->price, 0) }}</span>
                                    </td>
                                    <td>★ {{ number_format($item->rating, 1) }}</td>
                                    <td>{{ $item->prep_time }}</td>
                                    <td>
                                        <span class="badge badge-success">সক্রিয় (Active)</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                        কোনো মেনু আইটেম পাওয়া যায়নি।
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- TAB 4: ANALYTICS REPORT -->
            <section id="tab-analytics" class="tab-section-content">
                <div class="admin-table-card">
                    <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 8px;">📊 কুষ্টিয়া সেলস ও ডেলিভারি রিপোর্ট</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 24px;">পৌরসভা, মজমুপুর, কোর্টপাড়া ও ইসলামী বিশ্ববিদ্যালয় ক্যাম্পাসের ডেলিভারি পরিসংখ্যান।</p>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                        <div style="padding: 20px; background: var(--bg-surface-2); border-radius: 14px; border: 1px solid var(--border-light);">
                            <div style="font-weight: 800; font-size: 1.1rem; margin-bottom: 6px;">📍 মজমুপুর ও এন এস রোড জোন</div>
                            <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 12px;">কুষ্টিয়া শহরের সর্বাধিক বিক্রিত খাদ্য ডেলিভারি এলাকা</div>
                            <div style="font-size: 1.4rem; font-weight: 900; color: var(--brand-primary);">৬৫% মোট অর্ডার</div>
                        </div>

                        <div style="padding: 20px; background: var(--bg-surface-2); border-radius: 14px; border: 1px solid var(--border-light);">
                            <div style="font-weight: 800; font-size: 1.1rem; margin-bottom: 6px;">🎓 ইসলামী বিশ্ববিদ্যালয় (IU) ক্যাম্পাস</div>
                            <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 12px;">শান্তিডাঙ্গা ক্যাম্পাস এক্সপ্রেস ফুড সার্ভিস</div>
                            <div style="font-size: 1.4rem; font-weight: 900; color: #3B82F6;">২০% মোট অর্ডার</div>
                        </div>

                        <div style="padding: 20px; background: var(--bg-surface-2); border-radius: 14px; border: 1px solid var(--border-light);">
                            <div style="font-weight: 800; font-size: 1.1rem; margin-bottom: 6px;">🌉 কোর্টপাড়া, থানা মোড় ও চৌড়হাস</div>
                            <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 12px;">কুষ্টিয়া সদর আবাসিক এলাকা</div>
                            <div style="font-size: 1.4rem; font-weight: 900; color: #10B981;">১৫% মোট অর্ডার</div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function switchAdminTab(tabName, el) {
            document.querySelectorAll('.admin-nav-item').forEach(btn => btn.classList.remove('active'));
            el.classList.add('active');

            document.querySelectorAll('.tab-section-content').forEach(sec => sec.classList.remove('active'));
            const target = document.getElementById(`tab-${tabName}`);
            if (target) target.classList.add('active');
        }

        async function updateOrderStatus(orderId, newStatus) {
            try {
                const res = await fetch(`/api/admin/orders/${orderId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                const data = await res.json();
                if (res.ok && data.status === 'success') {
                    window.craveApp.showToast(data.message, 'success');
                } else {
                    window.craveApp.showToast('স্ট্যাটাস আপডেট ব্যর্থ হয়েছে।', 'error');
                }
            } catch (e) {
                window.craveApp.showToast('সার্ভার সমস্যা, কিছুক্ষণ পর চেষ্টা করুন।', 'error');
            }
        }
    </script>
</body>
</html>
