# Aurora Cafe Management System v2.0.0

Phân hệ quản lý Cafe dành riêng cho Aurora Hotel Plaza. Đây là bản clone 1:1 từ hệ thống Nhà hàng, được cấu hình độc lập để chạy tại `/cafe`.

---

## 🛠 Hướng dẫn triển khai nhanh

1.  **Cơ sở dữ liệu**:
    - Tạo một database mới tên là `auroraho_cafe`.
    - Import tệp dữ liệu khởi tạo tại `cafe/database/init_cafe.sql`.
    - Cấu hình kết nối tại `cafe/config/database.php`.

2.  **Cấu hình hệ thống**:
    - Tên ứng dụng đã được đổi thành **Aurora Cafe** trong `cafe/config/constants.php`.
    - Toàn bộ logic Realtime, Geofencing và iPad Shortcut đã được tích hợp sẵn.

3.  **Truy cập**:
    - Đường dẫn: `yourdomain.com/cafe`.
    - Để lưu iPad Shortcut: `yourdomain.com/cafe/home`.

---

## 📝 Ghi chú bảo trì
- Toàn bộ ảnh món ăn (uploads) được giữ nguyên từ bản Nhà hàng để làm mẫu. Bạn có thể thay đổi trong trang Quản trị Món của Cafe.
- Hệ thống chạy độc lập hoàn toàn với bản Nhà hàng, không ảnh hưởng đến doanh thu hay dữ liệu của nhau.

*Lead Developer: LongDev - © 2026 Aurora Hotel Plaza.*
