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
        this.trackingInterval = null;

        this.init();
    }

    init() {
        this.initTheme();
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

        if (items.length === 0) {
            grid.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                    <div style="font-size: 3rem; margin-bottom: 12px;">🍲</div>
                    <h3 style="font-size: 1.4rem; margin-bottom: 8px;">কোনো খাবার খুঁজে পাওয়া যায়নি</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem;">অন্য কিছু লিখে সার্চ করুন অথবা ফিল্টার পরিবর্তন করুন।</p>
                </div>
            `;
            return;
        }

        grid.innerHTML = items.map(item => {
            const isSpicy = item.is_spicy;
            const isVeg = item.is_vegetarian;

            return `
                <div class="food-card" data-id="${item.id}">
                    <div class="food-card-img-wrap">
                        <img src="${item.image}" alt="${item.name}" loading="lazy" />
                        <div class="food-card-badges">
                            ${item.is_chef_special ? `<span class="badge badge-brand">কুষ্টিয়া স্পেশাল</span>` : ''}
                            ${isVeg ? `<span class="badge badge-success">নিরামিষ / Veg</span>` : ''}
                            ${isSpicy ? `<span class="badge badge-spicy">🌶️ ঝাল</span>` : ''}
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
                                <span>${item.calories} ক্যালোরি</span>
                            </div>` : ''}
                        </div>
                        <h4 class="food-item-name">${item.name}</h4>
                        <p class="food-item-desc">${item.description}</p>
                        <div class="food-card-footer">
                            <div class="price-wrap">
                                <span class="food-price">৳${item.price.toFixed(0)}</span>
                                ${item.original_price ? `<span class="original-price">৳${item.original_price.toFixed(0)}</span>` : ''}
                            </div>
                            <div class="card-action-group">
                                <button class="btn-customize" onclick="window.craveApp.openCustomizeModal(${JSON.stringify(item).replace(/"/g, '&quot;')})" title="কাস্টমাইজ ও অপশন">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                </button>
                                <button class="btn-add-cart" onclick="window.craveApp.quickAddToCart(${JSON.stringify(item).replace(/"/g, '&quot;')})">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    অর্ডার
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
                    <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 6px;">আপনার কার্ট খালি</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">কুষ্টিয়ার সুস্বাদু খাবার উপভোগ করতে মেনু দেখুন!</p>
                    <button class="btn btn-primary" onclick="window.craveApp.closeCart(); document.getElementById('menu-catalog').scrollIntoView({behavior: 'smooth'})">মেনু দেখুন</button>
                </div>
            `;
            this.updateCartSummary(0);
            return;
        }

        let subtotal = 0;

        list.innerHTML = this.cart.map(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            return `
                <div class="cart-item-card">
                    <img src="${item.image}" alt="${item.name}" class="cart-item-img" />
                    <div class="cart-item-details">
                        <div>
                            <div class="cart-item-title">${item.name}</div>
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
        const freeDeliveryThreshold = 400.00;
        const progress = Math.min(100, (subtotal / freeDeliveryThreshold) * 100);
        const meterFill = document.getElementById('deliveryProgressFill');
        const meterText = document.getElementById('deliveryProgressText');

        if (meterFill && meterText) {
            meterFill.style.width = `${progress}%`;
            if (subtotal >= freeDeliveryThreshold) {
                meterText.innerHTML = `🎉 আপনি পাচ্ছেন <strong>ফ্রি এক্সপ্রেস ডেলিভারি!</strong>`;
            } else {
                const diff = (freeDeliveryThreshold - subtotal).toFixed(0);
                meterText.innerHTML = `আর মাত্র <strong>৳${diff}</strong> অর্ডারে <strong>ফ্রি ডেলিভারি</strong>`;
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
        const total = Math.max(0, subtotal - discount + deliveryFee + vat);

        document.getElementById('checkoutOrderSummaryTotal').innerText = `৳${total.toFixed(0)}`;
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

    showToast(message, type = 'brand') {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <span>${type === 'success' ? '✓' : (type === 'error' ? '✕' : '★')}</span>
            <span>${message}</span>
        `;

        container.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(15px) scale(0.9)';
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.craveApp = new CraveApp();
});
