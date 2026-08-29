/**
 * KUSHTIA CRAVE EXPRESS - JAVASCRIPT APP ENGINE
 * Customized for Kushtia, Bangladesh (BDT ৳, bKash, Nagad, Cash On Delivery)
 */

class CraveApp {
    constructor() {
        this.cart = JSON.parse(localStorage.getItem('kushtia_cart') || '[]');
        this.appliedCoupon = JSON.parse(localStorage.getItem('kushtia_coupon') || 'null');
        this.activeCategory = 'all';
        this.activeDietFilters = {
            vegetarian: false,
            spicy: false,
            chef_special: false,
            under_15: false
        };
        this.currentSort = 'popular';
        this.searchQuery = '';
        this.currentCustomizingItem = null;
        this.activeOrder = JSON.parse(localStorage.getItem('kushtia_active_order') || 'null');
        this.currentUser = JSON.parse(localStorage.getItem('kushtia_user') || 'null');
        this.currentLang = localStorage.getItem('kushtia_lang') || 'bn';
        this.trackingInterval = null;

        this.init();
    }

    init() {
        this.initTheme();
        this.initLang();
        this.initAuth();
        this.renderCart();
        this.bindEvents();
        
        if (this.activeOrder) {
            const trackBtn = document.getElementById('recentOrderTrackBtn');
            if (trackBtn) trackBtn.style.display = 'inline-flex';
        }
    }

    /* ==========================================
       1. THEME TOGGLE ENGINE (DARK / LIGHT)
       ========================================== */
    initTheme() {
        const savedTheme = localStorage.getItem('kushtia_theme') || 
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        
        this.setTheme(savedTheme);

        const toggleBtn = document.getElementById('themeToggleBtn');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const current = document.documentElement.getAttribute('data-theme') || 'light';
                const nextTheme = current === 'dark' ? 'light' : 'dark';
                this.setTheme(nextTheme);
            });
        }
    }

    setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('kushtia_theme', theme);

        const toggleBtn = document.getElementById('themeToggleBtn');
        if (toggleBtn) {
            toggleBtn.innerHTML = theme === 'dark' 
                ? `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>` 
                : `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>`;
        }
    }

    /* ==========================================
       1.5. GLOBAL BILINGUAL TRANSLATION ENGINE (EN / BN)
       ========================================== */
    initLang() {
        const savedLang = localStorage.getItem('kushtia_lang') || 'bn';
        this.setLanguage(savedLang, false);

        document.querySelectorAll('.lang-toggle-btn, .lang-floating-switcher').forEach(btn => {
            btn.addEventListener('click', () => {
                const nextLang = this.currentLang === 'bn' ? 'en' : 'bn';
                this.setLanguage(nextLang, true);
            });
        });
    }

    toggleLanguage() {
        const nextLang = this.currentLang === 'bn' ? 'en' : 'bn';
        this.setLanguage(nextLang, true);
    }

    setLanguage(lang, showToast = true) {
        this.currentLang = lang;
        localStorage.setItem('kushtia_lang', lang);
        document.documentElement.setAttribute('lang', lang);

        // Update all language toggle buttons
        document.querySelectorAll('.lang-toggle-btn').forEach(btn => {
            if (lang === 'bn') {
                btn.innerHTML = `<span class="lang-flag">🇧🇩</span> <span class="lang-text">বাংলা</span> <span style="font-size:0.75rem; color:var(--text-muted);">| EN</span>`;
                btn.title = "Switch to English";
            } else {
                btn.innerHTML = `<span class="lang-flag">🇬🇧</span> <span class="lang-text">English</span> <span style="font-size:0.75rem; color:var(--text-muted);">| বাংলা</span>`;
                btn.title = "বাংলায় পরিবর্তন করুন";
            }
        });

        // Translate the whole DOM
        this.translateDOM();

        // Re-render dynamic components
        this.renderCart();
        this.renderAuthUI();
        if (typeof this.fetchFoodItems === 'function') {
            this.fetchFoodItems();
        }

        if (showToast) {
            this.showToast(lang === 'bn' ? '🇧🇩 ভাষা পরিবর্তন করা হয়েছে: বাংলা' : '🇬🇧 Language switched to: English', 'brand');
        }
    }

    translateDOM() {
        const isBn = this.currentLang === 'bn';
        const dict = this.getDictionary();

        // 1. Text elements with data-i18n
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (dict[key]) {
                el.innerHTML = dict[key];
            }
        });

        // 2. Bilingual pair elements data-en / data-bn
        document.querySelectorAll('[data-en][data-bn]').forEach(el => {
            el.innerHTML = isBn ? el.getAttribute('data-bn') : el.getAttribute('data-en');
        });

        // 3. Placeholders with data-i18n-placeholder
        document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
            const key = el.getAttribute('data-i18n-placeholder');
            if (dict[key]) {
                el.placeholder = dict[key];
            }
        });
        document.querySelectorAll('[data-placeholder-en][data-placeholder-bn]').forEach(el => {
            el.placeholder = isBn ? el.getAttribute('data-placeholder-bn') : el.getAttribute('data-placeholder-en');
        });
    }

    getDictionary() {
        const isBn = this.currentLang === 'bn';
        if (isBn) {
            return {
                'nav.home': 'হোমপেজ',
                'nav.menu': 'খাবারের মেনু',
                'nav.orders': 'অর্ডার ট্র্যাকিং',
                'nav.contact': 'যোগাযোগ',
                'nav.auth': 'সাইন আপ / লগইন',
                'nav.cart': 'কার্ট',
                'nav.track_order': 'অর্ডার ট্র্যাকিং',
                'hero.badge': 'কুষ্টিয়া শহরে মাত্র ২০ মিনিটে দ্রুততম ফুড ডেলিভারি',
                'hero.title': 'কুষ্টিয়ার খাঁটি স্বাদ <br/><span class="gradient-text">আপনার দোরগোড়ায়</span>',
                'hero.subtitle': 'বিখ্যাত কুলফি মালাই, গড়াইয়ের খাঁটি ইলিশ, শাহী বিরিয়ানি ও লোভনীয় স্ট্রিট ফুড উপভোগ করুন কুষ্টিয়ার সেরা রেস্টুরেন্ট থেকে।',
                'hero.search_placeholder': 'খাবার বা রেস্টুরেন্ট সার্চ করুন (যেমন: কুলফি, বিরিয়ানি)...',
                'hero.stat_speed': '১৫-২০ মিনিট',
                'hero.stat_speed_lbl': 'গড় ডেলিভারি সময়',
                'hero.stat_rating': '৪.৯ ★ রেটিং',
                'hero.stat_rating_lbl': '২৫,০০০+ সন্তুষ্ট ভোজনরসিক',
                'hero.stat_restaurants': '৫০+ কিচেন',
                'hero.stat_restaurants_lbl': 'কুষ্টিয়া সেরা রেস্তোরাঁ',
                'menu.section_badge': '🍽️ আমাদের এক্সক্লুসিভ মেনু',
                'menu.section_title': 'কুষ্টিয়ার লোভনীয় <span class="gradient-text">খাবারের সমাহার</span>',
                'menu.section_subtitle': 'শতভাগ ফ্রেশ উপাদান, হাইজেনিক রান্না এবং কুষ্টিয়া শহরের সেরা রেসিপিতে তৈরি।',
                'menu.tab_all': 'সব খাবার',
                'menu.tab_heritage': 'কুষ্টিয়া হেরিটেজ ও কুলফি',
                'menu.tab_biryani': 'বিরিয়ানি ও রাইস মিলস',
                'menu.tab_street': 'স্ট্রিট ফুড ও স্ন্যাক্স',
                'menu.tab_sweets': 'মিষ্টি ও ডেজার্ট',
                'menu.tab_drinks': 'বেভারেজ ও চা',
                'menu.filter_veg': '🌱 নিরামিষ / Veg',
                'menu.filter_spicy': '🌶️ মশলাদার',
                'menu.filter_chef': '👑 শেফ স্পেশাল',
                'menu.filter_budget': '⚡ বাজেট ফুড (<৳১৫০)',
                'menu.sort_popular': 'জনপ্রিয়তা অনুযায়ী',
                'menu.sort_rating': 'সর্বোচ্চ রেটিং',
                'menu.sort_price_low': 'দাম: কম থেকে বেশি',
                'menu.sort_price_high': 'দাম: বেশি থেকে কম',
                'menu.sort_prep_time': 'দ্রুততম ডেলিভারি',
                'cart.title': 'আপনার খাবারের কার্ট',
                'cart.free_del_prompt': 'আর মাত্র <strong>৳৪০০</strong> অর্ডারে পাচ্ছেন <strong>ফ্রি হোম ডেলিভারি</strong>',
                'cart.free_del_unlocked': '🎉 অভিনন্দন! আপনি <strong>ফ্রি হোম ডেলিভারি</strong> পাচ্ছেন!',
                'cart.empty_title': 'আপনার কার্ট খালি!',
                'cart.empty_desc': 'মেনু থেকে আপনার পছন্দের খাবার কার্টে যুক্ত করুন।',
                'cart.subtotal': 'মোট মূল্য',
                'cart.delivery_fee': 'ডেলিভারি চার্জ',
                'cart.free': 'ফ্রি',
                'cart.coupon_discount': 'কুপন ডিসকাউন্ট',
                'cart.vat': 'ভ্যাট ও সার্ভিস চার্জ (৫%)',
                'cart.total': 'সর্বমোট',
                'cart.checkout_btn': 'অর্ডার কনফার্ম করুন (চেকআউট)',
                'checkout.modal_title': 'চেকআউট ও ডেলিভারি তথ্য',
                'checkout.name_lbl': 'আপনার পূর্ণ নাম *',
                'checkout.phone_lbl': 'মোবাইল নম্বর (বিকাশ/নগদ/কল) *',
                'checkout.zone_lbl': 'কুষ্টিয়া ডেলিভারি এলাকা *',
                'checkout.address_lbl': 'সুনির্দিষ্ট ঠিকানা (বাসা/রোড নম্বর) *',
                'checkout.notes_lbl': 'বিশেষ কোনো নির্দেশনা (ঐচ্ছিক)',
                'checkout.payment_lbl': 'পেমেন্ট মাধ্যম নির্বাচন করুন',
                'checkout.cod': 'ক্যাশ অন ডেলিভারি',
                'checkout.bkash': 'বিকাশ / নগদ',
                'checkout.card': 'কার্ড পেমেন্ট',
                'checkout.submit_btn': 'অর্ডার কনফার্ম করুন 🚀',
                'order_page.title': 'লাইভ অর্ডার ট্র্যাকিং • KushtiaExpress',
                'order_page.hero_title': 'আপনার খাবার <span class="gradient-text">কোথায় আছে জানুন</span>',
                'order_page.search_placeholder': 'অর্ডার কোড লিখুন (যেমন: KST-9872)...',
                'order_page.search_btn': 'খুঁজুন',
                'order_page.stage_received': 'অর্ডার গৃহীত হয়েছে',
                'order_page.stage_preparing': 'রান্না চলছে',
                'order_page.stage_onway': 'রাইডার পথে আছে',
                'order_page.stage_delivered': 'ডেলিভারি সম্পন্ন',
                'auth.signup_tab': 'নতুন সাইন আপ (Sign Up)',
                'auth.login_tab': 'লগইন (Sign In)',
                'auth.name_lbl': 'আপনার পূর্ণ নাম *',
                'auth.phone_lbl': 'মোবাইল নম্বর *',
                'auth.email_lbl': 'ইমেইল ঠিকানা *',
                'auth.zone_lbl': 'কুষ্টিয়া ডেলিভারি জোন',
                'auth.address_lbl': 'বাসা/ঠিকানা (ঐচ্ছিক)',
                'auth.pass_lbl': 'পাসওয়ার্ড (কমপক্ষে ৬ অক্ষর) *',
                'auth.signup_submit': 'সাইন আপ সম্পন্ন করুন',
                'auth.login_submit': 'লগইন করুন',
            };
        } else {
            return {
                'nav.home': 'Home',
                'nav.menu': 'Food Menu',
                'nav.orders': 'Order Tracking',
                'nav.contact': 'Contact Us',
                'nav.auth': 'Sign In / Register',
                'nav.cart': 'Cart',
                'nav.track_order': 'Track Order',
                'hero.badge': 'Fastest 20-Min Food Delivery in Kushtia City',
                'hero.title': 'Authentic Taste of Kushtia <br/><span class="gradient-text">Delivered to Your Door</span>',
                'hero.subtitle': 'Enjoy famous Royal Kulfi Malai, Gorai Fresh Ilish, Shahi Biryani, and sizzling street delicacies from Kushtia’s finest kitchens.',
                'hero.search_placeholder': 'Search delicious food or restaurants (e.g. Kulfi, Biryani)...',
                'hero.stat_speed': '15-20 Mins',
                'hero.stat_speed_lbl': 'Avg. Delivery Speed',
                'hero.stat_rating': '4.9 ★ Rating',
                'hero.stat_rating_lbl': '25,000+ Happy Foodies',
                'hero.stat_restaurants': '50+ Kitchens',
                'hero.stat_restaurants_lbl': 'Kushtia Top Restaurants',
                'menu.section_badge': '🍽️ Our Exclusive Menu',
                'menu.section_title': 'Kushtia’s Delicious <span class="gradient-text">Food Catalog</span>',
                'menu.section_subtitle': '100% fresh ingredients, hygienic preparation, and authentic recipes loved across Kushtia.',
                'menu.tab_all': 'All Items',
                'menu.tab_heritage': 'Kushtia Heritage & Kulfi',
                'menu.tab_biryani': 'Biryani & Rice Meals',
                'menu.tab_street': 'Street Food & Snacks',
                'menu.tab_sweets': 'Sweets & Desserts',
                'menu.tab_drinks': 'Beverages & Tea',
                'menu.filter_veg': '🌱 Vegetarian',
                'menu.filter_spicy': '🌶️ Spicy',
                'menu.filter_chef': '👑 Chef Special',
                'menu.filter_budget': '⚡ Budget Food (<৳150)',
                'menu.sort_popular': 'Most Popular',
                'menu.sort_rating': 'Highest Rated',
                'menu.sort_price_low': 'Price: Low to High',
                'menu.sort_price_high': 'Price: High to Low',
                'menu.sort_prep_time': 'Fastest Delivery',
                'cart.title': 'Your Food Cart',
                'cart.free_del_prompt': 'Add <strong>৳400</strong> more to get <strong>FREE Home Delivery</strong>',
                'cart.free_del_unlocked': '🎉 Congratulations! You unlocked <strong>FREE Delivery</strong>!',
                'cart.empty_title': 'Your Cart is Empty!',
                'cart.empty_desc': 'Add delicious items from the menu to get started.',
                'cart.subtotal': 'Subtotal',
                'cart.delivery_fee': 'Delivery Fee',
                'cart.free': 'Free',
                'cart.coupon_discount': 'Coupon Discount',
                'cart.vat': 'VAT & Service Fee (5%)',
                'cart.total': 'Total Amount',
                'cart.checkout_btn': 'Proceed to Checkout',
                'checkout.modal_title': 'Checkout & Delivery Details',
                'checkout.name_lbl': 'Full Name *',
                'checkout.phone_lbl': 'Mobile Phone (bKash/Nagad/Call) *',
                'checkout.zone_lbl': 'Kushtia Delivery Zone *',
                'checkout.address_lbl': 'Street / House Address *',
                'checkout.notes_lbl': 'Special Cooking Instructions (Optional)',
                'checkout.payment_lbl': 'Select Payment Method',
                'checkout.cod': 'Cash on Delivery',
                'checkout.bkash': 'bKash / Nagad',
                'checkout.card': 'Debit / Credit Card',
                'checkout.submit_btn': 'Confirm & Place Order 🚀',
                'order_page.title': 'Live Order Tracking • KushtiaExpress',
                'order_page.hero_title': 'Track Exactly <span class="gradient-text">Where Your Food Is</span>',
                'order_page.search_placeholder': 'Enter Order Code (e.g. KST-9872)...',
                'order_page.search_btn': 'Track',
                'order_page.stage_received': 'Order Received',
                'order_page.stage_preparing': 'Kitchen Preparing',
                'order_page.stage_onway': 'Rider On The Way',
                'order_page.stage_delivered': 'Delivered',
                'auth.signup_tab': 'Sign Up',
                'auth.login_tab': 'Sign In',
                'auth.name_lbl': 'Full Name *',
                'auth.phone_lbl': 'Mobile Number *',
                'auth.email_lbl': 'Email Address *',
                'auth.zone_lbl': 'Kushtia Delivery Zone',
                'auth.address_lbl': 'Address (Optional)',
                'auth.pass_lbl': 'Password (Min 6 chars) *',
                'auth.signup_submit': 'Complete Sign Up',
                'auth.login_submit': 'Sign In',
            };
        }
    }

    localizeFoodItem(item) {
        if (!item) return item;
        const isBn = this.currentLang === 'bn';

        // Translation dictionary for all authentic Kushtia seeded dishes
        const bnFoodNames = {
            'Kushtia Famous Royal Shahi Kulfi Malai': 'কুষ্টিয়ার বিখ্যাত রয়্যাল শাহী কুলফি মালাই',
            'Authentic Kushtia Tiler Khaja (Crispy Sesame Crunch)': 'ঐতিহ্যবাহী কুষ্টিয়ার তিলের খাজা',
            'Gorai Special Ilish Paturi (Mustard Hilsa)': 'গড়াই স্পেশাল সর্ষে ইলিশ পাতুড়ি',
            'Kushtia Shahi Mutton Kacchi Biryani': 'কুষ্টিয়া শাহী খাসির কাচ্চি বিরিয়ানি',
            'Old Town Spicy Beef Kala Bhuna Platter': 'পুরান কুষ্টিয়া স্পাইসি বিফ কালা ভুনা প্ল্যাটার',
            'Lalon Shah Morog Polao (Heritage Recipe)': 'লালন শাহ মোরগ পোলাও (ঐতিহ্যবাহী)',
            'Mojompur Station Crispy Fuchka & Doi Chotpoti': 'মজমুপুর স্পেশাল ক্রিস্পি ফুচকা ও দই চটপটি',
            'Kushtia Ghee Baked Shahi Nimki & Singara Combo': 'ঘিয়ে ভাজা শাহী নিমকি ও গরম গরম সিঙ্গারা',
            'Chourhas Highway Special Spicy Chicken Chaap': 'চৌড়হাস হাইওয়ে স্পেশাল চিকেন চাপ ও নান',
            'Rabri Falooda Delight with Royal Kulfi Cut': 'রয়্যাল কুলফি কাটসহ শাহী রাবড়ি ফালুদা',
            'Kushtia Pure Chanar Golapjamun (Hot)': 'কুষ্টিয়ার খাঁটি ছানার গরম গোলাপজামুন',
            'Lalon Akhrar Special Masala Dudh Cha (Clay Cup)': 'মাটির ভাঁড়ে খাঁটি গাভীর দুধ চা'
        };

        const enFoodDescs = {
            'Kushtia Famous Royal Shahi Kulfi Malai': 'Authentic rich milk rabri, pistachios, cashews, and saffron crafted into famous traditional kulfi.',
            'Authentic Kushtia Tiler Khaja (Crispy Sesame Crunch)': 'Crispy wafer-thin layers made with pure sesame seeds and sugarcane jaggery.',
            'Gorai Special Ilish Paturi (Mustard Hilsa)': 'Fresh Padma/Gorai river Hilsa steamed in banana leaf with mustard & green chilies.',
            'Kushtia Shahi Mutton Kacchi Biryani': 'Fragrant Chinigura rice layered with tender mutton marinated in special secret spices.',
            'Old Town Spicy Beef Kala Bhuna Platter': 'Slow-cooked traditional caramelized beef with mustard oil and steamed parathas.',
            'Lalon Shah Morog Polao (Heritage Recipe)': 'Heritage farm chicken cooked with aromatic Chinigura rice and rich ghee.',
            'Mojompur Station Crispy Fuchka & Doi Chotpoti': '10 pieces crispy fuchka stuffed with spiced potato, boiled egg, and tangy tamarind water.',
            'Kushtia Ghee Baked Shahi Nimki & Singara Combo': 'Fresh crispy kolija singaras and flaky ghee nimkis served with coriander chutney.',
            'Chourhas Highway Special Spicy Chicken Chaap': 'Slow shallow-fried spicy whole chicken thigh served with hot butter garlic naan.',
            'Rabri Falooda Delight with Royal Kulfi Cut': 'Rose syrup falooda noodles, sweet basil seeds, rich rabri, and kulfi slices.',
            'Kushtia Pure Chanar Golapjamun (Hot)': '4 pieces hot authentic cottage cheese gulab jamuns soaked in aromatic cardamom syrup.',
            'Lalon Akhrar Special Masala Dudh Cha (Clay Cup)': 'Creamy pure cow milk tea brewed with crushed cardamom, cinnamon, and cloves in clay cup.'
        };

        const displayName = isBn && bnFoodNames[item.name] ? bnFoodNames[item.name] : item.name;
        const displayDesc = !isBn && enFoodDescs[item.name] ? enFoodDescs[item.name] : item.description;

        return {
            ...item,
            displayName,
            displayDesc
        };
    }

    /* ==========================================
       2. EVENT BINDINGS
       ========================================== */
    bindEvents() {
        const heroSearch = document.getElementById('heroSearchInput');
        if (heroSearch) {
            heroSearch.addEventListener('input', (e) => {
                this.searchQuery = e.target.value;
                this.fetchFoodItems();
            });
        }

        document.querySelectorAll('.category-tab-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                document.querySelectorAll('.category-tab-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                this.activeCategory = btn.dataset.slug || 'all';
                this.fetchFoodItems();
            });
        });

        document.querySelectorAll('.filter-pill').forEach(pill => {
            pill.addEventListener('click', () => {
                const filterKey = pill.dataset.filter;
                this.activeDietFilters[filterKey] = !this.activeDietFilters[filterKey];
                pill.classList.toggle('active', this.activeDietFilters[filterKey]);
                this.fetchFoodItems();
            });
        });

        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => {
                this.currentSort = e.target.value;
                this.fetchFoodItems();
            });
        }

        const cartTrigger = document.getElementById('cartDrawerTrigger');
        const cartClose = document.getElementById('cartDrawerClose');
        const cartOverlay = document.getElementById('cartOverlay');

        if (cartTrigger) cartTrigger.addEventListener('click', () => this.openCart());
        if (cartClose) cartClose.addEventListener('click', () => this.closeCart());
        if (cartOverlay) cartOverlay.addEventListener('click', () => this.closeCart());

        const applyCouponBtn = document.getElementById('applyCouponBtn');
        if (applyCouponBtn) {
            applyCouponBtn.addEventListener('click', () => {
                const codeInput = document.getElementById('cartCouponInput');
                if (codeInput && codeInput.value) {
                    this.applyCouponCode(codeInput.value);
                }
            });
        }

        const checkoutBtn = document.getElementById('proceedCheckoutBtn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', () => {
                if (this.cart.length === 0) {
                    this.showToast('আপনার কার্ট খালি রয়েছে!', 'error');
                    return;
                }
                this.closeCart();
                this.openCheckoutModal();
            });
        }

        const checkoutForm = document.getElementById('checkoutForm');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitOrder();
            });
        }

        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.addEventListener('click', () => {
                document.querySelectorAll('.payment-method-card').forEach(c => c.classList.remove('active'));
                card.classList.add('active');
                const input = document.getElementById('selectedPaymentMethod');
                if (input) input.value = card.dataset.method;
            });
        });

        document.querySelectorAll('.coupon-copy-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const code = btn.dataset.code;
                navigator.clipboard.writeText(code);
                this.showToast(`কুপন কোড '${code}' কপি করা হয়েছে!`, 'success');
                this.applyCouponCode(code);
            });
        });

        document.querySelectorAll('.quick-tag-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const cat = btn.dataset.category;
                const tab = document.querySelector(`.category-tab-btn[data-slug="${cat}"]`);
                if (tab) tab.click();
                const menuSection = document.getElementById('menu-catalog');
                if (menuSection) menuSection.scrollIntoView({ behavior: 'smooth' });
            });
        });
    }

    /* ==========================================
       3. AJAX FOOD SEARCH & FILTER ENGINE
       ========================================== */
    async fetchFoodItems() {
        const grid = document.getElementById('foodItemsGrid');
        if (!grid) return;

        grid.style.opacity = '0.5';

        const params = new URLSearchParams({
            category: this.activeCategory,
            search: this.searchQuery,
            sort: this.currentSort,
            vegetarian: this.activeDietFilters.vegetarian ? 1 : 0,
            spicy: this.activeDietFilters.spicy ? 1 : 0,
            chef_special: this.activeDietFilters.chef_special ? 1 : 0,
            under_15: this.activeDietFilters.under_15 ? 1 : 0,
        });

        try {
            const res = await fetch(`/api/food-items?${params.toString()}`);
            const data = await res.json();
            
            if (data.status === 'success') {
                this.renderFoodGrid(data.data);
            }
        } catch (err) {
            console.error('Error fetching food items:', err);
        } finally {
            grid.style.opacity = '1';
        }
    }

    renderFoodGrid(items) {
        const grid = document.getElementById('foodItemsGrid');
        if (!grid) return;

        const isBn = this.currentLang === 'bn';
        if (items.length === 0) {
            grid.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                    <div style="font-size: 3rem; margin-bottom: 12px;">🍲</div>
                    <h3 style="font-size: 1.4rem; margin-bottom: 8px;">${isBn ? 'কোনো খাবার খুঁজে পাওয়া যায়নি' : 'No food items found'}</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem;">${isBn ? 'অন্য কিছু লিখে সার্চ করুন অথবা ফিল্টার পরিবর্তন করুন।' : 'Try searching for something else or change filter options.'}</p>
                </div>
            `;
            return;
        }

        grid.innerHTML = items.map(rawItem => {
            const item = this.localizeFoodItem(rawItem);
            const isSpicy = item.is_spicy;
            const isVeg = item.is_vegetarian;

            return `
                <div class="food-card" data-id="${item.id}">
                    <div class="food-card-img-wrap">
                        <img src="${item.image}" alt="${item.displayName}" loading="lazy" />
                        <div class="food-card-badges">
                            ${item.is_chef_special ? `<span class="badge badge-brand">${isBn ? 'কুষ্টিয়া স্পেশাল' : 'Kushtia Special'}</span>` : ''}
                            ${isVeg ? `<span class="badge badge-success">${isBn ? 'নিরামিষ / Veg' : 'Vegetarian'}</span>` : ''}
                            ${isSpicy ? `<span class="badge badge-spicy">🌶️ ${isBn ? 'মশলাদার' : 'Spicy'}</span>` : ''}
                        </div>
                        <div class="food-rating-badge">
                            ★ <span>${item.rating.toFixed(1)}</span> (${item.reviews_count})
                        </div>
                    </div>
                    <div class="food-card-body">
                        <div class="food-meta-row">
                            <div class="food-meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <span>${item.prep_time}</span>
                            </div>
                            ${item.calories ? `
                            <div class="food-meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2c1.5 3 4 5 4 9 0 4.4-3.6 8-8 8s-8-3.6-8-8c0-4 2.5-6 4-9 1.5 3 2.5 4 4 4s2.5-1 4-4z"></path></svg>
                                <span>${item.calories} ${isBn ? 'ক্যালোরি' : 'kcal'}</span>
                            </div>` : ''}
                        </div>
                        <h4 class="food-item-name">${item.displayName}</h4>
                        <p class="food-item-desc">${item.displayDesc}</p>
                        <div class="food-card-footer">
                            <div class="price-wrap">
                                <span class="food-price">৳${item.price.toFixed(0)}</span>
                                ${item.original_price ? `<span class="original-price">৳${item.original_price.toFixed(0)}</span>` : ''}
                            </div>
                            <div class="card-action-group">
                                <button class="btn-customize" onclick="window.craveApp.openCustomizeModal(${JSON.stringify(rawItem).replace(/"/g, '&quot;')})" title="${isBn ? 'কাস্টমাইজ ও অপশন' : 'Customize & Options'}">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                </button>
                                <button class="btn-add-cart" onclick="window.craveApp.quickAddToCart(${JSON.stringify(rawItem).replace(/"/g, '&quot;')})">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    ${isBn ? 'অর্ডার' : 'Add'}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    /* ==========================================
       4. FOOD CUSTOMIZATION MODAL
       ========================================== */
    openCustomizeModal(item) {
        this.currentCustomizingItem = item;
        const modal = document.getElementById('customizeModal');
        const modalBody = document.getElementById('customizeModalBody');
        const modalTitle = document.getElementById('customizeModalTitle');

        if (!modal || !modalBody) return;

        modalTitle.innerText = `কাস্টমাইজ: ${item.name}`;

        const opts = item.customization_options || {};
        const sizes = opts.sizes || [{ name: 'Regular Serving', price: 0 }];
        const toppings = opts.toppings || [];

        modalBody.innerHTML = `
            <div style="display: flex; gap: 16px; margin-bottom: 20px; align-items: center;">
                <img src="${item.image}" alt="${item.name}" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover;" />
                <div>
                    <h4 style="font-size: 1.1rem; font-weight: 700;">${item.name}</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">মূল্য: ৳${item.price.toFixed(0)}</p>
                </div>
            </div>

            <!-- Size Selector -->
            <div style="margin-bottom: 20px;">
                <label class="form-label">পরিমাণ / সাইজ নির্বাচন করুন</label>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    ${sizes.map((s, idx) => `
                        <label style="display: flex; justify-content: space-between; align-items: center; background: var(--bg-surface-2); padding: 10px 14px; border-radius: 10px; cursor: pointer; border: 1px solid var(--border-light);">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="radio" name="customSize" value="${idx}" ${idx === 0 ? 'checked' : ''} onchange="window.craveApp.recalculateCustomPrice()" />
                                <span style="font-weight: 600; font-size: 0.9rem;">${s.name}</span>
                            </div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: var(--brand-primary);">${s.price > 0 ? `+৳${s.price.toFixed(0)}` : 'অন্তর্ভুক্ত'}</span>
                        </label>
                    `).join('')}
                </div>
            </div>

            <!-- Addons / Toppings -->
            ${toppings.length > 0 ? `
            <div style="margin-bottom: 20px;">
                <label class="form-label">অতিরিক্ত আইটেম ও স্পেশাল মসলা</label>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    ${toppings.map((top, idx) => `
                        <label style="display: flex; justify-content: space-between; align-items: center; background: var(--bg-surface-2); padding: 10px 14px; border-radius: 10px; cursor: pointer; border: 1px solid var(--border-light);">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" class="custom-topping-cb" value="${idx}" data-price="${top.price}" data-name="${top.name}" onchange="window.craveApp.recalculateCustomPrice()" />
                                <span style="font-weight: 600; font-size: 0.9rem;">${top.name}</span>
                            </div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: var(--brand-primary);">+৳${top.price.toFixed(0)}</span>
                        </label>
                    `).join('')}
                </div>
            </div>` : ''}

            <!-- Special Chef Instructions -->
            <div class="form-group">
                <label class="form-label">রান্নার বিশেষ নির্দেশিকা (ঐচ্ছিক)</label>
                <textarea id="customNotesInput" class="form-control" rows="2" placeholder="যেমন: ঝাল কম দিবেন, পেঁয়াজ বেরেস্তা বেশি দিবেন..."></textarea>
            </div>
        `;

        this.recalculateCustomPrice();
        modal.classList.add('active');
    }

    recalculateCustomPrice() {
        if (!this.currentCustomizingItem) return;
        const item = this.currentCustomizingItem;
        const opts = item.customization_options || {};
        const sizes = opts.sizes || [{ name: 'Regular Serving', price: 0 }];

        const selectedSizeIdx = document.querySelector('input[name="customSize"]:checked')?.value || 0;
        const sizePrice = sizes[selectedSizeIdx] ? sizes[selectedSizeIdx].price : 0;

        let toppingsPrice = 0;
        document.querySelectorAll('.custom-topping-cb:checked').forEach(cb => {
            toppingsPrice += parseFloat(cb.dataset.price || 0);
        });

        const singleItemTotal = item.price + sizePrice + toppingsPrice;
        const totalBtn = document.getElementById('customizeAddCartBtn');
        if (totalBtn) {
            totalBtn.innerText = `কার্টে যোগ করুন • ৳${singleItemTotal.toFixed(0)}`;
        }
    }

    confirmCustomAddToCart() {
        if (!this.currentCustomizingItem) return;
        const item = this.currentCustomizingItem;
        const opts = item.customization_options || {};
        const sizes = opts.sizes || [{ name: 'Regular', price: 0 }];

        const selectedSizeIdx = document.querySelector('input[name="customSize"]:checked')?.value || 0;
        const selectedSize = sizes[selectedSizeIdx] || { name: 'Regular', price: 0 };

        const selectedToppings = [];
        let extraPrice = selectedSize.price;

        document.querySelectorAll('.custom-topping-cb:checked').forEach(cb => {
            selectedToppings.push(cb.dataset.name);
            extraPrice += parseFloat(cb.dataset.price || 0);
        });

        const notes = document.getElementById('customNotesInput')?.value || '';

        const cartItem = {
            id: item.id,
            name: item.name,
            image: item.image,
            price: item.price + extraPrice,
            base_price: item.price,
            quantity: 1,
            selected_size: selectedSize.name,
            selected_toppings: selectedToppings,
            notes: notes,
            cart_key: `${item.id}-${selectedSize.name}-${selectedToppings.sort().join(',')}`
        };

        this.addItemToCart(cartItem);
        this.closeModal('customizeModal');
        this.showToast(`কার্টে যোগ হয়েছে: ${item.name}!`, 'success');
    }

    quickAddToCart(item) {
        const cartItem = {
            id: item.id,
            name: item.name,
            image: item.image,
            price: item.price,
            base_price: item.price,
            quantity: 1,
            selected_size: 'Regular',
            selected_toppings: [],
            notes: '',
            cart_key: `${item.id}-Regular-`
        };

        this.addItemToCart(cartItem);
        this.showToast(`কার্টে যোগ হয়েছে: ${item.name}!`, 'brand');
    }

    /* ==========================================
       5. CART DRAWER & STATE ENGINE
       ========================================== */
    addItemToCart(newItem) {
        const existing = this.cart.find(i => i.cart_key === newItem.cart_key);
        if (existing) {
            existing.quantity += 1;
        } else {
            this.cart.push(newItem);
        }
        this.saveCart();
        this.renderCart();
    }

    updateItemQuantity(cartKey, delta) {
        const item = this.cart.find(i => i.cart_key === cartKey);
        if (!item) return;

        item.quantity += delta;
        if (item.quantity <= 0) {
            this.cart = this.cart.filter(i => i.cart_key !== cartKey);
        }
        this.saveCart();
        this.renderCart();
    }

    saveCart() {
        localStorage.setItem('kushtia_cart', JSON.stringify(this.cart));
        if (this.appliedCoupon) {
            localStorage.setItem('kushtia_coupon', JSON.stringify(this.appliedCoupon));
        } else {
            localStorage.removeItem('kushtia_coupon');
        }
    }

    openCart() {
        const drawer = document.getElementById('cartDrawer');
        const overlay = document.getElementById('cartOverlay');
        if (drawer) drawer.classList.add('active');
        if (overlay) overlay.classList.add('active');
    }

    closeCart() {
        const drawer = document.getElementById('cartDrawer');
        const overlay = document.getElementById('cartOverlay');
        if (drawer) drawer.classList.remove('active');
        if (overlay) overlay.classList.remove('active');
    }

    renderCart() {
        const isBn = this.currentLang === 'bn';
        const totalCount = this.cart.reduce((sum, i) => sum + i.quantity, 0);
        const badge = document.getElementById('navCartCount');
        if (badge) {
            badge.innerText = totalCount;
            badge.style.display = totalCount > 0 ? 'flex' : 'none';
        }

        const list = document.getElementById('cartItemsList');
        if (!list) return;

        if (this.cart.length === 0) {
            list.innerHTML = `
                <div style="text-align: center; padding: 60px 20px;">
                    <div style="font-size: 3rem; margin-bottom: 12px;">🛒</div>
                    <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 6px;">${isBn ? 'আপনার কার্ট খালি' : 'Your cart is empty'}</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">${isBn ? 'কুষ্টিয়ার সুস্বাদু খাবার উপভোগ করতে মেনু দেখুন!' : 'Explore our menu for delicious Kushtia meals!'}</p>
                    <button class="btn btn-primary" onclick="window.craveApp.closeCart(); document.getElementById('menu-catalog').scrollIntoView({behavior: 'smooth'})">${isBn ? 'মেনু দেখুন' : 'Explore Menu'}</button>
                </div>
            `;
            this.updateCartSummary(0);
            return;
        }

        let subtotal = 0;

        list.innerHTML = this.cart.map(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            const localized = this.localizeFoodItem(item);

            return `
                <div class="cart-item-card">
                    <img src="${item.image}" alt="${localized.displayName || item.name}" class="cart-item-img" />
                    <div class="cart-item-details">
                        <div>
                            <div class="cart-item-title">${localized.displayName || item.name}</div>
                            <div class="cart-item-customs">
                                ${item.selected_size}${item.selected_toppings?.length ? ` • ${item.selected_toppings.join(', ')}` : ''}
                            </div>
                        </div>
                        <div class="cart-item-bottom">
                            <span style="font-weight: 800; font-size: 0.95rem; color: var(--text-main);">৳${itemTotal.toFixed(0)}</span>
                            <div class="cart-qty-picker">
                                <button class="qty-btn" onclick="window.craveApp.updateItemQuantity('${item.cart_key}', -1)">-</button>
                                <span class="qty-val">${item.quantity}</span>
                                <button class="qty-btn" onclick="window.craveApp.updateItemQuantity('${item.cart_key}', 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        this.updateCartSummary(subtotal);
    }

    updateCartSummary(subtotal) {
        const isBn = this.currentLang === 'bn';
        const freeDeliveryThreshold = 400.00;
        const progress = Math.min(100, (subtotal / freeDeliveryThreshold) * 100);
        const meterFill = document.getElementById('deliveryProgressFill');
        const meterText = document.getElementById('deliveryProgressText');

        if (meterFill && meterText) {
            meterFill.style.width = `${progress}%`;
            if (subtotal >= freeDeliveryThreshold) {
                meterText.innerHTML = isBn 
                    ? `🎉 আপনি পাচ্ছেন <strong>ফ্রি এক্সপ্রেস ডেলিভারি!</strong>` 
                    : `🎉 You unlocked <strong>FREE Express Delivery!</strong>`;
            } else {
                const diff = (freeDeliveryThreshold - subtotal).toFixed(0);
                meterText.innerHTML = isBn 
                    ? `আর মাত্র <strong>৳${diff}</strong> অর্ডারে <strong>ফ্রি ডেলিভারি</strong>` 
                    : `Add <strong>৳${diff}</strong> more for <strong>FREE Delivery</strong>`;
            }
        }

        const deliveryFee = (subtotal >= freeDeliveryThreshold || subtotal === 0) ? 0.00 : 40.00;

        let discount = 0.00;
        if (this.appliedCoupon && subtotal > 0) {
            if (this.appliedCoupon.type === 'percentage') {
                discount = (subtotal * this.appliedCoupon.value) / 100;
            } else if (this.appliedCoupon.type === 'fixed') {
                discount = Math.min(this.appliedCoupon.value, subtotal);
            } else if (this.appliedCoupon.type === 'free_delivery') {
                discount = deliveryFee;
            }
        }

        const vat = subtotal > 0 ? (subtotal - discount) * 0.05 : 0;
        const total = Math.max(0, subtotal - discount + deliveryFee + vat);

        document.getElementById('cartSubtotal').innerText = `৳${subtotal.toFixed(0)}`;
        document.getElementById('cartDeliveryFee').innerText = deliveryFee === 0 ? 'ফ্রি' : `৳${deliveryFee.toFixed(0)}`;
        document.getElementById('cartTax').innerText = `৳${vat.toFixed(0)}`;
        document.getElementById('cartTotal').innerText = `৳${total.toFixed(0)}`;

        const discountRow = document.getElementById('cartDiscountRow');
        if (discountRow) {
            if (discount > 0) {
                discountRow.style.display = 'flex';
                document.getElementById('cartDiscountVal').innerText = `-৳${discount.toFixed(0)} (${this.appliedCoupon.code})`;
            } else {
                discountRow.style.display = 'none';
            }
        }
    }

    /* ==========================================
       6. COUPON ENGINE
       ========================================== */
    async applyCouponCode(code) {
        if (!code) return;
        const cleanCode = code.trim().toUpperCase();
        const subtotal = this.cart.reduce((sum, i) => sum + (i.price * i.quantity), 0);

        try {
            const res = await fetch('/api/validate-coupon', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    code: cleanCode,
                    subtotal: subtotal,
                    delivery_fee: 40.00
                })
            });

            const data = await res.json();
            if (res.ok && data.valid) {
                this.appliedCoupon = {
                    code: cleanCode,
                    type: data.type,
                    value: data.discount,
                    title: data.title
                };
                this.saveCart();
                this.renderCart();
                this.showToast(data.message, 'success');
            } else {
                this.showToast(data.message || 'ভুল কুপন কোড', 'error');
            }
        } catch (err) {
            if (cleanCode === 'KUSHTIA50') {
                this.appliedCoupon = { code: 'KUSHTIA50', type: 'fixed', value: 50, title: '৳৫০ ছাড়' };
                this.saveCart();
                this.renderCart();
                this.showToast("কুপন 'KUSHTIA50' সক্রিয় হয়েছে!", 'success');
            } else if (cleanCode === 'GORAI') {
                this.appliedCoupon = { code: 'GORAI', type: 'free_delivery', value: 40, title: 'ফ্রি ডেলিভারি' };
                this.saveCart();
                this.renderCart();
                this.showToast("কুপন 'GORAI' সক্রিয় হয়েছে!", 'success');
            } else {
                this.showToast("ভুল কুপন কোড। KUSHTIA50 অথবা GORAI ট্রাই করুন।", 'error');
            }
        }
    }

    /* ==========================================
       7. CHECKOUT & ORDER PLACEMENT
       ========================================== */
    openCheckoutModal() {
        const subtotal = this.cart.reduce((sum, i) => sum + (i.price * i.quantity), 0);
        const freeDeliveryThreshold = 400.00;
        const deliveryFee = (subtotal >= freeDeliveryThreshold || subtotal === 0) ? 0.00 : 40.00;
        
        let discount = 0;
        if (this.appliedCoupon) {
            if (this.appliedCoupon.type === 'percentage') discount = (subtotal * this.appliedCoupon.value) / 100;
            else if (this.appliedCoupon.type === 'fixed') discount = Math.min(this.appliedCoupon.value, subtotal);
            else if (this.appliedCoupon.type === 'free_delivery') discount = deliveryFee;
        }

        const vat = (subtotal - discount) * 0.05;
        document.getElementById('checkoutOrderSummaryTotal').innerText = `৳${total.toFixed(0)}`;

        // Auto-fill customer details if logged in
        if (this.currentUser) {
            const nameInp = document.getElementById('custName');
            const phoneInp = document.getElementById('custPhone');
            const addrInp = document.getElementById('custAddress');
            if (nameInp && !nameInp.value) nameInp.value = this.currentUser.name || '';
            if (phoneInp && !phoneInp.value) phoneInp.value = this.currentUser.phone || '';
            if (addrInp && !addrInp.value) addrInp.value = this.currentUser.address || '';
        }

        this.openModal('checkoutModal');
    }

    async submitOrder() {
        const form = document.getElementById('checkoutForm');
        const submitBtn = document.getElementById('submitOrderBtn');
        if (!form || !submitBtn) return;

        submitBtn.disabled = true;
        submitBtn.innerText = 'অর্ডার কনফার্ম করা হচ্ছে...';

        const name = document.getElementById('custName').value;
        const phone = document.getElementById('custPhone').value;
        const address = document.getElementById('custAddress').value;
        const notes = document.getElementById('custNotes').value;
        const paymentMethod = document.getElementById('selectedPaymentMethod').value || 'bkash';

        const payload = {
            customer_name: name,
            customer_phone: phone,
            customer_email: 'customer@kushtia.com',
            delivery_address: address,
            notes: notes,
            payment_method: paymentMethod,
            items: this.cart,
            promo_code: this.appliedCoupon?.code || null,
            tip: 0
        };

        try {
            const res = await fetch('/api/orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json();
            if (res.ok && data.status === 'success') {
                this.cart = [];
                this.appliedCoupon = null;
                this.saveCart();
                this.renderCart();

                this.closeModal('checkoutModal');
                this.activeOrder = data.order;
                localStorage.setItem('kushtia_active_order', JSON.stringify(data.order));

                const trackBtn = document.getElementById('recentOrderTrackBtn');
                if (trackBtn) trackBtn.style.display = 'inline-flex';

                this.showToast('অর্ডার সফলভাবে সম্পন্ন হয়েছে!', 'success');
                this.openTrackingModal(data.order.order_code);
            } else {
                this.showToast(data.message || 'অর্ডার করতে সমস্যা হয়েছে।', 'error');
            }
        } catch (err) {
            console.error('Order submission error:', err);
            const mockCode = 'KUS-' + Math.floor(100000 + Math.random() * 900000);
            this.cart = [];
            this.appliedCoupon = null;
            this.saveCart();
            this.renderCart();
            this.closeModal('checkoutModal');
            this.openTrackingModal(mockCode);
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerText = 'অর্ডার কনফার্ম করুন (Confirm Order)';
        }
    }

    /* ==========================================
       8. REAL-TIME LIVE ORDER TRACKER MODAL
       ========================================== */
    openTrackingModal(orderCode) {
        const code = orderCode || this.activeOrder?.order_code || 'KUS-934812';
        const modal = document.getElementById('trackingModal');
        if (!modal) return;

        document.getElementById('trackOrderCodeDisplay').innerText = `অর্ডার #${code}`;
        this.openModal('trackingModal');

        this.pollOrderStatus(code);
    }

    async pollOrderStatus(code) {
        try {
            const res = await fetch(`/api/orders/${code}/track`);
            const data = await res.json();

            if (res.ok && data.status === 'success') {
                this.renderTrackingDetails(data.tracking, data.order);
            } else {
                this.renderSimulatedTracking();
            }
        } catch (err) {
            this.renderSimulatedTracking();
        }
    }

    renderTrackingDetails(tracking, order) {
        const eta = document.getElementById('trackingEtaMinutes');
        if (eta) eta.innerText = `${tracking.estimated_minutes_left} মিনিট`;

        const stageTitle = document.getElementById('trackingStatusStage');
        if (stageTitle) stageTitle.innerText = tracking.steps.find(s => !s.done)?.title || 'ডেলিভারি সম্পন্ন';

        const stepsWrap = document.getElementById('trackingTimelineSteps');
        if (stepsWrap) {
            stepsWrap.innerHTML = tracking.steps.map((step, idx) => `
                <div class="timeline-step ${step.done ? 'completed' : (idx === 1 ? 'active' : '')}">
                    <div class="step-dot"></div>
                    <div class="step-title">${step.title}</div>
                    <div class="step-desc">${step.description} • <span style="color: var(--brand-primary);">${step.time}</span></div>
                </div>
            `).join('');
        }
    }

    renderSimulatedTracking() {
        const stepsWrap = document.getElementById('trackingTimelineSteps');
        if (stepsWrap) {
            stepsWrap.innerHTML = `
                <div class="timeline-step completed">
                    <div class="step-dot"></div>
                    <div class="step-title">অর্ডার গৃহীত হয়েছে (Order Received)</div>
                    <div class="step-desc">কুষ্টিয়া রেস্টুরেন্টে আপনার অর্ডারটি গৃহীত হয়েছে • এইমাত্র</div>
                </div>
                <div class="timeline-step active">
                    <div class="step-dot"></div>
                    <div class="step-title">রান্না চলছে (Kitchen Preparing)</div>
                    <div class="step-desc">টাটকা ও গরম গরম খাবার প্রস্তুত করা হচ্ছে</div>
                </div>
                <div class="timeline-step">
                    <div class="step-dot"></div>
                    <div class="step-title">রাইডার পথে আছে (Rider On the Way)</div>
                    <div class="step-desc">নিরাপদ থার্মাল বক্সে রাইডার কুষ্টিয়ার রাস্তায় রয়েছে</div>
                </div>
                <div class="timeline-step">
                    <div class="step-dot"></div>
                    <div class="step-title">ডেলিভারি সম্পন্ন (Delivered)</div>
                    <div class="step-desc">আপনার দোরগোড়ায় খাবার হস্তান্তর করা হয়েছে</div>
                </div>
            `;
        }
    }

    /* ==========================================
       9. MODAL & TOAST HELPERS
       ========================================== */
    openModal(modalId) {
        const m = document.getElementById(modalId);
        if (m) m.classList.add('active');
    }

    closeModal(modalId) {
        const m = document.getElementById(modalId);
        if (m) m.classList.remove('active');
    }

    /* ==========================================
       10. CUSTOMER AUTHENTICATION & PROFILE ENGINE
       ========================================== */
    async initAuth() {
        try {
            const res = await fetch('/api/auth/me');
            const data = await res.json();
            if (data.logged_in && data.user) {
                this.currentUser = data.user;
                localStorage.setItem('kushtia_user', JSON.stringify(data.user));
            } else {
                this.currentUser = null;
                localStorage.removeItem('kushtia_user');
            }
        } catch (e) {
            // Keep local cached user if offline
        }
        this.renderAuthUI();
    }

    renderAuthUI() {
        const guestBtns = document.querySelectorAll('.auth-guest-view');
        const userBtns = document.querySelectorAll('.auth-user-view');
        const userNames = document.querySelectorAll('.auth-user-name');
        const userAvatars = document.querySelectorAll('.auth-user-initial');

        if (this.currentUser) {
            guestBtns.forEach(el => el.style.display = 'none');
            userBtns.forEach(el => el.style.display = 'inline-flex');
            userNames.forEach(el => el.innerText = this.currentUser.name);
            const initial = (this.currentUser.name || 'U').charAt(0).toUpperCase();
            userAvatars.forEach(el => el.innerText = initial);
        } else {
            guestBtns.forEach(el => el.style.display = 'inline-flex');
            userBtns.forEach(el => el.style.display = 'none');
        }
    }

    openAuthModal(tab = 'register') {
        this.switchAuthTab(tab);
        this.openModal('authModal');
    }

    switchAuthTab(tab) {
        const regTabBtn = document.getElementById('tabBtnRegister');
        const loginTabBtn = document.getElementById('tabBtnLogin');
        const regForm = document.getElementById('authRegisterForm');
        const loginForm = document.getElementById('authLoginForm');

        if (tab === 'register') {
            if (regTabBtn) regTabBtn.classList.add('active');
            if (loginTabBtn) loginTabBtn.classList.remove('active');
            if (regForm) regForm.style.display = 'block';
            if (loginForm) loginForm.style.display = 'none';
        } else {
            if (loginTabBtn) loginTabBtn.classList.add('active');
            if (regTabBtn) regTabBtn.classList.remove('active');
            if (loginForm) loginForm.style.display = 'block';
            if (regForm) regForm.style.display = 'none';
        }
    }

    async handleRegister(e) {
        e.preventDefault();
        const submitBtn = document.getElementById('authRegisterSubmitBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerText = 'অ্যাকাউন্ট তৈরি হচ্ছে...';
        }

        const name = document.getElementById('regName')?.value;
        const email = document.getElementById('regEmail')?.value;
        const phone = document.getElementById('regPhone')?.value;
        const delivery_zone = document.getElementById('regZone')?.value;
        const address = document.getElementById('regAddress')?.value;
        const password = document.getElementById('regPassword')?.value;

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
                this.currentUser = data.user;
                localStorage.setItem('kushtia_user', JSON.stringify(data.user));
                this.renderAuthUI();
                this.closeModal('authModal');
                this.showToast(data.message, 'success');
            } else {
                this.showToast(data.message || 'নিবন্ধন ব্যর্থ হয়েছে। তথ্য যাচাই করুন।', 'error');
            }
        } catch (err) {
            this.showToast('সার্ভারে সমস্যা হচ্ছে, কিছুক্ষণ পর আবার চেষ্টা করুন।', 'error');
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerText = 'সাইন আপ সম্পন্ন করুন';
            }
        }
    }

    async handleLogin(e) {
        e.preventDefault();
        const submitBtn = document.getElementById('authLoginSubmitBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerText = 'লগইন হচ্ছে...';
        }

        const login_id = document.getElementById('loginId')?.value;
        const password = document.getElementById('loginPassword')?.value;

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
                this.currentUser = data.user;
                localStorage.setItem('kushtia_user', JSON.stringify(data.user));
                this.renderAuthUI();
                this.closeModal('authModal');
                this.showToast(data.message, 'success');
            } else {
                this.showToast(data.message || 'ভুল মোবাইল নম্বর/ইমেইল অথবা পাসওয়ার্ড।', 'error');
            }
        } catch (err) {
            this.showToast('সার্ভারে সমস্যা হচ্ছে, কিছুক্ষণ পর আবার চেষ্টা করুন।', 'error');
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerText = 'লগইন করুন';
            }
        }
    }

    async handleLogout() {
        try {
            await fetch('/api/auth/logout', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
        } catch (e) {}

        this.currentUser = null;
        localStorage.removeItem('kushtia_user');
        this.renderAuthUI();
        this.showToast('আপনি সফলভাবে লগআউট করেছেন।', 'brand');
        const menu = document.getElementById('authUserDropdownMenu');
        if (menu) menu.classList.remove('active');
    }

    toggleUserDropdown() {
        const menu = document.getElementById('authUserDropdownMenu');
        if (menu) menu.classList.toggle('active');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.craveApp = new CraveApp();
});
