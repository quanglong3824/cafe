-- ============================================================
-- Cafe Migration Script
-- Aurora Cafe — Digital Menu & Order System
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Làm sạch dữ liệu menu hiện tại
TRUNCATE TABLE `menu_set_items`;
TRUNCATE TABLE `menu_items`;
TRUNCATE TABLE `menu_categories`;
TRUNCATE TABLE `menu_sets`;

-- 2. Cập nhật thông tin hệ thống
UPDATE `location_limits` SET `name` = 'Giới hạn QR Cafe' WHERE `id` > 0;
UPDATE `users` SET `name` = 'Admin Cafe' WHERE `username` = 'admin';

-- 3. Thêm Danh mục Menu mới (Cafe-oriented)
INSERT INTO `menu_categories` (`id`, `name`, `name_en`, `menu_type`, `icon`, `sort_order`, `is_active`) VALUES
(1, 'Cà Phê Việt Nam', 'Vietnamese Coffee', 'asia', 'fa-coffee', 1, 1),
(2, 'Cà Phê Ý (Espresso)', 'Italian Coffee', 'europe', 'fa-mug-hot', 2, 1),
(3, 'Trà & Macchiato', 'Tea & Macchiato', 'alacarte', 'fa-leaf', 3, 1),
(4, 'Sinh Tố & Nước Ép', 'Smoothies & Juices', 'alacarte', 'fa-glass-whiskey', 4, 1),
(5, 'Đồ Đá Xay', 'Ice Blended', 'other', 'fa-snowflake', 5, 1),
(6, 'Bánh Ngọt & Tráng Miệng', 'Cakes & Desserts', 'asia', 'fa-birthday-cake', 6, 1),
(7, 'Đồ Ăn Nhẹ', 'Light Snacks', 'alacarte', 'fa-utensils', 7, 1);

-- 4. Thêm Món Ăn/Đồ Uống (Cafe-oriented)
-- Cà Phê Việt Nam
INSERT INTO `menu_items` (`id`, `category_id`, `name`, `name_en`, `description`, `price`, `tags`, `sort_order`, `is_available`, `is_active`) VALUES
(1, 1, 'Cà Phê Đen Đá', 'Black Coffee with Ice', 'Cà phê rang xay nguyên chất đậm đà', 29000, 'bestseller', 1, 1, 1),
(2, 1, 'Cà Phê Sữa Đá', 'Milk Coffee with Ice', 'Cà phê pha phin truyền thống kết hợp sữa đặc', 35000, 'bestseller', 2, 1, 1),
(3, 1, 'Bạc Xỉu', 'White Coffee', 'Sữa tươi pha chút cà phê, ngọt ngào và béo ngậy', 39000, 'recommended', 3, 1, 1),
(4, 1, 'Cà Phê Trứng', 'Egg Coffee', 'Cà phê hòa quyện cùng lớp kem trứng đánh bông', 45000, 'new', 4, 1, 1);

-- Cà Phê Ý
INSERT INTO `menu_items` (`id`, `category_id`, `name`, `name_en`, `description`, `price`, `tags`, `sort_order`, `is_available`, `is_active`) VALUES
(5, 2, 'Espresso', 'Espresso', 'Cà phê nguyên chất chiết xuất máy', 35000, NULL, 1, 1, 1),
(6, 2, 'Cappuccino', 'Cappuccino', 'Sự kết hợp hoàn hảo giữa Espresso, sữa nóng và bọt sữa', 49000, 'recommended', 2, 1, 1),
(7, 2, 'Latte Art', 'Caffe Latte', 'Espresso kết hợp sữa tươi tạo hình nghệ thuật', 49000, NULL, 3, 1, 1);

-- Trà
INSERT INTO `menu_items` (`id`, `category_id`, `name`, `name_en`, `description`, `price`, `tags`, `sort_order`, `is_available`, `is_active`) VALUES
(8, 3, 'Trà Đào Cam Sả', 'Peach Tea with Orange & Lemongrass', 'Trà đào thanh mát với đào miếng và hương sả', 45000, 'bestseller', 1, 1, 1),
(9, 3, 'Trà Vải', 'Lychee Tea', 'Trà đen hảo hạng cùng quả vải tươi ngon', 45000, NULL, 2, 1, 1),
(10, 3, 'Trà Sữa Matcha', 'Matcha Milk Tea', 'Matcha Nhật Bản kết hợp sữa tươi béo ngậy', 49000, 'recommended', 3, 1, 1);

-- Sinh Tố & Nước Ép
INSERT INTO `menu_items` (`id`, `category_id`, `name`, `name_en`, `description`, `price`, `tags`, `sort_order`, `is_available`, `is_active`) VALUES
(11, 4, 'Sinh Tố Bơ', 'Avocado Smoothie', 'Bơ sáp tươi ngon xay cùng sữa đặc', 55000, 'bestseller', 1, 1, 1),
(12, 4, 'Nước Ép Cam Tươi', 'Fresh Orange Juice', '100% nước cam tươi nguyên chất', 45000, NULL, 2, 1, 1);

-- Đá Xay
INSERT INTO `menu_items` (`id`, `category_id`, `name`, `name_en`, `description`, `price`, `tags`, `sort_order`, `is_available`, `is_active`) VALUES
(13, 5, 'Matcha Đá Xay', 'Matcha Ice Blended', 'Matcha, sữa tươi và đá xay bông', 55000, 'recommended', 1, 1, 1),
(14, 5, 'Cookie Đá Xay', 'Cookies & Cream Blended', 'Bánh oreo xay cùng kem tươi béo ngậy', 55000, 'new', 2, 1, 1);

-- Bánh & Tráng Miệng
INSERT INTO `menu_items` (`id`, `category_id`, `name`, `name_en`, `description`, `price`, `tags`, `sort_order`, `is_available`, `is_active`) VALUES
(15, 6, 'Bánh Sừng Bò', 'Croissant', 'Bánh mì ngàn lớp thơm mùi bơ Pháp', 35000, 'recommended', 1, 1, 1),
(16, 6, 'Tiramisu', 'Tiramisu', 'Bánh phô mai kiểu Ý tan trong miệng', 45000, 'bestseller', 2, 1, 1);

-- Đồ Ăn Nhẹ
INSERT INTO `menu_items` (`id`, `category_id`, `name`, `name_en`, `description`, `price`, `tags`, `sort_order`, `is_available`, `is_active`) VALUES
(17, 7, 'Hạt Hướng Dương', 'Sunflower Seeds', 'Món nhâm nhi lý tưởng bên tách trà', 25000, NULL, 1, 1, 1),
(18, 7, 'Hạt Điều Rang Muối', 'Roasted Cashews', 'Hạt điều Bình Phước giòn bùi', 45000, NULL, 2, 1, 1);

-- 5. Thêm Menu Sets (Combos)
INSERT INTO `menu_sets` (`id`, `name`, `name_en`, `description`, `price`, `is_active`, `sort_order`) VALUES
(1, 'Combo Năng Lượng', 'Energy Combo', '1 Cà phê sữa đá + 1 Bánh sừng bò', 65000, 1, 1),
(2, 'Combo Thư Giãn', 'Relax Combo', '1 Trà đào cam sả + 1 Tiramisu', 80000, 1, 2);

-- 6. Gán món vào Set
INSERT INTO `menu_set_items` (`set_id`, `menu_item_id`, `quantity`, `is_required`) VALUES
(1, 2, 1, 1), -- Cà Phê Sữa Đá
(1, 15, 1, 1), -- Bánh Sừng Bò
(2, 8, 1, 1), -- Trà Đào Cam Sả
(2, 16, 1, 1); -- Tiramisu

SET FOREIGN_KEY_CHECKS = 1;
