/**
 * Laguna University Food Stalls POS & Ordering System
 * Coral/Blush Dashboard Theme Interactivity
 * Live Cart AJAX, Live Search, Category Filtering, Modal Checkout & Steppers
 */

document.addEventListener('DOMContentLoaded', function () {
    const appUrl = window.APP_URL || '';

    // ==========================================
    // 1. LIVE SEARCH & CATEGORY FILTERING
    // ==========================================
    const searchInput = document.getElementById('posFoodSearchInput');
    const categoryTiles = document.querySelectorAll('.coral-cat-tile, .pos-category-pill');
    const menuHeading = document.getElementById('coralMenuHeading');
    let currentCategory = 'all';

    function filterCards() {
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        const selected = currentCategory.toLowerCase();
        const stallSections = document.querySelectorAll('.pos-stall-section');
        let totalVisibleCards = 0;

        stallSections.forEach(section => {
            const stallName = (section.getAttribute('data-stall-name') || '').toLowerCase();
            let sectionMatchesFilter = (selected === 'all');

            if (selected === 'chick-chi-laok' && (stallName.includes('chick') || stallName.includes('laok'))) {
                sectionMatchesFilter = true;
            } else if (selected === 'chaohaus' && (stallName.includes('chao') || stallName.includes('haus'))) {
                sectionMatchesFilter = true;
            } else if (selected === 'carbonation' && stallName.includes('carbon')) {
                sectionMatchesFilter = true;
            } else if (selected === 'food' || selected === 'rice bowl') {
                sectionMatchesFilter = true;
            } else if (selected === 'drinks') {
                sectionMatchesFilter = true;
            }

            if (!sectionMatchesFilter) {
                section.style.display = 'none';
                return;
            }

            // Check individual cards inside this section
            const cards = section.querySelectorAll('.coral-food-card, .pos-food-card');
            let sectionVisibleCards = 0;

            cards.forEach(card => {
                const name = (card.getAttribute('data-name') || '').toLowerCase();
                const desc = (card.getAttribute('data-desc') || '').toLowerCase();
                const cat = (card.getAttribute('data-category') || '').toLowerCase();

                const matchesSearch = query === '' || name.includes(query) || desc.includes(query) || stallName.includes(query);
                
                let matchesCategory = true;
                if (selected === 'food' || selected === 'rice bowl') {
                    matchesCategory = (cat === 'food');
                } else if (selected === 'drinks') {
                    matchesCategory = (cat === 'drinks');
                }

                if (matchesSearch && matchesCategory) {
                    card.style.display = '';
                    sectionVisibleCards++;
                    totalVisibleCards++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (sectionVisibleCards > 0) {
                section.style.display = '';
            } else {
                section.style.display = 'none';
            }
        });

        const emptyGrid = document.querySelector('.pos-empty-grid');
        if (emptyGrid) {
            emptyGrid.style.display = totalVisibleCards === 0 ? 'block' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterCards);
    }

    categoryTiles.forEach(tile => {
        tile.addEventListener('click', function () {
            categoryTiles.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentCategory = this.getAttribute('data-category') || 'All';
            const label = this.getAttribute('data-label') || this.textContent.trim();

            if (menuHeading) {
                if (currentCategory === 'All') {
                    menuHeading.textContent = 'Popular Menu';
                } else {
                    menuHeading.textContent = label + ' Menu';
                }
            }

            filterCards();
        });
    });

    // ==========================================
    // 2. FOOD CARD OPTION PILLS TOGGLE
    // ==========================================
    document.addEventListener('click', function (e) {
        const pill = e.target.closest('.coral-opt-pill');
        if (!pill) return;
        const group = pill.closest('.coral-opt-pills');
        if (group) {
            group.querySelectorAll('.coral-opt-pill').forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            const radio = pill.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        }
    });

    // ==========================================
    // 3. CART OPERATIONS (AJAX) - CORAL BILLS
    // ==========================================
    const orderItemsList = document.getElementById('posOrderItemsList');
    const summaryItems = document.getElementById('posSummaryItems');
    const summaryDiscount = document.getElementById('posSummaryDiscount');
    const summaryTotal = document.getElementById('posSummaryTotal');
    const mobileCartBadge = document.getElementById('posMobileCartBadge');
    const modalTotal = document.getElementById('posModalTotal');

    function renderCart(data) {
        if (!orderItemsList) return;

        if (!data.items || data.items.length === 0) {
            orderItemsList.innerHTML = `
                <div class="coral-empty-bills text-center py-4 text-muted">
                    <i class="bi bi-receipt fs-2 mb-2 d-block opacity-50"></i>
                    <p class="small mb-0">No items in your bill yet.<br>Click items from the menu to add!</p>
                </div>
            `;
        } else {
            let html = '';
            data.items.forEach(item => {
                const priceFormatted = parseFloat(item.price).toFixed(2);
                html += `
                    <div class="coral-bill-item pos-order-item" data-id="${item.product_id}">
                        <div class="coral-bill-thumb-wrap">
                            <img src="${item.image_url}" alt="${escapeHtml(item.name)}" class="coral-bill-thumb" onerror="this.src='${appUrl}/assets/uploads/products/121.jpg'">
                        </div>
                        <div class="coral-bill-details">
                            <h4 class="coral-bill-name">${escapeHtml(item.name)}</h4>
                            <span class="coral-bill-meta">${escapeHtml(item.stall_name || 'Portion')}</span>
                        </div>
                        <div class="coral-bill-right">
                            <span class="coral-bill-price">₱${priceFormatted}</span>
                            <div class="coral-stepper pos-qty-stepper">
                                <button type="button" class="coral-step-btn minus pos-qty-btn" data-product-id="${item.product_id}" data-action="minus" title="Decrease">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="coral-step-num pos-qty-num">${item.quantity}</span>
                                <button type="button" class="coral-step-btn plus pos-qty-btn" data-product-id="${item.product_id}" data-action="plus" title="Increase">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            orderItemsList.innerHTML = html;
        }

        if (summaryItems) summaryItems.textContent = data.total_formatted || '₱0.00';
        if (summaryDiscount) summaryDiscount.textContent = data.discount_formatted || '₱0.00';
        if (summaryTotal) summaryTotal.textContent = data.final_total_formatted || '₱0.00';
        if (modalTotal) modalTotal.textContent = data.final_total_formatted || '₱0.00';
        if (mobileCartBadge) mobileCartBadge.textContent = data.count || 0;
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Add to cart click
    document.addEventListener('click', function (e) {
        const addBtn = e.target.closest('.pos-add-to-cart-btn, .coral-add-billing-btn, .coral-card-add-simple');
        if (!addBtn) return;
        e.preventDefault();

        const productId = addBtn.getAttribute('data-product-id') || addBtn.getAttribute('data-id');
        if (!productId) return;

        const origText = addBtn.innerHTML;
        addBtn.disabled = true;
        addBtn.innerHTML = 'Adding...';

        const formData = new FormData();
        formData.append('action', 'add');
        formData.append('product_id', productId);
        formData.append('quantity', '1');
        formData.append('ajax', '1');

        fetch(`${appUrl}/cart`, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            renderCart(data);
            showMiniToast('Added to bill!');
            addBtn.innerHTML = 'Added ✓';
            setTimeout(() => {
                addBtn.disabled = false;
                addBtn.innerHTML = origText;
            }, 700);
        })
        .catch(() => {
            window.location.href = `${appUrl}/cart/add/${productId}`;
        });
    });

    // Stepper Plus / Minus
    document.addEventListener('click', function (e) {
        const qtyBtn = e.target.closest('.coral-step-btn, .pos-qty-btn');
        if (!qtyBtn) return;
        e.preventDefault();

        const productId = qtyBtn.getAttribute('data-product-id');
        const action = qtyBtn.getAttribute('data-action');
        const itemRow = qtyBtn.closest('.coral-bill-item, .pos-order-item');
        const numElem = itemRow ? itemRow.querySelector('.coral-step-num, .pos-qty-num') : null;
        let currentQty = numElem ? parseInt(numElem.textContent, 10) : 1;

        let newQty = action === 'plus' ? currentQty + 1 : currentQty - 1;

        const formData = new FormData();
        formData.append('action', 'update');
        formData.append('product_id', productId);
        formData.append('qty', newQty);
        formData.append('ajax', '1');

        fetch(`${appUrl}/cart`, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            renderCart(data);
        });
    });

    // Clear Bills / Order click
    const clearOrderBtn = document.getElementById('posClearOrderBtn');
    if (clearOrderBtn) {
        clearOrderBtn.addEventListener('click', function () {
            if (!confirm('Clear all items from your current bill?')) return;
            const formData = new FormData();
            formData.append('action', 'clear');
            formData.append('ajax', '1');

            fetch(`${appUrl}/cart`, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                renderCart(data);
                showMiniToast('Bill cleared');
            });
        });
    }

    // ==========================================
    // 4. ORDER MODE TABS (Dine / Pick Up / Delivery)
    // ==========================================
    const modeTabs = document.querySelectorAll('.coral-mode-tab, .pos-mode-pill');
    const formOrderMode = document.getElementById('posFormOrderMode');
    const modalModeBadge = document.getElementById('posModalModeBadge');
    const dateLabel = document.getElementById('posDateLabel');
    const timeLabel = document.getElementById('posTimeLabel');

    modeTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            modeTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const mode = this.getAttribute('data-mode') || 'dine';
            if (formOrderMode) formOrderMode.value = mode;
            if (modalModeBadge) modalModeBadge.textContent = mode.toUpperCase();

            if (mode === 'dine') {
                if (dateLabel) dateLabel.innerHTML = 'Order Date <span class="text-danger">*</span>';
                if (timeLabel) timeLabel.innerHTML = 'Table # / Dining Time <span class="text-danger">*</span>';
            } else if (mode === 'pickup') {
                if (dateLabel) dateLabel.innerHTML = 'Pickup Date <span class="text-danger">*</span>';
                if (timeLabel) timeLabel.innerHTML = 'Pickup Time <span class="text-danger">*</span>';
            } else {
                if (dateLabel) dateLabel.innerHTML = 'Delivery Date <span class="text-danger">*</span>';
                if (timeLabel) timeLabel.innerHTML = 'Delivery Time <span class="text-danger">*</span>';
            }
        });
    });

    // ==========================================
    // 5. PAYMENT METHOD SELECTOR (Cash / Debit / GCash)
    // ==========================================
    const payTiles = document.querySelectorAll('.coral-pm-tile, .pos-pay-btn');
    const formPaymentMethod = document.getElementById('posFormPaymentMethod');
    const modalPayBadge = document.getElementById('posModalPayBadge');
    const proofSection = document.getElementById('posModalProofSection');
    const proofInput = document.getElementById('posModalProofInput');

    payTiles.forEach(tile => {
        tile.addEventListener('click', function () {
            payTiles.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const method = this.getAttribute('data-method') || 'cash';
            if (formPaymentMethod) formPaymentMethod.value = method;
            if (modalPayBadge) modalPayBadge.textContent = method.toUpperCase();

            const counterMsg = document.getElementById('posModalCounterMsg');
            const noteText = document.getElementById('posPaymentNoteText');

            if (method === 'ewallet') {
                if (proofSection) proofSection.style.display = 'block';
                if (proofInput) proofInput.required = true;
                if (counterMsg) counterMsg.style.display = 'none';
            } else if (method === 'debit') {
                if (proofSection) proofSection.style.display = 'none';
                if (proofInput) proofInput.required = false;
                if (counterMsg) counterMsg.style.display = 'block';
                if (noteText) noteText.textContent = 'Pay via debit card tap or swipe at the stall cashier terminal.';
            } else {
                if (proofSection) proofSection.style.display = 'none';
                if (proofInput) proofInput.required = false;
                if (counterMsg) counterMsg.style.display = 'block';
                if (noteText) noteText.textContent = 'Pay with Cash at the stall cashier upon dining or pickup.';
            }
        });
    });

    // ==========================================
    // 6. CHECKOUT BUTTON & MODAL
    // ==========================================
    const checkoutBtn = document.getElementById('posCheckoutBtn');
    const checkoutModalElem = document.getElementById('posCheckoutModal');

    if (checkoutBtn && checkoutModalElem) {
        checkoutBtn.addEventListener('click', function () {
            const hasItems = document.querySelectorAll('.coral-bill-item, .pos-order-item').length > 0;
            if (!hasItems) {
                alert('Your bill is empty. Please add items from the menu before checking out.');
                return;
            }

            // Validation: Require login before placing orders
            if (typeof window.IS_LOGGED_IN !== 'undefined' && !window.IS_LOGGED_IN) {
                alert('Kailangan po mag-log in muna upang makapag-order. Ililipat ka sa Login page.');
                window.location.href = (window.APP_URL || '') + '/login';
                return;
            }

            const modal = new bootstrap.Modal(checkoutModalElem);
            modal.show();
        });
    }

    // ==========================================
    // 7. MOBILE FLOATING CART DRAWER
    // ==========================================
    const mobileCartToggle = document.getElementById('posMobileCartToggle');
    const billsSidebar = document.getElementById('posOrderSidebar');

    if (mobileCartToggle && billsSidebar) {
        mobileCartToggle.addEventListener('click', function () {
            billsSidebar.classList.toggle('open');
        });

        document.addEventListener('click', function (e) {
            if (billsSidebar.classList.contains('open') && !billsSidebar.contains(e.target) && !mobileCartToggle.contains(e.target)) {
                billsSidebar.classList.remove('open');
            }
        });
    }

    // ==========================================
    // 8. MINI TOAST HELPER
    // ==========================================
    function showMiniToast(msg) {
        let toast = document.createElement('div');
        toast.className = 'pos-toast-popup';
        toast.textContent = msg;
        document.body.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 10);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 1800);
    }
});
