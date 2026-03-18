/**
 * Customer Menu JS — Aurora Cafe
 */

let cart = [];
let currentItem = null;

document.addEventListener('DOMContentLoaded', () => {
    checkLocation();
    loadCart();
    setupCategoryNav();
    setupSearch();
    updateCartUI();
});

function checkLocation() {
    const overlay = document.getElementById('locationOverlay');
    const wrapper = document.getElementById('menuWrapper');
    const btn = document.getElementById('btnAllowLocation');
    const errorEl = document.getElementById('locationError');

    btn.addEventListener('click', () => {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> ĐANG XÁC THỰC...';
        btn.disabled = true;

        if (!navigator.geolocation) {
            showLocError("Trình duyệt của bạn không hỗ trợ định vị. Vui lòng sử dụng trình duyệt khác (Chrome, Safari).");
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                const distance = calculateDistance(
                    userLat, userLng, 
                    CUSTOMER_CONFIG.restaurantCoords.lat, 
                    CUSTOMER_CONFIG.restaurantCoords.lng
                );



                if (distance > CUSTOMER_CONFIG.maxDistance) {
                    showLocError(`Bạn đang ở quá xa nhà hàng (${Math.round(distance)}m). Vui lòng quét mã tại bàn để đặt món.`);
                } else {
                    // Success!
                    overlay.style.transition = 'opacity 0.5s';
                    overlay.style.opacity = '0';
                    setTimeout(() => {
                        overlay.style.display = 'none';
                        wrapper.style.display = 'block';
                    }, 500);
                }
            },
            (err) => {
                let msg = "Không thể lấy vị trí. ";
                switch(err.code) {
                    case err.PERMISSION_DENIED: msg += "Vui lòng cho phép truy cập vị trí trong cài đặt trình duyệt."; break;
                    case err.POSITION_UNAVAILABLE: msg += "Thông tin vị trí không khả dụng."; break;
                    case err.TIMEOUT: msg += "Yêu cầu lấy vị trí hết hạn."; break;
                    default: msg += "Lỗi không xác định.";
                }
                showLocError(msg);
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    });

    function showLocError(msg) {
        errorEl.textContent = msg;
        errorEl.style.display = 'block';
        btn.innerHTML = '<i class="fas fa-redo me-2"></i> THỬ LẠI';
        btn.disabled = false;
    }
}

/**
 * Calculates distance in meters using Haversine formula
 */
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371e3; // Earth radius in meters
    const φ1 = lat1 * Math.PI / 180;
    const φ2 = lat2 * Math.PI / 180;
    const Δφ = (lat2 - lat1) * Math.PI / 180;
    const Δλ = (lon2 - lon1) * Math.PI / 180;

    const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
              Math.cos(φ1) * Math.cos(φ2) *
              Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    return R * c;
}

function setupCategoryNav() {
    const pills = document.querySelectorAll('.cat-pill');
    pills.forEach(pill => {
        pill.addEventListener('click', (e) => {
            // Smooth scroll to section handled by browser if using href="#id"
            // But we want to ensure the pills update
            pills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
        });
    });

    // Intersection Observer to update active category on scroll
    const sections = document.querySelectorAll('.menu-section');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.id.replace('cat-', '');
                pills.forEach(p => {
                    if (p.dataset.category === id) {
                        p.classList.add('active');
                        // Scroll pill into view horizontally
                        p.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                    } else {
                        p.classList.remove('active');
                    }
                });
            }
        });
    }, { threshold: 0.2 });

    sections.forEach(s => observer.observe(s));
}

function setupSearch() {
    const searchInput = document.getElementById('menuSearch');
    const typeBtns = document.querySelectorAll('.type-btn');
    const categoryPills = document.querySelectorAll('.cat-pill');
    
    if (!searchInput) return;

    const filterMenu = () => {
        const query = searchInput.value.toLowerCase().trim();
        const activeType = document.querySelector('.type-btn.active').dataset.type;
        const cards = document.querySelectorAll('.menu-item-card');
        
        cards.forEach(card => {
            const name = card.dataset.name.toLowerCase();
            const nameEn = (card.dataset.nameEn || '').toLowerCase();
            const type = card.dataset.type;
            
            const isMatchText = name.includes(query) || nameEn.includes(query);
            const isMatchType = (activeType === 'all' || type === activeType);
            
            card.style.display = (isMatchText && isMatchType) ? 'flex' : 'none';
        });

        // Hide/Show sections and category pills
        document.querySelectorAll('.menu-section').forEach(section => {
            const sectionType = section.dataset.type;
            const hasVisibleItems = Array.from(section.querySelectorAll('.menu-item-card'))
                .some(card => card.style.display !== 'none');
            
            const shouldShowSection = hasVisibleItems && (activeType === 'all' || sectionType === activeType);
            section.style.display = shouldShowSection ? 'block' : 'none';
            
            // Sync category pills visibility
            const catId = section.id.replace('cat-', '');
            categoryPills.forEach(pill => {
                if (pill.dataset.category === catId) {
                    pill.style.display = shouldShowSection ? 'inline-block' : 'none';
                }
            });
        });
        
        // Ensure "All" pill is always visible if not searching
        const allPill = document.querySelector('.cat-pill[data-category="all"]');
        if (allPill) allPill.style.display = (query === '' && activeType === 'all') ? 'inline-block' : 'none';
    };

    searchInput.addEventListener('input', filterMenu);
    
    typeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            typeBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterMenu();
            
            // Scroll to top of menu when changing type
            window.scrollTo({ top: document.querySelector('.menu-sections').offsetTop - 100, behavior: 'smooth' });
        });
    });
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount).replace('₫', '₫');
}

function loadCart() {
    const saved = localStorage.getItem(`cart_table_${CUSTOMER_CONFIG.tableId}`);
    if (saved) {
        try {
            cart = JSON.parse(saved);
        } catch (e) {
            cart = [];
        }
    }
}

function saveCart() {
    localStorage.setItem(`cart_table_${CUSTOMER_CONFIG.tableId}`, JSON.stringify(cart));
    updateCartUI();
}

function updateCartUI() {
    const cartBar = document.getElementById('cartBar');
    const cartCount = document.getElementById('cartCount');
    const cartTotal = document.getElementById('cartTotal');
    
    const totalCount = cart.reduce((sum, item) => sum + item.quantity, 0);
    const totalPrice = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    if (totalCount > 0) {
        cartBar.classList.remove('hidden');
        cartCount.textContent = totalCount;
        cartTotal.textContent = formatCurrency(totalPrice);
    } else {
        cartBar.classList.add('hidden');
    }

    // Also update modal if open
    updateCartModal();
}

function quickAdd(id, name, price) {
    const existing = cart.find(item => item.id === id && !item.note);
    if (existing) {
        existing.quantity++;
    } else {
        cart.push({ id, name, price, quantity: 1, note: '' });
    }
    saveCart();
    showToast(`Đã thêm ${name}`);
}

function showToast(msg) {
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.innerHTML = `<i class="fas fa-check-circle"></i> <span>${msg}</span>`;
    document.body.appendChild(toast);
    
    // Add CSS for toast if not exists
    if (!document.getElementById('toastStyles')) {
        const style = document.createElement('style');
        style.id = 'toastStyles';
        style.innerHTML = `
            .toast-notification {
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: rgba(15, 23, 42, 0.9);
                color: white;
                padding: 12px 25px;
                border-radius: 50rem;
                z-index: 9999;
                display: flex;
                align-items: center;
                gap: 10px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                animation: toastFadeIn 0.3s forwards, toastFadeOut 0.3s 2.7s forwards;
                font-weight: 600;
                font-size: 0.9rem;
                white-space: nowrap;
            }
            @keyframes toastFadeIn { from { top: -50px; opacity: 0; } to { top: 20px; opacity: 1; } }
            @keyframes toastFadeOut { from { top: 20px; opacity: 1; } to { top: -50px; opacity: 0; } }
        `;
        document.head.appendChild(style);
    }

    setTimeout(() => toast.remove(), 3000);
}

function showItemDetail(item) {
    currentItem = { ...item, quantity: 1, note: '' };
    document.getElementById('detailName').textContent = item.name;
    document.getElementById('detailPrice').textContent = formatCurrency(item.price);
    document.getElementById('detailDesc').textContent = item.description || 'Không có mô tả cho món ăn này.';
    document.getElementById('detailQty').textContent = '1';
    document.getElementById('detailNote').value = '';
    
    const imgContainer = document.getElementById('detailImg');
    if (item.image) {
        imgContainer.style.backgroundImage = `url(${CUSTOMER_CONFIG.baseUrl}/public/uploads/${item.image})`;
        imgContainer.innerHTML = '';
    } else {
        imgContainer.style.backgroundImage = 'none';
        imgContainer.style.backgroundColor = '#f1f5f9';
        imgContainer.innerHTML = '<i class="fas fa-coffee" style="font-size:3rem; color:#cbd5e1; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);"></i>';
    }

    updateDetailTotal();
    document.getElementById('itemDetailModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeItemDetail() {
    document.getElementById('itemDetailModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function changeDetailQty(delta) {
    if (!currentItem) return;
    currentItem.quantity = Math.max(1, currentItem.quantity + delta);
    document.getElementById('detailQty').textContent = currentItem.quantity;
    updateDetailTotal();
}

function updateDetailTotal() {
    const total = currentItem.price * currentItem.quantity;
    document.getElementById('detailBtnTotal').textContent = formatCurrency(total);
}

function addFromDetail() {
    currentItem.note = document.getElementById('detailNote').value.trim();
    
    // Find item with SAME ID and SAME NOTE
    const existing = cart.find(item => item.id === currentItem.id && item.note === currentItem.note);
    if (existing) {
        existing.quantity += currentItem.quantity;
    } else {
        cart.push({ ...currentItem });
    }
    
    saveCart();
    closeItemDetail();
    showToast(`Đã thêm ${currentItem.name}`);
}

function toggleCartModal() {
    const modal = document.getElementById('cartModal');
    const isHidden = modal.classList.contains('hidden');
    
    if (isHidden) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        updateCartModal();
    } else {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

function updateCartModal() {
    const container = document.getElementById('cartItemsList');
    const modalTotal = document.getElementById('modalCartTotal');
    
    if (cart.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-shopping-basket fa-3x text-light mb-3"></i>
                <p class="text-muted">Giỏ hàng đang trống.</p>
                <button class="btn-gold mt-3" onclick="toggleCartModal()">TIẾP TỤC CHỌN MÓN</button>
            </div>
        `;
        modalTotal.textContent = '0₫';
        return;
    }

    let html = '';
    let total = 0;
    
    cart.forEach((item, index) => {
        total += item.price * item.quantity;
        html += `
            <div class="cart-item" style="display:flex; justify-content:space-between; align-items:center; padding:15px 0; border-bottom:1px solid var(--border);">
                <div style="flex:1;">
                    <div style="font-weight:700; color:var(--text-dark);">${item.name}</div>
                    <div style="color:var(--gold-dark); font-weight:600; font-size:0.85rem;">${formatCurrency(item.price)}</div>
                    ${item.note ? `<div style="font-style:italic; font-size:0.75rem; color:var(--text-light); margin-top:4px;">Lưu ý: ${item.note}</div>` : ''}
                </div>
                <div class="qty-selector" style="background:#f1f5f9; padding:5px 10px; border-radius:10px; display:flex; align-items:center; gap:15px; scale:0.8;">
                    <button class="qty-btn" style="width:30px; height:30px; font-size:0.8rem;" onclick="changeCartQty(${index}, -1)"><i class="fas fa-minus"></i></button>
                    <span class="qty-value" style="font-size:1rem; min-width:20px;">${item.quantity}</span>
                    <button class="qty-btn" style="width:30px; height:30px; font-size:0.8rem;" onclick="changeCartQty(${index}, 1)"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    modalTotal.textContent = formatCurrency(total);
}

function changeCartQty(index, delta) {
    cart[index].quantity += delta;
    if (cart[index].quantity <= 0) {
        cart.splice(index, 1);
    }
    saveCart();
    if (cart.length === 0) {
        toggleCartModal();
    }
}

async function submitOrder() {
    if (cart.length === 0) return;

    const notes = document.getElementById('orderNotes').value;
    const btn = document.getElementById('btnSubmitOrder');
    const originalText = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ĐANG XỬ LÝ...';

    const formData = new FormData();
    formData.append('cart', JSON.stringify(cart));
    formData.append('notes', notes);

    try {
        const response = await fetch(`${CUSTOMER_CONFIG.baseUrl}/qr/order/submit`, {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            cart = [];
            saveCart();
            showToast('Gửi bếp thành công!');
            setTimeout(() => {
                window.location.href = `${CUSTOMER_CONFIG.baseUrl}/qr/order/status`;
            }, 1000);
        } else {
            alert(result.error || 'Lỗi gửi order. Vui lòng thử lại.');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    } catch (e) {
        console.error(e);
        alert('Lỗi kết nối máy chủ. Vui lòng kiểm tra mạng.');
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
}

async function callWaiter(type) {
    if (!confirm(type === 'payment' ? 'Bạn muốn yêu cầu thanh toán?' : 'Bạn muốn gọi nhân viên phục vụ?')) return;

    try {
        const formData = new FormData();
        formData.append('table_id', CUSTOMER_CONFIG.tableId);
        formData.append('type', type);

        const response = await fetch(`${CUSTOMER_CONFIG.baseUrl}/qr/support/call-waiter`, {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        if (result.success) {
            showToast('Yêu cầu đã được gửi đến nhân viên!');
        } else {
            alert('Gửi yêu cầu thất bại.');
        }
    } catch (e) {
        alert('Lỗi kết nối.');
    }
}

// Close modals when clicking backdrop
document.querySelectorAll('.modal-backdrop').forEach(modal => {
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });
});
