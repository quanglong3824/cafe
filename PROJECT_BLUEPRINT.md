# 📋 BẢN THIẾT KẾ HỆ THỐNG AURORA CAFE (BLUEPRINT)

Tài liệu này tổng hợp các giải pháp kỹ thuật và tính năng cao cấp đã triển khai, có thể áp dụng cho các hệ thống Ordering/Booking trong các lĩnh vực khác.

## 1. Cơ chế Realtime & Đồng bộ dữ liệu
- **Nhân viên (Waiter/Admin):** 
    - Cơ chế polling 4s/lần.
    - Sử dụng `GenerateHash(items)` để so sánh trạng thái cũ và mới. Chỉ reload khi hash thay đổi.
- **Khách hàng (Customer):**
    - **Sync-to-Server:** Mọi thao tác Add/Update/Remove trong giỏ hàng (LocalStorage) đều gọi API `sync-draft` ngay lập tức.
    - **Sync-from-Server:** Polling 5s/lần gọi API `get-drafts`. Nếu nhân viên chỉnh sửa món nháp từ admin, giỏ hàng máy khách tự động cập nhật.
    - **Interaction Lock:** Sử dụng `markInteraction()` để tạm dừng polling khi khách đang thao tác, tránh xung đột dữ liệu (race conditions).

## 2. Quy trình Thanh toán & Thông báo
- **Payment Request:** Khách bấm yêu cầu thanh toán -> Tạo thông báo loại `payment_request`.
- **Quick Action:** Trong danh sách thông báo của nhân viên, hiển thị nút "Xác nhận thanh toán" xử lý qua AJAX.
- **Auto-Finish:** Trang trạng thái của khách polling `check-status`. Nếu nhận được `status: closed`, tự động hiển thị `PaymentSuccessOverlay` với hiệu ứng Luxury.

## 3. Tối ưu UX & Kỹ thuật
- **Location Memory:** Lưu trạng thái định vị vào `sessionStorage`. Tránh làm phiền khách hàng khi tải lại trang hoặc đặt thêm món.
- **Luxury UI:** 
    - Nút bấm: Gradient (135deg, gold-dark, gold), Border-radius lớn (16px), Box-shadow mạnh.
    - Hiệu ứng: Scale(0.97) khi bấm, Heart-beat animation cho thông báo thành công.
- **Cache Busting:** Áp dụng `?v=<?= time() ?>` cho toàn bộ link CSS/JS trong các tệp View để cập nhật giao diện tức thì trên thiết bị khách.

## 4. Quản lý nhân sự (Staff Accountability)
- **Waiters Logging:** Cập nhật `waiter_id` vào bảng `orders` ngay tại thời điểm gọi hàm `close()`.
- **Session Attribution:** Ưu tiên lấy `waiter_id` từ người thực hiện thao tác đóng bàn cuối cùng để ghi vào lịch sử giao dịch.

---
*Tài liệu được khởi tạo ngày 18/03/2026 bởi Gemini CLI.*
