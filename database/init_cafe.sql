-- Aurora Restaurant Database Backup
-- Generated: 2026-03-18 11:33:29

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `customer_sessions`;
CREATE TABLE `customer_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `table_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_session_id` (`session_id`),
  KEY `idx_table_active` (`table_id`,`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `customer_sessions` VALUES ('1', '4h9mq0ckfmghi9ni3e7hkgr27k', '1', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 19:07:47', '2026-03-17 19:37:47', '2026-03-17 19:07:47');
INSERT INTO `customer_sessions` VALUES ('2', 'u76o6dpolbpnem292njglu0n31', '2', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 19:08:13', '2026-03-17 19:38:13', '2026-03-17 19:08:13');
INSERT INTO `customer_sessions` VALUES ('3', 'dl1u1arrkfp1jt57e611rm14ol', '28', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 19:11:24', '2026-03-17 19:41:24', '2026-03-17 19:11:24');
INSERT INTO `customer_sessions` VALUES ('4', 'k1vqer89fd6mcaodui959lc94u', '1', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 19:21:08', '2026-03-17 19:51:08', '2026-03-17 19:21:08');
INSERT INTO `customer_sessions` VALUES ('5', 'gqijh3f69va64doa2d5bu8c9tr', '1', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 19:25:38', '2026-03-17 19:55:38', '2026-03-17 19:21:56');
INSERT INTO `customer_sessions` VALUES ('6', 'rrvdnl6pgo3b3etu7gpgople8p', '12', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 19:27:34', '2026-03-17 19:57:34', '2026-03-17 19:25:52');
INSERT INTO `customer_sessions` VALUES ('7', 'ro6dtb9cs0o2mpqkmtok1onbji', '6', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 19:33:50', '2026-03-17 20:03:50', '2026-03-17 19:33:19');
INSERT INTO `customer_sessions` VALUES ('8', 'cu0rl0q4flcp73fpn9gns57njh', '1', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 21:44:19', '2026-03-18 21:44:19', '2026-03-17 19:35:08');
INSERT INTO `customer_sessions` VALUES ('9', '8kouqchg3ep9n11mcd39q280hc', '28', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 19:48:54', '2026-03-17 20:18:54', '2026-03-17 19:48:54');
INSERT INTO `customer_sessions` VALUES ('10', 'm1ill4h7m9n1m35bstbf69oggi', '28', NULL, '222.253.191.65', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '1', '2026-03-17 19:49:23', '2026-03-17 20:19:23', '2026-03-17 19:49:23');
INSERT INTO `customer_sessions` VALUES ('11', 'dh3j0vh3dbh148vi2tc7gl1ek8', '1', NULL, '222.253.191.65', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.6 Safari/605.1.15', '1', '2026-03-17 21:17:12', '2026-03-18 21:17:12', '2026-03-17 21:17:12');
INSERT INTO `customer_sessions` VALUES ('13', 'r03redi7dachirj4pb0efltlto', '3', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 21:17:44', '2026-03-18 21:17:44', '2026-03-17 21:17:44');
INSERT INTO `customer_sessions` VALUES ('17', 'ph7n9bueatdr00mt8tj7n815fm', '1', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 21:23:53', '2026-03-18 21:23:53', '2026-03-17 21:23:53');
INSERT INTO `customer_sessions` VALUES ('27', 'ev5d51u1jocn7admdfgmsm4ffg', '1', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 21:44:56', '2026-03-18 21:44:56', '2026-03-17 21:44:56');
INSERT INTO `customer_sessions` VALUES ('28', '55onaj18n2qqfl47tnp3usf6gr', '21', NULL, '222.253.191.65', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-17 21:46:45', '2026-03-18 21:46:45', '2026-03-17 21:45:09');
INSERT INTO `customer_sessions` VALUES ('31', 'ak6lf5e3u96gei6kdovnlblkhl', '12', NULL, '118.70.230.232', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-18 09:52:52', '2026-03-19 09:52:52', '2026-03-18 09:50:34');
INSERT INTO `customer_sessions` VALUES ('34', '9g9q3s2vdhjn3jccaniqccjjhp', '1', NULL, '118.70.230.232', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-18 09:53:02', '2026-03-19 09:53:02', '2026-03-18 09:53:02');
INSERT INTO `customer_sessions` VALUES ('35', 'fb0fflnkclmpqu92dp5hjjdmh9', '4', NULL, '118.70.230.232', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.6 Safari/605.1.15', '1', '2026-03-18 10:49:49', '2026-03-19 10:49:49', '2026-03-18 10:49:49');
INSERT INTO `customer_sessions` VALUES ('36', 'cfe628klq7cquesneid5dvekj8', '12', NULL, '118.70.230.232', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.6 Safari/605.1.15', '1', '2026-03-18 10:50:33', '2026-03-19 10:50:33', '2026-03-18 10:50:33');
INSERT INTO `customer_sessions` VALUES ('37', '578rmiqo7pv7632iu0i5nmdkb8', '10', NULL, '118.70.230.232', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-18 11:00:45', '2026-03-19 11:00:45', '2026-03-18 11:00:45');
INSERT INTO `customer_sessions` VALUES ('38', 'cqos6peiqauf32re8m1rhjsioi', '14', NULL, '118.70.230.232', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-18 11:14:45', '2026-03-19 11:14:45', '2026-03-18 11:14:45');
INSERT INTO `customer_sessions` VALUES ('39', 't9d324s0asl14s5b3efsm1a0nt', '1', NULL, '118.70.230.232', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-18 11:26:00', '2026-03-19 11:26:00', '2026-03-18 11:17:30');
INSERT INTO `customer_sessions` VALUES ('41', 'fb4ig0cg8j47h7nqr5nrc34tg1', '14', NULL, '118.70.230.232', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '1', '2026-03-18 11:17:47', '2026-03-19 11:17:47', '2026-03-18 11:17:47');

DROP TABLE IF EXISTS `location_limits`;
CREATE TABLE `location_limits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT 'Giới hạn QR Restaurant',
  `center_lat` decimal(10,8) NOT NULL COMMENT 'Vĩ độ trung tâm (Aurora Hotel)',
  `center_lng` decimal(11,8) NOT NULL COMMENT 'Kinh độ trung tâm',
  `radius_meters` int(10) unsigned NOT NULL DEFAULT 500 COMMENT 'Bán kính giới hạn (m)',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Bật/tắt giới hạn vị trí',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `location_limits` VALUES ('1', 'Giới hạn QR Restaurant', '10.95770000', '106.84480000', '500', '1', '2026-03-08 16:36:35', '2026-03-08 16:36:35');
INSERT INTO `location_limits` VALUES ('2', 'Giới hạn QR Restaurant', '10.95770000', '106.84480000', '500', '1', '2026-03-08 16:46:06', '2026-03-08 16:46:06');

DROP TABLE IF EXISTS `menu_categories`;
CREATE TABLE `menu_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'Tên danh mục: Khai vị, Chính, Tráng miệng...',
  `name_en` varchar(100) DEFAULT NULL COMMENT 'Tên tiếng Anh (tuỳ chọn)',
  `menu_type` enum('asia','europe','alacarte','set','other') DEFAULT 'asia',
  `icon` varchar(50) DEFAULT 'fa-utensils' COMMENT 'Font Awesome icon class',
  `sort_order` smallint(5) unsigned DEFAULT 0 COMMENT 'Thứ tự hiển thị',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `menu_categories` VALUES ('1', 'Khai Vị', 'Appetizers', 'asia', 'fa-leaf', '1', '1', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_categories` VALUES ('2', 'Món Chính', 'Main Course', 'alacarte', 'fa-drumstick-bite', '2', '1', '2026-03-07 18:08:27', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('3', 'Tráng Miệng', 'Desserts', 'asia', 'fa-ice-cream', '3', '1', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_categories` VALUES ('4', 'Đồ Uống', 'Beverages', 'alacarte', 'fa-glass-martini-alt', '4', '1', '2026-03-07 18:08:27', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('5', 'Đặc Sản', 'Specialties', 'asia', 'fa-star', '5', '1', '2026-03-07 18:08:27', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('6', 'Gỏi - Nộm', 'Salads', 'alacarte', 'fa-leaf', '1', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('7', 'Lẩu', 'Hot Pot', 'europe', 'fa-bowl-hot', '2', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('8', 'Đồ Nướng', 'Grilled', 'alacarte', 'fa-fire', '3', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('9', 'Cơm', 'Rice Dishes', 'alacarte', 'fa-bowl-rice', '4', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('10', 'Mì - Bún - Phở', 'Noodles', 'alacarte', 'fa-bowl-food', '5', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('11', 'Hải Sản', 'Seafood', 'asia', 'fa-fish', '6', '1', '2026-03-07 18:45:33', '2026-03-07 18:45:33');
INSERT INTO `menu_categories` VALUES ('12', 'Salad Âu', 'European Salad', 'europe', 'fa-leaf', '1', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('13', 'Súp Âu', 'European Soup', 'europe', 'fa-bowl-hot', '2', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('14', 'Món Chính Âu', 'European Main', 'europe', 'fa-utensils', '3', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('15', 'Mì Ý', 'Pasta', 'alacarte', 'fa-bowl-food', '4', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('16', 'Bít Tết', 'Steak', 'alacarte', 'fa-drumstick-bite', '5', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('17', 'Cá & Hải Sản Âu', 'Fish & Seafood', 'europe', 'fa-fish', '6', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('18', 'Pizza', 'Pizza', 'asia', 'fa-pizza-slice', '7', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');
INSERT INTO `menu_categories` VALUES ('19', 'Set 2 Người', 'Set for 2', 'alacarte', 'fa-users', '1', '1', '2026-03-07 18:45:33', '2026-03-07 18:45:33');
INSERT INTO `menu_categories` VALUES ('20', 'Set 4 Người', 'Set for 4', 'alacarte', 'fa-users', '2', '1', '2026-03-07 18:45:33', '2026-03-07 18:45:33');
INSERT INTO `menu_categories` VALUES ('21', 'Set 6 Người', 'Set for 6', 'alacarte', 'fa-users', '3', '1', '2026-03-07 18:45:33', '2026-03-07 18:45:33');
INSERT INTO `menu_categories` VALUES ('22', 'Set BBQ', 'BBQ Set', 'alacarte', 'fa-fire', '4', '1', '2026-03-07 18:45:33', '2026-03-07 18:45:33');
INSERT INTO `menu_categories` VALUES ('23', 'Set Hải Sản', 'Seafood Set', 'asia', 'fa-fish', '5', '1', '2026-03-07 18:45:33', '2026-03-17 08:55:26');

DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE `menu_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `name` varchar(150) NOT NULL COMMENT 'Tên món',
  `name_en` varchar(150) DEFAULT NULL COMMENT 'Tên tiếng Anh (tuỳ chọn)',
  `description` text DEFAULT NULL COMMENT 'Mô tả món',
  `price` decimal(10,0) NOT NULL DEFAULT 0 COMMENT 'Giá (VND)',
  `image` varchar(255) DEFAULT NULL COMMENT 'Đường dẫn ảnh món',
  `is_available` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=còn hàng, 0=hết hàng',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=hiển thị, 0=ẩn',
  `tags` set('bestseller','new','spicy','vegetarian','recommended') DEFAULT NULL,
  `sort_order` smallint(5) unsigned DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_items_category` (`category_id`),
  KEY `idx_items_available` (`is_available`,`is_active`),
  CONSTRAINT `fk_items_category` FOREIGN KEY (`category_id`) REFERENCES `menu_categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `menu_items` VALUES ('1', '1', 'Gỏi cuốn tôm thịt', 'Fresh Spring Rolls', NULL, '85000', NULL, '1', '1', 'bestseller', '1', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('2', '1', 'Chả giò rế', 'Crispy Rolls', NULL, '75000', NULL, '1', '1', NULL, '2', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('3', '1', 'Súp bào ngư vi cá', 'Abalone Soup', NULL, '150000', NULL, '1', '1', 'recommended', '3', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('4', '2', 'Cơm chiên hải sản', 'Seafood Fried Rice', NULL, '120000', NULL, '1', '1', 'bestseller', '1', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('5', '2', 'Bò lúc lắc', 'Shaken Beef', NULL, '180000', NULL, '1', '1', 'recommended', '2', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('6', '2', 'Cá chẽm hấp gừng', 'Steamed Seabass', NULL, '250000', NULL, '1', '1', NULL, '3', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('7', '2', 'Tôm sú nướng muối ớt', 'Grilled Tiger Prawn', NULL, '220000', NULL, '1', '1', 'spicy', '4', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('8', '3', 'Chè bưởi', 'Pomelo Dessert', NULL, '45000', NULL, '1', '1', NULL, '1', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('9', '3', 'Kem dừa', 'Coconut Ice Cream', NULL, '55000', NULL, '1', '1', 'bestseller', '2', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('10', '4', 'Nước ép cam', 'Fresh Orange Juice', NULL, '65000', NULL, '1', '1', NULL, '1', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('11', '4', 'Sinh tố bơ', 'Avocado Smoothie', NULL, '75000', NULL, '1', '1', 'bestseller', '2', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('12', '4', 'Trà đào cam sả', 'Peach Tea', NULL, '55000', NULL, '1', '1', NULL, '3', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('13', '4', 'Bia Tiger lon', 'Tiger Beer Can', NULL, '35000', NULL, '1', '1', NULL, '4', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('14', '4', 'Nước suối', 'Water', NULL, '15000', NULL, '1', '1', NULL, '5', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `menu_items` VALUES ('55', '1', 'Gỏi cuốn tôm thịt', 'Fresh Spring Rolls', 'Cuốn tươi với tôm, thịt, rau sống, ăn kèm nước chấm', '85000', NULL, '1', '1', 'bestseller', '1', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('56', '1', 'Chả giò rế hải sản', 'Crispy Seafood Rolls', 'Chả giò giòn với nhân hải sản', '95000', NULL, '1', '1', 'new', '2', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('57', '1', 'Nem nướng Nha Trang', 'Grilled Pork Spring Rolls', 'Nem nướng than hoa, bánh tráng, rau sống', '110000', NULL, '1', '1', 'recommended', '3', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('58', '1', 'Bò lúc lắc', 'Shaken Beef', 'Bò mềm lắc với tiêu đen, ăn kèm bánh mì', '145000', NULL, '1', '1', 'bestseller', '4', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('59', '1', 'Súp cua vi cá', 'Crab & Shark Fin Soup', 'Súp cua với vi cá, trứng cút', '180000', NULL, '1', '1', 'recommended', '5', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('60', '1', 'Súp bào ngư', 'Abalone Soup', 'Súp bào ngư nguyên con', '220000', NULL, '1', '1', NULL, '6', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('61', '6', 'Gỏi ngó sen tôm thịt', 'Lotus Root Salad', 'Ngó sen giòn, tôm thịt, rau thơm, nước mắm chua ngọt', '125000', NULL, '1', '1', 'bestseller', '1', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('62', '6', 'Gỏi đu đủ bò khô', 'Papaya Salad with Dried Beef', 'Đu đủ giòn, bò khô, đậu phộng', '95000', NULL, '1', '1', NULL, '2', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('63', '6', 'Gỏi hải sản Thái', 'Thai Seafood Salad', 'Hải sản trộn chua cay kiểu Thái', '165000', NULL, '1', '1', 'spicy', '3', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('64', '6', 'Nộm hoa chuối tai heo', 'Banana Flower Salad', 'Hoa chuối, tai heo, rau thơm', '85000', NULL, '1', '1', NULL, '4', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('65', '7', 'Lẩu thái hải sản', 'Thai Seafood Hot Pot', 'Lẩu chua cay với tôm, mực, cá, rau', '350000', NULL, '1', '1', 'bestseller,spicy', '1', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('66', '7', 'Lẩu nấm thập cẩm', 'Mixed Mushroom Hot Pot', 'Lẩu nấm các loại, rau, đậu hũ', '280000', NULL, '1', '1', 'vegetarian', '2', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('67', '7', 'Lẩu bò nhúng dấm', 'Vinegar Beef Hot Pot', 'Bò nhúng dấm, rau sống, bún', '320000', NULL, '1', '1', 'recommended', '3', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('68', '7', 'Lẩu gà lá é', 'Chicken Hot Pot with Herbs', 'Gà ta nấu lá é, nấm', '290000', NULL, '1', '1', NULL, '4', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('69', '7', 'Lẩu cá kèo', 'Mudfish Hot Pot', 'Cá kèo tươi, rau đắng, bún', '260000', NULL, '1', '1', NULL, '5', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('70', '8', 'Tôm sú nướng muối ớt', 'Grilled Tiger Prawn', 'Tôm sú tươi nướng muối ớt', '280000', NULL, '1', '1', 'bestseller,spicy', '1', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('71', '8', 'Mực nướng sa tế', 'Grilled Squid with Satay', 'Mực trứng nướng sa tế', '165000', NULL, '1', '1', 'spicy', '2', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('72', '8', 'Sườn nướng BBQ', 'BBQ Pork Ribs', 'Sườn heo nướng sốt BBQ', '195000', NULL, '1', '1', 'recommended', '3', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('73', '8', 'Gà nướng mật ong', 'Honey Grilled Chicken', 'Gà ta nướng mật ong', '175000', NULL, '1', '1', NULL, '4', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('74', '8', 'Ba chỉ bò Mỹ nướng', 'Grilled Beef Belly', 'Ba chỉ bò Mỹ nướng than hoa', '220000', NULL, '1', '1', NULL, '5', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('75', '9', 'Cơm chiên hải sản', 'Seafood Fried Rice', 'Cơm chiên với tôm, mực, trứng', '120000', NULL, '1', '1', 'bestseller', '1', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('76', '9', 'Cơm chiên dương châu', 'Yangzhou Fried Rice', 'Cơm chiên với thịt xá xíu, tôm, trứng', '110000', NULL, '1', '1', NULL, '2', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('77', '9', 'Cơm gà xối mỡ', 'Crispy Skin Chicken Rice', 'Gà da giòn, cơm mỡ hành', '95000', NULL, '1', '1', 'recommended', '3', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('78', '9', 'Cơm sườn nướng', 'Grilled Pork Chop Rice', 'Sườn nướng, bì, chả, đồ chua', '85000', NULL, '1', '1', NULL, '4', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('79', '9', 'Cơm bò kho', 'Braised Beef Rice', 'Bò kho đậm đà, bánh mì', '95000', NULL, '1', '1', NULL, '5', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('80', '10', 'Phở bò đặc biệt', 'Special Beef Pho', 'Phở bò với gầu, nạm, gân, bánh phở tươi', '95000', NULL, '1', '1', 'bestseller', '1', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('81', '10', 'Phở gà', 'Chicken Pho', 'Phở gà ta, bánh phở tươi', '85000', NULL, '1', '1', NULL, '2', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('82', '10', 'Bún bò Huế', 'Hue Beef Noodle Soup', 'Bún bò cay nồng, giò heo, chả cua', '95000', NULL, '1', '1', 'spicy', '3', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('83', '10', 'Bún chả cá', 'Fish Cake Noodle Soup', 'Bún với chả cá, nước dùng ngọt', '85000', NULL, '1', '1', NULL, '4', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('84', '10', 'Mì xào giòn', 'Crispy Noodles', 'Mì giòn với hải sản, rau cải', '110000', NULL, '1', '1', NULL, '5', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('85', '10', 'Hủ tiếu Nam Vang', 'Phnom Penh Noodles', 'Hủ tiếu với tôm, thịt, gan', '85000', NULL, '1', '1', NULL, '6', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('86', '11', 'Cá chẽm hấp hồng hạnh', 'Steamed Seabass with Mushrooms', 'Cá chẽm tươi hấp với nấm hồng hạnh', '320000', NULL, '1', '1', 'recommended', '1', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('87', '11', 'Tôm càng nướng mọi', 'Grilled River Prawn', 'Tôm càng sông nướng mọi', '380000', NULL, '1', '1', 'bestseller', '2', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('88', '11', 'Mực hấp gừng sả', 'Steamed Squid with Ginger', 'Mực tươi hấp gừng sả', '185000', NULL, '1', '1', NULL, '3', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('89', '11', 'Sò huyết nướng mỡ hành', 'Grilled Clams with Scallion', 'Sò huyết tươi nướng mỡ hành', '165000', NULL, '1', '1', NULL, '4', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('90', '11', 'Cua rang me', 'Tamarind Crab', 'Cua biển rang me', '450000', NULL, '1', '1', NULL, '5', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('91', '3', 'Chè bưởi', 'Pomelo Dessert', 'Chè bưởi hạt lựu, nước cốt dừa', '45000', NULL, '1', '1', 'bestseller', '1', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('92', '3', 'Kem dừa', 'Coconut Ice Cream', 'Kem dừa tươi, đậu phộng', '55000', NULL, '1', '1', 'bestseller', '2', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('93', '3', 'Sương sa hạt lựu', 'Jelly Dessert', 'Sương sa, hạt lựu, nước đường', '40000', NULL, '1', '1', NULL, '3', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('94', '3', 'Bánh flan', 'Crème Caramel', 'Bánh flan trứng, caramel', '50000', NULL, '1', '1', NULL, '4', '2026-03-07 18:46:29', '2026-03-07 18:46:29');
INSERT INTO `menu_items` VALUES ('125', '12', 'Salad Cá Ngừ', 'Tuna Salad', 'Xà lách, cà chua, dưa leo, cá ngừ, trứng cút', '125000', NULL, '1', '1', 'bestseller', '1', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('126', '12', 'Salad Bò Nướng', 'Grilled Beef Salad', 'Thịt bò nướng, rau mixed, sốt vinaigrette', '145000', NULL, '1', '1', 'recommended', '2', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('127', '12', 'Salad Caesar', 'Caesar Salad', 'Xà lách romaine, sốt caesar, bánh mì giòn, phô mai parmesan', '115000', NULL, '1', '1', 'bestseller', '3', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('128', '12', 'Salad Hải Sản', 'Seafood Salad', 'Tôm, mực, bạch tuộc trộn với rau', '185000', NULL, '1', '1', NULL, '4', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('129', '13', 'Súp Hành Tây', 'French Onion Soup', 'Hành tây caramen, phô mai nướng', '95000', NULL, '1', '1', NULL, '1', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('130', '13', 'Súp Nấm Kem Tươi', 'Cream of Mushroom Soup', 'Nấm các loại, kem tươi, ăn kèm bánh mì', '85000', NULL, '1', '1', 'vegetarian', '2', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('131', '13', 'Súp Hải Sản', 'Seafood Chowder', 'Súp kem với tôm, mực, nghêu', '135000', NULL, '1', '1', 'recommended', '3', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('132', '13', 'Súp Bí Đỏ', 'Pumpkin Soup', 'Bí đỏ, kem tươi, hạt bí', '75000', NULL, '1', '1', 'vegetarian', '4', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('133', '14', 'Gà Áp Chảo Sốt Vang Đỏ', 'Pan-Seared Chicken with Red Wine', 'Ức gà áp chảo, sốt vang đỏ, khoai tây nghiền', '185000', NULL, '1', '1', 'recommended', '1', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('134', '14', 'Sườn Heo Nướng Mật Ong', 'Honey Glazed Pork Ribs', 'Sườn heo nướng mật ong, rau củ', '195000', NULL, '1', '1', NULL, '2', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('135', '14', 'Cá Hồi Áp Chảo', 'Pan-Seared Salmon', 'Cá hồi Na Uy, sốt chanh dây, khoai lang', '245000', NULL, '1', '1', 'bestseller', '3', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('136', '14', 'Cừu Nướng Kiểu Úc', 'Australian Lamb Rack', 'Sườn cừu nướng, xốt bạc hà, khoai tây', '385000', NULL, '1', '1', NULL, '4', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('137', '15', 'Spaghetti Carbonara', 'Spaghetti Carbonara', 'Mì Ý với thịt xông khói, trứng, phô mai', '145000', NULL, '1', '1', 'bestseller', '1', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('138', '15', 'Spaghetti Bolognese', 'Spaghetti Bolognese', 'Mì Ý với sốt bò băm cà chua', '135000', NULL, '1', '1', NULL, '2', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('139', '15', 'Fettuccine Alfredo', 'Fettuccine Alfredo', 'Mì fettuccine với sốt kem phô mai', '140000', NULL, '1', '1', 'vegetarian', '3', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('140', '15', 'Penne Hải Sản', 'Seafood Penne', 'Mì penne với tôm, mực, nghêu, sốt cà chua', '175000', NULL, '1', '1', 'recommended', '4', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('141', '15', 'Lasagna Thịt Bò', 'Beef Lasagna', 'Mì lớp với thịt bò, phô mai, sốt cà chua', '165000', NULL, '1', '1', NULL, '5', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('142', '16', 'Bò Úc Úc Úc Úc Úc Úc Úc', 'Australian Beef Steak', 'Thăn bò Úc 200g, sốt tiêu đen, khoai tây', '385000', NULL, '1', '1', 'bestseller', '1', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('143', '16', 'Bò Mỹ Ribeye', 'American Ribeye', 'Ribeye bò Mỹ 300g, sốt nấm, rau củ', '520000', NULL, '1', '1', NULL, '2', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('144', '16', 'Bò Nhật Wagyu A5', 'Japanese Wagyu A5', 'Wagyu A5 Nhật 150g, sốt rượu vang', '1250000', NULL, '1', '1', NULL, '3', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('145', '16', 'Bò Canada Tenderloin', 'Canadian Tenderloin', 'Thăn mềm Canada 250g, sốt bơ chanh', '420000', NULL, '1', '1', 'recommended', '4', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('146', '16', 'Bò Ba Chỉ Nướng', 'Grilled Beef Belly', 'Ba chỉ bò Mỹ 200g, sốt BBQ, khoai lang', '280000', NULL, '1', '1', NULL, '5', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('147', '17', 'Cá Chẽm Sốt Chanh Bơ', 'Seabass with Lemon Butter', 'Phi lê cá chẽm, sốt chanh bơ, măng tây', '265000', NULL, '1', '1', 'recommended', '1', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('148', '17', 'Cá Hồi Nướng Muối Ớt', 'Grilled Salmon', 'Cá hồi nướng muối ớt, rau củ', '245000', NULL, '1', '1', NULL, '2', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('149', '17', 'Tôm Hùm Nướng Bơ Tỏi', 'Grilled Lobster', 'Tôm hùm Canada nướng bơ tỏi', '850000', NULL, '1', '1', NULL, '3', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('150', '17', 'Nghêu Hấp Rượu Vang', 'Steamed Clams in Wine', 'Nghêu tươi hấp rượu vang trắng, tỏi', '185000', NULL, '1', '1', NULL, '4', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('151', '18', 'Pizza Margherita', 'Pizza Margherita', 'Cà chua, phô mai mozzarella, húng quế', '165000', NULL, '1', '1', 'bestseller,vegetarian', '1', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('152', '18', 'Pizza Pepperoni', 'Pizza Pepperoni', 'Xúc xích pepperoni, phô mai, sốt cà chua', '185000', NULL, '1', '1', 'bestseller', '2', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('153', '18', 'Pizza Hải Sản', 'Seafood Pizza', 'Tôm, mực, nghêu, phô mai', '225000', NULL, '1', '1', 'recommended', '3', '2026-03-07 18:47:06', '2026-03-07 18:47:06');
INSERT INTO `menu_items` VALUES ('154', '18', 'Pizza Thịt Xông Khói', 'BBQ Chicken Pizza', 'Thịt gà, thịt xông khói, sốt BBQ', '195000', NULL, '1', '1', NULL, '4', '2026-03-07 18:47:06', '2026-03-07 18:47:06');

DROP TABLE IF EXISTS `menu_set_items`;
CREATE TABLE `menu_set_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `set_id` int(10) unsigned NOT NULL,
  `menu_item_id` int(10) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `is_required` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=bắt buộc, 0=tuỳ chọn',
  `sort_order` smallint(5) unsigned DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_set_items_set` (`set_id`),
  KEY `fk_set_items_menu` (`menu_item_id`),
  CONSTRAINT `fk_set_items_menu` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_set_items_set` FOREIGN KEY (`set_id`) REFERENCES `menu_sets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `menu_set_items` VALUES ('9', '7', '80', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('10', '7', '10', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('11', '8', '4', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('12', '8', '10', '1', '0', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('13', '9', '4', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('14', '9', '1', '2', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('15', '9', '14', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('16', '10', '80', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('17', '10', '56', '2', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('18', '10', '10', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('19', '11', '137', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('20', '11', '127', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('21', '11', '14', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('22', '12', '130', '2', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('23', '12', '125', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('24', '12', '135', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('25', '12', '142', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('26', '12', '9', '2', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('27', '13', '61', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('28', '13', '65', '1', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('29', '13', '4', '2', '1', '0', '2026-03-07 18:47:50');
INSERT INTO `menu_set_items` VALUES ('30', '13', '9', '2', '1', '0', '2026-03-07 18:47:50');

DROP TABLE IF EXISTS `menu_sets`;
CREATE TABLE `menu_sets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL COMMENT 'Tên set',
  `name_en` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,0) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` smallint(5) unsigned DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `menu_sets` VALUES ('7', 'Set Ăn Sáng Á Cơ Bản', 'Basic Asian Breakfast Set', 'Lựa chọn: Phở bò HOẶC Cơm chiên + Nước ép', '95000', NULL, '1', '1', '2026-03-07 18:47:15', '2026-03-07 18:47:15');
INSERT INTO `menu_sets` VALUES ('8', 'Set Ăn Sáng Âu Cơ Bản', 'Basic European Breakfast Set', 'Lựa chọn: Eggs Benedict HOẶC Pancake + Cà phê', '110000', NULL, '1', '2', '2026-03-07 18:47:15', '2026-03-07 18:47:15');
INSERT INTO `menu_sets` VALUES ('9', 'Set Trưa Văn Phòng 1', 'Office Lunch Set 1', 'Cơm chiên hải sản + Gỏi cuốn + Nước suối', '120000', NULL, '1', '3', '2026-03-07 18:47:15', '2026-03-07 18:47:15');
INSERT INTO `menu_sets` VALUES ('10', 'Set Trưa Văn Phòng 2', 'Office Lunch Set 2', 'Phở bò + Chả giò + Nước ép cam', '115000', NULL, '1', '4', '2026-03-07 18:47:15', '2026-03-07 18:47:15');
INSERT INTO `menu_sets` VALUES ('11', 'Set Trưa Nhanh', 'Quick Lunch Set', 'Mì Ý + Salad + Nước uống', '135000', NULL, '1', '5', '2026-03-07 18:47:15', '2026-03-07 18:47:15');
INSERT INTO `menu_sets` VALUES ('12', 'Set Tối Lãng Mạn 2 Người', 'Romantic Dinner for 2', 'Súp + Salad + 2 Món chính + Tráng miệng + 2 Nước', '650000', NULL, '1', '6', '2026-03-07 18:47:15', '2026-03-07 18:47:15');
INSERT INTO `menu_sets` VALUES ('13', 'Set Tối Á 2 Người', 'Asian Dinner for 2', 'Gỏi + Lẩu Thái + 2 Cơm + Tráng miệng + 2 Nước', '580000', NULL, '1', '7', '2026-03-07 18:47:15', '2026-03-07 18:47:15');
INSERT INTO `menu_sets` VALUES ('14', 'Set Gia Đình 4 Người', 'Family Set for 4', 'Gỏi + 2 Món chính + Cơm + Tráng miệng + Nước', '1250000', NULL, '1', '8', '2026-03-07 18:47:15', '2026-03-07 18:47:15');
INSERT INTO `menu_sets` VALUES ('15', 'Set Gia Đình 6 Người', 'Family Set for 6', 'Gỏi + 3 Món chính + Lẩu + Cơm + Tráng miệng + Nước', '1850000', NULL, '1', '9', '2026-03-07 18:47:15', '2026-03-07 18:47:15');
INSERT INTO `menu_sets` VALUES ('16', 'Set BBQ 2 Người', 'BBQ Set for 2', 'Ba chỉ bò + Sườn + Gà + Rau + Sốt + Cơm', '550000', NULL, '1', '10', '2026-03-07 18:47:15', '2026-03-07 18:47:15');
INSERT INTO `menu_sets` VALUES ('17', 'Set BBQ 4 Người', 'BBQ Set for 4', 'Ba chỉ bò + Sườn + Tôm + Mực + Gà + Rau + Sốt + Cơm', '1100000', NULL, '1', '11', '2026-03-07 18:47:15', '2026-03-07 18:47:15');
INSERT INTO `menu_sets` VALUES ('18', 'Set Hải Sản 2 Người', 'Seafood Set for 2', 'Gỏi hải sản + Cá hấp + Tôm nướng + Cơm + Tráng miệng', '750000', NULL, '1', '12', '2026-03-07 18:47:15', '2026-03-07 18:47:15');
INSERT INTO `menu_sets` VALUES ('19', 'Set Hải Sản 4 Người', 'Seafood Set for 4', 'Gỏi hải sản + Cá hấp + Tôm nướng + Cua + Cơm + Tráng miệng', '1450000', NULL, '1', '13', '2026-03-07 18:47:15', '2026-03-07 18:47:15');

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `table_id` int(11) unsigned DEFAULT NULL COMMENT 'Bàn vật lý mà món này thuộc về (cho merged tables)',
  `menu_item_id` int(10) unsigned NOT NULL,
  `item_name` varchar(150) NOT NULL COMMENT 'Snapshot tên món tại thời điểm ghi',
  `item_price` decimal(10,0) NOT NULL COMMENT 'Snapshot giá tại thời điểm ghi',
  `quantity` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `note` varchar(255) DEFAULT NULL COMMENT 'Ghi chú: không hành, ít cay...',
  `split_from_item_id` int(11) unsigned DEFAULT NULL COMMENT 'ID của món gốc mà món này được tách từ đó',
  `is_split_item` tinyint(1) unsigned DEFAULT 0 COMMENT '1 = món này đã được tách từ bàn khác',
  `status` enum('draft','confirmed','cancelled') DEFAULT 'draft',
  `customer_id` varchar(64) DEFAULT NULL COMMENT 'Session ID của khách hàng (cho customer ordering)',
  `submitted_at` timestamp NULL DEFAULT NULL COMMENT 'Thời gian khách gửi món (chuyển từ draft sang pending)',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_order_items_order` (`order_id`),
  KEY `fk_order_items_menu` (`menu_item_id`),
  KEY `idx_order_items_table` (`table_id`),
  KEY `idx_split_tracking` (`is_split_item`,`split_from_item_id`),
  KEY `idx_table_status` (`table_id`,`status`),
  KEY `idx_customer_id` (`customer_id`),
  KEY `idx_submitted_at` (`submitted_at`),
  CONSTRAINT `fk_order_items_menu` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_items_table` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `order_items` VALUES ('1', '1', '6', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 19:22:05', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('2', '1', '6', '125', 'Salad Cá Ngừ', '125000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 19:23:55', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('3', '1', '6', '126', 'Salad Bò Nướng', '145000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 19:23:58', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('4', '1', '6', '131', 'Súp Hải Sản', '135000', '2', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 19:24:37', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('5', '1', '6', '59', 'Súp cua vi cá', '180000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 19:30:57', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('6', '7', '1', '55', 'Gỏi cuốn tôm thịt', '85000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:04:53', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('7', '7', '1', '2', 'Chả giò rế', '75000', '2', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:04:59', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('8', '7', '1', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:05:05', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('9', '7', '1', '4', 'Cơm chiên hải sản', '120000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:05:08', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('10', '7', '1', '5', 'Bò lúc lắc', '180000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:05:09', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('11', '7', '1', '137', 'Spaghetti Carbonara', '145000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:05:19', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('12', '8', '1', '2', 'Chả giò rế', '75000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:07:08', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('13', '8', '1', '60', 'Súp bào ngư', '220000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:07:10', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('14', '8', '1', '2', 'Chả giò rế', '75000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:08:44', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('15', '8', '1', '55', 'Gỏi cuốn tôm thịt', '85000', '1', 'Không cho ớt', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:09:47', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('16', '8', '1', '55', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:13:03', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('17', '8', '1', '71', 'Mực nướng sa tế', '165000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:13:06', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('18', '8', '1', '60', 'Súp bào ngư', '220000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:14:37', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('19', '8', '1', '60', 'Súp bào ngư', '220000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:16:03', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('20', '8', '1', '3', 'Súp bào ngư vi cá', '150000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:16:50', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('21', '10', '6', '2', 'Chả giò rế', '75000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:17:31', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('22', '10', '6', '5', 'Bò lúc lắc', '180000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:17:34', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('23', '10', '6', '71', 'Mực nướng sa tế', '165000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:17:37', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('24', '10', '6', '80', 'Phở bò đặc biệt', '95000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:17:42', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('25', '10', '6', '77', 'Cơm gà xối mỡ', '95000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:20:03', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('26', '9', '4', '55', 'Gỏi cuốn tôm thịt', '85000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:32:14', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('27', '9', '4', '66', 'Lẩu nấm thập cẩm', '280000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:32:16', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('28', '12', '1', '55', 'Gỏi cuốn tôm thịt', '85000', '5', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 20:39:33', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('29', '13', '7', '55', 'Gỏi cuốn tôm thịt', '85000', '8', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:16:36', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('31', '13', '7', '57', 'Nem nướng Nha Trang', '110000', '2', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:16:43', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('32', '13', '7', '67', 'Lẩu bò nhúng dấm', '320000', '2', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:16:45', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('33', '13', '7', '9', 'Kem dừa', '55000', '8', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:16:47', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('34', '14', '1', '1', 'Gỏi cuốn tôm thịt', '85000', '12', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:25:30', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('35', '14', '1', '58', 'Bò lúc lắc', '145000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:25:36', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('36', '14', '1', '60', 'Súp bào ngư', '220000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:25:43', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('37', '14', '1', '63', 'Gỏi hải sản Thái', '165000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:25:49', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('38', '14', '1', '7', 'Tôm sú nướng muối ớt', '220000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:25:55', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('39', '14', '1', '9', 'Kem dừa', '55000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:26:02', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('40', '14', '1', '94', 'Bánh flan', '50000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:26:03', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('41', '14', '1', '92', 'Kem dừa', '55000', '6', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:26:07', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('42', '14', '1', '71', 'Mực nướng sa tế', '165000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:26:24', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('44', '15', '1', '10', 'Nước ép cam', '65000', '1', 'Set: Set Ăn Sáng Á Cơ Bản', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:59:41', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('45', '15', '1', '80', 'Phở bò đặc biệt', '95000', '1', 'Set: Set Ăn Sáng Á Cơ Bản', NULL, '0', 'confirmed', NULL, NULL, '2026-03-07 21:59:41', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('46', '17', '22', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 09:58:21', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('47', '17', '22', '55', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 09:58:22', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('48', '17', '22', '2', 'Chả giò rế', '75000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 09:58:25', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('49', '17', '22', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 09:58:46', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('50', '17', '22', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 10:00:38', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('51', '17', '22', '10', 'Nước ép cam', '65000', '1', 'Set: Set Ăn Sáng Á Cơ Bản', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 10:01:33', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('52', '17', '22', '80', 'Phở bò đặc biệt', '95000', '1', 'Set: Set Ăn Sáng Á Cơ Bản', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 10:01:33', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('53', '17', '22', '4', 'Cơm chiên hải sản', '120000', '1', 'Set: Set Trưa Văn Phòng 1', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 10:01:37', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('54', '17', '22', '1', 'Gỏi cuốn tôm thịt', '85000', '2', 'Set: Set Trưa Văn Phòng 1', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 10:01:37', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('55', '17', '22', '14', 'Nước suối', '15000', '1', 'Set: Set Trưa Văn Phòng 1', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 10:01:37', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('56', '17', '22', '14', 'Nước suối', '15000', '1', 'Set: Set Trưa Nhanh', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 10:01:53', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('57', '17', '22', '127', 'Salad Caesar', '115000', '1', 'Set: Set Trưa Nhanh', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 10:01:53', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('58', '17', '22', '137', 'Spaghetti Carbonara', '145000', '1', 'Set: Set Trưa Nhanh', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 10:01:53', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('60', '22', '19', '10', 'Nước ép cam', '65000', '1', 'Set: Set Ăn Sáng Á Cơ Bản', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 10:25:13', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('61', '22', '19', '80', 'Phở bò đặc biệt', '95000', '1', 'Set: Set Ăn Sáng Á Cơ Bản', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 10:25:13', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('62', '30', '19', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 15:22:52', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('63', '30', '19', '55', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 15:22:53', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('64', '30', '19', '2', 'Chả giò rế', '75000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-08 15:22:55', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('65', '32', '21', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-09 22:26:35', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('66', '32', '21', '2', 'Chả giò rế', '75000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-09 22:26:38', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('67', '32', '21', '56', 'Chả giò rế hải sản', '95000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-09 22:26:38', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('68', '32', '21', '57', 'Nem nướng Nha Trang', '110000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-09 22:26:40', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('69', '32', '21', '58', 'Bò lúc lắc', '145000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-09 22:26:41', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('70', '32', '21', '3', 'Súp bào ngư vi cá', '150000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-09 22:26:42', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('71', '32', '21', '63', 'Gỏi hải sản Thái', '165000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-09 22:26:45', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('72', '32', '21', '65', 'Lẩu thái hải sản', '350000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-09 22:26:51', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('73', '32', '21', '9', 'Kem dừa', '55000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-09 22:26:54', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('74', '32', '21', '93', 'Sương sa hạt lựu', '40000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-09 22:26:56', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('75', '33', '13', '3', 'Súp bào ngư vi cá', '150000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-16 09:28:06', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('76', '33', '13', '60', 'Súp bào ngư', '220000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-16 09:28:08', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('77', '33', '13', '62', 'Gỏi đu đủ bò khô', '95000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-16 09:28:09', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('78', '34', '19', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-16 14:52:21', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('79', '34', '19', '55', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-16 14:52:22', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('80', '34', '19', '2', 'Chả giò rế', '75000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-16 14:52:23', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('81', '35', '20', '10', 'Nước ép cam', '65000', '1', 'Set: Set Ăn Sáng Á Cơ Bản', NULL, '0', 'draft', NULL, NULL, '2026-03-16 18:13:44', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('82', '35', '20', '80', 'Phở bò đặc biệt', '95000', '4', 'Set: Set Ăn Sáng Á Cơ Bản', NULL, '0', 'draft', NULL, NULL, '2026-03-16 18:13:44', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('83', '36', '22', '66', 'Lẩu nấm thập cẩm', '280000', '1', '', NULL, '0', 'draft', NULL, NULL, '2026-03-16 20:26:28', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('84', '42', '19', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 08:04:05', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('85', '42', '19', '55', 'Gỏi cuốn tôm thịt', '85000', '2', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 08:15:52', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('100', '43', '20', '10', 'Nước ép cam', '65000', '1', 'Set: Set Ăn Sáng Á Cơ Bản', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:00:23', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('101', '43', '20', '80', 'Phở bò đặc biệt', '95000', '1', 'Set: Set Ăn Sáng Á Cơ Bản', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:00:23', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('103', '43', '20', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:29:19', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('109', '44', '20', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:49:02', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('110', '44', '20', '55', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:49:04', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('111', '45', '23', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:49:26', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('112', '45', '23', '55', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:49:27', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('113', '46', '19', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:52:17', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('114', '47', '20', '55', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:52:44', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('117', '47', '20', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:56:07', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('118', '47', '20', '87', 'Tôm càng nướng mọi', '380000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:56:26', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('119', '47', '20', '55', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:59:18', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('120', '47', '20', '86', 'Cá chẽm hấp hồng hạnh', '320000', '2', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:59:27', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('121', '47', '20', '152', 'Pizza Pepperoni', '185000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:59:29', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('122', '47', '20', '153', 'Pizza Hải Sản', '225000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 11:59:32', '2026-03-17 12:19:12');
INSERT INTO `order_items` VALUES ('123', '49', '19', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 12:21:31', '2026-03-17 12:51:23');
INSERT INTO `order_items` VALUES ('124', '49', '19', '2', 'Chả giò rế', '75000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 12:21:34', '2026-03-17 12:51:23');
INSERT INTO `order_items` VALUES ('125', '51', '19', '1', 'Gỏi cuốn tôm thịt', '85000', '8', '', NULL, '0', 'draft', NULL, NULL, '2026-03-17 13:04:24', '2026-03-17 13:41:57');
INSERT INTO `order_items` VALUES ('126', '52', '21', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 13:29:53', '2026-03-17 13:29:58');
INSERT INTO `order_items` VALUES ('127', '52', '21', '55', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 13:29:56', '2026-03-17 13:29:58');
INSERT INTO `order_items` VALUES ('128', '53', '21', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 13:43:05', '2026-03-17 13:43:11');
INSERT INTO `order_items` VALUES ('129', '53', '21', '56', 'Chả giò rế hải sản', '95000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 13:43:06', '2026-03-17 13:43:11');
INSERT INTO `order_items` VALUES ('130', '53', '21', '14', 'Nước suối', '15000', '1', 'Set: Set Trưa Nhanh', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 13:43:09', '2026-03-17 13:43:11');
INSERT INTO `order_items` VALUES ('131', '53', '21', '127', 'Salad Caesar', '115000', '1', 'Set: Set Trưa Nhanh', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 13:43:09', '2026-03-17 13:43:11');
INSERT INTO `order_items` VALUES ('132', '53', '21', '137', 'Spaghetti Carbonara', '145000', '1', 'Set: Set Trưa Nhanh', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 13:43:09', '2026-03-17 13:43:11');
INSERT INTO `order_items` VALUES ('133', '55', '27', '57', 'Nem nướng Nha Trang', '110000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 14:05:54', '2026-03-17 14:06:54');
INSERT INTO `order_items` VALUES ('134', '55', '27', '3', 'Súp bào ngư vi cá', '150000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 14:05:56', '2026-03-17 14:06:54');
INSERT INTO `order_items` VALUES ('135', '55', '27', '58', 'Bò lúc lắc', '145000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 14:05:56', '2026-03-17 14:06:54');
INSERT INTO `order_items` VALUES ('136', '55', '27', '87', 'Tôm càng nướng mọi', '380000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 14:06:10', '2026-03-17 14:06:54');
INSERT INTO `order_items` VALUES ('137', '55', '27', '89', 'Sò huyết nướng mỡ hành', '165000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 14:06:29', '2026-03-17 14:06:54');
INSERT INTO `order_items` VALUES ('138', '55', '27', '153', 'Pizza Hải Sản', '225000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 14:06:37', '2026-03-17 14:06:54');
INSERT INTO `order_items` VALUES ('139', '55', '27', '66', 'Lẩu nấm thập cẩm', '280000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 14:06:42', '2026-03-17 14:06:54');
INSERT INTO `order_items` VALUES ('140', '55', '27', '136', 'Cừu Nướng Kiểu Úc', '385000', '3', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-17 14:06:51', '2026-03-17 14:06:54');
INSERT INTO `order_items` VALUES ('141', '57', '12', '62', 'Gỏi đu đủ bò khô', '95000', '1', '', NULL, '0', '', 'rrvdnl6pgo3b3etu7gpgople8p', '2026-03-17 19:26:16', '2026-03-17 19:26:16', '2026-03-17 19:26:16');
INSERT INTO `order_items` VALUES ('142', '57', '12', '126', 'Salad Bò Nướng', '145000', '1', '', NULL, '0', '', 'rrvdnl6pgo3b3etu7gpgople8p', '2026-03-17 19:26:16', '2026-03-17 19:26:16', '2026-03-17 19:26:16');
INSERT INTO `order_items` VALUES ('143', '57', '12', '5', 'Bò lúc lắc', '180000', '1', '', NULL, '0', '', 'rrvdnl6pgo3b3etu7gpgople8p', '2026-03-17 19:26:16', '2026-03-17 19:26:16', '2026-03-17 19:26:16');
INSERT INTO `order_items` VALUES ('144', '57', '12', '67', 'Lẩu bò nhúng dấm', '320000', '1', '', NULL, '0', '', 'rrvdnl6pgo3b3etu7gpgople8p', '2026-03-17 19:27:05', '2026-03-17 19:27:05', '2026-03-17 19:27:05');
INSERT INTO `order_items` VALUES ('145', '57', '12', '61', 'Gỏi ngó sen tôm thịt', '125000', '1', '', NULL, '0', '', 'rrvdnl6pgo3b3etu7gpgople8p', '2026-03-17 19:27:39', '2026-03-17 19:27:39', '2026-03-17 19:27:39');
INSERT INTO `order_items` VALUES ('146', '58', '1', '61', 'Gỏi ngó sen tôm thịt', '125000', '1', '', NULL, '0', '', 'cu0rl0q4flcp73fpn9gns57njh', '2026-03-17 19:38:54', '2026-03-17 19:38:54', '2026-03-17 19:38:54');
INSERT INTO `order_items` VALUES ('147', '62', '1', '8', 'Chè bưởi', '45000', '1', '', NULL, '0', 'draft', NULL, NULL, '2026-03-17 21:24:28', '2026-03-17 21:24:28');
INSERT INTO `order_items` VALUES ('148', '62', '1', '61', 'Gỏi ngó sen tôm thịt', '125000', '3', '', NULL, '0', '', 'cu0rl0q4flcp73fpn9gns57njh', '2026-03-17 21:24:56', '2026-03-17 21:24:56', '2026-03-17 21:24:56');
INSERT INTO `order_items` VALUES ('149', '64', '21', '9', 'Kem dừa', '55000', '1', '', NULL, '0', 'draft', NULL, NULL, '2026-03-17 21:33:15', '2026-03-17 21:33:15');
INSERT INTO `order_items` VALUES ('150', '64', '21', '94', 'Bánh flan', '50000', '1', '', NULL, '0', 'draft', NULL, NULL, '2026-03-17 21:33:17', '2026-03-17 21:33:17');
INSERT INTO `order_items` VALUES ('151', '65', '12', '61', 'Gỏi ngó sen tôm thịt', '125000', '1', '', NULL, '0', '', 'ak6lf5e3u96gei6kdovnlblkhl', '2026-03-18 09:50:48', '2026-03-18 09:50:48', '2026-03-18 09:50:48');
INSERT INTO `order_items` VALUES ('152', '69', '2', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', '152', '1', 'confirmed', NULL, NULL, '2026-03-18 10:24:10', '2026-03-18 10:25:24');
INSERT INTO `order_items` VALUES ('153', '68', '19', '55', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'draft', NULL, NULL, '2026-03-18 10:24:11', '2026-03-18 10:24:11');
INSERT INTO `order_items` VALUES ('154', '71', '4', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', '154', '1', 'confirmed', NULL, NULL, '2026-03-18 10:27:16', '2026-03-18 10:30:29');
INSERT INTO `order_items` VALUES ('155', '70', '1', '55', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-18 10:27:17', '2026-03-18 10:27:20');
INSERT INTO `order_items` VALUES ('156', '70', '1', '2', 'Chả giò rế', '75000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-18 10:27:18', '2026-03-18 10:27:20');
INSERT INTO `order_items` VALUES ('157', '70', '1', '56', 'Chả giò rế hải sản', '95000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-18 10:27:19', '2026-03-18 10:27:20');
INSERT INTO `order_items` VALUES ('158', '72', '1', '1', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-18 10:32:57', '2026-03-18 10:33:03');
INSERT INTO `order_items` VALUES ('159', '72', '1', '55', 'Gỏi cuốn tôm thịt', '85000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-18 10:32:58', '2026-03-18 10:33:03');
INSERT INTO `order_items` VALUES ('160', '72', '1', '2', 'Chả giò rế', '75000', '1', '', NULL, '0', 'confirmed', NULL, NULL, '2026-03-18 10:32:59', '2026-03-18 10:33:03');
INSERT INTO `order_items` VALUES ('161', '73', '4', '56', 'Chả giò rế hải sản', '95000', '1', '', '161', '1', 'confirmed', NULL, NULL, '2026-03-18 10:33:00', '2026-03-18 10:33:26');

DROP TABLE IF EXISTS `order_notifications`;
CREATE TABLE `order_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned DEFAULT NULL,
  `table_id` int(10) unsigned NOT NULL,
  `notification_type` enum('new_order','order_item','support_request','payment_request','scan_qr') NOT NULL DEFAULT 'new_order',
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `read_by` int(10) unsigned DEFAULT NULL COMMENT 'Nhân viên đã đọc',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_notification_order` (`order_id`),
  KEY `idx_notification_table` (`table_id`),
  KEY `idx_notification_unread` (`is_read`),
  KEY `idx_notification_type` (`notification_type`),
  KEY `idx_notification_created` (`created_at`),
  CONSTRAINT `fk_notification_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_notification_table` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Lưu trữ thông báo order cho waiter';

INSERT INTO `order_notifications` VALUES ('1', NULL, '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:07:47');
INSERT INTO `order_notifications` VALUES ('2', NULL, '2', 'scan_qr', 'Bàn A.02: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.02', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:08:13');
INSERT INTO `order_notifications` VALUES ('3', NULL, '28', 'scan_qr', 'Bàn Âu 02: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn Âu 02', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:11:24');
INSERT INTO `order_notifications` VALUES ('4', NULL, '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:21:08');
INSERT INTO `order_notifications` VALUES ('5', NULL, '1', 'support_request', 'Bàn 1: Cần hỗ trợ', 'Khách tại bàn 1 đang gọi nhân viên.', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:21:27');
INSERT INTO `order_notifications` VALUES ('6', NULL, '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:21:56');
INSERT INTO `order_notifications` VALUES ('7', NULL, '1', 'support_request', 'Bàn 1: Cần hỗ trợ', 'Khách tại bàn 1 đang gọi nhân viên.', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:23:28');
INSERT INTO `order_notifications` VALUES ('8', NULL, '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:25:38');
INSERT INTO `order_notifications` VALUES ('9', NULL, '12', 'scan_qr', 'Bàn B.06: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn B.06', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:25:52');
INSERT INTO `order_notifications` VALUES ('10', '57', '12', 'new_order', 'Bàn 12: Order mới', 'Khách đã gửi order mới qua QR.', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:26:16');
INSERT INTO `order_notifications` VALUES ('11', '57', '12', 'scan_qr', 'Bàn B.06: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn B.06', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:26:52');
INSERT INTO `order_notifications` VALUES ('12', '57', '12', 'order_item', 'Bàn 12: Thêm món mới', 'Khách đã gửi thêm món qua QR.', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:27:05');
INSERT INTO `order_notifications` VALUES ('13', '57', '12', 'scan_qr', 'Bàn B.06: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn B.06', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:27:34');
INSERT INTO `order_notifications` VALUES ('14', '57', '12', 'order_item', 'Bàn 12: Thêm món mới', 'Khách đã gửi thêm món qua QR.', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:27:39');
INSERT INTO `order_notifications` VALUES ('15', NULL, '6', 'scan_qr', 'Bàn A.06: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.06', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:33:19');
INSERT INTO `order_notifications` VALUES ('16', NULL, '6', 'scan_qr', 'Bàn A.06: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.06', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:33:50');
INSERT INTO `order_notifications` VALUES ('17', NULL, '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:35:08');
INSERT INTO `order_notifications` VALUES ('18', '58', '1', 'new_order', 'Bàn 1: Order mới', 'Khách đã gửi order mới qua QR.', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:38:54');
INSERT INTO `order_notifications` VALUES ('19', NULL, '28', 'scan_qr', 'Bàn Âu 02: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn Âu 02', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:48:54');
INSERT INTO `order_notifications` VALUES ('20', NULL, '28', 'scan_qr', 'Bàn Âu 02: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn Âu 02', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:49:00');
INSERT INTO `order_notifications` VALUES ('21', NULL, '28', 'scan_qr', 'Bàn Âu 02: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn Âu 02', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:49:23');
INSERT INTO `order_notifications` VALUES ('22', NULL, '28', 'scan_qr', 'Bàn Âu 02: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn Âu 02', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:58:35');
INSERT INTO `order_notifications` VALUES ('23', NULL, '28', 'scan_qr', 'Bàn Âu 02: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn Âu 02', '1', '2026-03-18 09:43:59', '3', '2026-03-17 19:59:22');
INSERT INTO `order_notifications` VALUES ('24', '59', '28', 'scan_qr', 'Bàn Âu 02: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn Âu 02', '1', '2026-03-18 09:43:59', '3', '2026-03-17 20:16:09');
INSERT INTO `order_notifications` VALUES ('25', '60', '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:59', '3', '2026-03-17 21:17:12');
INSERT INTO `order_notifications` VALUES ('26', '61', '3', 'scan_qr', 'Bàn A.03: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.03', '1', '2026-03-18 09:43:59', '3', '2026-03-17 21:17:44');
INSERT INTO `order_notifications` VALUES ('27', '61', '3', 'scan_qr', 'Bàn A.03: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.03', '1', '2026-03-18 09:43:59', '3', '2026-03-17 21:19:34');
INSERT INTO `order_notifications` VALUES ('28', '61', '3', 'scan_qr', 'Bàn A.03: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.03', '1', '2026-03-18 09:43:59', '3', '2026-03-17 21:19:45');
INSERT INTO `order_notifications` VALUES ('29', '62', '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:58', '3', '2026-03-17 21:23:53');
INSERT INTO `order_notifications` VALUES ('30', '62', '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:58', '3', '2026-03-17 21:24:34');
INSERT INTO `order_notifications` VALUES ('31', '62', '1', 'order_item', 'Bàn 1: Thêm món mới', 'Khách đã gửi thêm món qua QR.', '1', '2026-03-18 09:43:58', '3', '2026-03-17 21:24:56');
INSERT INTO `order_notifications` VALUES ('32', '62', '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:57', '3', '2026-03-17 21:27:37');
INSERT INTO `order_notifications` VALUES ('33', '62', '1', 'support_request', 'Bàn 1: Cần hỗ trợ', 'Khách tại bàn 1 đang gọi nhân viên.', '1', '2026-03-18 09:43:57', '3', '2026-03-17 21:27:42');
INSERT INTO `order_notifications` VALUES ('34', '63', '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:57', '3', '2026-03-17 21:27:53');
INSERT INTO `order_notifications` VALUES ('35', '63', '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:57', '3', '2026-03-17 21:27:55');
INSERT INTO `order_notifications` VALUES ('36', '63', '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:57', '3', '2026-03-17 21:27:56');
INSERT INTO `order_notifications` VALUES ('37', '63', '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:57', '3', '2026-03-17 21:27:56');
INSERT INTO `order_notifications` VALUES ('38', '63', '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 09:43:56', '3', '2026-03-17 21:30:39');
INSERT INTO `order_notifications` VALUES ('39', '64', '21', 'scan_qr', 'Bàn VIP 2.1: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn VIP 2.1', '1', '2026-03-18 09:43:56', '3', '2026-03-17 21:45:09');
INSERT INTO `order_notifications` VALUES ('40', '64', '21', 'support_request', 'Bàn 21: Cần hỗ trợ', 'Khách tại bàn 21 đang gọi nhân viên.', '1', '2026-03-18 09:43:54', '3', '2026-03-17 21:45:17');
INSERT INTO `order_notifications` VALUES ('41', '65', '12', 'scan_qr', 'Bàn B.06: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn B.06', '1', '2026-03-18 09:51:02', '3', '2026-03-18 09:50:34');
INSERT INTO `order_notifications` VALUES ('42', '65', '12', 'order_item', 'Bàn 12: Thêm món mới', 'Khách đã gửi thêm món qua QR.', '1', '2026-03-18 09:51:05', '3', '2026-03-18 09:50:48');
INSERT INTO `order_notifications` VALUES ('43', '65', '12', 'scan_qr', 'Bàn B.06: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn B.06', '1', '2026-03-18 09:53:18', '3', '2026-03-18 09:51:15');
INSERT INTO `order_notifications` VALUES ('44', '65', '12', 'support_request', 'Bàn 12: Cần hỗ trợ', 'Khách tại bàn 12 đang gọi nhân viên.', '1', '2026-03-18 09:53:17', '3', '2026-03-18 09:51:19');
INSERT INTO `order_notifications` VALUES ('45', '66', '1', 'scan_qr', 'Bàn A.01: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.01', '1', '2026-03-18 10:09:33', '3', '2026-03-18 09:53:02');
INSERT INTO `order_notifications` VALUES ('46', '73', '4', 'scan_qr', 'Bàn A.04: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn A.04', '0', NULL, NULL, '2026-03-18 10:49:49');
INSERT INTO `order_notifications` VALUES ('47', NULL, '10', 'scan_qr', 'Bàn B.04: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn B.04', '0', NULL, NULL, '2026-03-18 11:00:45');
INSERT INTO `order_notifications` VALUES ('48', NULL, '10', 'support_request', 'Bàn 10: Cần hỗ trợ', 'Khách tại bàn 10 đang gọi nhân viên.', '0', NULL, NULL, '2026-03-18 11:01:19');
INSERT INTO `order_notifications` VALUES ('49', NULL, '14', 'scan_qr', 'Bàn C.02: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn C.02', '0', NULL, NULL, '2026-03-18 11:14:45');
INSERT INTO `order_notifications` VALUES ('50', NULL, '14', 'scan_qr', 'Bàn C.02: Khách đang xem menu', 'Khách vừa quét mã QR tại bàn C.02', '0', NULL, NULL, '2026-03-18 11:17:47');

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `table_id` int(10) unsigned NOT NULL,
  `waiter_id` int(10) unsigned DEFAULT NULL,
  `shift_id` int(10) unsigned DEFAULT NULL,
  `guest_count` tinyint(3) unsigned DEFAULT 1 COMMENT 'Số khách',
  `note` text DEFAULT NULL COMMENT 'Ghi chú cho cả order',
  `customer_notes` text DEFAULT NULL COMMENT 'Ghi chú từ khách hàng (lý do hủy, đặc biệt...)',
  `requires_confirmation` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Cần xác nhận từ nhân viên: 1=Có, 0=Không',
  `status` enum('open','closed') NOT NULL DEFAULT 'open' COMMENT 'open=đang phục vụ, closed=khách ra',
  `order_source` enum('waiter','customer_qr') NOT NULL DEFAULT 'waiter' COMMENT 'Nguồn tạo order: waiter (phục vụ) hoặc customer_qr (khách quét QR)',
  `is_realtime_hidden` tinyint(1) DEFAULT 0,
  `payment_method` varchar(50) DEFAULT 'cash',
  `payment_status` enum('pending','paid','canceled') DEFAULT 'pending',
  `opened_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Giờ mở bàn',
  `closed_at` timestamp NULL DEFAULT NULL COMMENT 'Giờ đóng bàn',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_orders_table` (`table_id`),
  KEY `idx_orders_waiter` (`waiter_id`),
  KEY `idx_orders_status` (`status`),
  KEY `idx_orders_opened` (`opened_at`),
  KEY `idx_order_source` (`order_source`),
  KEY `idx_orders_session` (`session_id`),
  CONSTRAINT `fk_orders_table` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_orders_waiter` FOREIGN KEY (`waiter_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `orders` VALUES ('1', '6', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-07 19:21:40', '2026-03-07 19:40:08', '2026-03-07 19:21:40', '2026-03-07 19:40:08', NULL);
INSERT INTO `orders` VALUES ('2', '4', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-07 19:44:21', '2026-03-07 19:52:34', '2026-03-07 19:44:21', '2026-03-07 19:52:34', NULL);
INSERT INTO `orders` VALUES ('3', '1', '3', '1', '8', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-07 19:53:10', '2026-03-07 19:58:24', '2026-03-07 19:53:10', '2026-03-07 19:58:24', NULL);
INSERT INTO `orders` VALUES ('4', '3', '3', '1', '9', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-07 19:57:02', '2026-03-07 19:58:18', '2026-03-07 19:57:02', '2026-03-07 19:58:18', NULL);
INSERT INTO `orders` VALUES ('5', '1', '3', '1', '7', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-07 19:59:42', '2026-03-07 20:01:13', '2026-03-07 19:59:42', '2026-03-07 20:01:13', NULL);
INSERT INTO `orders` VALUES ('6', '1', '3', '1', '9', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-07 20:01:17', '2026-03-07 20:03:38', '2026-03-07 20:01:17', '2026-03-07 20:03:38', NULL);
INSERT INTO `orders` VALUES ('7', '1', '3', '1', '11', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-07 20:03:43', '2026-03-07 20:06:53', '2026-03-07 20:03:43', '2026-03-07 20:06:53', NULL);
INSERT INTO `orders` VALUES ('8', '1', '3', '1', '12', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-07 20:06:59', '2026-03-07 20:27:55', '2026-03-07 20:06:59', '2026-03-07 20:27:55', NULL);
INSERT INTO `orders` VALUES ('9', '4', '3', '1', '7', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-07 20:10:15', '2026-03-07 20:37:57', '2026-03-07 20:10:15', '2026-03-07 20:37:57', NULL);
INSERT INTO `orders` VALUES ('10', '6', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-07 20:17:23', '2026-03-07 20:29:01', '2026-03-07 20:17:23', '2026-03-07 20:29:01', NULL);
INSERT INTO `orders` VALUES ('11', '1', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-07 20:39:23', '2026-03-07 20:39:28', '2026-03-07 20:39:23', '2026-03-07 20:39:28', NULL);
INSERT INTO `orders` VALUES ('12', '1', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-07 20:39:31', '2026-03-07 20:39:50', '2026-03-07 20:39:31', '2026-03-07 20:39:50', NULL);
INSERT INTO `orders` VALUES ('13', '7', '3', '1', '8', NULL, NULL, '1', 'closed', 'waiter', '1', 'transfer', 'paid', '2026-03-07 21:16:12', '2026-03-07 21:17:53', '2026-03-07 21:16:12', '2026-03-07 21:43:57', NULL);
INSERT INTO `orders` VALUES ('14', '1', '3', '1', '12', NULL, NULL, '1', 'closed', 'waiter', '1', 'cash', 'paid', '2026-03-07 21:25:19', '2026-03-07 21:34:14', '2026-03-07 21:25:19', '2026-03-07 21:43:46', NULL);
INSERT INTO `orders` VALUES ('15', '1', '3', '1', '12', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-07 21:57:35', '2026-03-08 09:47:58', '2026-03-07 21:57:35', '2026-03-08 09:47:58', NULL);
INSERT INTO `orders` VALUES ('16', '1', '3', '1', '2', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 09:38:02', '2026-03-08 09:49:51', '2026-03-08 09:38:02', '2026-03-08 09:49:51', NULL);
INSERT INTO `orders` VALUES ('17', '22', '3', '1', '11', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-08 09:58:13', '2026-03-08 10:10:54', '2026-03-08 09:58:13', '2026-03-08 10:10:54', NULL);
INSERT INTO `orders` VALUES ('18', '19', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 10:12:36', '2026-03-08 10:21:01', '2026-03-08 10:12:36', '2026-03-08 10:21:01', NULL);
INSERT INTO `orders` VALUES ('19', '23', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 10:12:51', '2026-03-08 10:20:57', '2026-03-08 10:12:51', '2026-03-08 10:20:57', NULL);
INSERT INTO `orders` VALUES ('20', '1', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 10:17:00', '2026-03-08 10:20:50', '2026-03-08 10:17:00', '2026-03-08 10:20:50', NULL);
INSERT INTO `orders` VALUES ('21', '1', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 10:24:24', '2026-03-08 10:24:32', '2026-03-08 10:24:24', '2026-03-08 10:24:32', NULL);
INSERT INTO `orders` VALUES ('22', '19', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-08 10:25:01', '2026-03-08 10:29:04', '2026-03-08 10:25:01', '2026-03-08 10:29:04', NULL);
INSERT INTO `orders` VALUES ('23', '1', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 10:26:37', '2026-03-08 10:27:45', '2026-03-08 10:26:37', '2026-03-08 10:27:45', NULL);
INSERT INTO `orders` VALUES ('24', '23', '3', '1', '10', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 10:27:07', '2026-03-08 10:27:42', '2026-03-08 10:27:07', '2026-03-08 10:27:42', NULL);
INSERT INTO `orders` VALUES ('25', '13', '3', '1', '12', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 10:27:27', '2026-03-08 10:27:38', '2026-03-08 10:27:27', '2026-03-08 10:27:38', NULL);
INSERT INTO `orders` VALUES ('26', '19', '3', '1', '12', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 10:31:58', '2026-03-08 13:56:39', '2026-03-08 10:31:58', '2026-03-08 13:56:39', NULL);
INSERT INTO `orders` VALUES ('27', '1', '3', '1', '12', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 10:50:35', '2026-03-08 13:51:54', '2026-03-08 10:50:35', '2026-03-08 13:51:54', NULL);
INSERT INTO `orders` VALUES ('28', '19', '3', '1', '2', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 13:58:27', '2026-03-08 13:58:31', '2026-03-08 13:58:27', '2026-03-08 13:58:31', NULL);
INSERT INTO `orders` VALUES ('29', '19', '3', '1', '2', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 14:00:28', '2026-03-08 14:00:33', '2026-03-08 14:00:28', '2026-03-08 14:00:33', NULL);
INSERT INTO `orders` VALUES ('30', '19', '3', '1', '2', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-08 15:22:45', '2026-03-08 16:01:51', '2026-03-08 15:22:45', '2026-03-08 16:01:51', NULL);
INSERT INTO `orders` VALUES ('31', '1', '1', '0', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-08 17:16:29', '2026-03-16 21:32:48', '2026-03-08 17:16:29', '2026-03-16 21:32:48', NULL);
INSERT INTO `orders` VALUES ('32', '21', '3', '1', '6', NULL, NULL, '1', 'closed', 'waiter', '0', 'transfer', 'paid', '2026-03-09 22:26:30', '2026-03-16 21:32:40', '2026-03-09 22:26:30', '2026-03-16 21:32:40', NULL);
INSERT INTO `orders` VALUES ('33', '13', '3', '1', '2', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-16 09:17:22', '2026-03-16 21:32:44', '2026-03-16 09:17:22', '2026-03-16 21:32:44', NULL);
INSERT INTO `orders` VALUES ('34', '19', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'transfer', 'paid', '2026-03-16 14:52:14', '2026-03-16 21:32:34', '2026-03-16 14:52:14', '2026-03-16 21:32:34', NULL);
INSERT INTO `orders` VALUES ('35', '20', '3', '1', '2', NULL, NULL, '1', 'closed', 'waiter', '0', 'transfer', 'paid', '2026-03-16 18:13:31', '2026-03-16 21:32:27', '2026-03-16 18:13:31', '2026-03-16 21:32:27', NULL);
INSERT INTO `orders` VALUES ('36', '22', '3', NULL, '4', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-16 20:26:07', '2026-03-16 21:32:21', '2026-03-16 20:26:07', '2026-03-16 21:32:21', NULL);
INSERT INTO `orders` VALUES ('37', '30', '3', NULL, '3', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-16 20:31:34', '2026-03-16 21:29:54', '2026-03-16 20:31:34', '2026-03-16 21:29:54', NULL);
INSERT INTO `orders` VALUES ('38', '24', '3', NULL, '10', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-16 20:55:48', '2026-03-16 21:29:32', '2026-03-16 20:55:48', '2026-03-16 21:29:32', NULL);
INSERT INTO `orders` VALUES ('39', '1', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'pending', '2026-03-16 21:36:43', '2026-03-16 21:36:46', '2026-03-16 21:36:43', '2026-03-16 21:36:46', NULL);
INSERT INTO `orders` VALUES ('40', '1', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'pending', '2026-03-16 21:36:52', '2026-03-16 21:37:02', '2026-03-16 21:36:52', '2026-03-16 21:37:02', NULL);
INSERT INTO `orders` VALUES ('41', '19', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-17 07:35:47', '2026-03-17 08:01:17', '2026-03-17 07:35:47', '2026-03-17 08:01:17', NULL);
INSERT INTO `orders` VALUES ('42', '19', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-17 08:01:26', '2026-03-17 11:46:34', '2026-03-17 08:01:26', '2026-03-17 11:46:34', NULL);
INSERT INTO `orders` VALUES ('43', '20', '3', '1', '2', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-17 10:53:41', '2026-03-17 11:46:18', '2026-03-17 10:53:41', '2026-03-17 11:46:18', NULL);
INSERT INTO `orders` VALUES ('44', '20', '3', '1', '2', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-17 11:49:00', '2026-03-17 11:49:11', '2026-03-17 11:49:00', '2026-03-17 11:49:11', NULL);
INSERT INTO `orders` VALUES ('45', '23', '3', '1', '2', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-17 11:49:24', '2026-03-17 11:52:02', '2026-03-17 11:49:24', '2026-03-17 11:52:02', NULL);
INSERT INTO `orders` VALUES ('46', '19', '3', '1', '2', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-17 11:52:13', '2026-03-17 11:52:22', '2026-03-17 11:52:13', '2026-03-17 11:52:22', NULL);
INSERT INTO `orders` VALUES ('47', '20', '3', '1', '3', NULL, NULL, '1', 'closed', 'waiter', '0', 'transfer', 'paid', '2026-03-17 11:52:40', '2026-03-17 11:59:55', '2026-03-17 11:52:40', '2026-03-17 11:59:55', NULL);
INSERT INTO `orders` VALUES ('48', '1', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-17 12:21:24', '2026-03-17 12:23:10', '2026-03-17 12:21:24', '2026-03-17 12:23:10', NULL);
INSERT INTO `orders` VALUES ('49', '19', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-17 12:21:28', '2026-03-17 12:23:27', '2026-03-17 12:21:28', '2026-03-17 12:23:27', NULL);
INSERT INTO `orders` VALUES ('50', '20', '3', '1', '2', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-17 12:22:47', '2026-03-17 12:42:12', '2026-03-17 12:22:47', '2026-03-17 12:42:12', NULL);
INSERT INTO `orders` VALUES ('51', '19', '3', '1', '10', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-17 12:42:16', '2026-03-17 17:33:58', '2026-03-17 12:42:16', '2026-03-17 17:33:58', NULL);
INSERT INTO `orders` VALUES ('52', '21', '3', '1', '2', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-17 13:27:16', '2026-03-17 13:30:17', '2026-03-17 13:27:16', '2026-03-17 13:30:17', NULL);
INSERT INTO `orders` VALUES ('53', '21', '3', '1', '12', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-17 13:42:53', '2026-03-17 14:04:33', '2026-03-17 13:42:53', '2026-03-17 14:04:33', NULL);
INSERT INTO `orders` VALUES ('54', '1', '3', '1', '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'pending', '2026-03-17 14:05:24', '2026-03-17 14:05:26', '2026-03-17 14:05:24', '2026-03-17 14:05:26', NULL);
INSERT INTO `orders` VALUES ('55', '27', '3', '1', '12', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-17 14:05:32', '2026-03-17 18:01:42', '2026-03-17 14:05:32', '2026-03-17 18:01:42', NULL);
INSERT INTO `orders` VALUES ('56', '13', '3', '1', '2', '', NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-17 18:39:46', '2026-03-17 18:45:09', '2026-03-17 18:39:46', '2026-03-17 18:45:09', NULL);
INSERT INTO `orders` VALUES ('57', '12', NULL, NULL, '1', '', NULL, '1', 'closed', 'customer_qr', '0', 'transfer', 'paid', '2026-03-17 19:26:16', '2026-03-17 19:29:06', '2026-03-17 19:26:16', '2026-03-17 19:29:06', NULL);
INSERT INTO `orders` VALUES ('58', '1', NULL, NULL, '1', '', NULL, '1', 'closed', 'customer_qr', '0', 'cash', 'paid', '2026-03-17 19:38:54', '2026-03-17 19:40:11', '2026-03-17 19:38:54', '2026-03-17 19:40:11', NULL);
INSERT INTO `orders` VALUES ('59', '28', NULL, NULL, '1', '', NULL, '1', 'closed', 'customer_qr', '0', 'cash', 'pending', '2026-03-17 20:16:09', '2026-03-17 20:21:31', '2026-03-17 20:16:09', '2026-03-17 20:21:31', NULL);
INSERT INTO `orders` VALUES ('60', '1', NULL, NULL, '1', '', NULL, '1', 'closed', 'customer_qr', '0', 'cash', 'pending', '2026-03-17 21:17:12', '2026-03-17 21:22:29', '2026-03-17 21:17:12', '2026-03-17 21:22:29', NULL);
INSERT INTO `orders` VALUES ('61', '3', NULL, NULL, '1', '', NULL, '1', 'closed', 'customer_qr', '0', 'cash', 'pending', '2026-03-17 21:17:44', '2026-03-17 21:23:18', '2026-03-17 21:17:44', '2026-03-17 21:23:18', NULL);
INSERT INTO `orders` VALUES ('62', '1', NULL, NULL, '1', '', NULL, '1', 'closed', 'customer_qr', '0', 'cash', 'paid', '2026-03-17 21:23:53', '2026-03-17 21:27:50', '2026-03-17 21:23:53', '2026-03-17 21:27:50', NULL);
INSERT INTO `orders` VALUES ('63', '1', NULL, NULL, '1', '', NULL, '1', 'closed', 'customer_qr', '0', 'cash', 'canceled', '2026-03-17 21:27:53', '2026-03-17 21:31:51', '2026-03-17 21:27:53', '2026-03-17 21:31:51', NULL);
INSERT INTO `orders` VALUES ('64', '21', '3', '1', '2', '', NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-17 21:33:11', '2026-03-17 21:45:34', '2026-03-17 21:33:11', '2026-03-17 21:45:34', NULL);
INSERT INTO `orders` VALUES ('65', '12', NULL, NULL, '1', '', NULL, '1', 'closed', 'customer_qr', '0', 'cash', 'paid', '2026-03-18 09:50:34', '2026-03-18 09:52:38', '2026-03-18 09:50:34', '2026-03-18 09:52:38', NULL);
INSERT INTO `orders` VALUES ('66', '1', NULL, NULL, '1', '', NULL, '1', 'closed', 'customer_qr', '0', 'cash', 'pending', '2026-03-18 09:53:02', '2026-03-18 10:09:43', '2026-03-18 09:53:02', '2026-03-18 10:09:43', NULL);
INSERT INTO `orders` VALUES ('67', '19', '3', '1', '2', '', NULL, '1', 'closed', 'waiter', '0', 'cash', 'canceled', '2026-03-18 10:21:12', '2026-03-18 10:21:21', '2026-03-18 10:21:12', '2026-03-18 10:21:21', NULL);
INSERT INTO `orders` VALUES ('68', '19', '3', '1', '12', '', NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-18 10:24:04', '2026-03-18 10:26:36', '2026-03-18 10:24:04', '2026-03-18 10:26:36', NULL);
INSERT INTO `orders` VALUES ('69', '2', NULL, NULL, '1', NULL, NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-18 10:24:35', '2026-03-18 10:26:28', '2026-03-18 10:24:35', '2026-03-18 10:26:28', NULL);
INSERT INTO `orders` VALUES ('70', '1', '3', '1', '12', '', NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-18 10:26:45', '2026-03-18 10:32:39', '2026-03-18 10:26:45', '2026-03-18 10:32:39', NULL);
INSERT INTO `orders` VALUES ('71', '4', '3', '1', '12', 'Tách từ bàn A.01', NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-18 10:30:29', '2026-03-18 10:32:30', '2026-03-18 10:30:29', '2026-03-18 10:32:30', NULL);
INSERT INTO `orders` VALUES ('72', '1', '3', '1', '12', '', NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-18 10:32:48', '2026-03-18 10:50:57', '2026-03-18 10:32:48', '2026-03-18 10:50:57', NULL);
INSERT INTO `orders` VALUES ('73', '4', '3', '1', '12', 'Tách từ bàn A.01', NULL, '1', 'closed', 'waiter', '0', 'cash', 'paid', '2026-03-18 10:33:26', '2026-03-18 10:50:49', '2026-03-18 10:33:26', '2026-03-18 10:50:49', NULL);

DROP TABLE IF EXISTS `qr_tables`;
CREATE TABLE `qr_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `table_id` int(10) unsigned NOT NULL COMMENT 'Mã bàn (foreign key)',
  `qr_code` varchar(255) DEFAULT NULL COMMENT 'URL hoặc nội dung QR code',
  `qr_hash` varchar(64) NOT NULL COMMENT 'Mã hash duy nhất cho QR (dùng cho URL)',
  `generated_at` timestamp NULL DEFAULT current_timestamp() COMMENT 'Thời gian tạo QR',
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=đ aktiv, 0=ẩn',
  `scan_count` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Số lần quét QR code',
  `last_scanned_at` timestamp NULL DEFAULT NULL COMMENT 'Lần quét cuối cùng',
  `is_printed` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_id` (`table_id`),
  UNIQUE KEY `qr_hash` (`qr_hash`),
  KEY `idx_qr_active` (`is_active`),
  CONSTRAINT `fk_qr_tables_table` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `qr_tables` VALUES ('2', '2', '/qr/menu?table_id=2&token=5aea0ec36591ecddd837fa739b2a5786', '5aea0ec36591ecddd837fa739b2a5786', '2026-03-08 16:50:22', '2026-03-17 19:08:13', '1', '2', '2026-03-17 19:08:13', '0');
INSERT INTO `qr_tables` VALUES ('3', '3', '/qr/menu?table_id=3&token=42a2c52875c7bfc390916ca1c33a7157', '42a2c52875c7bfc390916ca1c33a7157', '2026-03-08 16:50:22', '2026-03-17 21:19:45', '1', '4', '2026-03-17 21:19:45', '0');
INSERT INTO `qr_tables` VALUES ('4', '4', '/qr/menu?table_id=4&token=59151733a4403e2ba90a3668b91ef209', '59151733a4403e2ba90a3668b91ef209', '2026-03-08 16:50:22', '2026-03-18 10:49:49', '1', '1', '2026-03-18 10:49:49', '0');
INSERT INTO `qr_tables` VALUES ('5', '5', '/qr/menu?table_id=5&token=618e597619b7339cb04747a43747b086', '618e597619b7339cb04747a43747b086', '2026-03-08 16:50:22', '2026-03-17 18:30:03', '1', '2', '2026-03-17 18:30:03', '0');
INSERT INTO `qr_tables` VALUES ('6', '6', '/qr/menu?table_id=6&token=4d594e96b4578dd6eb6a2772eeb342d4', '4d594e96b4578dd6eb6a2772eeb342d4', '2026-03-08 16:50:22', '2026-03-17 19:33:50', '1', '2', '2026-03-17 19:33:50', '0');
INSERT INTO `qr_tables` VALUES ('7', '7', '/qr/menu?table_id=7&token=9debf619d8155b5e4218cdd77c9caa19', '9debf619d8155b5e4218cdd77c9caa19', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('8', '8', '/qr/menu?table_id=8&token=1a19d6276459abb3b0c92c9d7dd7dc0f', '1a19d6276459abb3b0c92c9d7dd7dc0f', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('9', '9', '/qr/menu?table_id=9&token=399e1ce0c5dd5fcaeb4cc583e17b45c5', '399e1ce0c5dd5fcaeb4cc583e17b45c5', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('10', '10', '/qr/menu?table_id=10&token=fb7e119368932a90d53465b48456597e', 'fb7e119368932a90d53465b48456597e', '2026-03-08 16:50:22', '2026-03-18 11:00:45', '1', '1', '2026-03-18 11:00:45', '0');
INSERT INTO `qr_tables` VALUES ('11', '11', '/qr/menu?table_id=11&token=d6590664eb462875de436efba585885b', 'd6590664eb462875de436efba585885b', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('12', '12', '/qr/menu?table_id=12&token=7714f8eb8cd1d9f1f4119665b538b9ec', '7714f8eb8cd1d9f1f4119665b538b9ec', '2026-03-08 16:50:22', '2026-03-18 10:50:33', '1', '7', '2026-03-18 10:50:33', '0');
INSERT INTO `qr_tables` VALUES ('13', '13', '/qr/menu?table_id=13&token=77d2001b22efcd63714ee5ec39cd624f', '77d2001b22efcd63714ee5ec39cd624f', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('14', '14', '/qr/menu?table_id=14&token=4f49388e51b134fabd30a789026ef9d0', '4f49388e51b134fabd30a789026ef9d0', '2026-03-08 16:50:22', '2026-03-18 11:17:47', '1', '2', '2026-03-18 11:17:47', '0');
INSERT INTO `qr_tables` VALUES ('15', '15', '/qr/menu?table_id=15&token=e939bdc269e7ea98da7f779691f9c63f', 'e939bdc269e7ea98da7f779691f9c63f', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('16', '16', '/qr/menu?table_id=16&token=5271c6745193cbd78b6d60fff9fb2863', '5271c6745193cbd78b6d60fff9fb2863', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('17', '17', '/qr/menu?table_id=17&token=ced798a790cc9fc268d03bcb7d5ccb93', 'ced798a790cc9fc268d03bcb7d5ccb93', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('18', '18', '/qr/menu?table_id=18&token=fa8932bc456533b1d680f807d16f35e9', 'fa8932bc456533b1d680f807d16f35e9', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('19', '19', '/qr/menu?table_id=19&token=b756d7566f9984bbc5190a823b00497a', 'b756d7566f9984bbc5190a823b00497a', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('20', '20', '/qr/menu?table_id=20&token=21b46e1f5b1d62e2f92ff2f02b28cf20', '21b46e1f5b1d62e2f92ff2f02b28cf20', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('21', '21', '/qr/menu?table_id=21&token=8a76b7a961c5343e09d947e7d762e032', '8a76b7a961c5343e09d947e7d762e032', '2026-03-08 16:50:22', '2026-03-17 21:46:45', '1', '3', '2026-03-17 21:46:45', '0');
INSERT INTO `qr_tables` VALUES ('22', '22', '/qr/menu?table_id=22&token=bd35d8e8560defeda360b4d99677350e', 'bd35d8e8560defeda360b4d99677350e', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('23', '23', '/qr/menu?table_id=23&token=36fcd88597412647c56d588a4f136e49', '36fcd88597412647c56d588a4f136e49', '2026-03-08 16:50:22', '2026-03-17 18:37:19', '1', '1', '2026-03-17 18:37:19', '0');
INSERT INTO `qr_tables` VALUES ('25', '25', '/qr/menu?table_id=25&token=4feee1c893e3c3ae36a029a11fdcd143', '4feee1c893e3c3ae36a029a11fdcd143', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('26', '26', '/qr/menu?table_id=26&token=a13c5111c2fea2dbf170ad159d88b3d5', 'a13c5111c2fea2dbf170ad159d88b3d5', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('27', '27', '/qr/menu?table_id=27&token=ab4722e5df763a17d54a46afa3506d39', 'ab4722e5df763a17d54a46afa3506d39', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('28', '28', '/qr/menu?table_id=28&token=197c68ac3e576c4ca2ecc90ba0035749', '197c68ac3e576c4ca2ecc90ba0035749', '2026-03-08 16:50:22', '2026-03-17 21:17:31', '1', '8', '2026-03-17 21:17:31', '0');
INSERT INTO `qr_tables` VALUES ('29', '29', '/qr/menu?table_id=29&token=540c56c80e81ad174c96292e2a32e55b', '540c56c80e81ad174c96292e2a32e55b', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('30', '30', '/qr/menu?table_id=30&token=892c41525bae1635bc4dd6e00049db09', '892c41525bae1635bc4dd6e00049db09', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('31', '31', '/qr/menu?table_id=31&token=c4d60af58f19e189cfbae688a169a499', 'c4d60af58f19e189cfbae688a169a499', '2026-03-08 16:50:22', '2026-03-17 18:29:16', '1', '0', NULL, '0');
INSERT INTO `qr_tables` VALUES ('32', '32', '/qr/menu?table_id=32&token=3132152b936f32b9bd4833020db70d8e', '3132152b936f32b9bd4833020db70d8e', '2026-03-08 16:50:22', '2026-03-17 18:39:17', '1', '1', '2026-03-17 18:39:17', '0');
INSERT INTO `qr_tables` VALUES ('64', '1', '/qr/menu?table_id=1&token=c1674174442ac69294484eb54ffe1e2b', 'c1674174442ac69294484eb54ffe1e2b', '2026-03-17 17:59:01', '2026-03-18 11:26:00', '1', '34', '2026-03-18 11:26:00', '0');

DROP TABLE IF EXISTS `realtime_notifications`;
CREATE TABLE `realtime_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `channel` varchar(50) NOT NULL COMMENT 'Kênh: waiter_1, admin, table_5, all',
  `event_type` varchar(50) NOT NULL COMMENT 'Loại event: new_order, order_confirmed, table_occupied',
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Dữ liệu notification dạng JSON' CHECK (json_valid(`payload`)),
  `is_delivered` tinyint(1) NOT NULL DEFAULT 0,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL COMMENT 'Hết hạn sau 24h',
  PRIMARY KEY (`id`),
  KEY `idx_channel` (`channel`),
  KEY `idx_event_type` (`event_type`),
  KEY `idx_delivered` (`is_delivered`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Real-time push notifications';


DROP TABLE IF EXISTS `shifts`;
CREATE TABLE `shifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'Tên ca: Sáng, Chiều, Tối...',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `shifts` VALUES ('1', 'Ca Sáng', '06:00:00', '14:00:00', '2026-03-07 18:08:32');
INSERT INTO `shifts` VALUES ('2', 'Ca Chiều', '14:00:00', '22:00:00', '2026-03-07 18:08:32');

DROP TABLE IF EXISTS `support_requests`;
CREATE TABLE `support_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `table_id` int(10) unsigned NOT NULL,
  `type` enum('support','payment','scan_qr','new_order') NOT NULL DEFAULT 'support' COMMENT 'Loại yêu cầu: support=hỗ trợ, payment=thanh toán, scan_qr=quét QR, new_order=order mới',
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_support_table` (`table_id`),
  CONSTRAINT `fk_support_table` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `support_requests` VALUES ('1', '1', '', 'pending', '2026-03-17 13:52:40', '2026-03-17 13:52:40');
INSERT INTO `support_requests` VALUES ('2', '21', '', 'pending', '2026-03-17 14:04:55', '2026-03-17 14:04:55');
INSERT INTO `support_requests` VALUES ('3', '1', 'scan_qr', 'pending', '2026-03-17 15:03:45', '2026-03-17 15:03:45');
INSERT INTO `support_requests` VALUES ('4', '3', 'scan_qr', 'pending', '2026-03-17 15:39:27', '2026-03-17 15:39:27');
INSERT INTO `support_requests` VALUES ('5', '1', 'scan_qr', 'pending', '2026-03-17 17:07:43', '2026-03-17 17:07:43');
INSERT INTO `support_requests` VALUES ('6', '1', 'scan_qr', 'pending', '2026-03-17 17:37:02', '2026-03-17 17:37:02');
INSERT INTO `support_requests` VALUES ('7', '1', 'scan_qr', 'pending', '2026-03-17 17:45:25', '2026-03-17 17:45:25');
INSERT INTO `support_requests` VALUES ('8', '3', 'scan_qr', 'pending', '2026-03-17 19:49:23', '2026-03-17 19:49:23');
INSERT INTO `support_requests` VALUES ('9', '1', 'scan_qr', 'pending', '2026-03-17 21:24:23', '2026-03-17 21:24:23');
INSERT INTO `support_requests` VALUES ('10', '21', 'scan_qr', 'pending', '2026-03-17 21:33:13', '2026-03-17 21:33:13');
INSERT INTO `support_requests` VALUES ('11', '3', 'scan_qr', 'pending', '2026-03-18 10:08:29', '2026-03-18 10:08:29');

DROP TABLE IF EXISTS `table_status_history`;
CREATE TABLE `table_status_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `table_id` int(10) unsigned NOT NULL,
  `previous_status` enum('available','occupied') NOT NULL,
  `current_status` enum('available','occupied') NOT NULL,
  `changed_by` int(10) unsigned DEFAULT NULL COMMENT 'User ID hoặc NULL nếu từ customer',
  `change_reason` varchar(100) DEFAULT NULL COMMENT 'Lý do: scan_qr, waiter_open, manual_close, auto_close',
  `order_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_table_history` (`table_id`),
  KEY `idx_table_status_time` (`created_at`),
  KEY `idx_table_change_reason` (`change_reason`),
  CONSTRAINT `fk_history_table` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Lịch sử thay đổi trạng thái bàn';


DROP TABLE IF EXISTS `tables`;
CREATE TABLE `tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(50) NOT NULL COMMENT 'Tên bàn: Bàn 01, VIP 1...',
  `area` varchar(50) DEFAULT NULL COMMENT 'Khu vực: Trong, Ngoài, VIP...',
  `capacity` tinyint(3) unsigned NOT NULL DEFAULT 4 COMMENT 'Sức chứa (số ghế)',
  `status` enum('available','occupied') NOT NULL DEFAULT 'available',
  `position_x` smallint(5) unsigned DEFAULT 0 COMMENT 'Toạ độ X trên sơ đồ',
  `position_y` smallint(5) unsigned DEFAULT 0 COMMENT 'Toạ độ Y trên sơ đồ',
  `sort_order` smallint(5) unsigned DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_tables_parent` (`parent_id`),
  KEY `idx_parent_id` (`parent_id`),
  CONSTRAINT `fk_tables_parent` FOREIGN KEY (`parent_id`) REFERENCES `tables` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tables` VALUES ('1', NULL, 'A.01', 'A1', '4', 'available', '0', '0', '1', '1', '2026-03-07 18:20:45', '2026-03-18 10:50:57');
INSERT INTO `tables` VALUES ('2', NULL, 'A.02', 'A1', '4', 'available', '0', '0', '2', '1', '2026-03-07 18:20:45', '2026-03-18 10:50:57');
INSERT INTO `tables` VALUES ('3', NULL, 'A.03', 'A1', '4', 'available', '0', '0', '3', '1', '2026-03-07 18:20:45', '2026-03-18 10:50:57');
INSERT INTO `tables` VALUES ('4', NULL, 'A.04', 'A1', '4', 'available', '0', '0', '4', '1', '2026-03-07 18:20:45', '2026-03-18 10:50:49');
INSERT INTO `tables` VALUES ('5', NULL, 'A.05', 'A1', '4', 'available', '0', '0', '5', '1', '2026-03-07 18:20:45', '2026-03-17 14:05:26');
INSERT INTO `tables` VALUES ('6', NULL, 'A.06', 'A1', '4', 'available', '0', '0', '6', '1', '2026-03-07 18:20:45', '2026-03-17 14:05:26');
INSERT INTO `tables` VALUES ('7', NULL, 'B.01', 'B1', '4', 'available', '0', '0', '7', '1', '2026-03-07 18:20:45', '2026-03-17 18:44:51');
INSERT INTO `tables` VALUES ('8', NULL, 'B.02', 'B1', '4', 'available', '0', '0', '8', '1', '2026-03-07 18:20:45', '2026-03-17 18:44:51');
INSERT INTO `tables` VALUES ('9', NULL, 'B.03', 'B1', '4', 'available', '0', '0', '9', '1', '2026-03-07 18:20:45', '2026-03-17 18:44:51');
INSERT INTO `tables` VALUES ('10', NULL, 'B.04', 'B1', '4', 'available', '0', '0', '10', '1', '2026-03-07 18:20:45', '2026-03-17 18:44:51');
INSERT INTO `tables` VALUES ('11', NULL, 'B.05', 'B1', '4', 'available', '0', '0', '11', '1', '2026-03-07 18:20:45', '2026-03-17 18:44:51');
INSERT INTO `tables` VALUES ('12', NULL, 'B.06', 'B1', '4', 'available', '0', '0', '12', '1', '2026-03-07 18:20:45', '2026-03-18 09:52:38');
INSERT INTO `tables` VALUES ('13', NULL, 'C.01', 'C1', '4', 'available', '0', '0', '13', '1', '2026-03-07 18:20:45', '2026-03-17 18:45:09');
INSERT INTO `tables` VALUES ('14', NULL, 'C.02', 'C1', '4', 'available', '0', '0', '14', '1', '2026-03-07 18:20:45', '2026-03-08 10:24:32');
INSERT INTO `tables` VALUES ('15', NULL, 'C.03', 'C1', '4', 'available', '0', '0', '15', '1', '2026-03-07 18:20:45', '2026-03-08 10:24:32');
INSERT INTO `tables` VALUES ('16', NULL, 'C.04', 'C1', '4', 'available', '0', '0', '16', '1', '2026-03-07 18:20:45', '2026-03-08 10:24:32');
INSERT INTO `tables` VALUES ('17', NULL, 'C.05', 'C1', '4', 'available', '0', '0', '17', '1', '2026-03-07 18:20:45', '2026-03-08 10:24:32');
INSERT INTO `tables` VALUES ('18', NULL, 'C.06', 'C1', '4', 'available', '0', '0', '18', '1', '2026-03-07 18:20:45', '2026-03-08 10:24:32');
INSERT INTO `tables` VALUES ('19', NULL, 'VIP 1.1', 'VIP 1', '8', 'available', '0', '0', '19', '1', '2026-03-07 18:20:45', '2026-03-18 10:26:36');
INSERT INTO `tables` VALUES ('20', NULL, 'VIP 1.2', 'VIP 1', '8', 'available', '0', '0', '20', '1', '2026-03-07 18:20:45', '2026-03-18 10:26:36');
INSERT INTO `tables` VALUES ('21', NULL, 'VIP 2.1', 'VIP 2', '8', 'available', '0', '0', '21', '1', '2026-03-07 18:20:45', '2026-03-17 21:45:34');
INSERT INTO `tables` VALUES ('22', NULL, 'VIP 2.2', 'VIP 2', '8', 'available', '0', '0', '22', '1', '2026-03-07 18:20:45', '2026-03-17 14:04:33');
INSERT INTO `tables` VALUES ('23', NULL, 'VIP 3.1', 'VIP 3', '8', 'available', '0', '0', '23', '1', '2026-03-07 18:20:45', '2026-03-17 11:52:02');
INSERT INTO `tables` VALUES ('24', NULL, 'VIP 3.2', 'VIP 3', '8', 'available', '0', '0', '24', '1', '2026-03-07 18:20:45', '2026-03-16 21:29:32');
INSERT INTO `tables` VALUES ('25', NULL, 'VIP 4.1', 'VIP 4', '8', 'available', '0', '0', '25', '1', '2026-03-07 18:20:45', '2026-03-08 10:24:32');
INSERT INTO `tables` VALUES ('26', NULL, 'VIP 4.2', 'VIP 4', '8', 'available', '0', '0', '26', '1', '2026-03-07 18:20:45', '2026-03-08 10:24:32');
INSERT INTO `tables` VALUES ('27', NULL, 'Âu 01', 'Âu', '4', 'available', '0', '0', '27', '1', '2026-03-07 18:20:45', '2026-03-17 18:01:42');
INSERT INTO `tables` VALUES ('28', NULL, 'Âu 02', 'Âu', '4', 'available', '0', '0', '28', '1', '2026-03-07 18:20:45', '2026-03-17 20:21:31');
INSERT INTO `tables` VALUES ('29', NULL, 'Âu 03', 'Âu', '4', 'available', '0', '0', '29', '1', '2026-03-07 18:20:45', '2026-03-17 18:01:42');
INSERT INTO `tables` VALUES ('30', NULL, 'Âu 04', 'Âu', '4', 'available', '0', '0', '30', '1', '2026-03-07 18:20:45', '2026-03-16 21:29:54');
INSERT INTO `tables` VALUES ('31', NULL, 'Âu 05', 'Âu', '4', 'available', '0', '0', '31', '1', '2026-03-07 18:20:45', '2026-03-08 10:24:32');
INSERT INTO `tables` VALUES ('32', NULL, 'Âu 06', 'Âu', '4', 'available', '0', '0', '32', '1', '2026-03-07 18:20:45', '2026-03-08 10:24:32');

DROP TABLE IF EXISTS `user_shifts`;
CREATE TABLE `user_shifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `shift_id` int(10) unsigned NOT NULL,
  `work_date` date NOT NULL COMMENT 'Ngày làm việc',
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_user_shifts_user` (`user_id`),
  KEY `fk_user_shifts_shift` (`shift_id`),
  CONSTRAINT `fk_user_shifts_shift` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_user_shifts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'Tên nhân viên',
  `username` varchar(50) NOT NULL COMMENT 'Tên đăng nhập',
  `pin` char(4) NOT NULL COMMENT 'PIN 4 số đăng nhập iPad',
  `role` enum('waiter','admin','it') NOT NULL DEFAULT 'waiter',
  `avatar` varchar(255) DEFAULT NULL COMMENT 'URL ảnh đại diện',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=hoạt động, 0=vô hiệu',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` VALUES ('1', 'Admin Nhà Hàng', 'admin', '1234', 'admin', NULL, '1', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `users` VALUES ('2', 'IT System', 'it', '9999', 'it', NULL, '1', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `users` VALUES ('3', 'Nguyễn Văn A', 'waiter01', '1111', 'waiter', NULL, '1', '2026-03-07 18:08:27', '2026-03-07 18:08:27');
INSERT INTO `users` VALUES ('4', 'Trần Thị B', 'waiter02', '2222', 'waiter', NULL, '1', '2026-03-07 18:08:27', '2026-03-07 18:08:27');

DROP TABLE IF EXISTS `vw_location_limit`;
;

INSERT INTO `vw_location_limit` VALUES ('1', 'Giới hạn QR Restaurant', '10.95770000', '106.84480000', '500', '1', '2026-03-08 16:36:35', '2026-03-08 16:36:35');

SET FOREIGN_KEY_CHECKS = 1;
