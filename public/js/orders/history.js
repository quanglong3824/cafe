// ============================================================
// history.js — Logic trang Lịch sử giao dịch (Aurora Restaurant)
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Xử lý nút xem chi tiết
    const detailButtons = document.querySelectorAll('.view-details-btn');
    detailButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            const orderData = JSON.parse(this.getAttribute('data-order-data'));
            
            openOrderDetails(orderId, orderData);
        });
    });

    // Hàm mở chi tiết hóa đơn (Bottom Sheet)
    function openOrderDetails(orderId, orderData) {
        const modalTableTitle = document.getElementById('modalTableTitle');
        const modalOrderTime = document.getElementById('modalOrderTime');
        const modalOrderBody = document.getElementById('modalOrderBody');
        const btnPrintOrder = document.getElementById('btnPrintOrder');

        // Cập nhật thông tin cơ bản
        modalTableTitle.textContent = orderData.table_name;
        const closedAt = new Date(orderData.closed_at);
        modalOrderTime.textContent = `${closedAt.getHours().toString().padStart(2, '0')}:${closedAt.getMinutes().toString().padStart(2, '0')} • ${closedAt.toLocaleDateString('vi-VN')}`;
        btnPrintOrder.href = `${BASE_URL}/orders/print?order_id=${orderId}`;

        // Hiển thị loading
        modalOrderBody.innerHTML = `
            <div class="loading-spinner">
                <div class="spinner"></div>
            </div>
        `;

        // Mở modal (Bottom Sheet)
        Aurora.openModal('modalOrderDetails');

        // Tải dữ liệu chi tiết từ API
        fetch(`${BASE_URL}/api/notifications/poll`) // Tạm thời dùng poll hoặc tạo API riêng nếu cần
            // Thực tế nên gọi API lấy chi tiết order: /orders/get-detail?id=...
            .then(() => {
                // Giả lập dữ liệu hoặc gọi API thực tế
                return fetch(`${BASE_URL}/orders/get-detail?id=${orderId}`);
            })
            .then(res => res.json())
            .then(data => {
                if (data.ok && data.items) {
                    renderOrderDetails(data.items, orderData);
                } else {
                    modalOrderBody.innerHTML = '<p class="text-center text-danger">Không thể tải chi tiết hóa đơn.</p>';
                }
            })
            .catch(err => {
                console.error(err);
                modalOrderBody.innerHTML = '<p class="text-center text-danger">Lỗi kết nối máy chủ.</p>';
            });
    }

    // Hàm render danh sách món ăn vào modal
    function renderOrderDetails(items, orderData) {
        const modalOrderBody = document.getElementById('modalOrderBody');
        
        let itemsHtml = `
            <table class="modal-table-new">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Món ăn</th>
                        <th style="text-align: right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
        `;

        items.forEach(item => {
            itemsHtml += `
                <tr>
                    <td class="item-qty">x${item.quantity}</td>
                    <td class="item-info">
                        <div class="item-name">${item.item_name}</div>
                        <div class="item-price">${formatPrice(item.item_price)}</div>
                    </td>
                    <td class="item-total">${formatPrice(item.item_price * item.quantity)}</td>
                </tr>
            `;
        });

        itemsHtml += `
                </tbody>
            </table>
            
            <div class="modal-total-section">
                <div class="total-row">
                    <span class="text-muted small fw-bold">Nhân viên phục vụ:</span>
                    <span class="fw-bold">${orderData.waiter_name || 'Hệ thống'}</span>
                </div>
                <div class="total-row">
                    <span class="text-muted small fw-bold">Hình thức thanh toán:</span>
                    <span class="fw-bold">${orderData.payment_method.toUpperCase()}</span>
                </div>
                <div class="total-row main">
                    <span class="fw-bold">TỔNG CỘNG</span>
                    <span>${formatPrice(orderData.total)}</span>
                </div>
            </div>
        `;

        modalOrderBody.innerHTML = itemsHtml;
    }

    // Tiện ích định dạng tiền tệ
    function formatPrice(amount) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    }
});

// Hàm chuyển đổi bộ lọc
function setFilter(type) {
    document.getElementById('filter_type').value = type;
    document.getElementById('historyFilterForm').submit();
}
