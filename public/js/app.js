/**
 * app.js — Global utilities
 * Aurora Cafe
 */

'use strict';

(function () {

    // ── Admin sidebar toggle (mobile) ───────────────────────
    const sidebarToggle  = document.getElementById('sidebarToggle');
    const sidebar        = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar?.classList.add('is-open');
        sidebarOverlay?.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar?.classList.remove('is-open');
        sidebarOverlay?.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    sidebarToggle?.addEventListener('click', openSidebar);
    sidebarOverlay?.addEventListener('click', closeSidebar);

    // Close on Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeSidebar();
    });

    // ── Modal helpers ────────────────────────────────────────
    function openModal(id) {
        const el = document.getElementById(id);
        el?.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        el?.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    // Close modal on backdrop click
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
        backdrop.addEventListener('click', e => {
            if (e.target === backdrop) {
                backdrop.classList.remove('is-open');
                document.body.style.overflow = '';
            }
        });
    });

    // Close modal buttons
    document.querySelectorAll('[data-modal-close]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modalId = btn.closest('.modal-backdrop')?.id;
            if (modalId) closeModal(modalId);
        });
    });

    // Open modal buttons
    document.querySelectorAll('[data-modal-open]').forEach(btn => {
        btn.addEventListener('click', () => openModal(btn.dataset.modalOpen));
    });

    // ── Flash auto-dismiss ───────────────────────────────────
    document.querySelectorAll('.alert[data-autohide]').forEach(alert => {
        const delay = parseInt(alert.dataset.autohide) || 3000;
        setTimeout(() => {
            alert.style.transition = 'opacity 0.4s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 400);
        }, delay);
    });

    // ── Confirm delete helper ────────────────────────────────
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', e => {
            const msg = el.dataset.confirm || 'Bạn có chắc muốn xoá?';
            if (!confirm(msg)) e.preventDefault();
        });
    });

    // ── Expose globally for inline use ───────────────────────
    window.Aurora = { openModal, closeModal };

})();

// ── Real-time Notification System ────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    // Shared Elements
    const waiterBadge = document.getElementById('waiterNotiBadge');
    const adminBell = document.getElementById('notificationBell');
    const adminPanel = document.getElementById('notificationPanel');
    const adminCount = document.getElementById('notificationCount');
    const adminList = document.getElementById('notificationList');
    
    if (!waiterBadge && !adminBell && !document.getElementById('waiterFullNotiList')) return;

    const notifSound = new Audio('https://raw.githubusercontent.com/shashankmehta/notification-sounds/master/notification.mp3');
    notifSound.preload = 'auto';

    let lastNotifTimestamp = 0;

    // Admin Specific Logic
    if (adminBell) {
        adminBell.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpening = !adminPanel.classList.contains('show');
            adminPanel.classList.toggle('show');
            if (isOpening && adminCount.classList.contains('show')) {
                markAsRead();
                adminCount.classList.remove('show');
                adminList.querySelectorAll('.notification-item').forEach(item => item.classList.remove('unread'));
            }
        });
        document.addEventListener('click', (e) => {
            if (!adminBell.parentElement.contains(e.target)) adminPanel.classList.remove('show');
        });
    }

    async function pollNotifications() {
        try {
            const response = await fetch(`${BASE_URL}/notifications/poll`);
            const data = await response.json();
            
            if (!data.ok) return;

            const unreadCount = data.stats.unread;
            const notifications = data.notifications;

            // Sound logic
            if (unreadCount > 0) {
                const newestTimestamp = Math.max(...notifications.filter(n => !parseInt(n.is_read)).map(n => new Date(n.created_at).getTime()));
                if (newestTimestamp > lastNotifTimestamp && lastNotifTimestamp !== 0) {
                    notifSound.play().catch(e => {});
                }
                lastNotifTimestamp = newestTimestamp;
            } else if (notifications.length > 0 && lastNotifTimestamp === 0) {
                lastNotifTimestamp = Math.max(...notifications.map(n => new Date(n.created_at).getTime()));
            }

            // Update UI Badges
            const waiterBadge = document.getElementById('waiterNotiBadge');
            if (waiterBadge) {
                waiterBadge.textContent = unreadCount;
                waiterBadge.style.display = unreadCount > 0 ? 'block' : 'none';
            }

            if (adminCount) {
                adminCount.textContent = unreadCount;
                adminCount.classList.toggle('show', unreadCount > 0);
            }

            // Render list if panel is visible or if we are on notifications page
            if (adminPanel?.classList.contains('show') || !adminBell) {
                renderAdminList(notifications);
            }

        } catch (e) { console.error("Poll failed", e); }
    }

    function renderAdminList(notifications) {
        if (!adminList) return;
        if (notifications.length === 0) {
            adminList.innerHTML = '<div class="notification-item empty">Chưa có thông báo mới.</div>';
            return;
        }
        
        let html = '';
        notifications.forEach(n => {
            const isUnread = !parseInt(n.is_read);
            const isPaymentRequest = n.notification_type === 'payment_request';
            
            html += `
                <div class="notification-item ${isUnread ? 'unread' : ''}" onclick="!event.target.closest('button') && (window.location.href='${BASE_URL}/admin/realtime?order_id=${n.order_id}')">
                    <div class="notification-item-icon"><i class="fas ${getIcon(n.notification_type)}"></i></div>
                    <div class="notification-item-content">
                        <h5>${n.title}</h5>
                        <p>${n.message}</p>
                        <div class="notification-item-time">${formatTimeAgo(new Date(n.created_at))}</div>
                        
                        ${isPaymentRequest ? `
                            <div class="notification-actions mt-2">
                                <button class="btn btn-sm btn-success py-1 px-3 rounded-pill fw-bold" 
                                    onclick="quickPay(event, ${n.table_id}, ${n.order_id}, ${n.id})">
                                    <i class="fas fa-check-circle me-1"></i> XÁC NHẬN THANH TOÁN
                                </button>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
        });
        adminList.innerHTML = html;
    }

    /** Quick Pay from Notification */
    window.quickPay = async function(event, tableId, orderId, notifId) {
        event.stopPropagation();
        if (!confirm('Xác nhận đã nhận tiền và hoàn tất thanh toán cho bàn này?')) return;

        const btn = event.currentTarget;
        const originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> ĐANG XỬ LÝ...';

        try {
            const fd = new FormData();
            fd.append('table_id', tableId);
            fd.append('order_id', orderId);
            fd.append('payment_method', 'cash'); // Default for quick pay
            fd.append('ajax', '1');

            const response = await fetch(`${BASE_URL}/tables/close`, {
                method: 'POST',
                body: fd
            });
            const data = await response.json();

            if (data.ok) {
                // Mark notification as read
                await markAsRead(notifId);
                alert('Thanh toán thành công!');
                // Reload current view if it's realtime or table view
                if (window.location.href.includes('realtime') || window.location.href.includes('tables')) {
                    window.location.reload();
                }
            } else {
                alert(data.message || 'Lỗi thanh toán');
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
        } catch (e) {
            console.error(e);
            alert('Lỗi kết nối server');
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }
    }

    function getIcon(type) {
        switch(type) {
            case 'new_order': return 'fa-file-invoice-dollar';
            case 'scan_qr': return 'fa-qrcode';
            case 'support_request': return 'fa-life-ring';
            case 'payment_request': return 'fa-hand-holding-usd';
            default: return 'fa-bell';
        }
    }

    async function markAsRead(id = null) {
        try {
            const fd = new FormData();
            if (id) fd.append('id', id);
            const response = await fetch(`${BASE_URL}/notifications/mark-read`, { method: 'POST', body: fd });
            const data = await response.json();
            if (data.ok) pollNotifications();
        } catch (e) { console.error("Mark read failed", e); }
    }

    // Mark all as read button
    const markAllBtn = document.getElementById('markAllAsReadBtn');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            markAsRead();
        });
    }

    function formatTimeAgo(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        if (seconds < 60) return "vừa xong";
        let interval = seconds / 3600;
        if (interval > 1) return Math.floor(interval) + " giờ trước";
        interval = seconds / 60;
        if (interval > 1) return Math.floor(interval) + " phút trước";
        return Math.floor(seconds) + " giây trước";
    }

    pollNotifications();
    setInterval(pollNotifications, 4000);
});
